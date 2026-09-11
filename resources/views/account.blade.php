@extends('layout.user')
@section('title', 'My Account')
@section('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('css/account.css') }}">
@endsection
@section('content')

<div class="main">
    <h1 class="col-12"><i class="fa-solid fa-user"></i> My Account</h1>
    <div class="main_content row mt-0">
        <div class="main_left col-lg-3 col-12 mt-4">
            <div class="profile-photo-wrap">
                @if($user->profile_image)
                    <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }} profile photo" class="profile-photo" id="profile-photo">
                @else
                    <i class="fa-solid fa-circle-user user-logo" id="profile-photo"></i>
                @endif
                <button type="button" class="profile-photo-edit" id="profile-photo-edit" aria-label="Update profile photo">
                    <i class="fa-solid fa-camera"></i>
                </button>
            </div>
            <input type="file" id="profile-image-input" accept="image/jpeg,image/png,image/webp" hidden>
            @if($user->profile_image)
                <button type="button" class="profile-photo-delete" id="profile-photo-delete">Remove photo</button>
            @endif
            <h3 class="mb-0">{{ $user->name }}</h3>
            <p class="fs-5 text-secondary">{{ $user->email }}</p>
            <ul>
                <li><a href="#" class="account-tab-link active" data-tab="dashboard">
                        <i class="fa-solid fa-clipboard"></i>
                        Dashboard
                    </a></li>
                <li><a href="#" class="account-tab-link" data-tab="orders">
                        <i class="fa-solid fa-bag-shopping"></i>
                        Orders
                        @if($orders->count() > 0)
                            <span class="badge rounded-pill bg-secondary">{{ $orders->count() }}</span>
                        @endif
                    </a></li>
                <li><a href="#" class="account-tab-link" data-tab="address">
                        <i class="fa-solid fa-map-location-dot"></i>
                        Address
                    </a></li>
                <li><a href="#" class="account-tab-link" data-tab="account">
                        <i class="fa-regular fa-user"></i>
                        Account details
                    </a></li>
                <li><a href="{{ route('wishlist.index') }}">
                        <i class="fa-regular fa-heart"></i>
                        Wishlist
                    </a></li>
                <li><a href="{{ route('logout') }}">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        Logout
                    </a></li>
            </ul>
        </div>
        <div class="main_right col-lg-9 col-12 p-4">

            {{-- DASHBOARD TAB --}}
            <div class="account-tab-panel" id="tab-dashboard">
                <h3 class="fw-bold">Welcome to your account page</h3>
                <p class="fs-5 text-secondary">Hi {{ $user->name }}, today is a great day to check your account page. you can check also:</p>
                <div class="buttons row p-3 g-3">
                    <div class="col-md">
                        <a href="#" class="btn btn-dark btn-lg w-100 account-tab-link" data-tab="orders"><i class="fa-solid fa-bag-shopping"></i> Recent Orders</a>
                    </div>
                    <div class="col-md">
                        <a href="#" class="btn btn-dark btn-lg w-100 account-tab-link" data-tab="address"><i class="fa-solid fa-map-location-dot"></i> Address</a>
                    </div>
                    <div class="col-md">
                        <a href="#" class="btn btn-dark btn-lg w-100 account-tab-link" data-tab="account"><i class="fa-regular fa-user"></i> Account Details</a>
                    </div>
                </div>

                @if($orders->count() > 0)
                <h5 class="mt-4 mb-3">Your most recent order</h5>
                @php $latest = $orders->first(); @endphp
                <div class="order-card">
                    <div class="order-card-header">
                        <div>
                            <strong>Order #{{ $latest->order_number }}</strong>
                            <div class="text-secondary small">Placed on {{ $latest->created_at->utc()->timezone('Asia/Kolkata')->format('d M Y, h:i A') }}</div>
                        </div>
                        <span class="status-badge status-{{ $latest->status }}">{{ ucfirst($latest->status) }}</span>
                    </div>
                    <div class="order-card-body">
                        <div>{{ $latest->orderItems->count() }} item(s) &bull; Total: ₹{{ number_format($latest->total, 2) }}</div>
                        <a href="#" class="account-tab-link" data-tab="orders">View all orders &rarr;</a>
                    </div>
                </div>
                @else
                <div class="empty-state mt-4">
                    <i class="fa-solid fa-bag-shopping mb-2"></i>
                    <p class="mb-2">You haven't placed any orders yet.</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-dark">Start Shopping</a>
                </div>
                @endif
            </div>

            {{-- ORDERS TAB --}}
            <div class="account-tab-panel" id="tab-orders" style="display:none;">
                <h3 class="fw-bold mb-3">My Orders</h3>

                @if($orders->count() > 0)
                    @foreach($orders as $order)
                    @php
                        $canCancel = in_array($order->status, ['pending', 'confirmed', 'processing'], true);
                        $canDelete = in_array($order->status, ['delivered', 'cancelled'], true);
                    @endphp
                    <article class="order-card {{ $highlightOrder && (string) $order->id === (string) $highlightOrder ? 'order-card-highlight' : '' }}" data-order-id="{{ $order->id }}">
                        <div class="order-card-header">
                            <div class="order-summary-main">
                                <strong>Order #{{ $order->order_number }}</strong>
                                <div class="order-summary-meta">
                                    <span>{{ $order->orderItems->count() }} item(s)</span>
                                    <span>₹{{ number_format($order->total, 2) }}</span>
                                    <span>{{ $order->created_at->utc()->timezone('Asia/Kolkata')->format('d M Y, h:i A') }}</span>
                                </div>
                            </div>
                            <div class="order-summary-actions">
                                <span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                                <button type="button" class="order-toggle" aria-expanded="false" aria-controls="order-details-{{ $order->id }}">
                                    <span class="visually-hidden">Show order details</span>
                                    <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <div class="order-card-body order-details" id="order-details-{{ $order->id }}" hidden>
                            <div class="order-items-mini">
                                @foreach($order->orderItems as $item)
                                <div class="order-item-mini">
                                    <img src="{{ $item->product && $item->product->image ? asset('storage/' . $item->product->image) : asset('img/Item-1.jpeg') }}" alt="{{ $item->product->name ?? 'Product' }}">
                                    <div>
                                        <div class="fw-semibold">{{ $item->product->name ?? 'Product no longer available' }}</div>
                                        <div class="text-secondary small">Qty: {{ $item->quantity }} &times; ₹{{ number_format($item->price, 2) }}</div>
                                    </div>
                                    <div class="ms-auto fw-semibold">₹{{ number_format($item->total, 2) }}</div>
                                </div>
                                @endforeach
                            </div>

                            <div class="order-address-summary mt-3">
                                <strong><i class="fa-solid fa-location-dot me-1"></i>Delivery Address</strong>
                                @if($order->address)
                                <p class="mb-0 text-secondary">
                                    {{ $order->address->full_name }}, {{ $order->address->address }},
                                    {{ $order->address->city }}, {{ $order->address->state }} - {{ $order->address->pincode }}<br>
                                    Phone: {{ $order->address->phone_number }}
                                </p>
                                @else
                                <p class="mb-0 text-secondary">Address unavailable</p>
                                @endif
                            </div>

                            <div class="order-totals mt-3">
                                <div><span>Subtotal</span><span>₹{{ number_format($order->subtotal, 2) }}</span></div>
                                <div><span>Tax</span><span>₹{{ number_format($order->tax, 2) }}</span></div>
                                <div><span>Shipping</span><span>{{ $order->shipping == 0 ? 'FREE' : '₹' . number_format($order->shipping, 2) }}</span></div>
                                <div class="order-total-final"><span>Total</span><span>₹{{ number_format($order->total, 2) }}</span></div>
                            </div>

                            <div class="text-secondary small mt-2">
                                Payment method: <span class="text-uppercase">{{ $order->payment_method }}</span>
                            </div>

                            <div class="order-actions mt-3">
                                @if($canCancel)
                                <button type="button" class="btn btn-outline-danger btn-sm order-cancel-btn">
                                    <i class="fa-solid fa-ban me-1"></i>Cancel order
                                </button>
                                @endif
                                @if($canDelete)
                                <button type="button" class="btn btn-outline-secondary btn-sm order-delete-btn">
                                    <i class="fa-solid fa-trash me-1"></i>Delete history
                                </button>
                                @endif
                            </div>
                        </div>
                    </article>
                    @endforeach
                @else
                <div class="empty-state">
                    <i class="fa-solid fa-bag-shopping mb-2"></i>
                    <p class="mb-2">You haven't placed any orders yet.</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-dark">Start Shopping</a>
                </div>
                @endif
            </div>

            {{-- ADDRESS TAB --}}
            <div class="account-tab-panel" id="tab-address" style="display:none;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="fw-bold mb-0">My Addresses</h3>
                    <button type="button" class="btn btn-dark" id="acc-add-address-btn"><i class="fa-solid fa-plus me-2"></i>Add New Address</button>
                </div>

                <div id="acc-address-list" class="row g-3">
                    @forelse($addresses as $address)
                    <div class="col-md-6 acc-address-card-wrap" data-address-id="{{ $address->id }}">
                        <div class="acc-address-card">
                            <div class="d-flex justify-content-between">
                                <strong><i class="fa-solid fa-location-dot me-2"></i>{{ $address->full_name }}</strong>
                                <div>
                                    <button class="btn btn-sm btn-outline-secondary acc-edit-address" data-id="{{ $address->id }}"><i class="fa-solid fa-pen"></i></button>
                                    <button class="btn btn-sm btn-outline-danger acc-delete-address" data-id="{{ $address->id }}"><i class="fa-solid fa-trash"></i></button>
                                </div>
                            </div>
                            <p class="text-secondary mb-1 mt-2">
                                {{ $address->address }}, {{ $address->city }}, {{ $address->state }} - {{ $address->pincode }}
                            </p>
                            <p class="text-secondary mb-0">
                                Phone: {{ $address->phone_number }}
                                @if($address->alternative_phone) &bull; Alt: {{ $address->alternative_phone }} @endif
                            </p>
                        </div>
                    </div>
                    @empty
                    <div class="col-12" id="acc-no-address">
                        <div class="empty-state">
                            <i class="fa-solid fa-map-location-dot mb-2"></i>
                            <p class="mb-0">No addresses saved yet. Add one so checkout is faster next time.</p>
                        </div>
                    </div>
                    @endforelse
                </div>

                {{-- Add / Edit address form (hidden by default) --}}
                <div class="acc-address-form mt-4" id="acc-address-form" style="display:none;">
                    <h5 id="acc-address-form-title">Add New Address</h5>
                    <form id="acc-address-form-el">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="full_name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" name="phone_number" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Address</label>
                                <input type="text" class="form-control" name="address" placeholder="Street address, P.O. box, company name, c/o" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">City</label>
                                <input type="text" class="form-control" name="city" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">State</label>
                                <input type="text" class="form-control" name="state" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Pincode</label>
                                <input type="text" class="form-control" name="pincode" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Alternate Phone (optional)</label>
                                <input type="tel" class="form-control" name="alternative_phone">
                            </div>
                        </div>
                        <div class="mt-3 d-flex gap-2">
                            <button type="submit" class="btn btn-dark"><i class="fa-solid fa-save me-2"></i>Save Address</button>
                            <button type="button" class="btn btn-outline-secondary" id="acc-cancel-address"><i class="fa-solid fa-xmark me-2"></i>Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ACCOUNT DETAILS TAB --}}
            <div class="account-tab-panel" id="tab-account" style="display:none;">
                <h3 class="fw-bold mb-3">Account Details</h3>
                <div class="acc-details-card">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-secondary">Full Name</label>
                            <div class="fw-semibold fs-5">{{ $user->name }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-secondary">Email Address</label>
                            <div class="fw-semibold fs-5">{{ $user->email }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-secondary">Total Orders Placed</label>
                            <div class="fw-semibold fs-5">{{ $orders->count() }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-secondary">Saved Addresses</label>
                            <div class="fw-semibold fs-5">{{ $addresses->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // ---- Profile photo ----
    const profileInput = document.getElementById('profile-image-input');
    const profileEdit = document.getElementById('profile-photo-edit');
    const profileDelete = document.getElementById('profile-photo-delete');
    const profileWrap = document.querySelector('.profile-photo-wrap');

    if (profileEdit && profileInput) {
        profileEdit.addEventListener('click', () => profileInput.click());
        profileInput.addEventListener('change', async function () {
            if (!this.files.length) return;

            const formData = new FormData();
            formData.append('profile_image', this.files[0]);
            profileEdit.disabled = true;

            try {
                const response = await fetch('{{ route('account.profile-image.update') }}', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                    body: formData
                });
                const result = await response.json();
                if (!response.ok || !result.success) throw new Error(result.message || 'Unable to update profile photo.');

                let photo = document.getElementById('profile-photo');
                if (photo.tagName === 'I') {
                    photo = document.createElement('img');
                    photo.id = 'profile-photo';
                    photo.className = 'profile-photo';
                    photo.alt = '{{ $user->name }} profile photo';
                    profileWrap.insertBefore(photo, profileEdit);
                    document.querySelector('.user-logo')?.remove();
                }
                photo.src = result.image_url + '?v=' + Date.now();

                if (!document.getElementById('profile-photo-delete')) {
                    const removeButton = document.createElement('button');
                    removeButton.type = 'button';
                    removeButton.id = 'profile-photo-delete';
                    removeButton.className = 'profile-photo-delete';
                    removeButton.textContent = 'Remove photo';
                    profileWrap.parentNode.insertBefore(removeButton, profileWrap.nextSibling);
                    bindProfileDelete(removeButton);
                }
                Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Profile photo updated', showConfirmButton: false, timer: 2500 });
            } catch (error) {
                Swal.fire({ icon: 'error', title: 'Could not update photo', text: error.message });
            } finally {
                profileEdit.disabled = false;
                this.value = '';
            }
        });
    }

    function bindProfileDelete(button) {
        button.addEventListener('click', async function () {
            const confirmed = await Swal.fire({
                icon: 'warning',
                title: 'Remove profile photo?',
                showCancelButton: true,
                confirmButtonText: 'Remove',
                confirmButtonColor: '#dc3545'
            });
            if (!confirmed.isConfirmed) return;

            button.disabled = true;
            try {
                const response = await fetch('{{ route('account.profile-image.delete') }}', {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                });
                const result = await response.json();
                if (!response.ok || !result.success) throw new Error(result.message || 'Unable to remove profile photo.');

                const photo = document.getElementById('profile-photo');
                const icon = document.createElement('i');
                icon.id = 'profile-photo';
                icon.className = 'fa-solid fa-circle-user user-logo';
                photo.replaceWith(icon);
                button.remove();
                Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Default profile icon restored', showConfirmButton: false, timer: 2500 });
            } catch (error) {
                button.disabled = false;
                Swal.fire({ icon: 'error', title: 'Could not remove photo', text: error.message });
            }
        });
    }

    if (profileDelete) bindProfileDelete(profileDelete);

    // ---- Tab switching ----
    function showTab(tab) {
        document.querySelectorAll('.account-tab-panel').forEach(p => p.style.display = 'none');
        const panel = document.getElementById('tab-' + tab);
        if (panel) panel.style.display = 'block';

        document.querySelectorAll('.account-tab-link[data-tab]').forEach(l => l.classList.remove('active'));
        document.querySelectorAll('.main_left .account-tab-link[data-tab="' + tab + '"]').forEach(l => l.classList.add('active'));

        const url = new URL(window.location);
        url.searchParams.set('tab', tab);
        window.history.replaceState({}, '', url);
    }

    document.querySelectorAll('.account-tab-link[data-tab]').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            showTab(this.getAttribute('data-tab'));
        });
    });

    const initialTab = "{{ in_array($activeTab, ['dashboard','orders','address','account']) ? $activeTab : 'dashboard' }}";
    showTab(initialTab);

    // ---- Order details and order actions ----
    document.querySelectorAll('.order-toggle').forEach(function (button) {
        button.addEventListener('click', function () {
            const card = button.closest('.order-card');
            const details = document.getElementById(button.getAttribute('aria-controls'));
            const expanded = button.getAttribute('aria-expanded') === 'true';

            button.setAttribute('aria-expanded', String(!expanded));
            details.hidden = expanded;
            card.classList.toggle('is-expanded', !expanded);
        });
    });

    async function updateOrder(orderId, method, actionButton) {
        const response = await fetch(`/account/orders/${orderId}${method === 'PATCH' ? '/cancel' : ''}`, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        });
        const result = await response.json();

        if (!response.ok || !result.success) {
            throw new Error(result.message || 'Unable to update this order.');
        }

        return result;
    }

    document.querySelectorAll('.order-cancel-btn').forEach(function (button) {
        button.addEventListener('click', async function () {
            const card = button.closest('.order-card');
            const confirmed = await Swal.fire({
                icon: 'warning',
                title: 'Cancel this order?',
                text: 'This action cannot be undone.',
                showCancelButton: true,
                confirmButtonText: 'Yes, cancel it',
                confirmButtonColor: '#dc3545'
            });

            if (!confirmed.isConfirmed) return;

            button.disabled = true;
            try {
                await updateOrder(card.dataset.orderId, 'PATCH', button);
                const badge = card.querySelector('.status-badge');
                badge.textContent = 'Cancelled';
                badge.className = 'status-badge status-cancelled';
                button.remove();
                Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Order cancelled', showConfirmButton: false, timer: 2500 });
            } catch (error) {
                button.disabled = false;
                Swal.fire({ icon: 'error', title: 'Could not cancel order', text: error.message });
            }
        });
    });

    document.querySelectorAll('.order-delete-btn').forEach(function (button) {
        button.addEventListener('click', async function () {
            const card = button.closest('.order-card');
            const confirmed = await Swal.fire({
                icon: 'warning',
                title: 'Delete order history?',
                text: 'The order will be permanently removed from your account.',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it',
                confirmButtonColor: '#dc3545'
            });

            if (!confirmed.isConfirmed) return;

            button.disabled = true;
            try {
                await updateOrder(card.dataset.orderId, 'DELETE', button);
                card.remove();
                Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Order history deleted', showConfirmButton: false, timer: 2500 });
            } catch (error) {
                button.disabled = false;
                Swal.fire({ icon: 'error', title: 'Could not delete order', text: error.message });
            }
        });
    });

    @if($highlightOrder)
    Swal.fire({
        icon: 'success',
        title: 'Order placed successfully!',
        text: 'Your order has been placed. You can track its status right here.',
        confirmButtonColor: '#00796B'
    });
    @endif

    // ---- Address management (Add / Edit / Delete) ----
    const addBtn = document.getElementById('acc-add-address-btn');
    const cancelBtn = document.getElementById('acc-cancel-address');
    const form = document.getElementById('acc-address-form');
    const formEl = document.getElementById('acc-address-form-el');
    const formTitle = document.getElementById('acc-address-form-title');
    const addressList = document.getElementById('acc-address-list');

    function resetForm() {
        formEl.reset();
        formEl.removeAttribute('data-edit-id');
        formTitle.textContent = 'Add New Address';
        form.style.display = 'none';
    }

    if (addBtn) {
        addBtn.addEventListener('click', function () {
            resetForm();
            form.style.display = 'block';
            form.scrollIntoView({ behavior: 'smooth' });
        });
    }
    if (cancelBtn) {
        cancelBtn.addEventListener('click', resetForm);
    }

    function addressCardHtml(address) {
        return `
            <div class="col-md-6 acc-address-card-wrap" data-address-id="${address.id}">
                <div class="acc-address-card">
                    <div class="d-flex justify-content-between">
                        <strong><i class="fa-solid fa-location-dot me-2"></i>${address.full_name}</strong>
                        <div>
                            <button class="btn btn-sm btn-outline-secondary acc-edit-address" data-id="${address.id}"><i class="fa-solid fa-pen"></i></button>
                            <button class="btn btn-sm btn-outline-danger acc-delete-address" data-id="${address.id}"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </div>
                    <p class="text-secondary mb-1 mt-2">${address.address}, ${address.city}, ${address.state} - ${address.pincode}</p>
                    <p class="text-secondary mb-0">Phone: ${address.phone_number}${address.alternative_phone ? ' &bull; Alt: ' + address.alternative_phone : ''}</p>
                </div>
            </div>`;
    }

    function bindCardEvents(scopeEl) {
        scopeEl.querySelectorAll('.acc-edit-address').forEach(btn => btn.addEventListener('click', onEditAddress));
        scopeEl.querySelectorAll('.acc-delete-address').forEach(btn => btn.addEventListener('click', onDeleteAddress));
    }
    bindCardEvents(document);

    formEl.addEventListener('submit', async function (e) {
        e.preventDefault();
        const editId = formEl.getAttribute('data-edit-id');
        const formData = new FormData(formEl);
        const submitBtn = formEl.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Saving...';

        try {
            let response;
            if (editId) {
                const params = new URLSearchParams();
                for (const [key, value] of formData.entries()) params.append(key, value);
                response = await fetch(`/addresses/${editId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: params
                });
            } else {
                response = await fetch('/addresses', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                    body: formData
                });
            }

            const result = await response.json();
            if (result.success) {
                const noAddr = document.getElementById('acc-no-address');
                if (noAddr) noAddr.remove();

                if (editId) {
                    const existing = document.querySelector(`.acc-address-card-wrap[data-address-id="${editId}"]`);
                    if (existing) existing.outerHTML = addressCardHtml(result.address);
                } else {
                    addressList.insertAdjacentHTML('beforeend', addressCardHtml(result.address));
                }
                bindCardEvents(addressList);

                resetForm();
                Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: editId ? 'Address updated' : 'Address added', showConfirmButton: false, timer: 2500 });
            } else {
                Swal.fire({ icon: 'error', title: 'Something went wrong', text: result.message || 'Please check the form and try again.' });
            }
        } catch (err) {
            Swal.fire({ icon: 'error', title: 'Network error', text: 'Failed to save address. Please try again.' });
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    });

    async function onEditAddress(e) {
        const id = e.currentTarget.getAttribute('data-id');
        try {
            const response = await fetch(`/addresses/${id}`, {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }
            });
            const address = await response.json();

            formEl.querySelector('input[name="full_name"]').value = address.full_name || '';
            formEl.querySelector('input[name="phone_number"]').value = address.phone_number || '';
            formEl.querySelector('input[name="address"]').value = address.address || '';
            formEl.querySelector('input[name="city"]').value = address.city || '';
            formEl.querySelector('input[name="state"]').value = address.state || '';
            formEl.querySelector('input[name="pincode"]').value = address.pincode || '';
            formEl.querySelector('input[name="alternative_phone"]').value = address.alternative_phone || '';
            formEl.setAttribute('data-edit-id', id);
            formTitle.textContent = 'Edit Address';

            form.style.display = 'block';
            form.scrollIntoView({ behavior: 'smooth' });
        } catch (err) {
            Swal.fire({ icon: 'error', title: 'Could not load address' });
        }
    }

    async function onDeleteAddress(e) {
        const id = e.currentTarget.getAttribute('data-id');
        const confirmResult = await Swal.fire({
            icon: 'warning',
            title: 'Delete this address?',
            text: 'This action cannot be undone.',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            confirmButtonColor: '#e74c3c'
        });
        if (!confirmResult.isConfirmed) return;

        try {
            const response = await fetch(`/addresses/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
            });
            const result = await response.json();
            if (result.success) {
                const card = document.querySelector(`.acc-address-card-wrap[data-address-id="${id}"]`);
                if (card) card.remove();
                if (!document.querySelector('.acc-address-card-wrap')) {
                    addressList.innerHTML = `<div class="col-12" id="acc-no-address"><div class="empty-state"><i class="fa-solid fa-map-location-dot mb-2"></i><p class="mb-0">No addresses saved yet. Add one so checkout is faster next time.</p></div></div>`;
                }
                Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Address deleted', showConfirmButton: false, timer: 2500 });
            } else {
                Swal.fire({ icon: 'error', title: 'Cannot delete address', text: result.message || 'Failed to delete address' });
            }
        } catch (err) {
            Swal.fire({ icon: 'error', title: 'Network error' });
        }
    }
});
</script>
@endsection
