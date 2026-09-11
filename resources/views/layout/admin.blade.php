<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('styles')
    <style>
        body {
            min-height: 100vh;
            display: flex;
        }
        .sidebar {
            min-width: 200px;
            max-width: 200px;
            background-color: #343a40;
            color: #fff;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 10px;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .sidebar a.active {
            background-color: #00796b;
            color: #fff;
            border-left: 4px solid #80cbc4;
            padding-left: 6px;
            font-weight: 600;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
        .admin-pagination .pagination { gap: 6px; }
        .admin-pagination .page-link { border: 0; border-radius: 8px; color: #00796b; }
        .admin-pagination .page-item.active .page-link { background: #00796b; color: #fff; }
        .admin-pagination .page-link:hover { background: #e0f2f1; color: #005f56; }
        @media (max-width: 768px) {
            .sidebar {
                position: absolute;
                left: -200px;
                transition: left 0.3s;
            }
            .sidebar.active {
                left: 0;
            }
        }
    </style>
</head>
<body>

    <div class="sidebar" id="sidebar">
        <h4 class="p-3">My Dashboard</h4>
        <a class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{route('dashboard')}}">Home</a>
        <a class="{{ request()->routeIs('users*') ? 'active' : '' }}" href="{{route('users')}}">Users</a>
        <a class="{{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{route('categories.index')}}">Categories</a>
        <a class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{route('admin.orders.index')}}">Orders</a>
        <a class="{{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{route('products.index')}}">Products</a>
        <a class="{{ request()->routeIs('admin.settings*') ? 'active' : '' }}" href="{{ route('admin.settings') }}">Settings</a>
        <a href="{{route('admin.logout')}}">Log out</a>
    </div>
    
    <div class="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <button class="btn btn-primary d-md-none" id="menu-toggle">☰</button>
                <a class="navbar-brand ms-2" href="{{ route('admin.settings') }}">Welcome, {{ Auth::user()->name }}</a>
                <a class="admin-nav-profile ms-auto" href="{{ route('admin.settings') }}" aria-label="Admin settings">
                    @if(Auth::user()->profile_image)
                        <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="{{ Auth::user()->name }} profile photo">
                    @else
                        <i class="fa-solid fa-circle-user"></i>
                    @endif
                </a>
            </div>
        </nav>
        @if(session('success'))
            <div class="alert alert-success d-flex align-items-center gap-2 mt-3 mb-0" role="status">
                <i class="fa-solid fa-circle-check"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger d-flex align-items-center gap-2 mt-3 mb-0" role="alert">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif
        @yield('content')
        {{-- <div class="container mt-4">
            <div class="row g-3">
                <div class="col-md-3 col-sm-6">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Users</h5>
                            <p class="card-text">{{$usercount}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Orders</h5>
                            <p class="card-text">85</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Products</h5>
                            <p class="card-text">45</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="card text-white bg-danger mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Revenue</h5>
                            <p class="card-text">$2500</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add your content here -->
            <div class="mt-4">
                <h4>Welcome to your dashboard!</h4>
                <p>This is a simple responsive dashboard UI design. Connect it with your backend for dynamic data.</p>
            </div>
        </div> --}}
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.confirmAdminAction = async function (url, message) {
            const result = await Swal.fire({
                icon: 'warning',
                title: 'Are you sure?',
                text: message,
                showCancelButton: true,
                confirmButtonText: 'Yes, continue',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#dc3545'
            });

            if (result.isConfirmed) {
                window.location.href = url;
            }
        };

        document.querySelectorAll('.admin-delete-form').forEach(function (form) {
            form.addEventListener('submit', async function (event) {
                event.preventDefault();
                const result = await Swal.fire({
                    icon: 'warning',
                    title: 'Are you sure?',
                    text: form.dataset.confirmMessage || 'This data will be permanently deleted.',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#dc3545'
                });

                if (result.isConfirmed) form.submit();
            });
        });

        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');
        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });
    </script>
    <style>
        .admin-nav-profile { display: inline-flex; width: 38px; height: 38px; align-items: center; justify-content: center; overflow: hidden; border-radius: 50%; color: #00796b; font-size: 32px; text-decoration: none; }
        .admin-nav-profile img { width: 100%; height: 100%; object-fit: cover; }
    </style>
    @yield('scripts')
</body>
</html>
