@extends('layout.admin')
@section('title', 'Product List')
@section('content')    
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>All Products</h2>
        <a href="{{route('product.add')}}" class="btn btn-primary">Add New Product</a>
    </div>
    <form method="GET" action="{{ route('products.index') }}" class="admin-live-search mb-3">
        <div class="input-group">
            <span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
            <input type="search" name="search" value="{{ $search }}" class="form-control" placeholder="Search products by name or description" aria-label="Search products">
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Category</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Example row -->
            @php  $index= 1; @endphp
            @forelse($products as $product)
              <tr>
                  <td>{{ $products->firstItem() + $loop->index }}</td>
                  <td>
                    @if($product->image)
                      <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" width="60">
                    @endif
                  </td>
                  <td>{{$product->category_id}}</td>
                  <td>{{Str::limit($product->name,30)}}</td>
                  <td>{{Str::limit($product->description,30)}}</td>
                  <td>{{$product->price}}</td>
                  <td>{{$product->stock}}</td>
                  <td>
                      <a href="{{route('product.edit',$product->id)}}" class="btn btn-warning btn-sm">Edit</a>
                      <form action="{{ route('product.delete', $product->id) }}" method="POST" class="d-inline admin-delete-form" data-confirm-message="This product and its image will be deleted.">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                      </form>
                  </td>
              </tr>
            @empty
              <tr>
                  <td colspan="8" class="text-center">No products found</td>
              </tr>
            @endforelse
            <!-- Repeat rows dynamically -->
        </tbody>
    </table>
    <div class="d-flex justify-content-center mt-4 admin-pagination">
        {{ $products->links() }}
    </div>

</div>
@endsection
