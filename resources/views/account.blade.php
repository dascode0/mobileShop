 @extends('layout.user')
 @section('title', 'Account')
 @section('content')
 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="css/account.css">
 </head>

 <body>

     <div class="main">
         <h1 class="col-12"><i class="fa-solid fa-user"></i> My Account</h1>
         <div class="main_content row mt-0">
             <div class="main_left col-lg-3 col-12 mt-4">
                 <i class="fa-solid fa-circle-user user-logo"></i>
                 <h3 class="mb-0">{{$user->name}}</h3>
                 <p class="fs-5 text-secondary">{{$user->email}}</p>
                 <ul>
                     <li><a href="account.php" class="active">
                             <i class="fa-solid fa-clipboard"></i>
                             Dashboard
                         </a></li>
                     <li><a href="#">
                             <i class="fa-solid fa-bag-shopping"></i>
                             Orders
                         </a></li>
                     <li><a href="#">
                             <i class="fa-solid fa-download"></i>
                             Download
                         </a></li>
                     <li><a href="#">
                             <i class="fa-solid fa-map-location-dot"></i>
                             Address
                         </a></li>
                     <li><a href="#">
                             <i class="fa-regular fa-user"></i>
                             Account details
                         </a></li>
                     <li><a href="#">
                             <i class="fa-regular fa-heart"></i>
                             Wishlist
                         </a></li>
                     <li><a href="#">
                             <i class="fa-solid fa-code-compare"></i>
                             Compare
                         </a></li>
                     <li><a href="{{ route('logout') }}">
                             <i class="fa-solid fa-arrow-right-from-bracket"></i>
                             Logout
                         </a></li>
                 </ul>
             </div>
             <div class="main_right col-lg-9 col-12 p-4">
                 <h3 class="fw-bold">Welcome to your account page</h3>
                 <p class="fs-5 text-secondary">Hi {{$user->name}}, today is a great day to check your account page. you can check also:</p>
                 <div class="buttons row p-3 g-3">
                     <div class="col-md">
                         <a href="#" class="btn btn-dark btn-lg w-100"><i class="fa-solid fa-bag-shopping"></i> Recent Orders</a>
                     </div>
                     <div class="col-md">
                         <a href="#" class="btn btn-dark btn-lg w-100"><i class="fa-solid fa-map-location-dot"></i> Address</a>
                     </div>
                     <div class="col-md">
                         <a href="#" class="btn btn-dark btn-lg w-100"><i class="fa-regular fa-user"></i> Account Details</a>
                     </div>
                 </div>
             </div>
         </div>

     </div>
 </body>

 </html>
 @endsection