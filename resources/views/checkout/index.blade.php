@extends('layout.user')
@section('title', 'Checkout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="checkout-container">
        <div class="container">
            <!-- Checkout Header -->
            <div class="checkout-header">
                <h1><i class="fa-solid fa-credit-card me-3"></i>Secure Checkout</h1>
                <p class="mb-0">Complete your purchase in 3 simple steps</p>
            </div>

            <!-- Progress Steps -->
            <div class="progress-steps">
                <div class="step active" data-step="1">
                    <div class="step-circle">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <span class="step-label">Login</span>
                </div>
                <div class="step-line"></div>
                <div class="step" data-step="2">
                    <div class="step-circle">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <span class="step-label">Address</span>
                </div>
                <div class="step-line"></div>
                <div class="step" data-step="3">
                    <div class="step-circle">
                        <i class="fa-solid fa-receipt"></i>
                    </div>
                    <span class="step-label">Review Order</span>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <!-- Step 1: Login Check -->
                    <div class="checkout-step" id="step-1">
                        <div class="step-card">
                            <div class="step-header">
                                <h3><i class="fa-solid fa-user me-2"></i>Step 1: Account Information</h3>
                            </div>
                            <div class="logged-in-section">
                                <div class="user-info">
                                    <div class="user-avatar">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <div class="user-details">
                                        <h4 style="color: #00796b;">Welcome back, <span style="font-weight: bold; color: #00796b;">{{ Auth::user()->name }}</span>!</h4>
                                        <p class="text-secondary">{{ Auth::user()->email }}</p>
                                    </div>
                                    <button class="btn-continue" onclick="nextStep(2)">
                                        <i class="fa-solid fa-arrow-right me-2"></i>Continue
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Address Management -->
                    <div class="checkout-step" id="step-2" style="display: none;">
                        <div class="step-card">
                            <div class="step-header">
                                <h3><i class="fa-solid fa-location-dot me-2"></i>Step 2: Delivery Address</h3>
                            </div>

                            <div class="address-section">
                                <!-- Existing Addresses -->
                                <div class="existing-addresses" id="existing-addresses">
                                    <h5>Select Delivery Address</h5>
                                    <div class="address-list">
                                        <!-- Sample existing address -->
                                        @forelse ($addresses as $address)
                                            <div class="address-card" data-address-id="{{ $address->id }}">
                                                <div class="address-content">
                                                    <div class="address-header">
                                                        <h6><i class="fa-solid fa-home me-2"></i>Address
                                                            {{ $loop->iteration }}</h6>
                                                        <div class="address-actions">
                                                            <button class="btn-edit"
                                                                onclick="editAddress({{ $address->id }})">
                                                                <i class="fa-solid fa-edit"></i>
                                                            </button>
                                                            <button class="btn-delete"
                                                                onclick="deleteAddress({{ $address->id }})">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <p class="address-text">
                                                        {{ $address->full_name }}<br>
                                                        {{ $address->address }}<br>
                                                        {{ $address->city }}, {{ $address->state }}
                                                        {{ $address->pincode }}<br>
                                                        Phone: {{ $address->phone_number }}
                                                        @if ($address->alternative_phone)
                                                            <br>Alt: {{ $address->alternative_phone }}
                                                        @endif
                                                    </p>
                                                </div>
                                                <input type="radio" name="selected_address" value="{{ $address->id }}"
                                                    class="address-radio">
                                            </div>
                                        @empty
                                            <div class="no-addresses">
                                                <i class="fa-solid fa-location-dot mb-3"></i>
                                                <p>No addresses found. Please add a delivery address to continue.</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>

                                <!-- Add New Address -->
                                <div class="add-address-section">
                                    <button class="btn-add-address" onclick="toggleAddressForm()">
                                        <i class="fa-solid fa-plus me-2"></i>Add New Address
                                    </button>

                                    <div class="address-form" id="address-form" style="display: none;">
                                        <h5>Add Delivery Address</h5>
                                        <form id="new-address-form">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Full Name</label>
                                                        <input type="text" class="form-control" name="full_name"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Phone Number</label>
                                                        <input type="tel" class="form-control" name="phone_number"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Pincode</label>
                                                <input type="text" class="form-control" name="pincode" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Address</label>
                                                <input type="text" class="form-control" name="address"
                                                    placeholder="Street address, P.O. box, company name, c/o" required>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label">City</label>
                                                        <input type="text" class="form-control" name="city"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label">State</label>
                                                        <select class="form-control" name="state" required>
                                                            <option value="">Select State</option>
                                                            <option value="Andaman &amp; Nicobar Islands">Andaman &amp;
                                                                Nicobar Islands</option>
                                                            <option value="Andhra Pradesh">Andhra Pradesh</option>
                                                            <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                                            <option value="Assam">Assam</option>
                                                            <option value="Bihar">Bihar</option>
                                                            <option value="Chandigarh">Chandigarh</option>
                                                            <option value="Chhattisgarh">Chhattisgarh</option>
                                                            <option value="Dadra &amp; Nagar Haveli &amp; Daman &amp; Diu">
                                                                Dadra &amp; Nagar Haveli &amp; Daman &amp; Diu</option>
                                                            <option value="Delhi">Delhi</option>
                                                            <option value="Goa">Goa</option>
                                                            <option value="Gujarat">Gujarat</option>
                                                            <option value="Haryana">Haryana</option>
                                                            <option value="Himachal Pradesh">Himachal Pradesh</option>
                                                            <option value="Jammu &amp; Kashmir">Jammu &amp; Kashmir
                                                            </option>
                                                            <option value="Jharkhand">Jharkhand</option>
                                                            <option value="Karnataka">Karnataka</option>
                                                            <option value="Kerala">Kerala</option>
                                                            <option value="Ladakh">Ladakh</option>
                                                            <option value="Lakshadweep">Lakshadweep</option>
                                                            <option value="Madhya Pradesh">Madhya Pradesh</option>
                                                            <option value="Maharashtra">Maharashtra</option>
                                                            <option value="Manipur">Manipur</option>
                                                            <option value="Meghalaya">Meghalaya</option>
                                                            <option value="Mizoram">Mizoram</option>
                                                            <option value="Nagaland">Nagaland</option>
                                                            <option value="Odisha">Odisha</option>
                                                            <option value="Puducherry">Puducherry</option>
                                                            <option value="Punjab">Punjab</option>
                                                            <option value="Rajasthan">Rajasthan</option>
                                                            <option value="Sikkim">Sikkim</option>
                                                            <option value="Tamil Nadu">Tamil Nadu</option>
                                                            <option value="Telangana">Telangana</option>
                                                            <option value="Tripura">Tripura</option>
                                                            <option value="Uttarakhand">Uttarakhand</option>
                                                            <option value="Uttar Pradesh">Uttar Pradesh</option>
                                                            <option value="West Bengal">West Bengal</option>
                                                            <!-- Add more states -->
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Alternate phone (optional)</label>
                                                        <input type="tel" class="form-control"
                                                            name="alternative_phone">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-actions">
                                                <button type="button" class="btn-secondary"
                                                    onclick="toggleAddressForm()">
                                                    Cancel
                                                </button>
                                                <button type="submit" class="btn-primary">
                                                    <i class="fa-solid fa-save me-2"></i>Save Address
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="step-actions">
                                    <button class="btn-back" onclick="prevStep(1)">
                                        <i class="fa-solid fa-arrow-left me-2"></i>Back
                                    </button>
                                    <button class="btn-continue" onclick="nextStep(3)" id="continue-address">
                                        <i class="fa-solid fa-arrow-right me-2"></i>Continue to Review
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Order Summary -->
                    <div class="checkout-step" id="step-3" style="display: none;">
                        <div class="step-card">
                            <div class="step-header">
                                <h3><i class="fa-solid fa-receipt me-2"></i>Step 3: Review Your Order</h3>
                            </div>

                            <div class="order-review">
                                <!-- Order Items -->
                                <div class="order-items">
                                    <h5>Order Items</h5>
                                    <div class="items-list" id="order-items-list">
                                        @forelse ($cartItems as $item)
                                            <div class="order-item">
                                                <div class="item-image">
                                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                                        alt="{{ $item->product->name }}">
                                                </div>
                                                <div class="item-details">
                                                    <h2>{{ $item->product->name }}</h2>
                                                    <p class="text-gray">
                                                        {{ Str::limit($item->product->description, 300) }}</p>
                                                    <div class="item-price">
                                                        <span class="quantity">Qty: {{ $item->quantity }}</span>
                                                        <span
                                                            class="price">₹{{ number_format($item->product->price * $item->quantity, 0) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="empty-cart">
                                                <i class="fa-solid fa-shopping-cart mb-3"></i>
                                                <p>No items in cart</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>

                                <!-- Delivery Address Summary -->
                                <div class="delivery-summary">
                                    <h5>Delivery Address</h5>
                                    <div class="address-summary" id="selected-address-summary">
                                        <p class="text-muted">Please select an address from Step 2</p>
                                    </div>
                                </div>

                                <!-- Payment Method Selection -->
                                <div class="payment-method-section">
                                    <h5>Payment Method</h5>
                                    <div class="payment-options">
                                        <div class="payment-option">
                                            <input type="radio" id="cod" name="payment_method" value="cod"
                                                class="payment-radio">
                                            <label for="cod" class="payment-label">
                                                <div class="payment-content">
                                                    <div class="payment-icon">
                                                        <i class="fa-solid fa-money-bill"></i>
                                                    </div>
                                                    <div class="payment-details">
                                                        <h6>Cash on Delivery</h6>
                                                        <p class="text-muted">Pay when you receive your order</p>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>

                                        <div class="payment-option">
                                            <input type="radio" id="card" name="payment_method" value="card"
                                                class="payment-radio">
                                            <label for="card" class="payment-label">
                                                <div class="payment-content">
                                                    <div class="payment-icon">
                                                        <i class="fa-solid fa-credit-card"></i>
                                                    </div>
                                                    <div class="payment-details">
                                                        <h6>Credit/Debit Card</h6>
                                                        <p class="text-muted">Pay securely with your card</p>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>

                                        <div class="payment-option">
                                            <input type="radio" id="upi" name="payment_method" value="upi"
                                                class="payment-radio">
                                            <label for="upi" class="payment-label">
                                                <div class="payment-content">
                                                    <div class="payment-icon">
                                                        <i class="fa-solid fa-mobile-alt"></i>
                                                    </div>
                                                    <div class="payment-details">
                                                        <h6>UPI Payment</h6>
                                                        <p class="text-muted">Pay using UPI apps</p>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="step-actions">
                                    <button class="btn-back" onclick="prevStep(2)">
                                        <i class="fa-solid fa-arrow-left me-2"></i>Back to Address
                                    </button>
                                    <button class="btn-place-order" onclick="placeOrder()">
                                        <i class="fa-solid fa-check me-2"></i>Place Order
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary Sidebar -->
                <div class="col-lg-4">
                    <div class="order-summary-sidebar">
                        <h4 class="summary-title">
                            <i class="fa-solid fa-shopping-bag me-2"></i>Order Summary
                        </h4>

                        <div class="summary-calculations">
                            <div class="calculation-row">
                                <span>Subtotal:</span>
                                <span id="subtotal-amount">₹{{ number_format($subtotal, 0) }}</span>
                            </div>
                            <div class="calculation-row">
                                <span>Shipping:</span>
                                <span id="shipping-amount" class="{{ $shipping == 0 ? 'text-success' : '' }}">
                                    {{ $shipping == 0 ? 'FREE' : '₹' . number_format($shipping, 0) }}
                                </span>
                            </div>
                            <div class="calculation-row">
                                <span>Tax:</span>
                                <span id="tax-amount">₹{{ number_format($tax, 0) }}</span>
                            </div>
                            <hr>
                            <div class="total-row">
                                <span>Total:</span>
                                <span id="total-amount">₹{{ number_format($total, 0) }}</span>
                            </div>
                        </div>

                        <div class="security-badges">
                            <div class="security-badge">
                                <i class="fa-solid fa-shield-halved"></i>
                                <span>Secure Checkout</span>
                            </div>
                            <div class="security-badge">
                                <i class="fa-solid fa-truck"></i>
                                <span>Free Delivery</span>
                            </div>
                            <div class="security-badge">
                                <i class="fa-solid fa-undo"></i>
                                <span>Easy Returns</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/checkout.js') }}"></script>
@endsection
