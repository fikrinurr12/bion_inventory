<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verify Email - {{ config('app.name', 'BION Inventory System') }}</title>
    
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
                
                <h2>Verifikasi Email</h2>
                <p>
                    Silakan verifikasi alamat email Anda<br>
                    untuk melanjutkan ke sistem
                </p>
                
                <ul class="auth-features">
                    <li>
                        <i class="bi bi-shield-check"></i>
                        Keamanan Akun Terjamin
                    </li>
                    <li>
                        <i class="bi bi-envelope-check"></i>
                        Verifikasi Email Diperlukan
                    </li>
                    <li>
                        <i class="bi bi-clock-history"></i>
                        Proses Cepat & Mudah
                    </li>
                </ul>
            </div>
        </div>

        <!-- Form Section - Right Side -->
        <div class="auth-form-section">
            <div class="auth-form-header">
                <div style="text-align: center; margin-bottom: 20px;">
                    <i class="bi bi-envelope-paper" style="font-size: 4rem; color: #667eea;"></i>
                </div>
                <h3>Cek Email Anda</h3>
                <p>Link verifikasi telah dikirim ke email Anda</p>
            </div>

            @if (session('resent'))
                <div class="alert-auth alert-success">
                    <i class="bi bi-check-circle"></i>
                    Link verifikasi baru telah dikirim ke email Anda.
                </div>
            @endif

            <div style="background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px;">
                <p style="margin: 0; color: #2c3e50; line-height: 1.6;">
                    <i class="bi bi-info-circle" style="color: #667eea;"></i>
                    Sebelum melanjutkan, silakan cek email Anda untuk link verifikasi. 
                    Jika Anda tidak menerima email,
                </p>
            </div>

            <form method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="btn-auth">
                    <i class="bi bi-send"></i> Kirim Ulang Email Verifikasi
                </button>
            </form>

            <div class="auth-footer">
                <p style="color: #7f8c8d;">
                    <i class="bi bi-question-circle"></i> 
                    Butuh bantuan? 
                    <a href="mailto:support@bion.com">Hubungi Support</a>
                </p>
                
                <form method="POST" action="{{ route('logout') }}" style="margin-top: 15px;">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: #e74c3c; cursor: pointer; text-decoration: underline;">
                        <i class="bi bi-box-arrow-left"></i> Logout
                    </button>
                </form>
            </div>
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