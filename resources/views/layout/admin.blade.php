<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .content {
            flex: 1;
            padding: 20px;
        }
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
        <a href="{{route('dashboard')}}">Home</a>
        <a href="{{route('users')}}">Users</a>
        <a href="{{route('categories.index')}}">Categories</a>
        <a href="#">Orders</a>
        <a href="{{route('products.index')}}">Products</a>
        <a href="#">Settings</a>
        <a href="{{route('admin.logout')}}">Log out</a>
    </div>
    
    <div class="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <button class="btn btn-primary d-md-none" id="menu-toggle">☰</button>
                <a class="navbar-brand ms-2" href="#">Welcome, {{ session('user_name') }}</a>
            </div>
        </nav>
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
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');
        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });
    </script>
</body>
</html>
