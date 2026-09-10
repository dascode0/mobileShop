@extends('layout.admin')
@section('title', 'Add Product')
@section('content')

<div class="container my-5">
    <h2>Add New Product</h2>

    <form action="{{route('product.save')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="category" class="form-label">Select Category</label>
            <select class="form-select" id="category" name="category_id" required>
                <option value="" disabled selected>Select a category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach                
            </select>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter product name" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Product Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter product description"></textarea>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price (₹)</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Enter price" required>
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Stock Quantity</label>
            <input type="number" class="form-control" id="stock" name="stock" placeholder="Enter available stock" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Product Image</label>
            <input class="form-control" type="file" id="image" name="image" accept="image/*">
        </div>

        {{-- <!-- For multiple images in future -->
        <div class="mb-3">
            <label for="images" class="form-label">Product Images (Multiple)</label>
            <input class="form-control" type="file" id="images" name="images[]" accept="image/*" multiple>
        </div> --}}

        <button type="submit" class="btn btn-success">Add Product</button>
        <a href="{{route('products.index')}}" class="btn btn-secondary">Back to Products</a>
    </form>
</div>

@endsection
