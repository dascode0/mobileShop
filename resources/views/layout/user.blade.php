<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/png">
    <title>@yield('title')</title>
    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    {{-- slider --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- fontawesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    {{-- sweetalert2 alerte css cdn --}}
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- external css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/navbar.css') }}">
    @yield('styles')

</head>

<body>
    @if ($errors->any())
    <script>
        let errorMessages = "";
        // @foreach ($errors->all() as $error)
        // errorMessages += "{{ $error }}\n";
        // @endforeach
        // alert(errorMessages);
    </script>
    @endif
    <!-- Customer navigation -->
    <header class="site-header">
        <nav class="navbar navbar-expand-xl navbar-dark top-nav" aria-label="Main navigation">
            <div class="container-fluid px-lg-4">
                <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('img/logo-3.png') }}" alt="93Mobiles"></a>
                <form class="nav-search d-none d-lg-flex" role="search"><label class="visually-hidden" for="searchBox">Search products</label><input class="form-control" type="search" placeholder="Search for Samsung" id="searchBox"><button class="btn" type="submit" aria-label="Search"><i class="fa-solid fa-magnifying-glass"></i></button></form>
                <div class="nav-help d-none d-xxl-flex"><i class="ri-phone-fill"></i><span>Need help?<strong>08069856101</strong></span></div>
                <ul class="header-actions mb-0">
                    @if (session('user_id'))
                        <li><a href="{{ route('account') }}" aria-label="My account"><i class="fa-solid fa-user"></i><span class="d-none d-lg-inline">Account</span></a></li>
                    @else
                        <li><button type="button" id="signup-btn" aria-label="Log in or register"><i
                                    class="fa-solid fa-user"></i><span class="d-none d-lg-inline">Sign
                                    in</span></button></li>
                    @endif
                    <li><a href="{{ route('wishlist.index') }}" aria-label="Favorites"><span class="action-icon"><i class="fa-solid fa-heart"></i>@if($wishlistCount > 0)<span class="nav-count">{{ $wishlistCount > 99 ? '99+' : $wishlistCount }}</span>@endif</span><span class="d-none d-lg-inline">Favorites</span></a></li>
                    <li><a href="{{ route('cart.index') }}" aria-label="My cart"><span class="action-icon"><i class="ri-shopping-cart-fill"></i>@if($cartCount > 0)<span class="nav-count">{{ $cartCount > 99 ? '99+' : $cartCount }}</span>@endif</span><span class="d-none d-lg-inline">My cart</span></a></li>
                </ul>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#primaryNavigation" aria-controls="primaryNavigation" aria-expanded="false"
                    aria-label="Open menu"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse mobile-navigation" id="primaryNavigation">
                    <form class="nav-search nav-search--mobile d-lg-none" role="search"><label class="visually-hidden" for="mobileSearch">Search products</label><input class="form-control" type="search" placeholder="Search products" id="mobileSearch"><button class="btn" type="submit" aria-label="Search"><i class="fa-solid fa-magnifying-glass"></i></button></form>
                    <ul class="navbar-nav"><li><a href="{{ route('home') }}">Home</a></li><li><a href="{{ route('shop.index') }}">Shop all products</a></li><li><a href="{{ route('about.page') }}">Our story</a></li><li><a href="{{ route('news.page') }}">Hot news</a></li><li><a href="{{ route('contact.page') }}">Contact us</a></li></ul>
                </div>
            </div>
        </nav>
        <nav class="bottom-nav d-none d-xl-block" aria-label="Product navigation">
            <div class="container-fluid px-4 d-flex align-items-center gap-3">
                <div class="dropdown"><button class="department-button dropdown-toggle" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-menu-4-fill"></i> All
                        departments</button>
                    <ul class="dropdown-menu department-menu">
                        @forelse($navigationCategories as $category)
                            <li><a class="dropdown-item"
                                    href="{{ route('shop.index', ['category' => $category->id]) }}">{{ $category->name }}</a>
                        </li>@empty<li><span class="dropdown-item-text">No categories available</span></li>
                        @endforelse
                    </ul>
                </div>
                <ul class="bottom-links mb-0">
                    <li><a class="{{ request()->routeIs('home') ? 'active' : '' }}"
                            href="{{ route('home') }}">Home</a></li>
                    <li><a class="{{ request()->routeIs('shop.index') ? 'active' : '' }}"
                            href="{{ route('shop.index') }}">Shop</a></li>
                    <li><a class="{{ request()->routeIs('about.page') ? 'active' : '' }}"
                            href="{{ route('about.page') }}">Our Story</a></li>
                    <li><a class="{{ request()->routeIs('news.page') ? 'active' : '' }}"
                            href="{{ route('news.page') }}">Hot News</a></li>
                    <li><a class="{{ request()->routeIs('contact.page') ? 'active' : '' }}"
                            href="{{ route('contact.page') }}">Contacts</a></li>
                </ul>
                <span class="offer-pill ms-auto">FLAT10 · 10% OFF</span>
            </div>
        </nav>
    </header>
    <!-- Side Panel -->
    <div id="auth-panel" class="auth-panel">
        <div class="auth-header d-flex justify-content-between align-items-center p-3 ">
            <button class="btn-close" id="close-panel"></button>
        </div>
        <h5 class="m-0 text-center mt-1 fw-bold ">Account access</h5>
        <div class="auth-tabs d-flex  row mt-3">
            <div id="login-tab" class="col-6 active">Login</div>
            <div id="register-tab" class="col-6">Register</div>
            <!-- <button class="btn btn-outline-primary" id="login-tab">Login</button>
            <button class="btn btn-outline-primary" id="register-tab">Register</button> -->
        </div>
        <div class="auth-content p-4">
            @if ($errors->any())
                <div class="alert alert-danger py-2 small" role="alert">
                    <i class="fa-solid fa-circle-exclamation me-1"></i>{{ $errors->first() }}
                </div>
            @endif
            <div id="login-form">
                <form action="{{ route('loginSave') }}" method="post">
                    @csrf
                    <label for="login-email" class="form-label">Email *</label>
                    <input type="email" placeholder="" class="form-control mb-3" name="email" id="login-email"
                        value="{{ old('email') }}" required>

                    <label for="login-password" class="form-label">Password *</label>
                    <input type="password" placeholder="" class="form-control mb-3" id="login-password" name="password"
                        required>

                    <button type="submit" class="btn btn-dark w-100">Login</button>
                </form>

            </div>
            <div id="register-form" hidden>
                <form action="{{ route('registerSave') }}" method="post">
                    @csrf
                    <label for="name" class="form-label">Name *</label>
                    <input type="text" placeholder="" class="form-control mb-3" id="register-name" name="name"
                        value="{{ old('name') }}" required>
                    <label for="register-email" class="form-label">Email *</label>
                    <input type="email" placeholder="" class="form-control mb-3" id="register-email" name="email"
                        value="{{ old('email') }}" required>
                    <label for="register-password" class="form-label">Password *</label>
                    <input type="password" placeholder="" class="form-control mb-3" id="register-password" name="password"
                        required>
                    <label for="password_confirmation" class="form-label">Confirm Password *</label>
                    <input type="password" class="form-control mb-3" id="register-password_confirmation"
                        name="password_confirmation" required>
                    <button class="btn btn-dark w-100">Register</button>
                </form>
            </div>

        </div>
    </div>

    @yield('content')

    <!-- Responsive Modern Footer -->
    <footer class="footer bg-dark text-light pt-5 pb-3 mt-5">
        <div class="container">
            <div class="row gy-4">
                <div class="col-12 col-md-4">
                    <img src="{{ asset('img/logo-3.png') }}" alt="93Mobiles" height="50px">
                    <p class="small">Your one-stop shop for the latest electronics, fashion, and home appliances.
                        Enjoy fast delivery, best prices, and top-notch service.</p>
                </div>
                <div class="col-6 col-md-2">
                    <h6 class="fw-semibold mb-3">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light text-decoration-none">Home</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Shop</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Categories</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Contact</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md-3">
                    <h6 class="fw-semibold mb-3">Contact Us</h6>
                    <ul class="list-unstyled small">
                        <li><i class="fa-solid fa-location-dot me-2"></i>123 Main St, City, Country</li>
                        <li><i class="fa-solid fa-phone me-2"></i>+1 234 567 890</li>
                        <li><i class="fa-solid fa-envelope me-2"></i>info@avigadgetbox.com</li>
                    </ul>
                </div>
                <div class="col-12 col-md-3">
                    <h6 class="fw-semibold mb-3">Follow Us</h6>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-light fs-5"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-light fs-5"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-light fs-5"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-light fs-5"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <hr class="border-secondary my-4">
            <div class="row">
                <div class="col text-center small">
                    &copy; {{ date('Y') }} avigadgetbox. All rights reserved.
                </div>
            </div>
        </div>
    </footer>
    <!-- End Footer -->


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    {{-- swiper js  --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    {{-- SweetAlert2 js cdn --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- external js -->
    <script>
        window.authPanelTab = @json(session('auth_panel', 'login'));
        window.authPanelOpen = @json($errors->any() || session()->has('auth_panel'));
        window.productSearchUrl = @json(route('products.search'));
    </script>
    <script type="text/javascript" src="{{ asset('js/navbar.js') }}"></script>
    @yield('scripts')
</body>

</html>
