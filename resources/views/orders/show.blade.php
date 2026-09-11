@extends('layout.admin')
@section('title', 'Order ' . $order->order_number)
@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Order #{{ $order->order_number }}</h2>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-dark"><i class="fa-solid fa-arrow-left me-2"></i>Back to Orders</a>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">Items</div>
                <div class="card-body">
                    <table class="table align-middle">
                        <thead>
                            <tr><th>Product</th><th>Qty</th><th>Price</th><th>Total</th></tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                            <tr>
                                <td>{{ $item->product->name ?? 'Deleted product' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>₹{{ number_format($item->price, 2) }}</td>
                                <td>₹{{ number_format($item->total, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-end">
                        <p class="mb-1">Subtotal: ₹{{ number_format($order->subtotal, 2) }}</p>
                        <p class="mb-1">Tax: ₹{{ number_format($order->tax, 2) }}</p>
                        <p class="mb-1">Shipping: {{ $order->shipping == 0 ? 'FREE' : '₹' . number_format($order->shipping, 2) }}</p>
                        <h5>Total: ₹{{ number_format($order->total, 2) }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-dark text-white">Customer</div>
                <div class="card-body">
                    <p class="mb-1"><strong>{{ $order->user->name ?? 'Deleted user' }}</strong></p>
                    <p class="mb-0 text-muted">{{ $order->user->email ?? '' }}</p>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-dark text-white">Delivery Address</div>
                <div class="card-body">
                    @if($order->address)
                        <p class="mb-1">{{ $order->address->full_name }}</p>
                        <p class="mb-1">{{ $order->address->address }}</p>
                        <p class="mb-1">{{ $order->address->city }}, {{ $order->address->state }} - {{ $order->address->pincode }}</p>
                        <p class="mb-0">Phone: {{ $order->address->phone_number }}</p>
                        @if($order->address->alternative_phone)
                        <p class="mb-0">Alt Phone: {{ $order->address->alternative_phone }}</p>
                        @endif
                    @else
                        <p class="text-muted mb-0">Address unavailable</p>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">Order Status</div>
                <div class="card-body">
                    <p class="mb-2">Payment method: <span class="text-uppercase">{{ $order->payment_method }}</span></p>
                    <p class="mb-2">Placed on: {{ $order->created_at->format('d M Y, h:i A') }}</p>
                    <label class="form-label">Status</label>
                    <select class="form-select order-status-select" data-order-id="{{ $order->id }}">
                        @foreach(['pending','confirmed','processing','shipped','delivered','cancelled'] as $status)
                            <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
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
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                body: JSON.stringify({ status })
            });
            const result = await response.json();
            if (!result.success) alert(result.message || 'Failed to update order status');
        } catch (err) {
            alert('Network error while updating order status');
        }
    });
});
</script>
@endsection
