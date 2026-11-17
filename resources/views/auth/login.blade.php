<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Admin - Depo Hunter</title>
    
    <!-- Google Font: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Bootstrap 4.6.2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    
    <!-- Custom Elegant Login CSS -->
    <link rel="stylesheet" href="{{ asset('css/auth-login.css') }}">

    <!-- PWA Manifest & Meta Tags -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#4f46e5">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="BankRate ID">
    <link rel="apple-touch-icon" href="{{ asset('icons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('icons/icon.svg') }}">
</head>
<body class="login-body">

    <!-- Ambient glowing backgrounds -->
    <div class="ambient-orb orb-1"></div>
    <div class="ambient-orb orb-2"></div>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="brand-icon-wrapper">
                    <i class="fas fa-vault"></i>
                </div>
                <h2>Depo Hunter</h2>
                <p>Silakan masuk ke panel administrasi sistem</p>
            </div>

            @if(session('info'))
                <div class="alert-custom alert-custom-info">
                    <i class="fas fa-info-circle"></i>
                    <span>{{ session('info') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-custom alert-custom-danger">
                    <i class="fas fa-circle-exclamation"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" id="loginForm" autocomplete="off">
                @csrf

                <div class="form-group-custom">
                    <label for="emailInput">Alamat Email</label>
                    <div class="input-icon-group">
                        <i class="fas fa-envelope icon-left"></i>
                        <input 
                            type="email" 
                            name="email" 
                            id="emailInput" 
                            class="form-control-custom" 
                            placeholder="nama@email.com" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus
                        >
                    </div>
                </div>

                <div class="form-group-custom">
                    <label for="passwordInput">Kata Sandi</label>
                    <div class="input-icon-group">
                        <i class="fas fa-lock icon-left"></i>
                        <input 
                            type="password" 
                            name="password" 
                            id="passwordInput" 
                            class="form-control-custom" 
                            placeholder="••••••••" 
                            required
                        >
                        <button type="button" class="toggle-password" id="togglePasswordBtn" title="Tampilkan / Sembunyikan Kata Sandi">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="login-options">
                    <label class="custom-checkbox-wrapper">
                        <input type="checkbox" name="remember" id="rememberMe" {{ old('remember') ? 'checked' : '' }}>
                        <span>Ingat Sesi Saya</span>
                    </label>
                </div>

                <button type="submit" class="btn-login-gradient" id="loginSubmitBtn">
                    <span>Masuk ke Panel Admin</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </form>

            <div class="login-footer">
                &copy; {{ date('Y') }} Depo Hunter System &bull; Secure Access
            </div>
        </div>
    </div>

    <!-- jQuery 3.7.1 -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap 4.6.2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Login Custom JS -->
    <script src="{{ asset('js/auth/login.js') }}"></script>
    <!-- Progressive Web App Script -->
    <script src="{{ asset('js/pwa.js') }}"></script>
</body>
</html>
