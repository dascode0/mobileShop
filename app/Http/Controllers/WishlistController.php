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
            return response()->json(['status' => 'unauthenticated', 'message' => 'Please log in to save favorites.'], 401);
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
            return response()->json(['status' => 'unauthenticated', 'message' => 'Please log in to manage favorites.'], 401);
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
