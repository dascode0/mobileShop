@extends('layout.admin')
@section('title', 'Dashboard')
@section('content')
        <div class="container mt-4">
            <div class="row g-3">
                <div class="col-md-3 col-sm-6">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Users</h5>
                            <p class="card-text fs-3 mb-0">{{ $usercount }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="{{ route('admin.orders.index') }}" class="text-decoration-none">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Orders</h5>
                                <p class="card-text fs-3 mb-0">{{ $ordercount }}</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="{{ route('products.index') }}" class="text-decoration-none">
                        <div class="card text-white bg-warning mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Products</h5>
                                <p class="card-text fs-3 mb-0">{{ $productcount }}</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="card text-white bg-danger mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Revenue</h5>
                            <p class="card-text fs-3 mb-0">₹{{ number_format($revenue, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Recent Orders</h4>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-dark">View all orders</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle shadow-sm rounded">
                        <thead class="table-dark">
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                            <tr>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->user->name ?? 'Deleted user' }}</td>
                                <td>{{ $order->created_at->utc()->timezone('Asia/Kolkata')->format('d M Y') }}</td>
                                <td>₹{{ number_format($order->total, 2) }}</td>
                                <td><span class="badge text-bg-secondary text-capitalize">{{ $order->status }}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No orders placed yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
@endsection
