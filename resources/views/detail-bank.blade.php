<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ $bank->name }} ({{ $bank->code_saham ?? 'Bank' }}) - Suku Bunga Deposito &amp; Profil Lengkap | BankRate ID</title>
    <meta name="description" content="Informasi suku bunga deposito {{ $bank->name }} terkini. Bandingkan suku bunga per tenor, batas aman penjaminan LPS, dan simulasi imbal hasil bersih." />
    
    <!-- PWA Manifest & Meta Tags -->
    <link rel="manifest" href="{{ asset('manifest.json') }}" />
    <meta name="theme-color" content="#4f46e5" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="apple-mobile-web-app-title" content="BankRate ID" />
    <link rel="apple-touch-icon" href="{{ asset('icons/apple-touch-icon.png') }}" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('icons/icon.svg') }}" />
    <link rel="icon" href="{{ asset('favicon.ico') }}" />

    <!-- Google Fonts & Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;600;700&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />

    <style>
        @layer base {
            html, body {
                margin: 0;
                padding: 0;
            }
            body {
                overscroll-behavior: none;
            }
            main > :first-child {
                margin-top: 0 !important;
            }
            main > :last-child {
                margin-bottom: 0 !important;
            }
        }
        ::-webkit-scrollbar {
            display: none;
        }
    </style>

    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "surface-container-high": "#dce9ff",
                        "on-secondary": "#ffffff",
                        "on-secondary-container": "#fefcff",
                        "outline": "#76777d",
                        "primary": "#000000",
                        "on-surface": "#0b1c30",
                        "surface-container-low": "#eff4ff",
                        "on-primary": "#ffffff",
                        "on-surface-variant": "#45464d",
                        "error-container": "#ffdad6",
                        "surface-bright": "#f8f9ff",
                        "secondary-container": "#316bf3",
                        "surface-container-lowest": "#ffffff",
                        "primary-container": "#131b2e",
                        "background": "#f8f9ff",
                        "surface": "#f8f9ff",
                        "secondary": "#0051d5",
                        "surface-container": "#e5eeff",
                        "outline-variant": "#c6c6cd"
                    },
                    spacing: {
                        "margin-wide": "3rem",
                        "space-2xl": "3rem",
                        "space-xs": "0.25rem",
                        "space-sm": "0.5rem",
                        "space-lg": "1.5rem",
                        "gutter": "1.5rem",
                        "space-xl": "2rem",
                        "space-md": "1rem",
                        "margin": "2rem"
                    },
                    fontFamily: {
                        "label-md": ["Hanken Grotesk", "sans-serif"],
                        "headline-md": ["Hanken Grotesk", "sans-serif"],
                        "metric-display": ["Hanken Grotesk", "sans-serif"],
                        "label-sm": ["Hanken Grotesk", "sans-serif"],
                        "headline-lg": ["Hanken Grotesk", "sans-serif"],
                        "headline-sm": ["Hanken Grotesk", "sans-serif"],
                        "body-md": ["Hanken Grotesk", "sans-serif"],
                        "body-lg": ["Hanken Grotesk", "sans-serif"],
                        "body-sm": ["Hanken Grotesk", "sans-serif"],
                        "label-lg": ["Hanken Grotesk", "sans-serif"]
                    },
                    fontSize: {
                        "label-md": ["12px", { lineHeight: "16px", letterSpacing: "0.02em", fontWeight: "600" }],
                        "headline-md": ["20px", { lineHeight: "28px", letterSpacing: "-0.01em", fontWeight: "600" }],
                        "metric-display": ["28px", { lineHeight: "32px", letterSpacing: "-0.02em", fontWeight: "700" }],
                        "label-sm": ["10px", { lineHeight: "14px", letterSpacing: "0.04em", fontWeight: "700" }],
                        "headline-lg": ["24px", { lineHeight: "32px", letterSpacing: "-0.01em", fontWeight: "600" }],
                        "headline-sm": ["16px", { lineHeight: "24px", letterSpacing: "0em", fontWeight: "600" }],
                        "body-md": ["14px", { lineHeight: "20px", letterSpacing: "0em", fontWeight: "400" }],
                        "body-lg": ["16px", { lineHeight: "24px", letterSpacing: "0em", fontWeight: "400" }],
                        "body-sm": ["12px", { lineHeight: "16px", letterSpacing: "0em", fontWeight: "400" }],
                        "label-lg": ["14px", { lineHeight: "20px", letterSpacing: "0.01em", fontWeight: "600" }]
                    }
                }
            }
        };
    </script>
</head>

<body class="bg-surface font-body-md text-on-surface antialiased">
    <!-- Top Navigation Header -->
    <header class="fixed top-0 w-full z-50 bg-surface-container-lowest/90 backdrop-blur-md shadow-[0_1px_8px_rgba(15,23,42,0.06)]">
        <div class="w-full max-w-[1680px] mx-auto px-margin h-20 flex items-center justify-between gap-gutter">
            <div class="flex items-center gap-space-xl">
                <!-- Brand -->
                <a href="{{ route('home') }}" class="flex items-center gap-space-sm hover:opacity-90 transition-opacity">
                    <div class="w-9 h-9 rounded-lg bg-secondary flex items-center justify-center">
                        <span class="material-symbols-outlined text-on-secondary text-[22px]">account_balance</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-headline-sm text-headline-sm text-on-surface tracking-tight leading-none">
                            BankRate<span class="text-secondary">ID</span>
                        </span>
                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider leading-none mt-1">
                            Intelligence &amp; Simpanan
                        </span>
                    </div>
                </a>

                <!-- Live National Rates Indicator -->
                <div class="hidden xl:flex items-center gap-space-sm pl-space-lg bg-surface-container-low py-1.5 px-space-md rounded-lg">
                    <div class="flex items-center gap-1.5">
                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">BI Rate:</span>
                        <span class="font-label-md text-label-md text-on-surface font-bold">{{ number_format($biRate, 2) }}%</span>
                    </div>
                    <div class="w-1 h-3 bg-outline-variant rounded-full mx-1"></div>
                    <div class="flex items-center gap-1.5">
                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">LPS IDR:</span>
                        <span class="font-label-md text-label-md text-secondary font-bold">{{ number_format($lpsLimitGeneral, 2) }}%</span>
                    </div>
                    <div class="w-1 h-3 bg-outline-variant rounded-full mx-1"></div>
                    <div class="flex items-center gap-1.5">
                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">LPS BPR:</span>
                        <span class="font-label-md text-label-md text-on-surface font-bold">{{ number_format($lpsLimitBpr, 2) }}%</span>
                    </div>
                </div>
            </div>

            <!-- Quick Search Bar -->
            <div class="hidden lg:flex items-center flex-1 max-w-md">
                <div class="relative w-full">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">search</span>
                    <input
                        class="w-full pl-10 pr-4 py-2 bg-surface-container-low text-on-surface font-body-sm text-body-sm rounded-lg focus:outline-none focus:bg-surface-container-lowest focus:ring-2 focus:ring-secondary/40 transition-all placeholder:text-on-surface-variant"
                        placeholder="Cari bank, suku bunga deposito..." 
                        type="text" 
                        id="globalSearchInput"
                    />
                </div>
            </div>

            <!-- Nav Links -->
            <div class="flex items-center gap-space-lg">
                <nav class="flex items-center gap-space-xs">
                    <a class="font-label-lg text-label-lg px-3 py-2 text-on-surface-variant hover:text-on-surface hover:bg-surface-container-low rounded-lg transition-colors" href="{{ route('home') }}">Beranda</a>
                    <a class="font-label-lg text-label-lg px-3 py-2 text-on-surface-variant hover:text-on-surface hover:bg-surface-container-low rounded-lg transition-colors" href="{{ route('home') }}#tabel-deposito">Deposito Pasar</a>
                    <a class="font-label-lg text-label-lg px-3 py-2 text-on-surface-variant hover:text-on-surface hover:bg-surface-container-low rounded-lg transition-colors" href="#simulator">Simulasi</a>
                    <a class="font-label-lg text-label-lg px-3 py-2 text-on-surface-variant hover:text-on-surface hover:bg-surface-container-low rounded-lg transition-colors" href="{{ route('home') }}#regulasi-lps">Regulasi LPS</a>
                </nav>

                <div class="h-6 w-px bg-surface-container-highest"></div>

                <div class="flex items-center gap-space-sm">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-surface-container text-secondary font-label-md hover:bg-surface-container-high transition-colors" title="Buka Panel Admin">
                            <span class="material-symbols-outlined text-[18px]">dashboard</span>
                            <span>Panel Admin</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-surface-container-low text-on-surface hover:bg-surface-container transition-colors font-label-md">
                            <span class="material-symbols-outlined text-[18px]">login</span>
                            <span>Login</span>
                        </a>
                    @endauth

                    <!-- PWA Install Button -->
                    <button 
                        type="button" 
                        class="btn-pwa-install hidden items-center gap-1.5 px-3 py-1.5 rounded-lg bg-secondary text-on-secondary hover:opacity-95 transition-all font-label-md font-semibold shadow-sm cursor-pointer"
                        onclick="triggerPwaInstall()" 
                        title="Pasang Aplikasi BankRate ID"
                    >
                        <span class="material-symbols-outlined text-[18px]">install_mobile</span>
                        <span class="hidden md:inline">Pasang App</span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <main class="w-full pt-20 bg-surface">
        <div class="flex flex-col w-full">
            <div class="w-full max-w-[1680px] mx-auto px-margin py-space-lg flex flex-col gap-space-lg">
                
                <!-- 1. Breadcrumb Navigation -->
                <nav aria-label="Breadcrumb" class="flex items-center gap-space-xs text-on-surface-variant">
                    <a class="font-label-md text-label-md text-on-surface-variant hover:text-secondary transition-colors flex items-center gap-1" href="{{ route('home') }}">
                        <span class="material-symbols-outlined text-[16px]">home</span>
                        Beranda
                    </a>
                    <span class="material-symbols-outlined text-[16px] text-outline-variant">chevron_right</span>
                    <a class="font-label-md text-label-md text-on-surface-variant hover:text-secondary transition-colors" href="{{ route('home') }}#tabel-deposito">
                        @if($bank->type === 'digital')
                            Bank Digital
                        @elseif($bank->type === 'bpr')
                            BPR
                        @else
                            Bank Konvensional
                        @endif
                    </a>
                    <span class="material-symbols-outlined text-[16px] text-outline-variant">chevron_right</span>
                    <span class="font-label-md text-label-md text-on-surface font-bold truncate">
                        {{ $bank->name }} {{ $bank->code_saham ? '(' . $bank->code_saham . ')' : '' }}
                    </span>
                </nav>

                <!-- 2. Header Hero Profil Bank -->
                <section class="bg-surface-container-lowest rounded-xl p-space-lg shadow-sm flex flex-col gap-space-lg">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-space-lg">
                        <!-- Left Identity -->
                        <div class="flex items-start md:items-center gap-space-md">
                            <div class="relative w-16 h-16 md:w-20 md:h-20 rounded-xl bg-surface-container flex items-center justify-center shrink-0 shadow-sm overflow-hidden border border-outline-variant/30">
                                @if($bank->logo_url)
                                    <img src="{{ asset('storage/' . $bank->logo_url) }}" alt="{{ $bank->name }}" class="w-full h-full object-contain p-2">
                                @else
                                    <span class="material-symbols-outlined text-secondary text-[40px]" style="font-variation-settings: 'FILL' 1;">account_balance</span>
                                    <div class="absolute bottom-0 inset-x-0 bg-secondary text-[8px] font-bold text-center text-on-secondary py-0.5 tracking-wider">
                                        {{ strtoupper(substr($bank->name, 0, 3)) }}
                                    </div>
                                @endif
                            </div>

                            <div class="flex flex-col gap-1">
                                <div class="flex flex-wrap items-center gap-space-xs">
                                    <h1 class="font-headline-lg text-headline-lg text-on-surface font-bold tracking-tight">
                                        {{ $bank->name }}
                                    </h1>
                                    @if($bank->is_ojk_verified)
                                        <span class="inline-flex items-center gap-0.5 text-secondary" title="Terverifikasi OJK &amp; Bank Indonesia">
                                            <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">verified</span>
                                        </span>
                                    @endif
                                    <span class="font-label-sm text-label-sm uppercase px-2 py-0.5 rounded bg-surface-container text-secondary font-bold">
                                        @if($bank->type === 'digital')
                                            Bank Digital
                                        @elseif($bank->type === 'bpr')
                                            Bank Perekonomian Rakyat (BPR)
                                        @else
                                            Bank Konvensional
                                        @endif
                                    </span>
                                </div>

                                <div class="flex flex-wrap items-center gap-space-sm font-label-md text-label-md text-on-surface-variant">
                                    @if($bank->code_saham)
                                        <span class="font-bold text-on-surface">{{ $bank->code_saham }}</span>
                                        <span class="text-outline-variant">•</span>
                                        <span>IDX: {{ $bank->code_saham }}</span>
                                        <span class="text-outline-variant">•</span>
                                    @endif
                                    <span class="text-on-surface font-bold">{{ $bank->products->count() }} Pilihan Produk Deposito</span>
                                    <span class="text-outline-variant">•</span>
                                    <span>Bunga Hingga: <strong class="text-secondary font-bold">{{ number_format($maxRate, 2) }}% p.a.</strong></span>
                                </div>
                            </div>
                        </div>

                        <!-- Right Quick Actions -->
                        <div class="flex items-center gap-space-xs shrink-0 self-end lg:self-center">
                            <button class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-surface-container-low hover:bg-surface-container text-on-surface font-label-md text-label-md transition-colors" id="btnBookmark" type="button">
                                <span class="material-symbols-outlined text-[18px]">bookmark_border</span>
                                <span id="txtBookmark">Simpan Bank</span>
                            </button>

                            <button class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-surface-container-low hover:bg-surface-container text-on-surface font-label-md text-label-md transition-colors" type="button" id="btnShare">
                                <span class="material-symbols-outlined text-[18px]">share</span>
                                <span>Bagikan</span>
                            </button>

                            @php
                                $firstProdWithLink = $bank->products->firstWhere('referral_link', '!=', null);
                                $bankReferralLink = $firstProdWithLink ? $firstProdWithLink->referral_link : null;
                            @endphp

                            @if($bankReferralLink)
                                <a class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-secondary text-on-secondary hover:bg-on-secondary-fixed-variant font-label-md text-label-md transition-colors shadow-sm" href="{{ $bankReferralLink }}" target="_blank" rel="noopener noreferrer" title="Buka rekening deposito resmi">
                                    <span class="material-symbols-outlined text-[18px]">open_in_new</span>
                                    <span>Buka Deposito</span>
                                </a>
                            @else
                                <a class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-secondary text-on-secondary hover:bg-on-secondary-fixed-variant font-label-md text-label-md transition-colors shadow-sm" href="#simulator">
                                    <span class="material-symbols-outlined text-[18px]">calculate</span>
                                    <span>Simulasi Bunga</span>
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Trust Ribbon & Fast Metrics -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-space-sm pt-space-sm border-t border-surface-container">
                        <div class="flex items-center gap-2.5 p-2 rounded-lg bg-surface-container-low">
                            <div class="w-8 h-8 rounded-lg bg-surface-container flex items-center justify-center text-secondary shrink-0">
                                <span class="material-symbols-outlined text-[18px]">verified_user</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">Izin &amp; Regulasi</span>
                                <span class="font-label-md text-label-md text-on-surface font-bold">
                                    {{ $bank->is_ojk_verified ? 'Berizin & Diawasi OJK' : 'Verifikasi OJK' }}
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2.5 p-2 rounded-lg bg-surface-container-low">
                            <div class="w-8 h-8 rounded-lg bg-surface-container flex items-center justify-center text-secondary shrink-0">
                                <span class="material-symbols-outlined text-[18px]">security</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">Penjaminan Simpanan</span>
                                <span class="font-label-md text-label-md text-on-surface font-bold">
                                    {{ $bank->is_lps_insured ? 'Peserta Lembaga LPS' : 'Non-Penjaminan LPS' }}
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2.5 p-2 rounded-lg bg-surface-container-low">
                            <div class="w-8 h-8 rounded-lg bg-surface-container flex items-center justify-center text-secondary shrink-0">
                                <span class="material-symbols-outlined text-[18px]">percent</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">Suku Bunga Tertinggi</span>
                                <span class="font-label-md text-label-md text-secondary font-bold">
                                    {{ number_format($maxRate, 2) }}% p.a.
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2.5 p-2 rounded-lg bg-surface-container-low">
                            <div class="w-8 h-8 rounded-lg bg-surface-container flex items-center justify-center text-secondary shrink-0">
                                <span class="material-symbols-outlined text-[18px]">military_tech</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">Status Entitas</span>
                                <span class="font-label-md text-label-md text-on-surface font-bold">
                                    {{ $bank->type === 'digital' ? 'Bank Digital Indonesia' : ($bank->type === 'bpr' ? 'BPR Resmi Terdaftar' : 'Bank Umum Nasional') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- 3. Dua Kolom Utama (Grid: 8 Cols vs 4 Cols) -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg items-start">
                    
                    <!-- KOLOM KIRI / UTAMA (8 columns) -->
                    <section class="lg:col-span-8 flex flex-col gap-space-lg">
                        
                        <!-- Seksi Profil & Sejarah Singkat -->
                        <article class="bg-surface-container-lowest rounded-xl p-space-lg shadow-sm flex flex-col gap-space-md">
                            <div class="flex items-center justify-between pb-space-xs">
                                <div class="flex items-center gap-space-xs">
                                    <span class="material-symbols-outlined text-secondary text-[22px]">corporate_fare</span>
                                    <h2 class="font-headline-md text-headline-md text-on-surface font-bold">Profil &amp; Keunggulan {{ $bank->name }}</h2>
                                </div>
                                <span class="font-label-sm text-label-sm uppercase font-bold text-on-surface-variant bg-surface-container px-2 py-0.5 rounded">
                                    {{ $bank->code_saham ?? 'Perbankan' }}
                                </span>
                            </div>

                            <div class="relative overflow-hidden">
                                <p class="font-body-md text-body-md text-on-surface leading-relaxed">
                                    {{ $bank->description ?: ($bank->name . ' adalah lembaga perbankan resmi beroperasi di Indonesia yang terdaftar dan diawasi oleh Otoritas Jasa Keuangan (OJK). Menyediakan layanan simpanan deposito berjangka dengan tingkat suku bunga yang kompetitif dan opsi tenor yang fleksibel.') }}
                                </p>
                            </div>
                        </article>

                        <!-- Seksi Katalog Produk Deposito Bank -->
                        <article class="bg-surface-container-lowest rounded-xl p-space-lg shadow-sm flex flex-col gap-space-lg">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-space-sm">
                                <div>
                                    <div class="flex items-center gap-space-xs">
                                        <span class="material-symbols-outlined text-secondary text-[22px]">savings</span>
                                        <h2 class="font-headline-md text-headline-md text-on-surface font-bold">Katalog Produk Deposito {{ $bank->name }}</h2>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">
                                        Pilihan penempatan dana simpanan dengan jaminan keamanan dan imbal hasil terverifikasi.
                                    </p>
                                </div>

                                <!-- Filter Tab Tenor -->
                                <div class="flex items-center bg-surface-container-low p-1 rounded-lg self-start sm:self-auto" id="filterTenorGroup">
                                    <button class="filter-tab active font-label-sm text-label-sm uppercase px-3 py-1.5 rounded-lg bg-surface-container-lowest text-secondary font-bold shadow-sm transition-all" data-filter="all">Semua</button>
                                    <button class="filter-tab font-label-sm text-label-sm uppercase px-3 py-1.5 rounded-lg text-on-surface-variant hover:text-on-surface transition-all" data-filter="1m">1 Bln</button>
                                    <button class="filter-tab font-label-sm text-label-sm uppercase px-3 py-1.5 rounded-lg text-on-surface-variant hover:text-on-surface transition-all" data-filter="3m">3 Bln</button>
                                    <button class="filter-tab font-label-sm text-label-sm uppercase px-3 py-1.5 rounded-lg text-on-surface-variant hover:text-on-surface transition-all" data-filter="6m">6 Bln</button>
                                    <button class="filter-tab font-label-sm text-label-sm uppercase px-3 py-1.5 rounded-lg text-on-surface-variant hover:text-on-surface transition-all" data-filter="12m">12 Bln</button>
                                </div>
                            </div>

                            <!-- List Produk Deposito Dinamis -->
                            <div class="flex flex-col gap-space-md" id="productGrid">
                                @forelse($bank->products as $product)
                                    @php
                                        $rates = $product->rates->sortBy('duration_months');
                                        $highestRateForProd = $rates->sortByDesc('interest_rate')->first()?->interest_rate ?? 0;
                                        $tenorTokens = $rates->pluck('duration_months')->map(fn($m) => $m . 'm')->implode(' ') . ' all';
                                    @endphp

                                    <div class="product-item rounded-xl p-space-md bg-surface-container-low hover:bg-surface-container transition-all shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-space-md" data-tenors="{{ $tenorTokens }}">
                                        <div class="flex flex-col gap-2 flex-1">
                                            <div class="flex flex-wrap items-center gap-space-xs">
                                                <span class="font-label-sm text-label-sm uppercase px-2 py-0.5 rounded bg-secondary text-on-secondary font-bold">
                                                    {{ $product->name }}
                                                </span>
                                                @if($bank->is_lps_insured)
                                                    <span class="font-label-sm text-label-sm uppercase px-2 py-0.5 rounded bg-surface-container text-on-surface font-bold">
                                                        Garansi LPS
                                                    </span>
                                                @endif
                                                <span class="font-label-sm text-label-sm uppercase px-2 py-0.5 rounded bg-surface-container text-secondary font-bold">
                                                    Min Rp {{ number_format($product->min_deposit, 0, ',', '.') }}
                                                </span>
                                            </div>

                                            <div class="flex flex-col">
                                                <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold">
                                                    {{ $product->name }}
                                                </h3>
                                                <p class="font-body-sm text-body-sm text-on-surface-variant">
                                                    {{ $product->description ?: 'Penempatan simpanan deposito terpercaya dengan opsi tenor fleksibel dan bunga kompetitif.' }}
                                                </p>
                                            </div>

                                            <!-- Suku Bunga per Tenor -->
                                            <div class="flex flex-wrap items-center gap-space-xs text-on-surface-variant pt-1">
                                                @foreach($rates as $r)
                                                    <div class="bg-surface-container-lowest px-2.5 py-1 rounded-lg border border-surface-container flex items-center gap-1.5">
                                                        <span class="font-label-sm text-label-sm text-on-surface-variant block uppercase">{{ $r->duration_months }} Bln:</span>
                                                        <span class="font-label-md text-label-md text-secondary font-bold">{{ number_format($r->interest_rate, 2) }}%</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Right Buka Deposito CTA & Rate -->
                                        <div class="flex md:flex-col items-center md:items-end justify-between md:justify-center gap-space-sm shrink-0 border-t md:border-t-0 border-surface-container pt-space-xs md:pt-0">
                                            <div class="text-left md:text-right">
                                                <span class="font-label-sm text-label-sm text-on-surface-variant uppercase block">Bunga Hingga</span>
                                                <span class="font-metric-display text-metric-display text-secondary font-bold">
                                                    {{ number_format($highestRateForProd, 2) }}%
                                                    <span class="font-label-md text-label-md text-on-surface-variant font-normal">p.a.</span>
                                                </span>
                                            </div>

                                            <!-- Tombol Buka Deposito Sesuai Database URL -->
                                            @if($product->referral_link)
                                                <a href="{{ $product->referral_link }}" target="_blank" rel="noopener noreferrer" class="px-5 py-2 rounded-lg bg-secondary hover:bg-on-secondary-fixed-variant text-on-secondary font-label-lg text-label-lg transition-colors shadow-sm inline-flex items-center gap-1.5" title="Buka rekening deposito resmi">
                                                    <span>Buka Deposito</span>
                                                    <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                                                </a>
                                            @else
                                                <button class="px-5 py-2 rounded-lg bg-secondary hover:bg-on-secondary-fixed-variant text-on-secondary font-label-lg text-label-lg transition-colors shadow-sm inline-flex items-center gap-1.5" type="button" onclick="document.getElementById('depositNominal').focus();">
                                                    <span>Simulasi Bunga</span>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-10 bg-surface-container-low rounded-xl text-on-surface-variant">
                                        <span class="material-symbols-outlined text-4xl mb-2 text-outline">search_off</span>
                                        <h4 class="font-headline-sm font-bold text-on-surface">Belum Ada Data Produk Deposito</h4>
                                        <p class="font-body-sm text-outline mt-1">Data suku bunga deposito untuk bank ini belum diinput ke sistem.</p>
                                    </div>
                                @endforelse
                            </div>
                        </article>

                        <!-- Seksi Transparansi Ketentuan LPS & Regulasi -->
                        <article class="bg-surface-container-lowest rounded-xl p-space-lg shadow-sm flex flex-col gap-space-lg">
                            <div class="flex items-center gap-space-xs">
                                <span class="material-symbols-outlined text-secondary text-[22px]">policy</span>
                                <h2 class="font-headline-md text-headline-md text-on-surface font-bold">Transparansi Ketentuan LPS &amp; Perpajakan</h2>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md">
                                <div class="p-space-md rounded-lg bg-surface-container-low flex flex-col gap-space-sm">
                                    <span class="font-label-md text-label-md text-on-surface font-bold flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-secondary text-[18px]">verified</span>
                                        Ketentuan Penjaminan LPS
                                    </span>
                                    <ul class="flex flex-col gap-2 font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                                        <li class="flex items-start gap-2">
                                            <span class="material-symbols-outlined text-secondary text-[16px] shrink-0 mt-0.5">check_circle</span>
                                            <span><strong>Maksimal Saldo Dijamin:</strong> Rp 2.000.000.000 per nasabah per bank.</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <span class="material-symbols-outlined text-secondary text-[16px] shrink-0 mt-0.5">check_circle</span>
                                            <span><strong>Tingkat Bunga Penjaminan (TBP):</strong> Maksimum {{ number_format($lpsLimitGeneral, 2) }}% (Bank Umum) &amp; {{ number_format($lpsLimitBpr, 2) }}% (BPR).</span>
                                        </li>
                                    </ul>
                                </div>

                                <div class="p-space-md rounded-lg bg-surface-container-low flex flex-col gap-space-sm">
                                    <span class="font-label-md text-label-md text-on-surface font-bold flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-secondary text-[18px]">receipt_long</span>
                                        Pajak Penghasilan (PPh) Final
                                    </span>
                                    <ul class="flex flex-col gap-2 font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                                        <li class="flex items-start gap-2">
                                            <span class="material-symbols-outlined text-secondary text-[16px] shrink-0 mt-0.5">check_circle</span>
                                            <span>Sesuai PP No. 131/2000, bunga simpanan deposito dengan nominal saldo di atas Rp 7.500.000 dikenakan PPh Final sebesar 20%.</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <span class="material-symbols-outlined text-secondary text-[16px] shrink-0 mt-0.5">check_circle</span>
                                            <span>Simpanan di bawah Rp 7.500.000 dibebaskan dari pemotongan pajak bunga (0%).</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </article>

                        <!-- Bank Rekomendasi Lainnya -->
                        @if($otherBanks->isNotEmpty())
                            <article class="bg-surface-container-lowest rounded-xl p-space-lg shadow-sm flex flex-col gap-space-md">
                                <div class="flex items-center justify-between">
                                    <h2 class="font-headline-md text-headline-md text-on-surface font-bold">Bandingkan dengan Bank Lain</h2>
                                    <a href="{{ route('home') }}#tabel-deposito" class="font-label-md text-secondary hover:underline flex items-center gap-1">
                                        Lihat Semua Bank <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                                    </a>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md">
                                    @foreach($otherBanks as $ob)
                                        @php
                                            $obMaxRate = $ob->products->flatMap->rates->max('interest_rate') ?? 0;
                                        @endphp
                                        <a href="{{ route('bank.detail', $ob->id) }}" class="p-space-md rounded-xl bg-surface-container-low hover:bg-surface-container transition-all flex flex-col gap-2 group">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-lg bg-surface-container-lowest flex items-center justify-center overflow-hidden border border-outline-variant/30 shrink-0">
                                                    @if($ob->logo_url)
                                                        <img src="{{ asset('storage/' . $ob->logo_url) }}" alt="{{ $ob->name }}" class="w-full h-full object-contain p-1">
                                                    @else
                                                        <span class="font-bold text-on-surface text-label-md">{{ strtoupper(substr($ob->name, 0, 3)) }}</span>
                                                    @endif
                                                </div>
                                                <div>
                                                    <span class="font-headline-sm text-headline-sm text-on-surface font-bold group-hover:text-secondary transition-colors block">
                                                        {{ $ob->name }}
                                                    </span>
                                                    <span class="font-label-sm text-on-surface-variant uppercase">{{ $ob->type }}</span>
                                                </div>
                                            </div>
                                            <div class="flex items-center justify-between pt-2 border-t border-surface-container">
                                                <span class="font-label-sm text-on-surface-variant uppercase">Bunga Tertinggi</span>
                                                <span class="font-label-md text-secondary font-bold">{{ number_format($obMaxRate, 2) }}% p.a.</span>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </article>
                        @endif

                    </section>

                    <!-- KOLOM KANAN / SIDEBAR (4 columns) -->
                    <aside class="lg:col-span-4 flex flex-col gap-space-lg">
                        
                        <!-- Widget Interaktif: Kalkulator Simulasi Deposito -->
                        <section class="bg-surface-container-lowest rounded-xl p-space-lg shadow-sm flex flex-col gap-space-md sticky top-24" id="simulator">
                            <div class="flex items-center gap-space-xs">
                                <span class="material-symbols-outlined text-secondary text-[22px]">calculate</span>
                                <div>
                                    <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold">Kalkulator Deposito</h3>
                                    <p class="font-label-sm text-label-sm text-on-surface-variant">Simulasi imbal hasil simpanan {{ $bank->name }}</p>
                                </div>
                            </div>

                            <div class="flex flex-col gap-space-md pt-space-xs">
                                <!-- Nominal Input -->
                                <div class="flex flex-col gap-1.5">
                                    <label class="font-label-md text-label-md text-on-surface font-bold" for="depositNominal">
                                        Nominal Penempatan (IDR)
                                    </label>
                                    <div class="flex rounded-lg overflow-hidden bg-surface-container-low shadow-sm focus-within:ring-2 focus-within:ring-secondary/40">
                                        <span class="px-3.5 py-2.5 bg-surface-container text-on-surface-variant font-label-md text-label-md flex items-center font-bold">
                                            Rp
                                        </span>
                                        <input
                                            class="w-full bg-transparent px-3 py-2.5 font-headline-sm text-headline-sm text-on-surface font-bold focus:outline-none"
                                            id="depositNominal" type="text" inputmode="numeric"
                                            value="50,000,000" placeholder="50,000,000" autocomplete="off"
                                        />
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <button class="quick-amt text-label-sm font-label-sm px-2 py-0.5 rounded bg-surface-container hover:bg-surface-container-high text-on-surface transition-colors" data-amt="10000000" type="button">10 Jt</button>
                                        <button class="quick-amt text-label-sm font-label-sm px-2 py-0.5 rounded bg-surface-container hover:bg-surface-container-high text-on-surface transition-colors" data-amt="50000000" type="button">50 Jt</button>
                                        <button class="quick-amt text-label-sm font-label-sm px-2 py-0.5 rounded bg-surface-container hover:bg-surface-container-high text-on-surface transition-colors" data-amt="100000000" type="button">100 Jt</button>
                                        <button class="quick-amt text-label-sm font-label-sm px-2 py-0.5 rounded bg-surface-container hover:bg-surface-container-high text-on-surface transition-colors" data-amt="500000000" type="button">500 Jt</button>
                                    </div>
                                </div>

                                <!-- Tenor Selection Dinamis -->
                                <div class="flex flex-col gap-1.5">
                                    <label class="font-label-md text-label-md text-on-surface font-bold">Pilih Tenor Simpanan</label>
                                    @php
                                        $ratesByTenor = $allRates->groupBy('duration_months');
                                        $standardTenors = [1, 3, 6, 12];
                                        $defaultRate = $maxRate > 0 ? $maxRate : 5.00;
                                    @endphp
                                    <div class="grid grid-cols-4 gap-1.5" id="tenorButtonsContainer">
                                        @foreach($standardTenors as $m)
                                            @php
                                                $rObj = $ratesByTenor->get($m)?->first();
                                                $rVal = $rObj ? $rObj->interest_rate : ($m == 12 ? $defaultRate : max(3.0, $defaultRate - 0.25));
                                                $isActive = ($m == 12);
                                            @endphp
                                            <button 
                                                class="tenor-btn py-2 text-center rounded-lg {{ $isActive ? 'active bg-secondary text-on-secondary shadow-sm' : 'bg-surface-container-low hover:bg-surface-container text-on-surface' }} font-label-md text-label-md font-bold transition-all"
                                                data-months="{{ $m }}" 
                                                data-rate="{{ number_format($rVal, 2, '.', '') }}" 
                                                type="button"
                                            >
                                                {{ $m }} Bln
                                            </button>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Hasil Perhitungan Breakdown Card -->
                                <div class="p-space-md rounded-xl bg-surface-container-low flex flex-col gap-space-sm">
                                    <div class="flex items-center justify-between pb-1 border-b border-surface-container">
                                        <span class="font-body-sm text-body-sm text-on-surface-variant">Suku Bunga Acuan</span>
                                        <span class="font-label-md text-label-md text-secondary font-bold" id="calcRateDisplay">
                                            {{ number_format($defaultRate, 2) }}% p.a.
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between pb-1 border-b border-surface-container">
                                        <span class="font-body-sm text-body-sm text-on-surface-variant">Estimasi Bunga Kotor</span>
                                        <span class="font-label-md text-label-md text-on-surface font-bold" id="calcGrossDisplay">
                                            Rp 0
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between pb-1 border-b border-surface-container">
                                        <span class="font-body-sm text-body-sm text-on-surface-variant">Pajak Bunga (20% PPh)</span>
                                        <span class="font-label-md text-label-md text-error font-bold" id="calcTaxDisplay">
                                            Rp 0
                                        </span>
                                    </div>
                                    <div class="pt-space-xs flex flex-col gap-0.5">
                                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">Estimasi Bunga Bersih (Net)</span>
                                        <span class="font-metric-display text-metric-display text-secondary font-bold leading-tight" id="calcNetDisplay">
                                            Rp 0
                                        </span>
                                        <span class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">
                                            Total saat jatuh tempo: <strong class="text-on-surface" id="calcTotalDisplay">Rp 0</strong>
                                        </span>
                                    </div>
                                </div>

                                <!-- Tombol Buka Deposito di Kalkulator Sesuai URL Database -->
                                @if($bankReferralLink)
                                    <a href="{{ $bankReferralLink }}" target="_blank" rel="noopener noreferrer" class="w-full py-3 rounded-lg bg-secondary hover:bg-on-secondary-fixed-variant text-on-secondary font-label-lg text-label-lg transition-colors shadow-sm flex items-center justify-center gap-2">
                                        <span class="material-symbols-outlined text-[20px]">account_balance</span>
                                        <span>Buka Deposito {{ $bank->name }}</span>
                                        <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                                    </a>
                                @else
                                    <button class="w-full py-3 rounded-lg bg-secondary hover:bg-on-secondary-fixed-variant text-on-secondary font-label-lg text-label-lg transition-colors shadow-sm flex items-center justify-center gap-2" type="button" onclick="alert('Silakan kunjungi situs resmi atau aplikasi {{ $bank->name }} untuk pembukaan rekening deposito.')">
                                        <span class="material-symbols-outlined text-[20px]">account_balance</span>
                                        <span>Buka Deposito {{ $bank->name }}</span>
                                    </button>
                                @endif

                                <span class="font-label-sm text-label-sm text-on-surface-variant text-center leading-tight">
                                    Simulasi berdasarkan asumsi 365 hari per tahun kalender.
                                </span>
                            </div>
                        </section>

                    </aside>
                </div>
            </div>
        </div>

        <!-- Script Interaksi Halaman Detail Bank -->
        <script>
            (function initBankDetailInteractions() {
                // 1. Filter Tenor Katalog Produk Deposito
                const filterTabs = document.querySelectorAll('#filterTenorGroup .filter-tab');
                const productItems = document.querySelectorAll('#productGrid .product-item');

                filterTabs.forEach(tab => {
                    tab.addEventListener('click', () => {
                        filterTabs.forEach(t => {
                            t.classList.remove('bg-surface-container-lowest', 'text-secondary', 'font-bold', 'shadow-sm');
                            t.classList.add('text-on-surface-variant');
                        });
                        tab.classList.add('bg-surface-container-lowest', 'text-secondary', 'font-bold', 'shadow-sm');
                        tab.classList.remove('text-on-surface-variant');

                        const filter = tab.getAttribute('data-filter');
                        productItems.forEach(card => {
                            const tenors = card.getAttribute('data-tenors') || '';
                            if (filter === 'all' || tenors.includes(filter)) {
                                card.style.display = 'flex';
                            } else {
                                card.style.display = 'none';
                            }
                        });
                    });
                });

                // 2. Bookmark Action
                const btnBookmark = document.getElementById('btnBookmark');
                const txtBookmark = document.getElementById('txtBookmark');
                let isBookmarked = false;
                if (btnBookmark && txtBookmark) {
                    btnBookmark.addEventListener('click', () => {
                        isBookmarked = !isBookmarked;
                        const icon = btnBookmark.querySelector('.material-symbols-outlined');
                        if (isBookmarked) {
                            icon.textContent = 'bookmark';
                            icon.style.fontVariationSettings = "'FILL' 1";
                            icon.classList.add('text-secondary');
                            txtBookmark.textContent = 'Tersimpan';
                        } else {
                            icon.textContent = 'bookmark_border';
                            icon.style.fontVariationSettings = "'FILL' 0";
                            icon.classList.remove('text-secondary');
                            txtBookmark.textContent = 'Simpan Bank';
                        }
                    });
                }

                // 3. Share Action
                const btnShare = document.getElementById('btnShare');
                if (btnShare) {
                    btnShare.addEventListener('click', () => {
                        if (navigator.share) {
                            navigator.share({
                                title: document.title,
                                url: window.location.href
                            }).catch(() => {});
                        } else {
                            navigator.clipboard.writeText(window.location.href).then(() => {
                                alert('Link profil bank berhasil disalin ke clipboard!');
                            });
                        }
                    });
                }

                // 4. Kalkulator Simulasi Deposito Interaktif
                const nominalInput = document.getElementById('depositNominal');
                const tenorBtns = document.querySelectorAll('.tenor-btn');
                const quickAmtBtns = document.querySelectorAll('.quick-amt');

                const rateDisplay = document.getElementById('calcRateDisplay');
                const grossDisplay = document.getElementById('calcGrossDisplay');
                const taxDisplay = document.getElementById('calcTaxDisplay');
                const netDisplay = document.getElementById('calcNetDisplay');
                const totalDisplay = document.getElementById('calcTotalDisplay');

                let activeBtn = document.querySelector('.tenor-btn.active') || document.querySelector('.tenor-btn');
                let currentRate = activeBtn ? parseFloat(activeBtn.getAttribute('data-rate')) : 5.0;
                let currentMonths = activeBtn ? parseInt(activeBtn.getAttribute('data-months')) : 12;

                function formatRupiah(number) {
                    return 'Rp ' + Math.round(number).toLocaleString('id-ID');
                }

                function formatWithCommas(val) {
                    if (!val && val !== 0) return '';
                    const digits = val.toString().replace(/\D/g, '');
                    if (!digits) return '';
                    return digits.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                }

                function getCleanNominal() {
                    if (!nominalInput) return 0;
                    const clean = (nominalInput.value || '').replace(/\D/g, '');
                    return clean ? parseFloat(clean) : 0;
                }

                function recalculate() {
                    const nominal = getCleanNominal();
                    const days = currentMonths * 30;
                    const grossYield = (nominal * (currentRate / 100) * days) / 365;

                    let tax = 0;
                    if (nominal >= 7500000) {
                        tax = grossYield * 0.20;
                    }
                    const netYield = grossYield - tax;
                    const totalReturn = nominal + netYield;

                    if (rateDisplay) rateDisplay.textContent = currentRate.toFixed(2) + '% p.a.';
                    if (grossDisplay) grossDisplay.textContent = formatRupiah(grossYield);
                    if (taxDisplay) taxDisplay.textContent = tax > 0 ? '- ' + formatRupiah(tax) : 'Rp 0 (Bebas Pajak)';
                    if (netDisplay) netDisplay.textContent = formatRupiah(netYield);
                    if (totalDisplay) totalDisplay.textContent = formatRupiah(totalReturn);
                }

                // Proteksi dan pemformatan koma pada Nominal Penempatan
                if (nominalInput) {
                    // Cegah pengetikan manual karakter koma atau titik karena koma otomatis dibuat
                    nominalInput.addEventListener('keydown', (e) => {
                        if (e.key === ',' || e.key === '.') {
                            e.preventDefault();
                            return;
                        }

                        const pos = nominalInput.selectionStart;
                        const end = nominalInput.selectionEnd;

                        // Ketika kursor berada pada satu titik (tidak ada teks yang di-blok)
                        if (pos === end) {
                            // Backspace tepat setelah koma (contoh: "50,|000,000"):
                            // Koma tidak boleh terhapus secara mandiri, melainkan menghapus digit angka di depan koma
                            if (e.key === 'Backspace' && pos > 0) {
                                if (nominalInput.value[pos - 1] === ',') {
                                    e.preventDefault();
                                    const val = nominalInput.value;
                                    const digitsBefore = val.slice(0, pos - 1).replace(/\D/g, '').length;
                                    const newVal = val.slice(0, pos - 2) + val.slice(pos);
                                    const formatted = formatWithCommas(newVal);
                                    nominalInput.value = formatted;

                                    // Kembalikan posisi kursor sesuai digit yang tersisa
                                    const targetDigits = Math.max(0, digitsBefore - 1);
                                    let newPos = 0;
                                    let count = 0;
                                    while (newPos < formatted.length && count < targetDigits) {
                                        if (/\d/.test(formatted[newPos])) count++;
                                        newPos++;
                                    }
                                    nominalInput.setSelectionRange(newPos, newPos);
                                    recalculate();
                                }
                            }

                            // Delete tepat sebelum koma (contoh: "50|,000,000"):
                            // Menghapus digit angka setelah koma
                            if (e.key === 'Delete' && pos < nominalInput.value.length) {
                                if (nominalInput.value[pos] === ',') {
                                    e.preventDefault();
                                    const val = nominalInput.value;
                                    const digitsBefore = val.slice(0, pos).replace(/\D/g, '').length;
                                    const newVal = val.slice(0, pos) + val.slice(pos + 2);
                                    const formatted = formatWithCommas(newVal);
                                    nominalInput.value = formatted;

                                    let newPos = 0;
                                    let count = 0;
                                    while (newPos < formatted.length && count < digitsBefore) {
                                        if (/\d/.test(formatted[newPos])) count++;
                                        newPos++;
                                    }
                                    nominalInput.setSelectionRange(newPos, newPos);
                                    recalculate();
                                }
                            }
                        }
                    });

                    // Format otomatis ribuan dengan koma seiring pengetikan angka
                    nominalInput.addEventListener('input', () => {
                        const val = nominalInput.value;
                        const selStart = nominalInput.selectionStart || 0;
                        const digitsBefore = val.slice(0, selStart).replace(/\D/g, '').length;

                        const formatted = formatWithCommas(val);
                        nominalInput.value = formatted;

                        // Pertahankan kursor pada posisi digit yang tepat
                        let newPos = 0;
                        let count = 0;
                        while (newPos < formatted.length && count < digitsBefore) {
                            if (/\d/.test(formatted[newPos])) count++;
                            newPos++;
                        }
                        nominalInput.setSelectionRange(newPos, newPos);

                        recalculate();
                    });

                    // Pastikan default saat field ditinggalkan kosong
                    nominalInput.addEventListener('blur', () => {
                        if (!nominalInput.value.trim()) {
                            nominalInput.value = '10,000,000';
                            recalculate();
                        }
                    });
                }

                tenorBtns.forEach(btn => {
                    btn.addEventListener('click', () => {
                        tenorBtns.forEach(b => {
                            b.classList.remove('active', 'bg-secondary', 'text-on-secondary', 'shadow-sm');
                            b.classList.add('bg-surface-container-low', 'text-on-surface');
                        });
                        btn.classList.add('active', 'bg-secondary', 'text-on-secondary', 'shadow-sm');
                        btn.classList.remove('bg-surface-container-low', 'text-on-surface');

                        currentMonths = parseInt(btn.getAttribute('data-months'));
                        currentRate = parseFloat(btn.getAttribute('data-rate'));
                        recalculate();
                    });
                });

                quickAmtBtns.forEach(btn => {
                    btn.addEventListener('click', () => {
                        nominalInput.value = formatWithCommas(btn.getAttribute('data-amt'));
                        recalculate();
                    });
                });

                // Initial calculation
                recalculate();
            })();
        </script>
    </main>

    <!-- Footer -->
    <footer class="w-full bg-surface-container-lowest mt-space-2xl shadow-[0_-1px_8px_rgba(15,23,42,0.03)]">
        <div class="w-full max-w-[1680px] mx-auto px-margin py-space-xl">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-space-lg pb-space-lg">
                <div class="flex items-center gap-space-sm">
                    <div class="w-7 h-7 rounded-lg bg-secondary flex items-center justify-center">
                        <span class="material-symbols-outlined text-on-secondary text-[18px]">account_balance</span>
                    </div>
                    <span class="font-headline-sm text-headline-sm text-on-surface">BankRate ID</span>
                    <span class="font-body-sm text-body-sm text-on-surface-variant">— Platform Analisis &amp; Komparasi Suku Bunga Perbankan Indonesia</span>
                </div>
                <div class="flex items-center gap-space-md">
                    <div class="flex items-center gap-1.5 px-3 py-1 rounded bg-surface-container-low text-on-surface-variant">
                        <span class="material-symbols-outlined text-[16px] text-secondary">verified_user</span>
                        <span class="font-label-sm text-label-sm uppercase font-bold text-on-surface">Data Terkoreksi Harian</span>
                    </div>
                    <div class="flex items-center gap-1.5 px-3 py-1 rounded bg-surface-container-low text-on-surface-variant">
                        <span class="material-symbols-outlined text-[16px] text-secondary">shield</span>
                        <span class="font-label-sm text-label-sm uppercase font-bold text-on-surface">LPS Terdaftar</span>
                    </div>
                </div>
            </div>
            <div class="pt-space-md flex flex-col md:flex-row items-start md:items-center justify-between gap-space-sm text-on-surface-variant">
                <p class="font-body-sm text-body-sm max-w-4xl text-on-surface-variant leading-relaxed">
                    Data suku bunga dihimpun langsung dari laporan publikasi resmi perbankan, OJK, dan Bank Indonesia. Simpanan dijamin oleh LPS sesuai ketentuan yang berlaku.
                </p>
                <p class="font-body-sm text-body-sm shrink-0">&copy; {{ date('Y') }} BankRate ID. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>

    <!-- PWA Helper Script -->
    <script src="{{ asset('js/pwa.js') }}"></script>
</body>
</html>