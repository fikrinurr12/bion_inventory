<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reset Password - {{ config('app.name', 'BION Inventory System') }}</title>
    
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
                
                <h2>Reset Password</h2>
                <p>
                    Buat password baru untuk akun Anda<br>
                    Pastikan password kuat dan aman
                </p>
                
                <ul class="auth-features">
                    <li>
                        <i class="bi bi-shield-check"></i>
                        Password Terenkripsi
                    </li>
                    <li>
                        <i class="bi bi-lock"></i>
                        Minimal 8 Karakter
                    </li>
                    <li>
                        <i class="bi bi-key"></i>
                        Kombinasi Huruf & Angka
                    </li>
                </ul>
            </div>
        </div>

        <!-- Form Section - Right Side -->
        <div class="auth-form-section">
            <div class="auth-form-header">
                <div style="text-align: center; margin-bottom: 20px;">
                    <i class="bi bi-lock-fill" style="font-size: 4rem; color: #667eea;"></i>
                </div>
                <h3>Set New Password</h3>
                <p>Masukkan password baru Anda</p>
            </div>

            @if ($errors->any())
                <div class="alert-auth alert-danger">
                    <i class="bi bi-exclamation-circle"></i>
                    <strong>Error!</strong> Silakan periksa form kembali.
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input id="email" 
                           type="email" 
                           class="form-control-auth @error('email') is-invalid @enderror" 
                           name="email" 
                           value="{{ $email ?? old('email') }}" 
                           required 
                           autocomplete="email" 
                           autofocus
                           readonly>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">New Password</label>
                    <div class="password-toggle">
                        <input id="password" 
                               type="password" 
                               class="form-control-auth @error('password') is-invalid @enderror" 
                               name="password" 
                               required 
                               autocomplete="new-password"
                               placeholder="Minimal 8 karakter">
                        <i class="bi bi-eye toggle-password" onclick="togglePassword('password')"></i>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password-confirm">Confirm New Password</label>
                    <div class="password-toggle">
                        <input id="password-confirm" 
                               type="password" 
                               class="form-control-auth" 
                               name="password_confirmation" 
                               required 
                               autocomplete="new-password"
                               placeholder="Ulangi password baru">
                        <i class="bi bi-eye toggle-password" onclick="togglePassword('password-confirm')"></i>
                    </div>
                </div>

                <button type="submit" class="btn-auth">
                    <i class="bi bi-check-circle"></i> Reset Password
                </button>

                <div class="auth-footer">
                    <p style="color: #7f8c8d;">
                        <a href="{{ route('login') }}">
                            <i class="bi bi-arrow-left"></i> Back to Login
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const toggleIcon = passwordInput.nextElementSibling;
            
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
</body>
</html>