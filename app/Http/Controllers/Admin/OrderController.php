<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * List every order placed on the site, newest first.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'address', 'orderItems.product']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        $stats = [
            'total_orders' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'revenue' => (float) Order::whereNotIn('status', ['cancelled'])->sum('total'),
        ];

        return view('orders.index', compact('orders', 'stats'));
    }

    /**
     * Show a single order with full item and address detail.
     */
    public function show($id)
    {
        $order = Order::with(['user', 'address', 'orderItems.product'])->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    /**
     * Update an order's status from the admin panel.
     */
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully',
            'status' => $order->status,
        ]);
    }
}
