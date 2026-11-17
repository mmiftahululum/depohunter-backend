<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - Depo Hunter</title>

    <!-- Google Font: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- AdminLTE 3.2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    
    <!-- Select2 Bootstrap 4 Theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css">

    <!-- Custom Admin Styles -->
    <link rel="stylesheet" href="{{ asset('css/admin-custom.css') }}">

    <!-- PWA Manifest & Meta Tags -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#4f46e5">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="BankRate ID Admin">
    <link rel="apple-touch-icon" href="{{ asset('icons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('icons/icon.svg') }}">

    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom-0 shadow-sm">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('admin.dashboard') }}" class="nav-link font-weight-bold text-dark">Depo Hunter Admin</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto align-items-center">
            <!-- PWA Install Button -->
            <li class="nav-item mr-2">
                <button type="button" class="btn btn-sm btn-outline-primary btn-pwa-install d-none" onclick="triggerPwaInstall()" title="Pasang Aplikasi BankRate ID">
                    <i class="fas fa-download mr-1"></i> Install App
                </button>
            </li>

            <!-- User Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link d-flex align-items-center" data-toggle="dropdown" href="#">
                    <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mr-2 shadow-sm" style="width: 32px; height: 32px; font-weight: 600;">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <span class="d-none d-md-inline font-weight-600 text-dark">{{ Auth::user()->name ?? 'Administrator' }}</span>
                    <i class="fas fa-angle-down ml-2 text-muted" style="font-size: 0.8rem;"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right rounded shadow-sm border-0">
                    <div class="p-3 text-center border-bottom bg-light">
                        <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-2" style="width: 48px; height: 48px; font-size: 1.2rem; font-weight: 700;">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <h6 class="font-weight-bold mb-0">{{ Auth::user()->name ?? 'Administrator' }}</h6>
                        <small class="text-muted">{{ Auth::user()->email ?? '' }}</small>
                    </div>
                    <div class="p-2">
                        <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger rounded font-weight-500">
                                <i class="fas fa-sign-out-alt mr-2"></i> Keluar (Logout)
                            </button>
                        </form>
                    </div>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('admin.dashboard') }}" class="brand-link d-flex align-items-center">
            <span class="brand-image"><i class="fas fa-vault"></i></span>
            <span class="brand-text font-weight-bold ml-2">Depo Hunter</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center border-secondary">
                <div class="image">
                    <div class="rounded-circle bg-indigo text-white d-flex align-items-center justify-content-center font-weight-bold" style="width: 34px; height: 34px;">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                </div>
                <div class="info">
                    <a href="#" class="d-block text-white font-weight-600">{{ Auth::user()->name ?? 'Admin' }}</a>
                    <small class="text-success"><i class="fas fa-circle text-xs mr-1"></i> Online</small>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-header">MASTER DATA</li>

                    <li class="nav-item">
                        <a href="{{ route('admin.banks.index') }}" class="nav-link {{ request()->routeIs('admin.banks.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-university"></i>
                            <p>Data Bank</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.deposit-products.index') }}" class="nav-link {{ request()->routeIs('admin.deposit-products.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-piggy-bank"></i>
                            <p>Produk Deposito</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.deposit-rates.index') }}" class="nav-link {{ request()->routeIs('admin.deposit-rates.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-percentage"></i>
                            <p>Suku Bunga Deposito</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.rate-matrix.index') }}" class="nav-link {{ request()->routeIs('admin.rate-matrix.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-table"></i>
                            <p>Matrix Suku Bunga</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-sliders-h"></i>
                            <p>Pengaturan Global</p>
                        </a>
                    </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">
                    <div class="col-sm-6">
                        <h1 class="m-0 font-weight-bold text-dark" style="font-size: 1.5rem;">@yield('page_title', 'Dashboard')</h1>
                        @hasSection('page_description')
                            <p class="text-muted mb-0 font-weight-500" style="font-size: 0.88rem;">@yield('page_description')</p>
                        @endif
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right bg-transparent p-0 mb-0 font-weight-500">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                            @yield('breadcrumb')
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer bg-white text-muted border-top text-sm d-flex justify-content-between align-items-center">
        <div>
            <strong>&copy; {{ date('Y') }} <a href="{{ route('admin.dashboard') }}" class="text-primary font-weight-600">Depo Hunter</a>.</strong>
            Seluruh hak cipta dilindungi.
        </div>
        <div class="d-none d-sm-inline-block">
            <b>Versi</b> 2.0 (AdminLTE Native)
        </div>
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- Bootstrap 4.6.2 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Custom Admin Script -->
<script src="{{ asset('js/admin/custom.js') }}"></script>

<script>
    // SweetAlert Flash Notifications
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: "{{ session('error') }}",
            timer: 4000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    @endif

    @if(session('info'))
        Swal.fire({
            icon: 'info',
            title: 'Informasi',
            text: "{{ session('info') }}",
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    @endif
</script>

@stack('scripts')

<!-- Progressive Web App Script -->
<script src="{{ asset('js/pwa.js') }}"></script>
</body>
</html>
