@extends('layout.user')
@section('title', 'Shop')
@section('styles')
<style>
  body {
    background: #f8f9fa;
  }

  /* promo baneer */
  .promo-banner {
    background-color: #00796b !important;
    /* Teal shade */
    color: white;
    border-radius: 12px;
    padding: 20px;
  }

  .promo-banner .btn-dark {
    border-radius: 10px;
    padding: 10px 20px;
  }

  .promo-banner img {
    max-width: 100%;
    height: auto;
  }

  @media (min-width: 768px) {
    .promo-banner h2 {
      font-size: 2.5rem;
    }
  }
</style>
@endsection
@section('content')
<div class="container-fluid p-1 px-5 d-flex justify-content-between align-items-center bg-light">
  <div class="d-flex align-items-center justify-content-center">
    <a href="{{route('home')}}" class="text-decoration-none text-dark">Home</a>
    <span class="text-muted mx-2"> &gt; </span>
    <span class="text-secondary">Shop</span>
  </div>

  <div>
    <a href="{{route('home')}}" class="text-decoration-none text-secondary">
      < Return to previous page</a>
  </div>
</div>
<div class="container py-5">
  {{-- this is the top banner --}}
  <div class="row promo-banner align-items-center">
    <div class="col-md-6 mb-4 mb-md-0">
      <p class="mb-1">Cosmos Ring Design</p>
      <h2 class="mb-3 fw-bolder">First Waterproof Smartphone Rated IP69</h2>
      <p class="mb-1 text-white-50">NOW ON SALE</p>
      <h4 class="text-warning fw-bold">45% Flat</h4>
      <a href="#" class="btn btn-dark mt-2">Shop Now</a>
    </div>
    <div class="col-md-6 text-center">
      <img src="img/shop_banner.webp" alt="Phone Promo" class="img-fluid rounded">
    </div>
  </div>

  {{-- product is show to there --}}
  <div class="row">
    <!-- Sidebar Filters -->
    <div class="col-md-3 mb-4">
      <form action="{{route('shop.index')}}" method="GET">

        {{-- Preserve selected category --}}
        @if(request('category'))
        <input type="hidden" name="category" value="{{ request('category') }}">
        @endif

        <div class="mb-3 mt-3">
          <h3 for="" class="fw-bold">All Category</h3>
          <ul class="list-group border categories bg-gray">
            <li class="list-group-item d-flex justify-content-between align-items-center border-0">
              <a href="{{ route('shop.index') }}" class="text-decoration-none text-dark">All</a>
              <span class="badge bg-dark rounded-pill">{{ $products->total() }}</span>
            </li>
            @foreach($categories as $category)
            <li class="list-group-item d-flex justify-content-between align-items-center border-0">
              <a href="{{ route('shop.index', ['category' => $category->id]) }}" class="text-decoration-none text-dark">
                {{ $category->name }}
              </a>
              <span class="badge bg-primary rounded-pill bg-dark">{{ $category->products->count() }}</span>
            </li>
            @endforeach
          </ul>
        </div>

        <div class="mb-3">
          <label for="" class="form-label fw-bold">Price Range</label>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="price" id="allPrice" value="" {{request('price')=='' ? 'checked' : ''}}>
            <label class="form-check-label" for="allPrice">All</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="price" id="under1000" value="under-1000" {{request('price')=='under-1000' ? 'checked' : ''}}>
            <label class="form-check-label" for="under1000">Under ₹1000</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="price" id="1000to5000" value="1000-5000" {{request('price')=='1000-5000' ? 'checked' : ''}}>
            <label class="form-check-label" for="1000to5000">₹1000 - ₹5000</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="price" id="above5000" value="above-5000" {{request('price')=='above-5000' ? 'checked' : ''}}>
            <label class="form-check-label" for="above5000">Above ₹5000</label>
          </div>
        </div>
        <button type="submit" class="btn btn-dark w-25 rounded-3xl">Apply</button>
      </form>
    </div>

    <!-- Products Grid -->
    <div class="col-md-9">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">Shop</h3>
      </div>
      <div class="row">
        <!-- Example Product Card -->
        @foreach ($products as $product)
        <div class="col-md-4 mb-4">
          <div class="card h-100 shadow-sm">
            <img src="{{asset('storage/'.$product->image)}}" class="card-img-top" alt="Product Name" style="height:100%; object-fit: cover;">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">{{Str::limit($product->name,25)}}</h5>
              <p class="card-text text-muted mb-2">{{$product->category->name}}</p>
              <h6 class="fw-bold mb-3">₹{{$product->price}}</h6>
              <div class="mt-auto">
                <a href="{{route('product.show',$product->id)}}" class="btn btn-outline-dark w-100 mb-2">View Details</a>
                <a href="{{route('cart.add',$product->id)}}" class="btn btn-success w-100">Add to Cart</a>
              </div>
            </div>
          </div>
        </div>
        @endforeach

      </div>

      <!-- Pagination -->
      <div class="d-flex justify-content-center mt-4">
        {{$products->links()}}
      </div>

    </div>
  </div>
</div>
@endsection