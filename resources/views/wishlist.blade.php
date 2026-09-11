@extends('layout.user')
@section('title', 'Wishlist - Mobile Shop')
@section('styles')
<style>
    .wishlist-page {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .wishlist-header {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .wishlist-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
    }

    .wishlist-title i {
        color: #e74c3c;
    }

    .wishlist-container {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .wishlist-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }

    .wishlist-table th {
        background: linear-gradient(135deg, #00796B 0%, #004D40 100%);
        color: white;
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        border: none;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .wishlist-table th:first-child {
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }

    .wishlist-table th:last-child {
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
        text-align: center;
    }

    .wishlist-table td {
        padding: 1.5rem 1rem;
        border-bottom: 1px solid #e9ecef;
        vertical-align: middle;
    }

    .wishlist-table tr:hover {
        background: #f8f9fa;
        transition: all 0.3s ease;
    }

    .product-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .product-image {
        width: 80px;
        height: 80px;
        border-radius: 10px;
        object-fit: contain;
        background: #f8f9fa;
        padding: 0.5rem;
        border: 2px solid #e9ecef;
    }

    .product-details h5 {
        margin: 0 0 0.5rem 0;
        font-weight: 600;
        color: #2c3e50;
        font-size: 1rem;
    }

    .product-category {
        color: #00796B;
        font-size: 0.8rem;
        font-weight: 500;
        text-transform: uppercase;
    }

    .price-info {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .current-price {
        font-size: 1.2rem;
        font-weight: 700;
        color: #00796B;
    }

    .original-price {
        font-size: 0.9rem;
        color: #95a5a6;
        text-decoration: line-through;
    }

    .stock-status {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .stock-in {
        background: rgba(39, 174, 96, 0.1);
        color: #27ae60;
    }

    .stock-low {
        background: rgba(243, 156, 18, 0.1);
        color: #f39c12;
    }

    .stock-out {
        background: rgba(231, 76, 60, 0.1);
        color: #e74c3c;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }

    .btn-action {
        width: 40px;
        height: 40px;
        border: none;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        cursor: pointer;
        font-size: 1rem;
    }

    .btn-view {
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        color: white;
    }

    .btn-view:hover {
        background: linear-gradient(135deg, #2980b9 0%, #1f5f8b 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
    }

    .btn-cart {
        background: linear-gradient(135deg, #00796B 0%, #004D40 100%);
        color: white;
    }

    .btn-cart:hover {
        background: linear-gradient(135deg, #004D40 0%, #00251a 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 121, 107, 0.3);
    }

    .btn-remove {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        color: white;
    }

    .btn-remove:hover {
        background: linear-gradient(135deg, #c0392b 0%, #a93226 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
    }

    .empty-wishlist {
        text-align: center;
        padding: 4rem 2rem;
        color: #7f8c8d;
    }

    .empty-wishlist i {
        font-size: 4rem;
        color: #e74c3c;
        margin-bottom: 1rem;
    }

    .empty-wishlist h3 {
        color: #2c3e50;
        margin-bottom: 1rem;
    }

    .btn-shop {
        background: linear-gradient(135deg, #00796B 0%, #004D40 100%);
        color: white;
        padding: 1rem 2rem;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        margin-top: 1rem;
    }

    .btn-shop:hover {
        background: linear-gradient(135deg, #004D40 0%, #00251a 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 121, 107, 0.3);
        color: white;
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .wishlist-page {
            padding: 1rem 0;
        }

        .wishlist-header,
        .wishlist-container {
            padding: 1.5rem;
            margin: 0 1rem 1rem 1rem;
        }

        .wishlist-title {
            font-size: 2rem;
        }

        .wishlist-table {
            font-size: 0.9rem;
        }

        .wishlist-table th,
        .wishlist-table td {
            padding: 0.8rem 0.5rem;
        }

        .product-info {
            flex-direction: column;
            text-align: center;
            gap: 0.5rem;
        }

        .product-image {
            width: 60px;
            height: 60px;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-action {
            width: 35px;
            height: 35px;
            font-size: 0.9rem;
        }
    }
</style>
@endsection

@section('content')
<div class="wishlist-page">
    <div class="container">
        <!-- Wishlist Header -->
        <div class="wishlist-header">
            <h1 class="wishlist-title">
                <i class="bi bi-heart-fill"></i>
                WISHLIST
            </h1>
            <p class="text-muted mb-0">Your favorite products saved for later</p>
        </div>

        <!-- Wishlist Content -->
        <div class="wishlist-container">
            @if($wishlistItems && $wishlistItems->count() > 0)
            <div class="table-responsive">
                <table class="wishlist-table">
                    <thead>
                        <tr>
                            <th>PRODUCT</th>
                            <th>PRICE</th>
                            <th>STOCK STATUS</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($wishlistItems as $product)
                        <tr>
                            <td>
                                <div class="product-info">
                                    <img src="{{ asset('storage/' . ($product->image ?? 'default.jpg')) }}"
                                        alt="{{ $product->name }}"
                                        class="product-image">
                                    <div class="product-details">
                                        <h5>{{ $product->name }}</h5>
                                        <div class="product-category">
                                            {{ $product->category->name ?? 'Mobile Phone' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="price-info">
                                    <span class="current-price">₹{{ number_format($product->price) }}</span>
                                    <span class="original-price">₹{{ number_format($product->price + 2000) }}</span>
                                </div>
                            </td>
                            <td>
                                @php
                                $stock = $product->stock ?? 0;
                                $stockClass = $stock > 10 ? 'stock-in' : ($stock > 0 ? 'stock-low' : 'stock-out');
                                $stockText = $stock > 10 ? 'In stock' : ($stock > 0 ? 'Low stock' : 'Out of stock');
                                @endphp
                                <span class="stock-status {{ $stockClass }}">
                                    <i class="fa-solid fa-circle"></i>
                                    {{ $stockText }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('product.show', $product->id) }}"
                                        class="btn-action btn-view"
                                        title="View Product">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    @if(($product->stock ?? 0) > 0)
                                    <a href="{{ route('cart.add', $product->id) }}"
                                        class="btn-action btn-cart"
                                        title="Add to Cart">
                                        <i class="fa-solid fa-cart-plus"></i>
                                    </a>
                                    @else
                                    <button type="button" class="btn-action btn-cart" title="Out of stock" onclick="Swal.fire({toast:true,position:'top-end',icon:'info',title:'This product is not available right now. Please check again later.',showConfirmButton:false,timer:2400})">
                                        <i class="fa-solid fa-cart-plus"></i>
                                    </button>
                                    @endif
                                    <button class="btn-action btn-remove btn-remove-wishlist"
                                        data-id="{{ $product->id }}"
                                        title="Remove from Wishlist">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="empty-wishlist">
                <i class="bi bi-heart"></i>
                <h3>Your wishlist is empty</h3>
                <p>Start adding products you love to your wishlist!</p>
                <a href="{{ route('shop.index') }}" class="btn-shop">
                    <i class="fa-solid fa-shopping-bag"></i>
                    Continue Shopping
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Remove from wishlist
        $('.btn-remove-wishlist').click(function() {
            let button = $(this);
            let productId = button.data('id');
            let row = button.closest('tr');

            Swal.fire({
                icon: 'warning',
                title: 'Remove wishlist item?',
                text: 'This item will be removed from your wishlist.',
                showCancelButton: true,
                confirmButtonText: 'Remove',
                confirmButtonColor: '#dc3545'
            }).then(function(result) {
                if (!result.isConfirmed) return;
                $.post(`/unlike-product/` + productId, function(response) {
                    if (response.status === 'success') {
                        row.fadeOut(300, function() {
                            $(this).remove();
                            // Check if table is empty
                            if ($('.wishlist-table tbody tr').length === 0) {
                                location.reload();
                            }
                        });
                    }
                }).fail(function() {
                    Swal.fire({ icon: 'error', title: 'Could not remove item', text: 'Something went wrong. Please try again.' });
                });
            });
        });
    });
</script>
@endsection