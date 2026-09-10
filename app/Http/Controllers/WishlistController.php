<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

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
            return response()->json(['status' => 'error', 'message' => 'Please log in to add to wishlist'], 401);
        }

        /** @var User $user */
        $user = Auth::user();
        
        // Check if product is already in wishlist
        if ($user->wishlists()->where('product_id', $id)->exists()) {
            return response()->json(['status' => 'info', 'message' => 'Product already in wishlist']);
        }
        
        $user->wishlists()->attach($id);
        return response()->json(['status' => 'success', 'message' => 'Product added to wishlist']);
    }
    
    public function unwishProduct($id)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'Please log in to remove from wishlist'], 401);
        }

        /** @var User $user */
        $user = Auth::user();
        $user->wishlists()->detach($id);
        return response()->json(['status' => 'success', 'message' => 'Product removed from wishlist']);
    }
}
