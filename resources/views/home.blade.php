@extends('layout.user')
@section('title', 'Home')
@section('styles')
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
@endsection
@section('content')
    <div class="container-fluid main ps-lg-5 pe-lg-5">
        <div class="row p-2">
            <div class="first_main col-lg-5 p-2"><a href="#">
                    <div class="first_main_img">
                        <img src="img/slide01-1.jpeg" alt="" srcset="">
                    </div>
                    <div class="first_main_content">
                        <h1 class="fw-bold">Big Saving Days Sales</h1>
                        <p class=" fs-5">Don't miss out on this big sale</p>
                        <button class="btn ">View Details</button>
                    </div>
                </a></div>
            <div class="second_main col-lg-3 p-2 d-none d-md-block"><a href="#">
                    <div class="second_main_img">
                        <img src="img/slide01-2.jpeg" alt="" srcset="">
                    </div>
                    <div class="second_main_content">
                        <h1 class="fw-bold">Ultra Portable</h1>
                        <p class=" fs-5">as powerful as it is portable</p>
                        <button class="btn btn-dark">Shop Now</button>
                    </div>
                    <div class="shadow"></div>
                </a></div>
            <div class="third_main col-lg-4 p-2">
                <div class="third_top"><a href="">
                        <img src="img/slide01-3.jpeg" alt="">
                        <div class="third_top_content">
                            <h1 class="fw-bold">Handheld</h1>
                            <p class=" fs-5">USB 3 Rechargeable</p>
                            <p class=" fs-5 mt-2">Shop Now <i class="fa-solid fa-arrow-right"></i></p>
                        </div>
                        <div class="shadow"></div>
                    </a></div>
                <div class="third_bottom"><a href="#">
                        <img src="img/slide01-4.jpeg" alt="">
                        <div class="third_bottom_content">
                            <h1 class="fw-bold">Gearbox</h1>
                            <p class=" fs-5">Upto 30% Discount </p>
                            <p class=" fs-5 mt-2">Shop Now <i class="fa-solid fa-arrow-right"></i></p>
                        </div>
                        <div class="border"></div>
                    </a></div>
            </div>
        </div>
        <div class="row p-2 d-flex gap-2">
            <div class="col-md main-box d-flex justify-content-center align-items-center gap-3">
                <i class="fa-solid fa-tags "></i>
                <p>Log in <span>get up to 50% discounts</span></p>
            </div>
            <div class="col-md main-box d-none d-sm-flex justify-content-center align-items-center gap-3">
                <i class="fa-solid fa-house-chimney"></i>
                <p>Open new stores in your city </p>
            </div>
            <div class="col-md main-box d-flex justify-content-center align-items-center gap-3">
                <i class="fa-solid fa-truck-ramp-box"></i>
                <p>Free fast express delivery with tracking </p>
            </div>
            <div class="col-lg  main-box d-flex justify-content-center align-items-center gap-3">
                <i class="fa-solid fa-shield"></i>
                <p>Equipment loose and damage insurance </p>
            </div>
            <div class="col-md main-box d-none d-xl-flex justify-content-center align-items-center gap-3">
                <i class="fa-solid fa-credit-card"></i>
                <p>Installment without overpayments</p>
            </div>
        </div>
    </div>

    <!-- category section  -->

    <div class="category ps-lg-5 pe-lg-5 ps-2 pe-2">
        <h1 class="text-center pt-4 fw-bold fs-2">Popular Category</h1>
        <div class="swiper mySwiper mt-5">
            <div class="swiper-wrapper">
                @foreach($categories as $category)
                <div class="swiper-slide swiper-slide1">
                    <div class="category_box">
                        <a href="{{route('shop.index', ['category' => $category->id])}}" class="text-decoration-none text-dark">
                            <div class="category_img">
                                <img src="{{asset('storage/'.$category->image)}}" alt="">
                            </div>
                            <p class="mt-2">{{$category->name}}</p>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-button-next d-block d-xl-none"></div>
            <div class="swiper-button-prev d-block d-xl-none"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <!-- New Arrivals Products secction -->

    <div class="new_arrivals ps-lg-5 pe-lg-5 ps-2 pe-2">
        <h1 class="text-center pt-4 fw-bold fs-2">New Arrivals product</h1>
        <div class="swiper mySwiper mt-5 swiper1">
            <div class="swiper-wrapper">
                @foreach($products as $product)
                <div class="swiper-slide swiper-slide2" id="">
                    <div class="new_arrivals_box">
                        <a href="{{route('product.show',$product->id)}}" class="text-decoration-none text-dark">
                            <div class="image-box"><img src="{{asset('storage/'.$product->image)}}" alt=""></div>
                            <p class="text-secondary text-start mt-1 m-0" style="font-size: 15px;">
                                {{ $product->category->name ?? 'Uncategorized' }}
                            </p>
                            <p class="text-start m-0 fs-4"><a href="#" class="text-decoration-none text-dark">
                                {{Str::limit($product->name,15)}}
                            </a></p>
                            <div class="text-start m-0 d-flex gap-2">
                                <del class="text-secondary fs-6"><i class="fa-solid fa-indian-rupee-sign"></i>{{$product->price +1000}}</del>
                                <p><i class="fa-solid fa-indian-rupee-sign"></i>{{$product->price}}</p>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-button-next d-block d-xl-none"></div>
            <div class="swiper-button-prev d-block d-xl-none"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    {{-- special slider section --}}

    <div class="swiper mySwiper2 ">
        <div class="swiper-wrapper special_slider h-100">
            <div class="swiper-slide slide-1">
                <div style="position:absolute; top:20%; left:8%; color:white; max-width:90%; text-align:left;">
                    <p class="fs-5; fw-1">New Camera. New Design.</p>
                    <h1 style=" margin-bottom:0.5rem;" class="fs-1; fw-bold">iPhone 15 Pro Max</h1>
                    <hr style="width:60px; border:2px solid #fff; margin:1rem 0;">
                    <p style=" margin-bottom:1.5rem;" class="fs-5">Titanium. So Strong. So Light. So Pro.</p>
                    <a href="#" style="display:inline-block; background:#d1f5ee; color:#1a3c34; padding:0.45rem 2rem; border-radius:12px; font-size:1.2rem; text-decoration:none; font-weight:500;">
                        Shop now <span style="font-size:1.2em;">&#8594;</span>
                    </a>
                </div>
            </div>
            <div class="swiper-slide slide-2">
                <div style="position:absolute; top:20%; left:8%; color:#004d40; max-width:90%; text-align:left;">
                    <p style="margin-bottom:0.5rem; color:#15937e; " class="fs-5; fw-1">Experience Sound</p>
                    <h1 style="margin-bottom:0.5rem; color:#111;" class="fs-1; fw-bold">Freedom with AirPods</h1>
                    <hr style="width:60px; border:2px solid #15937e; margin:1rem 0;">
                    <p style="margin-bottom:1.5rem; color:#222;" class="fs-4">Unleash Wireless Sound Freedom.</p>
                    <a href="#" style="display:inline-block; background:#15937e; color:#fff; padding:0.45rem 2rem; border-radius:12px; font-size:1.2rem; text-decoration:none; font-weight:500;">
                        Discover <span style="font-size:1.2em;">&#8594;</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="custom-swiper2-nav">
            <button class="custom-swiper2-prev"><i class="fa-solid fa-chevron-left"></i></button>
            <button class="custom-swiper2-next"><i class="fa-solid fa-chevron-right"></i></button>
        </div>
    </div>

     <!-- Our Advantages Section -->
    <div class="container my-5">
        <h2 class="text-center fw-bold mb-4">Our Advantages</h2>
        <div class="row g-3 justify-content-center">
            <div class="col-12 col-md-6 col-lg-3">
                <div class="advantage-box d-flex align-items-center gap-3 p-3">
                    <i class="fa-solid fa-percent fa-2x "></i>
                    <span class="fw-semibold">Fee-Free Installment</span>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="advantage-box d-flex align-items-center gap-3 p-3">
                    <i class="fa-solid fa-shield-check fa-2x "></i>
                    <span class="fw-semibold">Best Price Guarantee</span>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="advantage-box d-flex align-items-center gap-3 p-3">
                    <i class="fa-solid fa-coins fa-2x "></i>
                    <span class="fw-semibold">Bonus Program 93Mobiles</span>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="advantage-box d-flex align-items-center gap-3 p-3">
                    <i class="fa-solid fa-calendar-day fa-2x"></i>
                    <span class="fw-semibold">Same-Day Pickup</span>
                </div>
            </div>
        </div>
        <div class="row g-3 justify-content-center mt-1">
            <div class="col-12 col-md-6 col-lg-3">
                <div class="advantage-box d-flex align-items-center gap-3 p-3">
                    <i class="fa-solid fa-truck fa-2x "></i>
                    <span class="fw-semibold">Convenient Delivery</span>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="advantage-box d-flex align-items-center gap-3 p-3">
                    <i class="fa-solid fa-cogs fa-2x"></i>
                    <span class="fw-semibold">Wholesale Price</span>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="advantage-box d-flex align-items-center gap-3 p-3">
                    <i class="fa-solid fa-car fa-2x "></i>
                    <span class="fw-semibold">Next-Day Delivery</span>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="advantage-box d-flex align-items-center gap-3 p-3">
                    <i class="fa-solid fa-rotate fa-2x "></i>
                    <span class="fw-semibold">Assured Buy Back</span>
                </div>
            </div>
        </div>
    </div>

    {{-- promotion section --}}

    <div class="container my-5">
        <div class="row g-4">
            <!-- Left Card: Promotions -->
            <div class="col-12 col-md-6">
                <div class="promo-card promo-card1 h-100 p-4">
                    <div class="flex-grow-1">
                        <h4 class="fw-bold mb-2">Didn't Find Anything Interesting?</h4>
                        <p class="mb-2 text-secondary">Perhaps you will find something among our promotions!</p>
                        <a href="#" class="fw-bold text-success text-decoration-none">All Promotions</a>
                    </div>
                </div>
            </div>
            <!-- Right Card: Newsletter -->
            <div class="col-12 col-md-6">
                <div class="promo-card promo-card2 h-100 p-4 bg-light-blue">
                    <div class="flex-grow-1 p-4">
                        <h4 class="fw-bold mb-2">Get the most interesting offers first to you!</h4>
                        <form class="d-flex mt-2" style="max-width:350px;">
                            <input type="email" class="form-control me-2" placeholder="Enter Email ID" required>
                            <button type="submit" class="btn btn-success px-3">+</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
@endsection
@section('scripts')
    <script type="text/javascript" src="{{asset('js/script.js')}}"></script>
    <script>
        @if(session('success'))
            Swal.fire({
                toast: true,
                position: 'top',
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
                position: 'top',
                icon: 'error',
                title: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        @endif
    </script>

@endsection


