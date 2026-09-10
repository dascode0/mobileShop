@extends('layout.admin')
@section('title', 'Edit Category')
@section('content')

<div class="container my-5">
    <h2 class="mb-4">Add New Category</h2>

    <form action="{{route('category.update',$category->id)}}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter category name" value="{{$category->name}}" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Category Image</label>
            <input class="form-control" type="file" id="image" name="image" value="{{$category->image}}" accept="image/*">
             @if($category->image)
                <div class="mt-2">
                    <p>Current Image:</p>
                    <img src="{{ asset('storage/'.$category->image) }}" alt="{{ $category->name }}" width="100">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Add Category</button>
        <a href="{{route('categories.index')}}" class="btn btn-secondary">Back to List</a>
    </form>
</div>
@endsection
