@extends('layout.admin')
@section('title', 'Product List')
@section('content')    
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>All Products</h2>
        <a href="{{route('product.add')}}" class="btn btn-primary">Add New Product</a>
    </div>

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
                  <td>{{$index++}}</td>
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
                      <a class="btn btn-danger btn-sm" href="{{route('product.delete',$product->id)}}">Delete</a>
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

  

</div>
@endsection
