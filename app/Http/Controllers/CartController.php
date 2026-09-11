<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        if(!Auth::check()) {
            return redirect()->route('home')->with('error', 'You need to be logged in to view your cart.');
        }
        $userId = Auth::id();
        $cartitems = Cart::where('user_id', $userId)->with('product')->get();
        if ($cartitems->isEmpty()) {
            return view('cart.index', ['message' => 'Your cart is empty']);
        }
        return view('cart.index', ['cartitems' => $cartitems]);
    }
    public function addToCart(Request $request){
        $userId = Auth::id();
        if (!$userId) {
            $product = Product::findOrFail($request->product_id);
            $guestCart = $request->session()->get('guest_cart', []);
            $guestCart[$product->id] = (int) ($guestCart[$product->id] ?? 0) + 1;
            $request->session()->put('guest_cart', $guestCart);
            return redirect()->route('home')->with('success', 'Product saved in your cart. Login to complete your cart.');
        }

       $existingCartItem=Cart::where('user_id', $userId)->where('product_id',$request->product_id)->first();
       if($existingCartItem){
              $existingCartItem->quantity += 1;
                $existingCartItem->save();
         }else{
            $cartItem = new Cart();
            $cartItem->user_id = $userId;
            $cartItem->product_id = $request->product_id;
            $cartItem->quantity = 1; // Default quantity is 1
            $cartItem->save();  
         }
        return redirect()->route('cart.index')->with('success', 'Product added to cart successfully.');

    }
    public function quantityUpdate(Request $request, $productId){
        $userId = Auth::id();
        if (!$userId) {
            return redirect()->route('home')->with('error', 'You need to be logged in to update cart items.');
        }

        $cartItem = Cart::where('user_id', $userId)->where('product_id', $productId)->first();
        if ($cartItem) {
            $cartItem->quantity = $request->input('quantity');
            $cartItem->save();
            return redirect()->route('cart.index')->with('success', 'Cart updated successfully.');
        } else {
            return redirect()->route('cart.index')->with('error', 'Product not found in cart.');
        }
    }
    public function removeFromCart(Request $request){
        $userId = Auth::id();
        if (!$userId) {
            return redirect()->route('home')->with('error', 'You need to be logged in to remove items from your cart.');
        }

        $cartItem = Cart::where('user_id', $userId)->where('id', request()->id)->first();
        if ($cartItem) {
            $cartItem->delete();
            return redirect()->route('cart.index')->with('success', 'Product removed from cart successfully.');
        } else {
            return redirect()->route('cart.index')->with('error', 'Product not found in cart.');
        }
    }
    public function clearAll(){
        $userId = Auth::id();
        if (!$userId) {
            return redirect()->route('home')->with('error', 'You need to be logged in to clear your cart.');
        }

        Cart::where('user_id', $userId)->delete();
        return redirect()->route('cart.index')->with('success', 'All items removed from cart successfully.');
    }
    
}
