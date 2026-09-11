<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('home')->with('error', 'Please login to view your wishlist.');
        }

        /** @var User $user */
        $user = Auth::user();
        $wishlistItems = $user->wishlists()->with('category')->get();

        return view('wishlist', compact('wishlistItems'));
    }
    public function wishProduct($id)
    {
        if (!Auth::check()) {
            Product::findOrFail($id);
            $guestWishlist = session()->get('guest_wishlist', []);
            if (!in_array((int) $id, array_map('intval', $guestWishlist), true)) {
                $guestWishlist[] = (int) $id;
                session()->put('guest_wishlist', $guestWishlist);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Product saved to favorites. Login to keep it in your account.',
                'wishlistCount' => count($guestWishlist),
            ]);
        }

        $product = Product::findOrFail($id);
        /** @var User $user */
        $user = Auth::user();
        
        // Check if product is already in wishlist
        if ($user->wishlists()->where('product_id', $product->id)->exists()) {
            return response()->json(['status' => 'info', 'message' => 'This product is already in your favorites.']);
        }
        
        $user->wishlists()->attach($product->id);
        return response()->json([
            'status' => 'success',
            'message' => 'Product added to your favorites.',
            'wishlistCount' => $user->wishlists()->count(),
        ]);
    }
    
    public function unwishProduct($id)
    {
        if (!Auth::check()) {
            $guestWishlist = array_values(array_filter(
                session()->get('guest_wishlist', []),
                fn ($productId) => (int) $productId !== (int) $id
            ));
            session()->put('guest_wishlist', $guestWishlist);
            return response()->json([
                'status' => 'success',
                'message' => 'Product removed from your favorites.',
                'wishlistCount' => count($guestWishlist),
            ]);
        }

        $product = Product::findOrFail($id);
        /** @var User $user */
        $user = Auth::user();
        $user->wishlists()->detach($product->id);
        return response()->json([
            'status' => 'success',
            'message' => 'Product removed from your favorites.',
            'wishlistCount' => $user->wishlists()->count(),
        ]);
    }
}
