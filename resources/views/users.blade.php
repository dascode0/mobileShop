@extends('layout.admin')
@section('title', 'Dashboard_Users')
@section('content')

<div class="container mt-4">
    <h2 class="mb-4">All Users</h2>
    <form method="GET" action="{{ route('users') }}" class="admin-live-search mb-3">
        <div class="input-group">
            <span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
            <input type="search" name="search" value="{{ $search }}" class="form-control" placeholder="Search users by name or email" aria-label="Search users">
        </div>
    </form>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <div class="table-responsive">
        <table class="table table-hover align-middle text-center shadow-sm rounded">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @php $index = 0; @endphp
                @forelse ($users as $user)
                    <tr>
                        @php $index++; @endphp
                        <td>{{ $users->firstItem() + $loop->index }}</td>
                        <td class="text-capitalize">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>User</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fa-solid fa-eye me-1"></i>View
                                </a>
                                <form action="{{ route('users.delete', $user) }}" method="POST" class="admin-delete-form" data-confirm-message="This user and all related data will be permanently deleted.">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fa-solid fa-trash me-1"></i>Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                        
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-muted">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $users->links() }}   
        </div>

    </div>
</div>
@endsection