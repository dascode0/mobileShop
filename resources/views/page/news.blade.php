@extends('layout.user')
@section('title','hot news')
@section('styles')
<style>
    .date-badge {
      position: absolute;
      top: 15px;
      left: 15px;
      background: white;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      font-weight: bold;
      font-size: 13px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }
    .category-label {
      font-size: 0.75rem;
      padding: 2px 10px;
      background-color: #e0f2f1;
      color: #00796b;
      border-radius: 15px;
      display: inline-block;
      margin-bottom: 10px;
      font-weight: 500;
    }
    .post-meta {
      font-size: 13px;
      color: #777;
    }
</style>
@endsection
@section('content')
<div class="container">
    <div class="py-2 d-flex ">
        <a href="{{route('home')}}" class="text-decoration-none text-dark">Home</a>
        <span class="text-muted mx-2"> &gt; </span>
        <span class="text-secondary">News</span>
    </div>
    <div class="container my-4">
        <div class="row g-4 align-items-center">
            <!-- Image -->
            <div class="col-md-5 position-relative">
            <img src="{{asset('img\news-post1.jpg')}}" class="img-fluid rounded" alt="Blog Image">
            <div class="date-badge">
                <div>02</div>
                <div style="font-size: 10px;">JAN</div>
            </div>
            </div>

            <!-- Content -->
            <div class="col-md-7">
            <div class="category-label">Audio Electronics</div>
            <h4 class="fw-bold">
                Announcing the new Fitbits Charge 6smart Fitness Tracker
            </h4>
            <p class="text-muted">
                Recently, I was invited by Nintendo of Canada to attend a very special Nintendo Holiday Showcase exclusive preview event in New York City. Located in...
            </p>
            <hr>
            <div class="d-flex justify-content-between align-items-center post-meta mt-3">
                <div>by <strong>ACE</strong></div>
                <div>
                👁 971 &nbsp;&nbsp; 💬 0 &nbsp;&nbsp; 🔗
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="container my-4">
        <div class="row g-4 align-items-center">
            <!-- Image -->
            <div class="col-md-5 position-relative">
            <img src="{{asset('img\news-post2.jpg')}}" class="img-fluid rounded" alt="Blog Image">
            <div class="date-badge">
                <div>14</div>
                <div style="font-size: 10px;">FEB</div>
            </div>
            </div>

            <!-- Content -->
            <div class="col-md-7">
            <div class="category-label">Audio Electronics</div>
            <h4 class="fw-bold">
                Your Conversion Rate on Amazon
            </h4>
            <p class="text-muted">
                Recently, I was invited by Nintendo of Canada to attend a very special Nintendo Holiday Showcase exclusive preview event in New York City.
            </p>
            <hr>
            <div class="d-flex justify-content-between align-items-center post-meta mt-3">
                <div>by <strong>ACE</strong></div>
                <div>
                👁 971 &nbsp;&nbsp; 💬 0 &nbsp;&nbsp; 🔗
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="container my-4">
        <div class="row g-4 align-items-center">
            <!-- Image -->
            <div class="col-md-5 position-relative">
            <img src="{{asset('img\news-post3.jpg')}}" class="img-fluid rounded" alt="Blog Image">
            <div class="date-badge">
                <div>20</div>
                <div style="font-size: 10px;">MAR</div>
            </div>
            </div>

            <!-- Content -->
            <div class="col-md-7">
            <div class="category-label">Audio Electronics</div>
            <h4 class="fw-bold">
                Success Story on Amazon
            </h4>
            <p class="text-muted">
                Recently, I was invited by Nintendo of Canada to attend a very special Nintendo Holiday Showcase exclusive preview event in New York City. Located in...
            </p>
            <hr>
            <div class="d-flex justify-content-between align-items-center post-meta mt-3">
                <div>by <strong>ACE</strong></div>
                <div>
                👁 971 &nbsp;&nbsp; 💬 0 &nbsp;&nbsp; 🔗
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="container my-4">
        <div class="row g-4 align-items-center">
            <!-- Image -->
            <div class="col-md-5 position-relative">
            <img src="{{asset('img\news-post4.jpg')}}" class="img-fluid rounded" alt="Blog Image">
            <div class="date-badge">
                <div>21</div>
                <div style="font-size: 10px;">APR</div>
            </div>
            </div>

            <!-- Content -->
            <div class="col-md-7">
            <div class="category-label">Audio Electronics</div>
            <h4 class="fw-bold">
                13 YouTube Ads Targeting Options
            </h4>
            <p class="text-muted">
                Recently, I was invited by Nintendo of Canada to attend a very special Nintendo Holiday Showcase exclusive preview event in New York City. Located in...
            </p>
            <hr>
            <div class="d-flex justify-content-between align-items-center post-meta mt-3">
                <div>by <strong>ACE</strong></div>
                <div>
                👁 971 &nbsp;&nbsp; 💬 0 &nbsp;&nbsp; 🔗
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="container my-4">
        <div class="row g-4 align-items-center">
            <!-- Image -->
            <div class="col-md-5 position-relative">
            <img src="{{asset('img\news-post5.jpg')}}" class="img-fluid rounded" alt="Blog Image">
            <div class="date-badge">
                <div>10</div>
                <div style="font-size: 10px;">JUN</div>
            </div>
            </div>

            <!-- Content -->
            <div class="col-md-7">
            <div class="category-label">Audio Electronics</div>
            <h4 class="fw-bold">
                Learn about the Google Pixel Tabletsthen enter for a chance
            </h4>
            <p class="text-muted">
                Recently, I was invited by Nintendo of Canada to attend a very special Nintendo Holiday Showcase exclusive preview event in New York City. Located in...
            </p>
            <hr>
            <div class="d-flex justify-content-between align-items-center post-meta mt-3">
                <div>by <strong>ACE</strong></div>
                <div>
                👁 971 &nbsp;&nbsp; 💬 0 &nbsp;&nbsp; 🔗
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection