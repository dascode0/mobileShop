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
                                <p class="card-text fs-3 mb-0" id="dashboard-order-count">{{ $ordercount }}</p>
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
                            <p class="card-text fs-3 mb-0" id="dashboard-revenue">₹{{ number_format($revenue, 2) }}</p>
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
                        <tbody id="dashboard-recent-orders">
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
        <div class="text-muted small mt-2"><i class="fa-solid fa-rotate me-1"></i>Orders update automatically.</div>
        <script>
            const dashboardOrdersUrl = @json(route('dashboard.orders'));
            async function refreshDashboardOrders() {
                try {
                    const response = await fetch(dashboardOrdersUrl, { headers: { 'Accept': 'application/json' } });
                    if (!response.ok) return;
                    const data = await response.json();
                    document.getElementById('dashboard-order-count').textContent = data.order_count;
                    document.getElementById('dashboard-revenue').textContent = '₹' + Number(data.revenue).toLocaleString('en-IN', { minimumFractionDigits: 2 });
                    document.getElementById('dashboard-recent-orders').innerHTML = data.orders.length
                        ? data.orders.map(order => `<tr><td>${order.number}</td><td>${order.customer}</td><td>${order.date}</td><td>₹${order.total}</td><td><span class="badge text-bg-secondary text-capitalize">${order.status}</span></td></tr>`).join('')
                        : '<tr><td colspan="5" class="text-center text-muted py-4">No orders placed yet.</td></tr>';
                } catch (error) {
                    console.error('Dashboard refresh failed', error);
                }
            }
            setInterval(refreshDashboardOrders, 15000);
        </script>
@endsection
