<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\Address;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Cart;


class AuthenticationController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4|confirmed',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('auth_panel', 'register');
        }

        $data = $validator->validated();

        unset($data['password_confirmation']);
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);
        Auth::login($user);
        $request->session()->put('user_id', $user->id);
        $request->session()->put('user_name', $user->name);
        $request->session()->put('user_email', $user->email);
        $this->mergeGuestData($request, $user);

        if ($user) {
            return redirect()->route('home')->with('success', 'Registration successful. Welcome to our store!');
        }
        return redirect()->back()->withErrors(['error' => 'Registration failed. Please try again.']);
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('auth_panel', 'login');
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $request->session()->put('user_id', $user->id);
            $request->session()->put('user_name', $user->name);
            $request->session()->put('user_email', $user->email);
            $this->mergeGuestData($request, $user);
            return redirect()->route('home')->with('success', 'Login successful. Welcome back!');
        }

        return redirect()->back()
            ->withErrors(['error' => 'Invalid credentials. Please try again.'])
            ->withInput()
            ->with('auth_panel', 'login');
    }

    private function mergeGuestData(Request $request, User $user): void
    {
        $guestCart = $request->session()->pull('guest_cart', []);
        foreach ($guestCart as $productId => $quantity) {
            if (!Product::whereKey($productId)->exists()) {
                continue;
            }
            $cartItem = Cart::firstOrNew([
                'user_id' => $user->id,
                'product_id' => (int) $productId,
            ]);
            $cartItem->quantity = (int) ($cartItem->quantity ?? 0) + max(1, (int) $quantity);
            $cartItem->save();
        }

        $guestWishlist = $request->session()->pull('guest_wishlist', []);
        $validProductIds = Product::whereIn('id', array_map('intval', $guestWishlist))->pluck('id')->all();
        if ($validProductIds) {
            $existingIds = $user->wishlists()->whereIn('product_id', $validProductIds)->pluck('products.id')->all();
            $user->wishlists()->syncWithoutDetaching(array_diff($validProductIds, $existingIds));
        }
    }
    public function account(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('home')->withErrors(['error' => 'You must be logged in to view this page.']);
        }

        $orders = Order::with(['address', 'orderItems.product'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $addresses = Address::where('user_id', $user->id)->latest()->get();

        // Allow deep-linking straight to a tab, e.g. /account?tab=orders
        $activeTab = $request->query('tab', 'dashboard');
        $highlightOrder = $request->query('order');

        return view('account', [
            'user' => $user,
            'orders' => $orders,
            'addresses' => $addresses,
            'activeTab' => $activeTab,
            'highlightOrder' => $highlightOrder,
        ]);
    }

    public function cancelOrder(Order $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);

        if (!in_array($order->status, ['pending', 'confirmed', 'processing'], true)) {
            return response()->json([
                'success' => false,
                'message' => 'This order can no longer be cancelled.',
            ], 422);
        }

        $order->update(['status' => 'cancelled']);

        return response()->json([
            'success' => true,
            'message' => 'Order cancelled successfully.',
            'status' => $order->status,
        ]);
    }

    public function deleteOrder(Order $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);

        if (!in_array($order->status, ['delivered', 'cancelled'], true)) {
            return response()->json([
                'success' => false,
                'message' => 'Only delivered or cancelled orders can be removed from history.',
            ], 422);
        }

        DB::transaction(function () use ($order) {
            $order->orderItems()->delete();
            $order->delete();
        });

        return response()->json([
            'success' => true,
            'message' => 'Order removed from your order history.',
        ]);
    }

    public function updateProfileImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = Auth::user();
        if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
            Storage::disk('public')->delete($user->profile_image);
        }

        $user->profile_image = $request->file('profile_image')->store('profile-images', 'public');
        $user->save();

        return response()->json([
            'success' => true,
            'image_url' => asset('storage/' . $user->profile_image),
        ]);
    }

    public function deleteProfileImage()
    {
        $user = Auth::user();
        if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
            Storage::disk('public')->delete($user->profile_image);
        }

        $user->profile_image = null;
        $user->save();

        return response()->json(['success' => true]);
    }
    public function logout(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('home')->withErrors(['error' => 'You must be logged in to perform this action.']);
        }
        Auth::logout();
        $request->session()->flush();
        return redirect()->route('home');
    }

    // dashboard method start to the admin panel
    public function dashboard()
    {
        $usercount = User::where('is_admin', false)->count();
        $ordercount = Order::count();
        $productcount = Product::count();
        $revenue = (float) Order::whereNotIn('status', ['cancelled'])->sum('total');
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('dashboard', compact('usercount', 'ordercount', 'productcount', 'revenue', 'recentOrders'));
    }

    public function dashboardOrders()
    {
        return response()->json([
            'order_count' => Order::count(),
            'revenue' => (float) Order::whereNotIn('status', ['cancelled'])->sum('total'),
            'orders' => Order::with('user')->latest()->take(5)->get()->map(function ($order) {
                return [
                    'number' => $order->order_number,
                    'customer' => $order->user->name ?? 'Deleted user',
                    'date' => $order->created_at->utc()->timezone('Asia/Kolkata')->format('d M Y'),
                    'total' => number_format($order->total, 2),
                    'status' => $order->status,
                ];
            }),
        ]);
    }

    public function adminSettings()
    {
        return view('admin.settings', ['admin' => Auth::user()]);
    }

    public function updateAdminSettings(Request $request)
    {
        $admin = Auth::user();
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $admin->id,
            'password' => 'nullable|string|min:4',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $admin->name = $data['name'];
        $admin->email = $data['email'];
        if (!empty($data['password'])) {
            $admin->password = Hash::make($data['password']);
        }
        if ($request->hasFile('profile_image')) {
            if ($admin->profile_image && Storage::disk('public')->exists($admin->profile_image)) {
                Storage::disk('public')->delete($admin->profile_image);
            }
            $admin->profile_image = $request->file('profile_image')->store('profile-images', 'public');
        }
        $admin->save();
        $request->session()->put(['user_name' => $admin->name, 'user_email' => $admin->email]);

        return redirect()->route('admin.settings')->with('success', 'Admin profile updated successfully.');
    }

    public function deleteAdminProfileImage(Request $request)
    {
        $admin = Auth::user();
        if ($admin->profile_image && Storage::disk('public')->exists($admin->profile_image)) {
            Storage::disk('public')->delete($admin->profile_image);
        }
        $admin->profile_image = null;
        $admin->save();
        return redirect()->route('admin.settings')->with('success', 'Profile photo removed.');
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $credentials['is_admin'] = true;
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $request->session()->put('user_id', $user->id);
            $request->session()->put('user_name', $user->name);
            $request->session()->put('user_email', $user->email);
            return redirect()->route('dashboard')->with('success', 'Admin login successful. Welcome back!');
        }

        return redirect()->back()->withErrors(['error' => 'Invalid credentials. Please try again.']);
    }
    public function adminLogout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            Auth::logout();
            $request->session()->flush();
            return redirect()->route('admin.login');
        } else {
            return redirect()->route('admin.login')->withErrors(['error' => 'You must be logged in to perform this action.']);
        }
    }
    public function users()
    {
        $user = Auth::user();
        if ($user) {
            $users = User::where('is_admin', false)->latest('id')->paginate(5);
            return view('users', ['users' => $users]);
        }
        return redirect()->route('admin.login')->withErrors(['error' => 'You must be logged in to view this page.']);
    }

    public function showUser(User $user)
    {
        abort_if($user->is_admin, 404);

        $user->load([
            'addresses',
            'orders' => fn ($query) => $query->with(['address', 'orderItems.product'])->latest(),
        ]);

        return view('users.show', compact('user'));
    }

    public function deleteUser(User $user)
    {
        if ($user->is_admin) {
            return redirect()->route('users')->withErrors(['error' => 'Admin accounts cannot be deleted here.']);
        }

        $user->delete();

        return redirect()->route('users')->with('success', 'User deleted successfully.');
    }

    // home page

    public function home()
    {
        $categories = Category::all();
        $products = Product::latest()->take(6)->get();

        return view('home', ['categories' => $categories, 'products' => $products]);
    }
}
