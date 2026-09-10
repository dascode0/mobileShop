@extends('layout.admin')
@section('title', 'Dashboard_Users')
@section('content')

<div class="container mt-4">
    <h2 class="mb-4">All Users</h2>
    <div class="table-responsive">
        <table class="table table-hover align-middle text-center shadow-sm rounded">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                @php $index = 0; @endphp
                @forelse ($users as $user)
                    <tr>
                        @php $index++; @endphp
                        <td>{{ $index}}</td>
                        <td class="text-capitalize">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        @if ($user->is_admin == 1)
                            <td>Admin</td>
                        @else
                            <td>User</td>
                        @endif
                        
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-muted">No users found.</td>
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