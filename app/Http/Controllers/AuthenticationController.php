<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthenticationController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4|confirmed',
        ]);

        unset($data['password_confirmation']);
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);
        Auth::login($user);
        $request->session()->put('user_id', $user->id);
        $request->session()->put('user_name', $user->name);
        $request->session()->put('user_email', $user->email);

        if ($user) {
            return redirect()->route('home');
        }
        return redirect()->back()->withErrors(['error' => 'Registration failed. Please try again.']);
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $request->session()->put('user_id', $user->id);
            $request->session()->put('user_name', $user->name);
            $request->session()->put('user_email', $user->email);
            return redirect()->route('home')->withErrors(['error' => 'thank you for login!.']);
        }

        return redirect()->back()->withErrors(['error' => 'Invalid credentials. Please try again.']);
    }
    public function account()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('home')->withErrors(['error' => 'You must be logged in to view this page.']);
        }
        return view('account', ['user' => $user]);
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
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('admin.login')->withErrors(['error' => 'You must be logged in to view this page.']);
        }
        $usercount = User::count(); // Get the total number of users
        return view('dashboard', compact('usercount'));
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
            $usercount = User::count(); // Get the total number of users
            return view('dashboard', compact('usercount'));
        }

        return redirect()->back()->withErrors(['error' => 'Invalid credentials. Please try again.']);
    }
    public function adminRegister(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4|confirmed',
        ]);
        $data['is_admin'] = true; // Assuming you want to set a flag for admin users

        unset($data['password_confirmation']);
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);
        Auth::login($user);
        $request->session()->put('user_id', $user->id);
        $request->session()->put('user_name', $user->name);
        $request->session()->put('user_email', $user->email);

        if ($user) {
            $usercount = User::count(); // Get the total number of users
            return view('dashboard', compact('usercount'));
        }
        return redirect()->back()->withErrors(['error' => 'Registration failed. Please try again.']);
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
            $users = User::paginate(5);
            return view('users', ['users' => $users]);
        }
        return redirect()->route('admin.login')->withErrors(['error' => 'You must be logged in to view this page.']);
    }

    // home page

    public function home()
    {
        $categories = Category::all();
        $products = Product::latest()->take(6)->get();

        return view('home', ['categories' => $categories, 'products' => $products]);
    }
}
