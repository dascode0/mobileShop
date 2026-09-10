<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark ">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('img/logo-3.png') }}" alt="93Mobiles" height="50px">
            </a>
            <form class="d-none d-lg-flex flex-grow-1 mx-3">
                <input class="form-control nav_search w-75" type="search" placeholder="Search for Samsung"
                    aria-label="Search" id="searchBox">
                <button class="btn btn-outline-light nav_search_btn" type="submit"><i
                        class="fa-solid fa-magnifying-glass"></i></button>
            </form>
            <div id="nav_contact" class="d-none d-xl-flex">
                <i class="ri-phone-fill"></i>
                <div id="nav_contact_content mt-2">
                    <span>Need help? Call us:</span>
                    <p class="fs-5">08069856101 </p>
                </div>
            </div>
            <div id="nav-tag">
                <ul class="nav-items me-lg-3">
                    @if (@session('user_id'))
                    <li class="nav-item"><a class="nav-link" href="{{ route('account') }}" id="">
                            <div class="nav-box">
                                <i class="fa-solid fa-user"></i>
                                <span class="nav-tag-text d-none d-lg-flex">welcome</span>
                            </div>
                        </a></li>
                    @else
                    <li class="nav-item"><a class="nav-link" href="javascript:void(0)" id="signup-btn">
                            <div class="nav-box">
                                <i class="fa-solid fa-user"></i>
                                <span class="nav-tag-text d-none d-lg-flex">Sign up</span>
                            </div>
                        </a></li>
                    @endif
                    <li class="nav-item"><a class="nav-link" href="#">
                            <div class="nav-box">
                                <i class="fa-solid fa-code-compare"></i>
                                <span class="nav-tag-text d-none d-lg-flex">Comparison</span>
                            </div>
                        </a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('wishlist.index') }} ">
                            <div class="nav-box">
                                <i class="fa-solid fa-heart-circle-plus"></i>
                                <span class="nav-tag-text d-none d-lg-flex">Favorites</span>
                            </div>
                        </a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('cart.index') }}">
                            <div class="nav-box">
                                <i class="ri-shopping-cart-fill"></i>
                                <span class="nav-tag-text d-none d-lg-flex">My Cart</span>
                            </div>
                        </a></li>
                </ul>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Sign In</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Comparison</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Favorites</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">My Cart</a></li>
                </ul>
            </div> -->
        </div>
        <div class="container d-lg-none mt-2">
            <form class="d-flex w-100">
                <input class="form-control nav_search" type="search" placeholder="Search for Samsung"
                    aria-label="Search">
                <button class="btn btn-outline-light nav_search_btn" type="submit"><i
                        class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>
    </nav>
    <div id="bottom_nav" class="d-none d-xl-flex  ">
        <div id="bottom_nav_first" class="d-flex align-items-center gap-1">
            <div class="btn-group" id="category">
                <button type="button" class="btn btn-secondary dropdown-toggle" id="category"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="ri-menu-4-fill"></i> all derpartment
                </button>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                    <li><a class="dropdown-item" href="#">Menu item</a></li>
                    <li><a class="dropdown-item" href="#">Menu item</a></li>
                    <li><a class="dropdown-item" href="#">Menu item</a></li>
                </ul>
            </div>
            <ul class="d-flex justify-content-center align-items-center gap-4 nav2_item">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('shop.index', ['category' => 8]) }}">Mobiles</a></li>
                <li><a href="{{ route('shop.index', ['category' => 9]) }}">Tablets</a></li>
                <li><a href="{{ route('shop.index') }}">Shop</a></li>
                <li><a href="{{ route('about.page') }}">Our Story</a></li>
                <li><a href="{{ route('news.page') }}">Hot News</a></li>
                <li><a href="{{ route('contact.page') }}">Contacts</a></li>
            </ul>

        </div>
        <div id="bottom_nav_second">
            <div id="outer">
                FLAT10| 10% OFF
                <div id="inner">
                    FLAT10| 10% OFF
                </div>
            </div>
        </div>
    </div>
    <!-- Side Panel -->
    <div id="auth-panel" class="auth-panel">
        <div class="auth-header d-flex justify-content-between align-items-center p-3 ">
            <button class="btn-close" id="close-panel"></button>
        </div>
        <h5 class="m-0 text-center mt-1 fw-bold ">Sign Up</h5>
        <div class="auth-tabs d-flex  row mt-3">
            <div id="login-tab" class="col-6">Login</div>
            <div id="register-tab" class="col-6">Register</div>
            <!-- <button class="btn btn-outline-primary" id="login-tab">Login</button>
            <button class="btn btn-outline-primary" id="register-tab">Register</button> -->
        </div>
        <div class="auth-content p-4">
            <div id="login-form">
                <form action="{{ route('loginSave') }}" method="post">
                    @csrf
                    <label for="email" class="form-label">Email *</label>
                    <input type="text" placeholder="" class="form-control mb-3" name="email" id="email"
                        required>

                    <label for="pass" class="form-label">Password *</label>
                    <input type="password" placeholder="" class="form-control mb-3" id="pass" name="password"
                        required>

                    <button type="submit" class="btn btn-dark w-100">Login</button>
                </form>

            </div>
            <div id="register-form" style="display: none;">
                <form action="{{ route('registerSave') }}" method="post">
                    @csrf
                    <label for="name" class="form-label">Name *</label>
                    <input type="text" placeholder="" class="form-control mb-3" id="name" name="name"
                        required>
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" placeholder="" class="form-control mb-3" id="email" name="email"
                        required>
                    <label for="pass" class="form-label">Password *</label>
                    <input type="password" placeholder="" class="form-control mb-3" id="pass" name="password"
                        required>
                    <label for="password_confirmation" class="form-label">Confirm Password *</label>
                    <input type="password" class="form-control mb-3" id="password_confirmation"
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
    <script type="text/javascript" src="{{ asset('js/navbar.js') }}"></script>
    @yield('scripts')
</body>

</html>