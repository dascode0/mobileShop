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
            if ((int) $product->stock < 1) {
                return redirect()->back()->with('error', 'This product is not available right now. Please check again later.');
            }
            $guestCart = $request->session()->get('guest_cart', []);
            $guestCart[$product->id] = min(
                (int) ($guestCart[$product->id] ?? 0) + 1,
                max(0, (int) $product->stock)
            );
            $request->session()->put('guest_cart', $guestCart);
            return redirect()->route('home')->with('success', 'Product saved in your cart. Login to complete your cart.');
        }

       $product = Product::findOrFail($request->product_id);
       if ((int) $product->stock < 1) {
           return redirect()->back()->with('error', 'This product is not available right now. Please check again later.');
       }
       $existingCartItem=Cart::where('user_id', $userId)->where('product_id',$request->product_id)->first();
       if($existingCartItem){
              if ($existingCartItem->quantity >= $product->stock) {
                  return redirect()->back()->with('error', 'You cannot add more than the available stock.');
              }
              $existingCartItem->quantity += 1;
                $existingCartItem->save();
         }else{
            $cartItem = new Cart();
            $cartItem->user_id = $userId;
            $cartItem->product_id = $request->product_id;
            $cartItem->quantity = 1;
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
            $product = $cartItem->product;
            $quantity = filter_var($request->input('quantity'), FILTER_VALIDATE_INT);
            if (!$quantity || $quantity < 1) {
                return redirect()->back()->with('error', 'Quantity must be at least 1.');
            }
            if ($quantity > (int) $product->stock) {
                return redirect()->back()->with('error', 'Only ' . $product->stock . ' item(s) are available.');
            }
            $cartItem->quantity = $quantity;
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
