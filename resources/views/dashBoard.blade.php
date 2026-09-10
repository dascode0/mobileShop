@extends('layout.admin')
@section('title', 'Dashboard')
@section('content')
        <div class="container mt-4">
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
        </div>
    
 @endsection