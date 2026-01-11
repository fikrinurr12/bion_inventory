<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ config('app.name', 'BION Inventory System') }}</title>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Inter:400,500,600,700" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
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
                <!-- Logo and BIMS - Horizontal Layout -->
                <div class="d-flex">
                    <!-- Logo -->
                    <div class="auth-logo me-3">
                        <img src="{{ asset('img/logo.png') }}" alt="BION Logo" style="height: 80px;">
                    </div>
                    
                    <!-- BIMS and System Name -->
                    <div>
                        <h1 class="display-3 fw-bold text-white mb-0" style="letter-spacing: 4px; line-height: 1;">BIMS</h1>
                        <p class="fs-6 text-white-80 mb-0" style="letter-spacing: 1px;">Bion Inventory Management System</p>
                    </div>
                </div>
                
                <ul class="auth-features">
                    <li>
                        <i class="bi bi-check-circle-fill"></i>
                        Manajemen Stok Real-time
                    </li>
                    <li>
                        <i class="bi bi-check-circle-fill"></i>
                        Tracking Barang Masuk & Keluar
                    </li>
                    <li>
                        <i class="bi bi-check-circle-fill"></i>
                        Laporan Lengkap & Export
                    </li>
                    <li>
                        <i class="bi bi-check-circle-fill"></i>
                        Multi-user & Role Management
                    </li>
                </ul>
            </div>
        </div>

        <!-- Form Section - Right Side -->
        <div class="auth-form-section">
            <div class="auth-form-header">
                <h3>Login</h3>
                <p>Masukkan email dan password untuk melanjutkan</p>
            </div>

            @if ($errors->any())
                <div class="alert-auth alert-danger">
                    <i class="bi bi-exclamation-circle"></i>
                    <strong>Error!</strong> {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
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
                           placeholder="Contoh: admin@bion.com">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="password-toggle">
                        <input id="password" 
                               type="password" 
                               class="form-control-auth @error('password') is-invalid @enderror" 
                               name="password" 
                               required 
                               autocomplete="current-password"
                               placeholder="Masukkan password">
                        <i class="bi bi-eye toggle-password" onclick="togglePassword()"></i>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-check">
                    <input class="form-check-input" 
                           type="checkbox" 
                           name="remember" 
                           id="remember" 
                           {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        Remember Me
                    </label>
                </div>

                <button type="submit" class="btn-auth">
                    <i class="bi bi-box-arrow-in-right"></i> Sign In
                </button>

                <div class="auth-footer">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            Forgot Password?
                        </a>
                    @endif
                    
                    @if (Route::has('register'))
                        <p style="margin-top: 15px; color: #7f8c8d;">
                            Don't have an account? 
                            <a href="{{ route('register') }}">Sign Up</a>
                        </p>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.toggle-password');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            }
        }
    </script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>