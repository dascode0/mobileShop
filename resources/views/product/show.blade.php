@extends('layout.user')
@section('title', $product->name . ' - Mobile Shop')
@section('styles')
<style>
    /* Product Page Container */
    .product-page {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    /* Product Image Section */
    .product-image-container {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }

    .product-main-image {
        width: 100%;
        max-height: 500px;
        object-fit: contain;
        border-radius: 15px;
        transition: transform 0.3s ease;
    }

    .product-main-image:hover {
        transform: scale(1.05);
    }

    .image-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: linear-gradient(135deg, #00796B 0%, #004D40 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.9rem;
        font-weight: 600;
        z-index: 10;
        transition: all 0.3s ease;
    }

    .product-image-container:hover .image-badge {
        transform: scale(0.9);
        opacity: 0.9;
    }

    /* Like/Save Button */
    .like-button {
        position: absolute;
        top: 1rem;
        left: 1rem;
        background: rgba(162, 33, 33, 0.9);
        border: none;
    }

    /* Product Details Section */
    .product-details-container {
        background: #2C2C2C;
        color: #FFFFFF;
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        height: fit-content;
        border: 1px solid #D4AF37;
    }

    .product-summary {
        background: linear-gradient(135deg, #2C2C2C 0%, #1a1a1a 100%);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border-left: 4px solid #D4AF37;
    }

    .product-title {
        font-size: 2.2rem;
        font-weight: 700;
        color: #FFFFFF;
        margin-bottom: 1rem;
        line-height: 1.2;
    }

    .product-category {
        display: inline-block;
        background: linear-gradient(135deg, #D4AF37 0%, #b8941f 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
    }

    .product-price {
        font-size: 2.5rem;
        font-weight: 800;
        color: #D4AF37;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .original-price {
        font-size: 1.5rem;
        color: #95a5a6;
        text-decoration: line-through;
        font-weight: 500;
    }

    .discount-badge {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        color: white;
        padding: 0.3rem 0.8rem;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .btn-add-cart {
        background: linear-gradient(135deg, #D4AF37 0%, #b8941f 100%);
        border: none;
        color: white;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        flex: 1;
        justify-content: center;
        min-width: 200px;
    }

    .btn-add-cart:hover {
        background: linear-gradient(135deg, #b8941f 0%, #9e7f1a 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(212, 175, 55, 0.3);
        color: white;
        text-decoration: none;
    }

    .btn-buy-now {
        background: linear-gradient(135deg, #2C2C2C 0%, #1a1a1a 100%);
        border: 2px solid #D4AF37;
        color: #D4AF37;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        flex: 1;
        justify-content: center;
        min-width: 200px;
    }

    .btn-buy-now:hover {
        background: linear-gradient(135deg, #1a1a1a 0%, #131313 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(243, 156, 18, 0.3);
        color: white;
    }

    /* Product Features */
    .product-features {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.8rem 0;
        border-bottom: 1px solid #e9ecef;
    }

    .feature-item:last-child {
        border-bottom: none;
    }

    .feature-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #00796B 0%, #004D40 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.1rem;
    }

    .feature-text {
        flex: 1;
        font-weight: 600;
        color: #2c3e50;
    }

    .feature-value {
        font-weight: 700;
        color: #00796B;
    }

    /* Stock Status */
    .stock-status {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-weight: 600;
        margin-bottom: 1.5rem;
    }

    .stock-available {
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

    /* Product Description Section */
    .product-description-section {
        background: white;
        border-radius: 20px;
        padding: 2.5rem;
        margin-top: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .description-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .description-title {
        font-size: 2rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 1rem;
        position: relative;
    }

    .description-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: linear-gradient(135deg, #00796B 0%, #004D40 100%);
        border-radius: 2px;
    }

    .description-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        align-items: start;
    }

    .description-text {
        color: #5a6c7d;
        line-height: 1.8;
        font-size: 1.1rem;
        text-align: justify;
    }

    .description-highlights {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 15px;
        padding: 1.5rem;
    }

    .highlight-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
        padding: 0.8rem;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .highlight-item:last-child {
        margin-bottom: 0;
    }

    .highlight-icon {
        width: 35px;
        height: 35px;
        background: linear-gradient(135deg, #00796B 0%, #004D40 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1rem;
    }

    .highlight-text {
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.95rem;
    }

    @media (max-width: 768px) {
        .description-content {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .product-description-section {
            padding: 1.5rem;
        }
    }

    /* Related Products Section */
    .related-products {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        margin-top: 3rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .section-title {
        text-align: center;
        font-size: 2rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 2rem;
        position: relative;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(135deg, #00796B 0%, #004D40 100%);
        border-radius: 2px;
    }

    /* Swiper Customization */
    .swiper1 {
        width: 100%;
        height: 400px;
        padding: 1rem 0;
    }

    .swiper-slide2 {
        background: white;
        border-radius: 15px;
        padding: 1rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .swiper-slide2:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .related-image-box {
        height: 200px;
        width: 100%;
        overflow: hidden;
        border-radius: 10px;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
    }

    .related-image-box img {
        max-height: 100%;
        max-width: 100%;
        width: auto;
        height: auto;
        object-fit: contain;
        transition: transform 0.3s ease;
    }

    .swiper-slide2:hover .related-image-box img {
        transform: scale(1.1);
    }

    .related-product-category {
        color: #00796B;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 0.5rem;
    }

    .related-product-name {
        font-size: 1rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }

    .related-product-price {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 700;
    }

    .related-current-price {
        color: #00796B;
        font-size: 1.1rem;
    }

    .related-original-price {
        color: #95a5a6;
        font-size: 0.9rem;
        text-decoration: line-through;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .product-page {
            padding: 1rem 0;
        }

        .product-image-container,
        .product-details-container {
            margin-bottom: 2rem;
            padding: 1.5rem;
        }

        .product-title {
            font-size: 1.8rem;
        }

        .product-price {
            font-size: 2rem;
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-add-cart,
        .btn-buy-now {
            min-width: 100%;
        }

        .related-products {
            margin-top: 2rem;
            padding: 1.5rem;
        }
    }

    @media (max-width: 576px) {
        .swiper1 {
            height: 350px;
        }

        .related-image-box {
            height: 150px;
        }
    }

    /* Keep the product page aligned with the storefront teal palette. */
    .product-page {
        background: linear-gradient(135deg, #f2fbfa 0%, #e0f2f1 100%);
    }

    .product-image-container,
    .product-description-section,
    .related-products {
        border: 1px solid #d5ebe7;
        box-shadow: 0 14px 32px rgba(0, 39, 38, 0.09);
    }

    .product-details-container {
        background: #ffffff;
        color: #25312e;
        border: 1px solid #d5ebe7;
        box-shadow: 0 14px 32px rgba(0, 39, 38, 0.12);
    }

    .product-summary {
        background: #f2fbfa;
        border-left-color: #00796b;
    }

    .product-title,
    .description-title,
    .section-title {
        color: #002726;
    }

    .product-category,
    .image-badge,
    .feature-icon,
    .highlight-icon {
        background: linear-gradient(135deg, #00796b 0%, #005c53 100%);
    }

    .product-price,
    .feature-value,
    .related-current-price,
    .related-product-category {
        color: #00796b;
    }

    .btn-add-cart {
        background: linear-gradient(135deg, #00796b 0%, #005c53 100%);
    }

    .btn-add-cart:hover {
        background: linear-gradient(135deg, #005c53 0%, #00443d 100%);
        box-shadow: 0 8px 25px rgba(0, 121, 107, 0.28);
    }

    .btn-buy-now {
        background: #ffffff;
        border-color: #00796b;
        color: #00796b;
    }

    .btn-buy-now:hover {
        background: #e0f2f1;
        color: #005c53;
        border-color: #005c53;
    }

    .product-summary h3 {
        color: #002726 !important;
    }

    .product-summary p {
        color: #52635f !important;
    }

    .description-title::after,
    .section-title::after {
        background: linear-gradient(135deg, #00796b 0%, #005c53 100%);
    }

    .swiper-slide2 {
        border: 1px solid #e0eeec;
        box-shadow: 0 6px 18px rgba(0, 39, 38, 0.08);
    }

    .swiper-slide2:hover {
        box-shadow: 0 16px 30px rgba(0, 121, 107, 0.18);
    }

    .related-image-box {
        background: #f2fbfa;
    }

    /* Refined storefront layout */
    .product-page {
        padding: 2.5rem 0 4rem;
        background: #f6fbfa;
    }

    .product-page > .container > .row:first-child {
        align-items: stretch;
    }

    .product-image-container,
    .product-details-container {
        height: 100%;
        border-radius: 1rem;
    }

    .product-image-container {
        min-height: 470px;
        padding: 3.25rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: #fff;
    }

    .product-image-container::before {
        content: '';
        position: absolute;
        inset: 1.25rem;
        border: 1px solid #e4f0ed;
        border-radius: .8rem;
        pointer-events: none;
    }

    .product-main-image {
        position: relative;
        z-index: 1;
        width: auto;
        max-width: 82%;
        max-height: 320px;
        border-radius: .75rem;
    }

    .product-main-image:hover {
        transform: scale(1.025);
    }

    .image-badge {
        top: 1.75rem;
        right: 1.75rem;
        padding: .45rem .8rem;
        border-radius: .45rem;
        background: #e0f2f1;
        color: #00695c;
        font-size: .75rem;
        letter-spacing: .03em;
    }

    .like-button {
        top: 1.7rem;
        left: 1.7rem;
        z-index: 2;
        width: 2.5rem;
        height: 2.5rem;
        border: 1px solid #d5e8e4 !important;
        border-radius: 50%;
        background: #fff !important;
        color: #00796b !important;
        box-shadow: 0 4px 12px rgba(0, 39, 38, .08);
    }

    .like-button.text-danger {
        color: #dc3545 !important;
    }

    .like-button:disabled {
        cursor: wait;
        opacity: .7;
    }

    .product-details-container {
        padding: 2.75rem;
        background: #fff;
    }

    .product-details-container::before {
        content: 'MOBILE COLLECTION';
        display: block;
        margin-bottom: 1rem;
        color: #00796b;
        font-size: .72rem;
        font-weight: 800;
        letter-spacing: .16em;
    }

    .product-title {
        max-width: 600px;
        margin-bottom: .9rem;
        color: #002726;
        font-size: clamp(2rem, 3.4vw, 3rem);
        letter-spacing: -.03em;
    }

    .product-category {
        margin-bottom: 1.6rem;
        padding: 0;
        background: transparent;
        color: #667873;
        font-size: .78rem;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .product-price {
        gap: .7rem;
        margin-bottom: 1.25rem;
        color: #00796b;
        font-size: 2rem;
    }

    .original-price {
        font-size: .95rem;
        color: #8a9995;
    }

    .discount-badge {
        padding: .3rem .5rem;
        border-radius: .3rem;
        background: #e0f2f1;
        color: #00695c;
        font-size: .7rem;
    }

    .stock-status {
        margin-bottom: 1.5rem;
        padding: .55rem .8rem;
        border-radius: .4rem;
        font-size: .82rem;
    }

    .action-buttons {
        gap: .75rem;
        margin-bottom: 1.75rem;
    }

    .btn-add-cart {
        min-width: 0;
        padding: .85rem 1.1rem;
        border-radius: .5rem;
        font-size: .95rem;
    }

    .action-buttons .btn-add-cart {
        width: 100%;
    }

    .product-image-footer {
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        width: 100%;
        max-width: 430px;
        margin-top: 2rem;
        padding-top: 1rem;
        border-top: 1px solid #e2efec;
    }

    .product-image-footer-item {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .4rem;
        padding: 0 .5rem;
        color: #52635f;
        font-size: .7rem;
        font-weight: 700;
        text-align: center;
    }

    .product-image-footer-item + .product-image-footer-item {
        border-left: 1px solid #e2efec;
    }

    .product-image-footer-item i {
        color: #00796b;
        font-size: .85rem;
    }

    .product-features {
        margin-bottom: 1.25rem;
        padding: .75rem 1rem;
        border: 1px solid #e1eeeb;
        border-radius: .7rem;
        background: #f8fbfa;
    }

    .feature-item {
        gap: .75rem;
        padding: .65rem 0;
    }

    .feature-icon {
        width: 2rem;
        height: 2rem;
        flex: 0 0 2rem;
        font-size: .85rem;
    }

    .feature-text {
        font-size: .86rem;
    }

    .feature-value {
        font-size: .82rem;
    }

    .product-summary {
        margin-bottom: 0;
        padding: 1rem 1.1rem;
        border: 1px solid #dcece8;
        border-left: 3px solid #00796b;
        border-radius: .65rem;
    }

    .product-description-section,
    .related-products {
        border-radius: 1rem;
    }

    .product-description-section {
        margin-top: 1.5rem;
        padding: 2.25rem;
    }

    .description-header {
        margin-bottom: 1.5rem;
        text-align: left;
    }

    .description-title,
    .section-title {
        margin-bottom: 0;
        font-size: 1.55rem;
        text-align: left;
    }

    .description-title::after,
    .section-title::after {
        left: 0;
        transform: none;
        width: 2.75rem;
        height: 3px;
    }

    .description-text {
        max-width: 850px;
        font-size: 1rem;
        text-align: left;
    }

    .related-products {
        position: relative;
        margin-top: 1.5rem;
        padding: 2rem 2.5rem 2.25rem;
    }

    .related-products .section-title {
        margin-bottom: 1.25rem;
    }

    .swiper1 {
        height: auto;
        padding: .75rem .15rem 2.4rem;
    }

    .swiper-slide2 {
        height: auto;
        padding: .7rem;
        border-radius: .75rem;
        background: #fff;
    }

    .related-image-box {
        height: 185px;
        margin-bottom: .8rem;
        border-radius: .55rem;
    }

    .related-product-category {
        margin-bottom: .35rem;
        font-size: .68rem;
        letter-spacing: .08em;
    }

    .related-product-name {
        min-height: 2.6em;
        margin-bottom: .6rem;
        font-size: .92rem;
    }

    .related-current-price {
        font-size: 1rem;
    }

    .related-original-price {
        font-size: .78rem;
    }

    .related-products .swiper-button-next,
    .related-products .swiper-button-prev {
        top: 48%;
        width: 2.5rem;
        height: 2.5rem;
        margin-top: 0;
        border: 1px solid #cfe4df;
        border-radius: 50%;
        background: #fff;
        color: #00796b;
        box-shadow: 0 5px 14px rgba(0, 39, 38, .1);
    }

    .related-products .swiper-button-next {
        right: .65rem;
    }

    .related-products .swiper-button-prev {
        left: .65rem;
    }

    .related-products .swiper-button-next::after,
    .related-products .swiper-button-prev::after {
        font-size: .85rem;
        font-weight: 900;
    }

    .related-products .swiper-button-next:hover,
    .related-products .swiper-button-prev:hover {
        background: #00796b;
        color: #fff;
    }

    .related-products .swiper-pagination {
        bottom: 0;
    }

    .related-products .swiper-pagination-bullet-active {
        width: 1.25rem;
        border-radius: .5rem;
        background: #00796b;
    }

    @media (max-width: 767.98px) {
        .product-page {
            padding: 1.25rem 0 2.5rem;
        }

        .product-image-container {
            min-height: 390px;
            padding: 2rem;
        }

        .product-main-image {
            max-width: 88%;
            max-height: 245px;
        }

        .product-image-container::before {
            inset: .9rem;
        }

        .product-details-container {
            padding: 1.5rem;
        }

        .product-title {
            font-size: 1.8rem;
        }

        .product-price {
            font-size: 1.7rem;
        }

        .action-buttons {
            flex-direction: row;
        }

        .btn-add-cart {
            flex: 1;
        }

        .product-image-footer {
            margin-top: 1.5rem;
        }

        .product-image-footer-item {
            flex-direction: column;
            gap: .25rem;
            font-size: .62rem;
        }

        .product-description-section,
        .related-products {
            padding: 1.5rem;
        }

        .related-products .swiper-button-next {
            right: .15rem;
        }

        .related-products .swiper-button-prev {
            left: .15rem;
        }
    }
</style>
@endsection
@section('content')
<div class="product-page">
    <div class="container">
        <div class="row g-4">
            <!-- Product Image Section -->
            <div class="col-lg-6">
                <div class="product-image-container">
                    <!-- If user liked the product -->
                    @if ($isFavorite)
                    <button class="btn-like text-danger like-button" data-id="{{ $product->id }}" data-action="unlike"
                        data-add-url="{{ route('wishlist.add', ['productId' => $product->id]) }}"
                        data-remove-url="{{ route('wishlist.remove', ['id' => $product->id]) }}"
                        data-add-label="Add {{ $product->name }} to favorites"
                        data-remove-label="Remove {{ $product->name }} from favorites"
                        aria-label="Remove {{ $product->name }} from favorites" title="Remove from favorites">
                        <i class="bi bi-heart-fill fs-5"></i>
                    </button>
                    @else
                    <button class="btn-like text-dark like-button" data-id="{{ $product->id }}" data-action="like"
                        data-add-url="{{ route('wishlist.add', ['productId' => $product->id]) }}"
                        data-remove-url="{{ route('wishlist.remove', ['id' => $product->id]) }}"
                        data-add-label="Add {{ $product->name }} to favorites"
                        data-remove-label="Remove {{ $product->name }} from favorites"
                        aria-label="Add {{ $product->name }} to favorites" title="Add to favorites">
                        <i class="bi bi-heart fs-5"></i>
                    </button>
                    @endif
                    <div class="image-badge">
                        <i class="fa-solid fa-mobile-screen-button me-1"></i>Mobile
                    </div>
                    <img src="{{ asset('storage/' . ($product->image ?? 'default.jpg')) }}"
                        alt="{{ $product->name ?? 'Product Image' }}" class="product-main-image">
                    <div class="product-image-footer" aria-label="Product service benefits">
                        <div class="product-image-footer-item">
                            <i class="fa-solid fa-truck-fast"></i>
                            <span>Fast delivery</span>
                        </div>
                        <div class="product-image-footer-item">
                            <i class="fa-solid fa-shield-halved"></i>
                            <span>1 year warranty</span>
                        </div>
                        <div class="product-image-footer-item">
                            <i class="fa-solid fa-rotate-left"></i>
                            <span>7 day returns</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Details Section -->
            <div class="col-lg-6">
                <div class="product-details-container">
                    <h1 class="product-title">{{ $product->name ?? 'Product Name' }}</h1>

                    <div class="product-category">
                        <i class="fa-solid fa-tag me-1"></i>{{ $product->category->name ?? 'Mobile Phone' }}
                    </div>

                    <div class="product-price">
                        <span>₹{{ number_format($product->price ?? 0) }}</span>
                        <span class="original-price">₹{{ number_format(($product->price ?? 0) + 5000) }}</span>
                        <span class="discount-badge">Save ₹5,000</span>
                    </div>

                    <!-- Stock Status -->
                    @php
                    $stock = $product->stock ?? 0;
                    $stockClass = $stock > 10 ? 'stock-available' : ($stock > 0 ? 'stock-low' : 'stock-out');
                    $stockIcon =
                    $stock > 10
                    ? 'fa-check-circle'
                    : ($stock > 0
                    ? 'fa-exclamation-triangle'
                    : 'fa-times-circle');
                    $stockText = $stock > 10 ? 'In Stock' : ($stock > 0 ? 'Low Stock' : 'Out of Stock');
                    @endphp

                    <div class="stock-status {{ $stockClass }}">
                        <i class="fa-solid {{ $stockIcon }}"></i>
                        <span>{{ $stockText }} ({{ $stock }} available)</span>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        @if($stock > 0)
                            <a href="{{ route('cart.add', $product->id) }}" class="btn-add-cart">
                                <i class="fa-solid fa-cart-plus"></i>
                                Add to Cart
                            </a>
                        @else
                            <span class="text-danger small">This product is not available right now. Please check again later.</span>
                        @endif
                    </div>

                    <!-- Product Features -->
                    <div class="product-features">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fa-solid fa-truck-fast"></i>
                            </div>
                            <div class="feature-text">Free Delivery</div>
                            <div class="feature-value">2-3 Days</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
                            <div class="feature-text">Warranty</div>
                            <div class="feature-value">1 Year</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fa-solid fa-rotate-left"></i>
                            </div>
                            <div class="feature-text">Return Policy</div>
                            <div class="feature-value">7 Days</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fa-solid fa-headset"></i>
                            </div>
                            <div class="feature-text">Support</div>
                            <div class="feature-value">24/7</div>
                        </div>
                    </div>

                    <!-- Product Summary -->
                    <div class="product-summary">
                        <h3 style="color: #2c3e50; font-weight: 700; margin-bottom: 1rem; font-size: 1.2rem;">
                            <i class="fa-solid fa-star me-2" style="color: #00796B;"></i>Key Features
                        </h3>
                        <p style="color: #5a6c7d; line-height: 1.6; margin: 0;">
                            {{ Str::limit($product->description ?? 'Premium mobile device with cutting-edge technology and elegant design.', 120) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Description Section -->
        <div class="product-description-section">
            <div class="description-header">
                <h2 class="description-title">
                    <i class="fa-solid fa-info-circle me-2"></i>Product Description
                </h2>
            </div>
            <div class="description-text">
                {{ $product->description ?? 'Experience the latest in mobile technology with this premium device. Featuring cutting-edge specifications and elegant design, this mobile phone delivers exceptional performance for all your daily needs. With advanced camera capabilities, long-lasting battery life, and lightning-fast processing power, this device is perfect for both personal and professional use. The sleek design and premium materials make it a perfect companion for your modern lifestyle.' }}
            </div>
        </div>

        <!-- Related Products Section -->
        <div class="related-products">
            <h2 class="section-title">
                <i class="fa-solid fa-heart me-2"></i>You May Also Like
            </h2>
            <div class="swiper mySwiper swiper1">
                <div class="swiper-wrapper">
                    @foreach ($products as $allproduct)
                    <div class="swiper-slide swiper-slide2">
                        <a href="{{ route('product.show', $allproduct->id) }}" class="text-decoration-none">
                            <div class="related-image-box">
                                <img src="{{ asset('storage/' . $allproduct->image) }}"
                                    alt="{{ $allproduct->name }}">
                            </div>
                            <div class="related-product-category">
                                {{ $allproduct->category->name ?? 'Mobile Phone' }}
                            </div>
                            <h4 class="related-product-name">
                                {{ Str::limit($allproduct->name, 25) }}
                            </h4>
                            <div class="related-product-price">
                                <span class="related-current-price">₹{{ number_format($allproduct->price) }}</span>
                                <span
                                    class="related-original-price">₹{{ number_format($allproduct->price + 2000) }}</span>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
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
        function favoriteNotification(icon, title) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: icon,
                title: title,
                showConfirmButton: false,
                timer: 2400,
                timerProgressBar: true
            });
        }

        function updateWishlistCount(count) {
            const counter = $('#wishlist-count');
            const numericCount = Number(count);

            if (!counter.length || !Number.isFinite(numericCount)) {
                return;
            }

            counter.text(numericCount > 99 ? '99+' : numericCount);
            counter.prop('hidden', numericCount === 0);
        }

        $('.btn-like').on('click', function() {
            const button = $(this);
            const action = button.data('action');
            const addFavoriteUrl = button.data('add-url');
            const removeFavoriteUrl = button.data('remove-url');
            const endpoint = action === 'like' ? addFavoriteUrl : removeFavoriteUrl;
            const addedLabel = button.data('remove-label');
            const removedLabel = button.data('add-label');

            button.prop('disabled', true);

            $.post(endpoint, function(response) {
                if (response.status === 'success') {
                    const isFavorite = action === 'like';
                    button.html(isFavorite
                        ? '<i class="bi bi-heart-fill fs-5"></i>'
                        : '<i class="bi bi-heart fs-5"></i>');
                    button.toggleClass('text-danger', isFavorite).toggleClass('text-dark', !isFavorite);
                    button.data('action', isFavorite ? 'unlike' : 'like');
                    button.attr('aria-label', isFavorite ? addedLabel : removedLabel);
                    button.attr('title', isFavorite ? 'Remove from favorites' : 'Add to favorites');
                    updateWishlistCount(response.wishlistCount);
                    favoriteNotification('success', response.message);
                } else {
                    favoriteNotification('info', response.message);
                }
            }).fail(function(xhr) {
                if (xhr.status === 401) {
                    favoriteNotification('info', 'Please log in to save this product to favorites.');
                } else if (xhr.status === 404) {
                    favoriteNotification('error', 'This product is no longer available.');
                } else {
                    favoriteNotification('error', 'Unable to update favorites. Please try again.');
                }
            }).always(function() {
                button.prop('disabled', false);
            });
        });


    });

    // Swiper initialization
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 4,
        spaceBetween: 18,
        loop: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        breakpoints: {
            992: {
                slidesPerView: 4,
                spaceBetween: 18,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 16,
            },
            576: {
                slidesPerView: 2,
                spaceBetween: 12,
            },
            320: {
                slidesPerView: 1.15,
                spaceBetween: 12,
            }
        }
    });
</script>
@endsection