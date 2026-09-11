@extends('layout.user')
@section('title', 'Shopping Cart')

@section('styles')
<style>
    .cart-container {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .cart-header {
        background: linear-gradient(135deg, #00796B 0%, #004D40 100%);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0, 121, 107, 0.3);
    }

    .cart-item-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border: none;
    }

    .cart-item-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .product-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .product-name {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }

    .product-price {
        color: #00796B;
        font-weight: 700;
        font-size: 1.2rem;
    }

    .quantity-controls {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: #f8f9fa;
        padding: 0.5rem;
        border-radius: 10px;
    }

    .quantity-input {
        width: 60px;
        text-align: center;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 0.5rem;
        font-weight: 600;
    }

    .btn-update {
        background: linear-gradient(135deg, #00796B 0%, #004D40 100%);
        border: none;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-update:hover {
        background: linear-gradient(135deg, #004D40 0%, #00251a 100%);
        transform: translateY(-2px);
    }

    .btn-remove {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        border: none;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-remove:hover {
        background: linear-gradient(135deg, #c0392b 0%, #a93226 100%);
        transform: translateY(-2px);
    }

    .cart-summary {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        position: sticky;
        top: 2rem;
    }

    .summary-title {
        color: #2c3e50;
        font-weight: 700;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .total-amount {
        background: linear-gradient(135deg, #00796B 0%, #004D40 100%);
        color: white;
        padding: 1rem;
        border-radius: 10px;
        text-align: center;
        margin: 1rem 0;
        font-size: 1.3rem;
        font-weight: 700;
    }

    .btn-checkout {
        background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
        border: none;
        color: white;
        padding: 1rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 1.1rem;
        width: 100%;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-checkout:hover {
        background: linear-gradient(135deg, #229954 0%, #1e8449 100%);
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(39, 174, 96, 0.3);
        color: white;
        text-decoration: none;
    }

    .btn-continue {
        background: transparent;
        border: 2px solid #00796B;
        color: #00796B;
        padding: 1rem;
        border-radius: 10px;
        font-weight: 600;
        width: 100%;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        margin-top: 0.5rem;
    }

    .btn-continue:hover {
        background: #00796B;
        color: white;
        transform: translateY(-1px);
        text-decoration: none;
    }

    .empty-cart {
        background: white;
        border-radius: 20px;
        padding: 4rem 2rem;
        text-align: center;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }

    .empty-cart-icon {
        font-size: 4rem;
        color: #bdc3c7;
        margin-bottom: 1rem;
    }

    .clear-all-btn {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        border: none;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .clear-all-btn:hover {
        background: linear-gradient(135deg, #c0392b 0%, #a93226 100%);
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .cart-container {
            padding: 1rem 0;
        }

        .cart-header {
            padding: 1.5rem;
            margin-bottom: 1rem;
        }

        .cart-item-card {
            padding: 1rem;
        }

        .product-image {
            width: 80px;
            height: 80px;
        }

        .cart-summary {
            position: static;
            margin-top: 2rem;
        }
    }
</style>
@endsection

@section('content')
<div class="cart-container">
    <div class="container">
        @if(empty($cartitems) || $cartitems->count() == 0)
        <div class="empty-cart">
            <i class="fa-solid fa-cart-shopping empty-cart-icon"></i>
            <h1 class="mt-3 mb-3">Your Shopping Cart is Empty</h1>
            <p class="text-muted mb-2">Looks like you haven't added anything to your cart yet.</p>
            <p class="text-muted mb-4">Start shopping now to fill your cart with amazing mobile devices!</p>
            <a href="{{route('shop.index')}}" class="btn btn-checkout" style="max-width: 300px;">
                <i class="fa-solid fa-mobile-screen-button me-2"></i>Start Shopping
            </a>
        </div>
        @else
        <div class="cart-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h1 class="mb-2"><i class="fa-solid fa-cart-shopping me-3"></i>Shopping Cart</h1>
                    <p class="mb-0 opacity-75">{{$cartitems->pluck('product_id')->unique()->count()}} item(s) in your cart</p>
                </div>
                <a href="{{route('cart.clearAll')}}" class="clear-all-btn mt-2 mt-md-0">
                    <i class="fa-solid fa-trash me-2"></i>Clear All
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8">
                @foreach($cartitems as $item)
                <div class="cart-item-card">
                    <div class="row align-items-center">
                        <div class="col-md-2 col-4 text-center">
                            <img src="{{asset('storage/'.$item->product->image)}}" alt="{{$item->product->name}}" class="product-image">
                        </div>
                        <div class="col-md-4 col-8">
                            <h5 class="product-name">{{$item->product->name}}</h5>
                            <p class="product-price mb-0">₹{{number_format($item->product->price)}}</p>
                        </div>
                        <div class="col-md-3 col-6 mt-3 mt-md-0">
                            <form action="{{ route('cart.updateQuantity',$item->product->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{$item->id}}">
                                <div class="quantity-controls">
                                    <label class="small text-muted mb-0">Qty:</label>
                                    <input type="number" name="quantity" class="quantity-input" value="{{$item->quantity}}" min="1">
                                    <button type="submit" class="btn-update">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-2 col-3 text-center mt-3 mt-md-0">
                            <p class="product-price mb-2">₹{{number_format($item->product->price * $item->quantity)}}</p>
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn-remove">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Cart Summary -->
            <div class="col-lg-4">
                <div class="cart-summary">
                    <h4 class="summary-title">
                        <i class="fa-solid fa-receipt me-2"></i>Order Summary
                    </h4>

                    @php
                    $subtotal = 0;
                    $itemCount = 0;
                    foreach($cartitems as $item) {
                    $subtotal += $item->product->price * $item->quantity;
                    $itemCount += $item->quantity;
                    }
                    $shipping = $subtotal > 1000 ? 0 : 50;
                    $total = $subtotal + $shipping;
                    @endphp

                    <div class="d-flex justify-content-between mb-2">
                        <span>Items ({{$itemCount}}):</span>
                        <span>₹{{number_format($subtotal)}}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping:</span>
                        <span class="{{$shipping == 0 ? 'text-success' : ''}}">{{$shipping == 0 ? 'FREE' : '₹'.number_format($shipping)}}</span>
                    </div>

                    @if($shipping == 0)
                    <small class="text-success mb-3 d-block">
                        <i class="fa-solid fa-check-circle me-1"></i>Free shipping on orders over ₹1000!
                    </small>
                    @else
                    <small class="text-muted mb-3 d-block">
                        <i class="fa-solid fa-info-circle me-1"></i>Free shipping on orders over ₹1000
                    </small>
                    @endif

                    <hr>

                    <div class="total-amount">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Total:</span>
                            <span>₹{{number_format($total)}}</span>
                        </div>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="btn-checkout">
                        <i class="fa-solid fa-credit-card me-2"></i>Proceed to Checkout
                    </a>

                    <a href="{{route('shop.index')}}" class="btn-continue">
                        <i class="fa-solid fa-arrow-left me-2"></i>Continue Shopping
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    @if(session('success'))
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: "{{ session('success') }}",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });
    @endif

    @if(session('error'))
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'error',
        title: "{{ session('error') }}",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });
    @endif
</script>
@endsection