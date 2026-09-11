@extends('layout.admin')
@section('title', 'User Details')
@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">User Details</h2>
            <p class="text-muted mb-0">View profile, addresses, and order history.</p>
        </div>
        <a href="{{ route('users') }}" class="btn btn-outline-dark"><i class="fa-solid fa-arrow-left me-2"></i>Back to Users</a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex align-items-center gap-3">
            @if($user->profile_image)
                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }} profile photo" class="rounded-circle" width="72" height="72" style="object-fit: cover;">
            @else
                <i class="fa-solid fa-circle-user text-secondary" style="font-size: 72px;"></i>
            @endif
            <div>
                <h4 class="mb-1">{{ $user->name }}</h4>
                <p class="text-muted mb-0">{{ $user->email }}</p>
                <small class="text-muted">User ID: {{ $user->id }}</small>
            </div>
        </div>
    </div>

    <div class="accordion shadow-sm" id="user-data">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#user-addresses">
                    <i class="fa-solid fa-location-dot me-2"></i>Addresses ({{ $user->addresses->count() }})
                </button>
            </h2>
            <div id="user-addresses" class="accordion-collapse collapse" data-bs-parent="#user-data">
                <div class="accordion-body">
                    @forelse($user->addresses as $address)
                        <div class="border rounded p-3 mb-2">
                            <strong>{{ $address->full_name }}</strong>
                            <p class="text-muted mb-0">
                                {{ $address->address }}, {{ $address->city }}, {{ $address->state }} - {{ $address->pincode }}<br>
                                Phone: {{ $address->phone_number }}
                            </p>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No saved addresses.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#user-orders">
                    <i class="fa-solid fa-bag-shopping me-2"></i>Orders ({{ $user->orders->count() }})
                </button>
            </h2>
            <div id="user-orders" class="accordion-collapse collapse" data-bs-parent="#user-data">
                <div class="accordion-body">
                    @forelse($user->orders as $order)
                        <div class="border rounded p-3 mb-2">
                            <div class="d-flex justify-content-between flex-wrap gap-2">
                                <strong>{{ $order->order_number }}</strong>
                                <span class="badge text-bg-secondary text-capitalize">{{ $order->status }}</span>
                            </div>
                            <div class="text-muted small mt-1">
                                {{ $order->created_at->utc()->timezone('Asia/Kolkata')->format('d M Y, h:i A') }}
                                · {{ $order->orderItems->count() }} item(s)
                                · ₹{{ number_format($order->total, 2) }}
                            </div>
                            <details class="mt-2">
                                <summary class="text-primary">Show order details</summary>
                                <div class="mt-2">
                                    @foreach($order->orderItems as $item)
                                        <div class="small">{{ $item->product->name ?? 'Deleted product' }} · Qty: {{ $item->quantity }} · ₹{{ number_format($item->total, 2) }}</div>
                                    @endforeach
                                </div>
                            </details>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No orders found.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
