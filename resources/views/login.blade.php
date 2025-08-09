<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SMG Dashboard</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>
<body>

<div class="card">
    <div class="p-5 flex-fill">
        <div class="text-center mb-4">
            <img src="{{ asset('assets/img/smg/logosmg.png') }}" class="card-img-top">
            <h3 class="fw-bold" style="color: #1a2035">Login Here!</h3>
            <p class="text-muted">Login to access Saudara Mandiri Group Admin Dashboard.</p>
        </div>

        @if(session('pesan'))
            <div class="alert alert-success">{{ session('pesan') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf
            <div class="mb-3">
                <label>Email address</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Enter your email" required>
            </div>

            <div class="mb-3 d-flex justify-content-between">
                <label>Password</label>
                <a href="#" class="text-link small">Forgot your password?</a>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" name="remember">
                <label class="form-check-label">Remember me</label>
            </div>

            <button type="submit" class="btn btn-login w-100 mb-3">
                <i class="bi bi-box-arrow-in-right"></i> Log In
            </button>
        </form>

        <div class="text-center">
            <p class="mb-0">Don't have an account? <a href="/register" class="text-link">Sign up</a></p>
        </div>
    </div>
</div>

<!-- Bootstrap Icons & JS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<script src="{{ asset('assets/js/kaiadmin.js') }}"></script>
</body>
</html>
