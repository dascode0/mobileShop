<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin-login.css') }}">
</head>
<body>
    <main class="wrapper">
      <div class="brand-mark"><i class="fa-solid fa-shield-halved"></i></div>
      <h1>Admin Login</h1>
      <p class="subtitle">Sign in to manage your store</p>
      @if ($errors->any())
        <div class="login-notification error" role="alert">
          <i class="fa-solid fa-circle-exclamation"></i>
          <span>{{ $errors->first() }}</span>
        </div>
      @endif
      @if (session('success'))
        <div class="login-notification success" role="status">
          <i class="fa-solid fa-circle-check"></i>
          <span>{{ session('success') }}</span>
        </div>
      @endif
      <form action="{{ route('admin.login.save') }}" method="post">
            @csrf
            <div class="field">
              <label for="admin-email">Email address</label>
              <input id="admin-email" type="email" placeholder="Enter your email" name="email" required>
            </div>
            <div class="field">
              <label for="admin-password">Password</label>
              <input id="admin-password" type="password" placeholder="Enter your password" name="password" required>
            </div>
            <div class="field btn">
              <div class="btn-layer"></div>
              <input type="submit" value="Login">
            </div>
          </form>
    </main>
</body>
</html>