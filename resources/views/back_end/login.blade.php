<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login | Nexus Dashboard</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('back_end/assets/css/style.css') }}">
  <style>
    body {
      background: linear-gradient(to right, #667eea, #764ba2);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: "Segoe UI", sans-serif;
    }
  </style>
</head>
<body>
  <div class="login-card">
    <h3 class="text-center">Nexus Login</h3>

    @if (Session::has('error'))
      <div class="alert alert-danger alert-dismissible d-flex justify-content-between align-items-center p-2" role="alert">
        <h4>{{ Session::get('error') }}</h4>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <form action="{{ route('auth.authenticate') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" placeholder="Enter your email">
        @error('email')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" placeholder="********">
        @error('password')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>

      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="form-check">
          <input type="checkbox" name="remember" class="form-check-input" checked>
          <label class="form-check-label">Keep me signed in</label>
        </div>
        <a href="#" class="text-decoration-none forgot-password">Forgot Password?</a>
      </div>

      <div class="d-grid mb-3">
        <button type="submit" class="btn btn-primary submit-btn">Login</button>
      </div>

      <div class="d-grid">
        <button class="btn g-login" type="button">
          <img src="{{ asset('back_end/assets/images/file-icons/icon-google.svg') }}" alt="Google Icon">
          Log in with Google
        </button>
      </div>
    </form>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
