<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'BION Inventory System') }}</title>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Inter:400,500,600,700" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom CSS (jika ada) -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            margin: 5px 10px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.1);
            color: white;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
            font-size: 1.1rem;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .stat-card {
            border-left: 4px solid;
        }
        .stat-card.primary { border-left-color: #3498db; }
        .stat-card.success { border-left-color: #2ecc71; }
        .stat-card.warning { border-left-color: #f39c12; }
        .stat-card.danger { border-left-color: #e74c3c; }
        .table thead th {
            background-color: #34495e;
            color: white;
            border: none;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5568d3 0%, #6a4190 100%);
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.3rem;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div id="app">
        @auth
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <nav class="col-md-2 d-md-block sidebar p-0">
                    <div class="position-sticky pt-4">
                        <div class="text-center mb-4">
                            <h4 class="text-white fw-bold">
                                <i class="bi bi-box-seam"></i> BION
                            </h4>
                            <small class="text-white-50">Inventory System</small>
                        </div>
                        
                        <hr class="text-white-50">
                        
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('barang.*') ? 'active' : '' }}" href="{{ route('barang.index') }}">
                                    <i class="bi bi-box"></i> Stok Barang
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('penerimaan.*') ? 'active' : '' }}" href="{{ route('penerimaan.index') }}">
                                    <i class="bi bi-arrow-down-circle"></i> Penerimaan Barang
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('pengeluaran.*') ? 'active' : '' }}" href="{{ route('pengeluaran.index') }}">
                                    <i class="bi bi-arrow-up-circle"></i> Pengeluaran Barang
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('lokasi-gudang.*') ? 'active' : '' }}" href="{{ route('lokasi-gudang.index') }}">
                                    <i class="bi bi-geo-alt"></i> Lokasi Gudang
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}" href="{{ route('laporan.index') }}">
                                    <i class="bi bi-file-earmark-text"></i> Laporan
                                </a>
                            </li>
                        </ul>
                        
                        <hr class="text-white-50 mt-4">
                        
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </nav>

                <!-- Main Content -->
                <main class="col-md-10 ms-sm-auto px-md-4">
                    <!-- Top Navbar -->
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">@yield('page-title', 'Dashboard')</h1>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><span class="dropdown-item-text"><small>Role: {{ Auth::user()->role->role_name ?? 'N/A' }}</small></span></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="bi bi-box-arrow-right"></i> Logout
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle"></i>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Page Content -->
                    @yield('content')
                </main>
            </div>
        </div>
        @else
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'BION Inventory System') }}
                </a>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
        @endauth
    </div>
    
    @stack('scripts')
</body>
</html>