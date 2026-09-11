<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page.
     */
    public function index()
    {
        // Get user's cart items
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        foreach ($cartItems as $cartItem) {
            if (!$cartItem->product || $cartItem->quantity > $cartItem->product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Some cart items no longer have enough stock. Please update your cart.',
                ], 422);
            }
        }

        // Get user's addresses
        $addresses = Address::where('user_id', Auth::id())->get();
        
        // Calculate totals
        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
        
        $tax = $subtotal * 0.02; // 2% tax
        $shipping = $subtotal > 50000 ? 0 : 500; // Free shipping above ₹50,000
        $total = $subtotal + $tax + $shipping;

        return view('checkout.index', compact('cartItems', 'addresses', 'subtotal', 'tax', 'shipping', 'total'));
    }

    /**
     * Get cart items for checkout.
     */
    public function getCartItems()
    {
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
        
        $items = $cartItems->map(function ($item) {
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'name' => $item->product->name,
                'image' => $item->product->image,
                'price' => $item->product->price,
                'quantity' => $item->quantity,
                'total' => $item->product->price * $item->quantity
            ];
        });

        $subtotal = $items->sum('total');
        $tax = $subtotal * 0.02;
        $shipping = $subtotal > 50000 ? 0 : 500;
        $total = $subtotal + $tax + $shipping;

        return response()->json([
            'items' => $items,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping' => $shipping,
            'total' => $total
        ]);
    }

    /**
     * Process the order placement.
     */
    public function placeOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address_id' => 'required|exists:addresses,id',
            'payment_method' => 'required|in:cod,card,upi',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Verify address belongs to user
        $address = Address::where('id', $request->address_id)
                         ->where('user_id', Auth::id())
                         ->firstOrFail();

        // Get cart items
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
        
        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty'
            ], 400);
        }

        DB::beginTransaction();
        
        try {
            // Calculate totals
            $subtotal = $cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });
            
            $tax = $subtotal * 0.02;
            $shipping = $subtotal > 50000 ? 0 : 500;
            $total = $subtotal + $tax + $shipping;

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'address_id' => $address->id,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping' => $shipping,
                'total' => $total,
                'payment_method' => $request->payment_method,
                'status' => 'pending',
                'order_number' => 'ORD-' . time() . '-' . Auth::id()
            ]);

            // Create order items
            foreach ($cartItems as $cartItem) {
                $product = $cartItem->product()->lockForUpdate()->first();
                if (!$product || $cartItem->quantity > $product->stock) {
                    throw new \RuntimeException('Insufficient stock for ' . ($product->name ?? 'a cart item'));
                }
                $product->decrement('stock', $cartItem->quantity);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $product->price,
                    'total' => $product->price * $cartItem->quantity
                ]);
            }

            // Clear cart
            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully',
                'order_id' => $order->id,
                'order_number' => $order->order_number
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to place order. Please try again.'
            ], 500);
        }
    }

    /**
     * Get order summary for review step.
     */
    public function getOrderSummary(Request $request)
    {
        $addressId = $request->get('address_id');
        
        // Get selected address
        $address = null;
        if ($addressId) {
            $address = Address::where('id', $addressId)
                             ->where('user_id', Auth::id())
                             ->first();
        }

        // Get cart items
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
        
        $items = $cartItems->map(function ($item) {
            return [
                'name' => $item->product->name,
                'image' => $item->product->image,
                'price' => $item->product->price,
                'quantity' => $item->quantity,
                'total' => $item->product->price * $item->quantity
            ];
        });

        return response()->json([
            'items' => $items,
            'address' => $address
        ]);
    }
}
