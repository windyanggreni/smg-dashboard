<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Register - SMG Dashboard</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>
<body>

<div class="card" style="transform: scale(0.8)">
    <div class="p-5 flex-fill">
        <div class="text-center mb-4">
            <img src="{{ asset('assets/img/smg/logosmg.png') }}" class="card-img-top" alt="SMG Logo">
            <h3 class="fw-bold" style="color: #1a2035">Register Here!</h3>
            <p class="text-muted">Create an admin account to access the dashboard.</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/register">
            @csrf

            <div class="mb-3">
                <label>Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Phone Number (optional)</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <input type="hidden" name="role" value="Admin">

            <button type="submit" class="btn btn-register w-100 mb-3">
                <i class="bi bi-person-plus"></i> Register
            </button>
        </form>

        <div class="text-center">
            <p class="mb-0">Already have an account? <a href="/login" class="text-link">Login here</a></p>
        </div>
    </div>
</div>

<!-- Bootstrap Icons & JS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<script src="{{ asset('assets/js/kaiadmin.js') }}"></script>
</body>
</html>
