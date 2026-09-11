@extends('layout.admin')
@section('title', 'Category List')
@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Category List</h2>
        <a href="{{route('category.add')}}" class="btn btn-primary">Add New Category</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Category Name</th>
                    <th>image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Example Row -->
                @php $index = 0; @endphp
                @forelse ($categories as $category)
                    @php $index++; @endphp
                    <tr>
                        <td>{{ $categories->firstItem() + $loop->index }}</td>
                        <td>{{$category->name}}</td>
                        <td>
                            @if($category->image)
                                <img src="{{ asset('storage/'.$category->image) }}" alt="{{ $category->name }}" width="60">
                            @else
                                <span class="text-muted">No Image</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{route('category.edit',$category->id)}}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('category.delete', $category->id) }}" method="POST" class="d-inline admin-delete-form" data-confirm-message="This category and its image will be deleted.">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-muted">No users found.</td>
                    </tr>
                @endforelse
                
                <!-- Loop your categories here -->
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center mt-4 admin-pagination">
        {{ $categories->links() }}
    </div>
</div>
@endsection
