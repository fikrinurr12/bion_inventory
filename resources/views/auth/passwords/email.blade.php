<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Forgot Password - {{ config('app.name', 'BION Inventory System') }}</title>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Inter:400,500,600,700" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
</head>
<body class="auth-page">
    <div class="auth-container">
        <!-- Welcome Section - Left Side -->
        <div class="auth-welcome">
            <div class="welcome-content">
                <div class="auth-logo">
                    <img src="{{ asset('img/logo.png') }}" alt="BION Logo" style="height: 80px;">
                </div>
                
                <h2>Lupa Password?</h2>
                <p>
                    Tidak masalah! Kami akan mengirimkan<br>
                    link reset password ke email Anda
                </p>
                
                <ul class="auth-features">
                    <li>
                        <i class="bi bi-shield-lock"></i>
                        Reset Password Aman
                    </li>
                    <li>
                        <i class="bi bi-envelope"></i>
                        Link via Email
                    </li>
                    <li>
                        <i class="bi bi-clock"></i>
                        Valid 60 Menit
                    </li>
                </ul>
            </div>
        </div>

        <!-- Form Section - Right Side -->
        <div class="auth-form-section">
            <div class="auth-form-header">
                <div style="text-align: center; margin-bottom: 20px;">
                    <i class="bi bi-key" style="font-size: 4rem; color: #667eea;"></i>
                </div>
                <h3>Reset Password</h3>
                <p>Masukkan email Anda untuk menerima link reset</p>
            </div>

            @if (session('status'))
                <div class="alert-auth alert-success">
                    <i class="bi bi-check-circle"></i>
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-auth alert-danger">
                    <i class="bi bi-exclamation-circle"></i>
                    <strong>Error!</strong> {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input id="email" 
                           type="email" 
                           class="form-control-auth @error('email') is-invalid @enderror" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autocomplete="email" 
                           autofocus
                           placeholder="email@bion.com">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <button type="submit" class="btn-auth">
                    <i class="bi bi-send"></i> Send Reset Link
                </button>

                <div class="auth-footer">
                    <p style="color: #7f8c8d;">
                        Ingat password Anda? 
                        <a href="{{ route('login') }}">Back to Login</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <style>
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</body>
</html>