@extends('layout.admin')
@section('title', 'Orders')
@section('content')
<div class="container mt-4">
    <h2 class="mb-4">All Orders</h2>

    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card text-white bg-dark"><div class="card-body">
                <h6 class="card-title">Total Orders</h6>
                <p class="card-text fs-4 mb-0">{{ $stats['total_orders'] }}</p>
            </div></div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card text-white bg-warning"><div class="card-body">
                <h6 class="card-title">Pending</h6>
                <p class="card-text fs-4 mb-0">{{ $stats['pending'] }}</p>
            </div></div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card text-white bg-success"><div class="card-body">
                <h6 class="card-title">Delivered</h6>
                <p class="card-text fs-4 mb-0">{{ $stats['delivered'] }}</p>
            </div></div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card text-white bg-primary"><div class="card-body">
                <h6 class="card-title">Revenue</h6>
                <p class="card-text fs-4 mb-0">₹{{ number_format($stats['revenue'], 2) }}</p>
            </div></div>
        </div>
    </div>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Search by order # / customer name / email" value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All statuses</option>
                @foreach(['pending','confirmed','processing','shipped','delivered','cancelled'] as $status)
                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-dark w-100">Filter</button>
        </div>
        @if(request('search') || request('status'))
        <div class="col-md-2">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
        </div>
        @endif
    </form>

    <div class="table-responsive">
        <table class="table table-hover align-middle text-center shadow-sm rounded">
            <thead class="table-dark">
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Address</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td class="fw-semibold">{{ $order->order_number }}</td>
                    <td>
                        {{ $order->user->name ?? 'Deleted user' }}<br>
                        <span class="text-muted small">{{ $order->user->email ?? '' }}</span>
                    </td>
                    <td class="text-start small">
                        @if($order->address)
                            {{ $order->address->city }}, {{ $order->address->state }}<br>
                            <span class="text-muted">{{ $order->address->phone_number }}</span>
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </td>
                    <td>{{ $order->orderItems->count() }}</td>
                    <td>₹{{ number_format($order->total, 2) }}</td>
                    <td class="text-uppercase">{{ $order->payment_method }}</td>
                    <td style="min-width: 160px;">
                        <select class="form-select form-select-sm order-status-select" data-order-id="{{ $order->id }}">
                            @foreach(['pending','confirmed','processing','shipped','delivered','cancelled'] as $status)
                                <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="small">{{ $order->created_at->utc()->timezone('Asia/Kolkata')->format('d M Y') }}</td>
                    <td><a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-dark">View</a></td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-muted py-4">No orders found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.querySelectorAll('.order-status-select').forEach(function (select) {
    select.addEventListener('change', async function () {
        const orderId = this.getAttribute('data-order-id');
        const status = this.value;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        try {
            const response = await fetch(`/admin/orders/${orderId}/status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ status })
            });
            const result = await response.json();
            if (!result.success) {
                alert(result.message || 'Failed to update order status');
            }
        } catch (err) {
            alert('Network error while updating order status');
        }
    });
});
</script>
@endsection
