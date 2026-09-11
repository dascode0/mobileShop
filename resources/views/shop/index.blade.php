@extends('layout.user')

@section('title', 'Shop')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
@endsection

@section('content')
<main class="shop-page">
    <div class="shop-breadcrumb">
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <a href="{{ route('home') }}">Home</a>
                <span>/</span> Shop
            </div>
            <button type="button" onclick="history.back()" class="btn btn-link">← Return</button>
        </div>
    </div>

    <div class="container py-4 py-lg-5">
        <section class="promo-banner row align-items-center g-3">
            <div class="col-md-6">
                <p class="mb-1">Cosmos Ring Design</p>
                <h1 class="fw-bolder">First Waterproof Smartphone Rated IP69</h1>
                <p class="text-white-50 mb-1">NOW ON SALE</p>
                <h4 class="text-warning fw-bold">45% Flat</h4>
                <a href="#products" class="btn btn-dark mt-2">Shop Now</a>
            </div>
            <div class="col-md-6 text-center">
                <img src="{{ asset('img/shop_banner.webp') }}" alt="Waterproof smartphone promotion">
            </div>
        </section>

        <div class="row g-4 mt-1" id="products">
            <aside class="col-lg-3">
                <button class="btn shop-filter-toggle d-lg-none w-100" type="button" data-bs-toggle="collapse" data-bs-target="#shopFilters" aria-expanded="false">
                    <i class="fa-solid fa-sliders me-2"></i>Filters
                </button>

                <div class="collapse d-lg-block" id="shopFilters">
                    <form class="shop-filters" method="GET" action="{{ route('shop.index') }}">
                        <input type="hidden" name="sort" value="{{ $sort }}">

                        <div class="filter-group">
                            <h2>Categories</h2>
                            <a class="filter-link {{ !request('category') ? 'active' : '' }}" href="{{ route('shop.index', request()->except('category', 'page')) }}">
                                <span>All products</span>
                                <b>{{ $allProductsCount }}</b>
                            </a>
                            @foreach($categories as $category)
                                <a class="filter-link {{ (string) request('category') === (string) $category->id ? 'active' : '' }}"
                                   href="{{ route('shop.index', array_merge(request()->except('category', 'page'), ['category' => $category->id])) }}">
                                    <span>{{ $category->name }}</span>
                                    <b>{{ $category->products_count }}</b>
                                </a>
                            @endforeach
                        </div>

                        <div class="filter-group">
                            <h2>Price range</h2>
                            @foreach(['' => 'All prices', 'under-1000' => 'Under ₹1,000', '1000-5000' => '₹1,000 - ₹5,000', 'above-5000' => 'Above ₹5,000'] as $value => $label)
                                <label class="filter-radio">
                                    <input type="radio" name="price" value="{{ $value }}" @checked(request('price', '') === $value)>
                                    <span>{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>

                        <button class="btn btn-dark w-100" type="submit">Apply filters</button>
                    </form>
                </div>
            </aside>

            <section class="col-lg-9">
                <div class="shop-toolbar">
                    <div>
                        <h2>Shop</h2>
                    </div>

                    <form method="GET" action="{{ route('shop.index') }}">
                        <input type="hidden" name="category" value="{{ request('category') }}">
                        <input type="hidden" name="price" value="{{ request('price') }}">
                        <label class="visually-hidden" for="sort">Sort products</label>
                        <select id="sort" name="sort" class="form-select" onchange="this.form.submit()">
                            <option value="latest" @selected($sort === 'latest')>Newest first</option>
                            <option value="price_low" @selected($sort === 'price_low')>Price: low to high</option>
                            <option value="price_high" @selected($sort === 'price_high')>Price: high to low</option>
                        </select>
                    </form>
                </div>

                @if($products->isNotEmpty())
                    <div class="row g-3">
                        @foreach($products as $product)
                            <div class="col-6 col-md-4">
                                <article class="shop-card">
                                    <a href="{{ route('product.show', $product->id) }}" class="shop-card-image">
                                        <x-storage-image :path="$product->image" :alt="$product->name" />
                                    </a>

                                    <div class="shop-card-body">
                                        <small>{{ $product->category->name ?? 'Uncategorized' }}</small>
                                        <h3>
                                            <a href="{{ route('product.show', $product->id) }}">{{ Str::limit($product->name, 36) }}</a>
                                        </h3>
                                        <p>₹{{ number_format($product->price) }}</p>
                                        <a href="{{ route('product.show', $product->id) }}" class="btn btn-outline-dark w-100 mb-2">View details</a>

                                        <form method="POST" action="{{ route('cart.add.post', $product->id) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-success w-100">Add to cart</button>
                                        </form>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>

                    <div class="shop-pagination mt-4" aria-label="Shop pagination">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="shop-empty">
                        <i class="fa-solid fa-box-open"></i>
                        <h3>No products found</h3>
                        <p>Try a different category or price range.</p>
                        <a href="{{ route('shop.index') }}" class="btn btn-dark">Clear filters</a>
                    </div>
                @endif
            </section>
        </div>
    </div>
</main>
@endsection
