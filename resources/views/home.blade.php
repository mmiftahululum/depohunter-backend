<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Primary SEO Meta Tags -->
    <title>BankRate ID - Komparasi Suku Bunga Deposito Tertinggi & Terlengkap di Indonesia</title>
    <meta name="title" content="BankRate ID - Komparasi Suku Bunga Deposito Tertinggi & Terlengkap di Indonesia" />
    <meta name="description"
        content="Bandingkan suku bunga deposito tertinggi di Indonesia dari bank digital, konvensional, dan BPR secara real-time. Cek batas penjaminan LPS, kalkulator simulasi bunga bersih PPh 20%, dan regulasi BI." />
    <meta name="keywords"
        content="suku bunga deposito, deposito tertinggi, bunga deposito bank digital, bunga deposito bpr, deposito lps, kalkulator deposito, komparasi deposito, simulasi deposito, bi rate, deposito jago, deposito seabank, deposito amar bank" />
    <meta name="author" content="BankRate ID" />
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
    <link rel="canonical" href="{{ url()->current() }}" />

    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:type" content="website" />
    <meta property="og:locale" content="id_ID" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:title" content="BankRate ID - Komparasi Suku Bunga Deposito Tertinggi di Indonesia" />
    <meta property="og:description"
        content="Temukan bunga deposito tertinggi dari Bank Digital, Konvensional, dan BPR. Pantau batas aman penjaminan LPS dan hitung keuntungan bersih simpanan Anda." />
    <meta property="og:site_name" content="BankRate ID" />
    <meta property="og:image" content="{{ asset('favicon.ico') }}" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:url" content="{{ url()->current() }}" />
    <meta name="twitter:title" content="BankRate ID - Komparasi Suku Bunga Deposito Tertinggi" />
    <meta name="twitter:description"
        content="Pantau suku bunga deposito terbaik di Indonesia, simulasi bunga bersih PPh 20%, dan batas penjaminan LPS secara real-time." />
    <meta name="twitter:image" content="{{ asset('favicon.ico') }}" />

    <!-- Progressive Web App (PWA) Meta & Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}" />
    <meta name="theme-color" content="#4f46e5" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="apple-mobile-web-app-title" content="BankRate ID" />
    <link rel="apple-touch-icon" href="{{ asset('icons/apple-touch-icon.png') }}" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('icons/icon.svg') }}" />

    <!-- Structured Data (JSON-LD Schema.org) -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@graph": [
            {
                "@type": "WebSite",
                "@id": "{{ url('/') }}#website",
                "url": "{{ url('/') }}",
                "name": "BankRate ID",
                "description": "Platform perbandingan dan intelijen suku bunga deposito perbankan Indonesia",
                "inLanguage": "id-ID"
            },
            {
                "@type": "FinancialService",
                "@id": "{{ url('/') }}#financialservice",
                "name": "BankRate ID - Depo Hunter",
                "url": "{{ url('/') }}",
                "description": "Informasi perbandingan suku bunga deposito bank umum, bank digital, dan BPR sesuai regulasi OJK & LPS",
                "areaServed": "ID",
                "currenciesAccepted": "IDR"
            },
            {
                "@type": "ItemList",
                "name": "Daftar Suku Bunga Deposito Tertinggi Indonesia",
                "description": "Peringkat suku bunga simpanan deposito perbankan terverifikasi pasar",
                "itemListElement": [
                    @foreach($topRates->take(5) as $idx => $r)
                        {
                            "@type": "ListItem",
                            "position": {{ $idx + 1 }},
                            "name": "{{ $r->product->bank->name ?? 'Bank' }} - {{ $r->product->name ?? 'Deposito' }} ({{ $r->interest_rate }}% p.a.)",
                            "description": "Tenor {{ $r->duration_months }} Bulan, Min Penempatan Rp {{ number_format($r->product->min_deposit ?? 0, 0, ',', '.') }}"
                        }@if(!$loop->last),@endif
                    @endforeach
                ]
            }
        ]
    }
    </script>

    <!-- Google Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;600;700&display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
        rel="stylesheet" />

    <style>
        @layer base {

            html,
            body {
                margin: 0;
                padding: 0;
            }

            body {
                overscroll-behavior: none;
            }

            main> :first-child {
                margin-top: 0 !important;
            }

            main> :last-child {
                margin-bottom: 0 !important;
            }
        }

        ::-webkit-scrollbar {
            display: none;
        }

        /* Dual Handle Range Slider Styling */
        .dual-range-input::-webkit-slider-runnable-track {
            -webkit-appearance: none;
            appearance: none;
            background: transparent;
            height: 100%;
        }

        .dual-range-input::-moz-range-track {
            background: transparent;
            height: 100%;
        }

        .dual-range-input::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #0051d5;
            border: 3px solid #ffffff;
            box-shadow: 0 1px 4px rgba(0, 81, 213, 0.4);
            cursor: pointer;
            pointer-events: auto;
            transition: transform 0.1s ease, box-shadow 0.1s ease;
        }

        .dual-range-input::-webkit-slider-thumb:hover {
            transform: scale(1.18);
            box-shadow: 0 2px 8px rgba(0, 81, 213, 0.5);
        }

        .dual-range-input::-webkit-slider-thumb:active {
            transform: scale(1.25);
            box-shadow: 0 0 0 6px rgba(0, 81, 213, 0.2);
        }

        .dual-range-input::-moz-range-thumb {
            appearance: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #0051d5;
            border: 3px solid #ffffff;
            box-shadow: 0 1px 4px rgba(0, 81, 213, 0.4);
            cursor: pointer;
            pointer-events: auto;
            transition: transform 0.1s ease, box-shadow 0.1s ease;
        }

        .dual-range-input::-moz-range-thumb:hover {
            transform: scale(1.18);
            box-shadow: 0 2px 8px rgba(0, 81, 213, 0.5);
        }

        .dual-range-input::-moz-range-thumb:active {
            transform: scale(1.25);
            box-shadow: 0 0 0 6px rgba(0, 81, 213, 0.2);
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
                        "primary-fixed": "#dae2fd",
                        "tertiary-fixed": "#cce5ff",
                        "on-surface": "#0b1c30",
                        "surface-container-low": "#eff4ff",
                        "on-primary": "#ffffff",
                        "on-tertiary": "#ffffff",
                        "on-surface-variant": "#45464d",
                        "error-container": "#ffdad6",
                        "surface-bright": "#f8f9ff",
                        "secondary-container": "#316bf3",
                        "on-primary-fixed": "#131b2e",
                        "on-tertiary-fixed": "#001d31",
                        "inverse-primary": "#bec6e0",
                        "surface-container-lowest": "#ffffff",
                        "primary-container": "#131b2e",
                        "tertiary": "#000000",
                        "surface-tint": "#565e74",
                        "background": "#f8f9ff",
                        "tertiary-container": "#001d31",
                        "surface-dim": "#cbdbf5",
                        "secondary-fixed-dim": "#b4c5ff",
                        "surface": "#f8f9ff",
                        "on-tertiary-fixed-variant": "#004b73",
                        "on-tertiary-container": "#188ace",
                        "primary-fixed-dim": "#bec6e0",
                        "surface-variant": "#d3e4fe",
                        "secondary": "#0051d5",
                        "surface-container": "#e5eeff",
                        "on-primary-container": "#7c839b",
                        "tertiary-fixed-dim": "#93ccff",
                        "inverse-surface": "#213145",
                        "surface-container-highest": "#d3e4fe",
                        "on-secondary-fixed-variant": "#003ea8",
                        "secondary-fixed": "#dbe1ff",
                        "error": "#ba1a1a",
                        "inverse-on-surface": "#eaf1ff",
                        "on-error-container": "#93000a",
                        "on-secondary-fixed": "#00174b",
                        "on-error": "#ffffff",
                        "on-primary-fixed-variant": "#3f465c",
                        "outline-variant": "#c6c6cd",
                        "on-background": "#0b1c30"
                    },
                    borderRadius: {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    spacing: {
                        "margin-wide": "3rem",
                        "space-2xl": "3rem",
                        "space-xs": "0.25rem",
                        "space-sm": "0.5rem",
                        "space-lg": "1.5rem",
                        "gutter": "1.5rem",
                        "space-xl": "2rem",
                        "gutter-compact": "1rem",
                        "space-md": "1rem",
                        "margin": "2rem"
                    },
                    fontFamily: {
                        "label-md": ["Hanken Grotesk"],
                        "headline-md": ["Hanken Grotesk"],
                        "metric-display": ["Hanken Grotesk"],
                        "label-sm": ["Hanken Grotesk"],
                        "display-xl": ["Hanken Grotesk"],
                        "metric-table": ["Hanken Grotesk"],
                        "display-lg": ["Hanken Grotesk"],
                        "headline-lg": ["Hanken Grotesk"],
                        "headline-sm": ["Hanken Grotesk"],
                        "body-md": ["Hanken Grotesk"],
                        "body-lg": ["Hanken Grotesk"],
                        "body-sm": ["Hanken Grotesk"],
                        "label-lg": ["Hanken Grotesk"]
                    },
                    fontSize: {
                        "label-md": ["12px", { "lineHeight": "16px", "letterSpacing": "0.02em", "fontWeight": "600" }],
                        "headline-md": ["20px", { "lineHeight": "28px", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "metric-display": ["28px", { "lineHeight": "32px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "label-sm": ["10px", { "lineHeight": "14px", "letterSpacing": "0.04em", "fontWeight": "700" }],
                        "display-xl": ["40px", { "lineHeight": "48px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "metric-table": ["14px", { "lineHeight": "20px", "letterSpacing": "0em", "fontWeight": "600" }],
                        "display-lg": ["32px", { "lineHeight": "40px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "headline-lg": ["24px", { "lineHeight": "32px", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "headline-sm": ["16px", { "lineHeight": "24px", "letterSpacing": "0em", "fontWeight": "600" }],
                        "body-md": ["14px", { "lineHeight": "20px", "letterSpacing": "0em", "fontWeight": "400" }],
                        "body-lg": ["16px", { "lineHeight": "24px", "letterSpacing": "0em", "fontWeight": "400" }],
                        "body-sm": ["12px", { "lineHeight": "16px", "letterSpacing": "0em", "fontWeight": "400" }],
                        "label-lg": ["14px", { "lineHeight": "20px", "letterSpacing": "0.01em", "fontWeight": "600" }]
                    }
                }
            }
        };
    </script>
</head>

<body class="bg-surface font-body-md text-on-surface antialiased">
    <!-- Top Header -->
    <header
        class="fixed top-0 w-full z-50 bg-surface-container-lowest/90 backdrop-blur-md shadow-[0_1px_8px_rgba(15,23,42,0.06)]">
        <div class="w-full max-w-[1680px] mx-auto px-margin h-20 flex items-center justify-between gap-gutter">
            <div class="flex items-center gap-space-xl">
                <!-- Brand -->
                <a href="{{ route('home') }}"
                    class="flex items-center gap-space-sm hover:opacity-90 transition-opacity">
                    <div class="w-9 h-9 rounded-lg bg-secondary flex items-center justify-center">
                        <span class="material-symbols-outlined text-on-secondary text-[22px]">account_balance</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-headline-sm text-headline-sm text-on-surface tracking-tight leading-none">
                            BankRate<span class="text-secondary">ID</span>
                        </span>
                        <span
                            class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider leading-none mt-1">
                            Intelligence &amp; Simpanan
                        </span>
                    </div>
                </a>

                <!-- Live National Rates Indicator -->
                <div
                    class="hidden xl:flex items-center gap-space-sm pl-space-lg bg-surface-container-low py-1.5 px-space-md rounded-lg">
                    <div class="flex items-center gap-1.5">
                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">BI Rate:</span>
                        <span
                            class="font-label-md text-label-md text-on-surface font-bold">{{ number_format($biRate, 2) }}%</span>
                    </div>
                    <div class="w-1 h-3 bg-outline-variant rounded-full mx-1"></div>
                    <div class="flex items-center gap-1.5">
                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">LPS IDR:</span>
                        <span
                            class="font-label-md text-label-md text-secondary font-bold">{{ number_format($lpsLimitGeneral, 2) }}%</span>
                    </div>
                    <div class="w-1 h-3 bg-outline-variant rounded-full mx-1"></div>
                    <div class="flex items-center gap-1.5">
                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">LPS BPR:</span>
                        <span
                            class="font-label-md text-label-md text-on-surface font-bold">{{ number_format($lpsLimitBpr, 2) }}%</span>
                    </div>
                </div>
            </div>

            <!-- Header Quick Search -->
            <div class="hidden lg:flex items-center flex-1 max-w-md">
                <div class="relative w-full">
                    <span
                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">search</span>
                    <input id="header-search-input"
                        class="w-full pl-10 pr-4 py-2 bg-surface-container-low text-on-surface font-body-sm text-body-sm rounded-lg focus:outline-none focus:bg-surface-container-lowest focus:ring-2 focus:ring-secondary/40 transition-all placeholder:text-on-surface-variant"
                        placeholder="Cari bank, produk deposito, suku bunga..." type="text" />
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="flex items-center gap-space-lg">
                <nav class="flex items-center gap-space-xs">
                    <a class="px-3 py-2 transition-colors bg-surface-container text-secondary font-bold rounded-lg"
                        href="{{ route('home') }}">Beranda</a>
                    <a class="font-label-lg text-label-lg px-3 py-2 text-on-surface-variant hover:text-on-surface hover:bg-surface-container-low rounded-lg transition-colors"
                        href="#tabel-deposito">Deposito Pasar</a>
                    <a class="font-label-lg text-label-lg px-3 py-2 text-on-surface-variant hover:text-on-surface hover:bg-surface-container-low rounded-lg transition-colors"
                        href="#simulator">Simulasi</a>
                    <a class="font-label-lg text-label-lg px-3 py-2 text-on-surface-variant hover:text-on-surface hover:bg-surface-container-low rounded-lg transition-colors"
                        href="#regulasi-lps">Regulasi LPS</a>
                </nav>

                <div class="h-6 w-px bg-surface-container-highest"></div>

                <div class="flex items-center gap-space-sm">
                    @auth
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-surface-container text-secondary font-label-md hover:bg-surface-container-high transition-colors"
                            title="Buka Panel Admin">
                            <span class="material-symbols-outlined text-[18px]">dashboard</span>
                            <span>Panel Admin</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-surface-container-low text-on-surface hover:bg-surface-container transition-colors font-label-md"
                            title="Masuk ke Panel Administrasi">
                            <span class="material-symbols-outlined text-[18px]">login</span>
                            <span>Login</span>
                        </a>
                    @endauth

                    <!-- PWA Install Button -->
                    <button type="button"
                        class="btn-pwa-install hidden items-center gap-1.5 px-3 py-1.5 rounded-lg bg-secondary text-on-secondary hover:opacity-95 transition-all font-label-md font-semibold shadow-sm cursor-pointer"
                        onclick="triggerPwaInstall()" title="Pasang Aplikasi BankRate ID di Perangkat">
                        <span class="material-symbols-outlined text-[18px]">install_mobile</span>
                        <span>Pasang App</span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <main class="w-full pt-20 bg-surface">
        <div class="flex flex-col w-full">
            <div class="w-full max-w-[1680px] mx-auto px-margin py-space-xl flex flex-col gap-space-2xl">

                <!-- Hero / Live Operational Brief -->
                <section
                    class="flex flex-col lg:flex-row lg:items-end justify-between gap-space-lg bg-surface-container-lowest p-space-xl rounded-xl shadow-sm relative overflow-hidden">
                    <div
                        class="absolute -right-20 -top-24 w-96 h-96 rounded-full bg-secondary-fixed/40 blur-3xl pointer-events-none">
                    </div>
                    <div class="flex flex-col gap-space-sm max-w-3xl z-10">
                        <div class="flex items-center gap-space-sm flex-wrap">
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded bg-secondary-fixed text-on-secondary-fixed font-label-sm text-label-sm uppercase tracking-wider">
                                <span class="w-2 h-2 rounded-full bg-secondary animate-pulse"></span>
                                Pantauan Pasar Aktif
                            </span>
                            <span class="font-body-sm text-body-sm text-on-surface-variant flex items-center gap-1">
                                <span
                                    class="material-symbols-outlined text-[16px] text-on-surface-variant">schedule</span>
                                Terakhir diperbarui: {{ $lastUpdated }} • Sumber data: Bank Indonesia, LPS, &amp;
                                Laporan Resmi Bank
                            </span>
                        </div>
                        <h1 class="font-display-xl text-display-xl text-on-surface tracking-tight">
                            Dashboard Perbankan Indonesia
                        </h1>
                        <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl">
                            Pantau suku bunga deposito tertinggi, indikator moneter BI &amp; regulasi penjaminan LPS
                            secara real-time untuk keputusan likuiditas optimal.
                        </p>
                    </div>
                    <div class="flex items-center gap-space-md shrink-0 z-10">
                        <a href="#simulator"
                            class="flex items-center gap-2 px-space-md py-2.5 rounded-lg bg-surface-container-low text-on-surface font-label-lg text-label-lg hover:bg-surface-container transition-colors shadow-sm">
                            <span class="material-symbols-outlined text-[20px] text-secondary">calculate</span>
                            Kalkulator Deposito
                        </a>
                        <a href="#tabel-deposito"
                            class="flex items-center gap-2 px-space-lg py-2.5 rounded-lg bg-secondary text-on-secondary font-label-lg text-label-lg hover:bg-secondary-container transition-colors shadow-sm">
                            <span class="material-symbols-outlined text-[20px]">compare_arrows</span>
                            Bandingkan Deposito
                        </a>
                    </div>
                </section>

                <!-- KPI Metric Cards (Indikator Perbankan Nasional) -->
                <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-gutter">
                    <!-- Card 1: Bank Konvensional -->
                    <div
                        class="bg-surface-container-lowest p-space-lg rounded-xl shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between pb-space-sm">
                            <span
                                class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Bank
                                Konvensional</span>
                            <div
                                class="w-8 h-8 rounded-lg bg-surface-container-low flex items-center justify-center text-on-surface">
                                <span class="material-symbols-outlined text-[20px]">account_balance</span>
                            </div>
                        </div>
                        <div class="my-space-xs">
                            <span
                                class="font-metric-display text-metric-display text-on-surface">{{ $totalKonvensional }}</span>
                            <span
                                class="font-headline-sm text-headline-sm text-on-surface-variant ml-1 font-normal">Entitas</span>
                        </div>
                        <div class="flex items-center justify-between pt-space-xs">
                            <span
                                class="inline-flex items-center gap-1 font-label-sm text-label-sm text-on-surface-variant bg-surface-container-low px-2 py-0.5 rounded">
                                <span class="w-1.5 h-1.5 rounded-full bg-outline"></span> Terverifikasi OJK
                            </span>
                            <span class="font-body-sm text-body-sm text-on-surface-variant">KBMI 1 - KBMI 4</span>
                        </div>
                    </div>

                    <!-- Card 2: Bank Digital -->
                    <div
                        class="bg-surface-container-lowest p-space-lg rounded-xl shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between pb-space-sm">
                            <span
                                class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Bank
                                Digital</span>
                            <div
                                class="w-8 h-8 rounded-lg bg-surface-container-low flex items-center justify-center text-on-surface">
                                <span class="material-symbols-outlined text-[20px]">smartphone</span>
                            </div>
                        </div>
                        <div class="my-space-xs">
                            <span
                                class="font-metric-display text-metric-display text-on-surface">{{ $totalDigital }}</span>
                            <span
                                class="font-headline-sm text-headline-sm text-on-surface-variant ml-1 font-normal">Pemain</span>
                        </div>
                        <div class="flex items-center justify-between pt-space-xs">
                            <span
                                class="inline-flex items-center gap-1 font-label-sm text-label-sm text-secondary bg-surface-container-high px-2 py-0.5 rounded font-bold">
                                <span class="material-symbols-outlined text-[14px]">trending_up</span> Penawaran Spesial
                            </span>
                            <span class="font-body-sm text-body-sm text-on-surface-variant">Simpanan Ritel</span>
                        </div>
                    </div>

                    <!-- Card 3: BI-Rate -->
                    <div
                        class="bg-surface-container-lowest p-space-lg rounded-xl shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between pb-space-sm">
                            <span
                                class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">BI-Rate
                                (Bank Indonesia)</span>
                            <div
                                class="w-8 h-8 rounded-lg bg-surface-container-low flex items-center justify-center text-on-surface">
                                <span class="material-symbols-outlined text-[20px]">analytics</span>
                            </div>
                        </div>
                        <div class="my-space-xs flex items-baseline gap-2">
                            <span
                                class="font-metric-display text-metric-display text-on-surface">{{ number_format($biRate, 2) }}%</span>
                            <span class="font-body-sm text-body-sm text-on-surface-variant">p.a.</span>
                        </div>
                        <div class="flex items-center justify-between pt-space-xs">
                            <span
                                class="inline-flex items-center gap-1 font-label-sm text-label-sm text-secondary bg-surface-container-low px-2 py-0.5 rounded">
                                <span class="material-symbols-outlined text-[14px]">check_circle</span> Suku Bunga Acuan
                            </span>
                            <span class="font-body-sm text-body-sm text-on-surface-variant">Moneter Terkini</span>
                        </div>
                    </div>

                    <!-- Card 4: Bunga Penjaminan LPS -->
                    <div
                        class="bg-surface-container-lowest p-space-lg rounded-xl shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between pb-space-sm">
                            <span
                                class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Bunga
                                Penjaminan LPS</span>
                            <div
                                class="w-8 h-8 rounded-lg bg-surface-container-low flex items-center justify-center text-on-surface">
                                <span class="material-symbols-outlined text-[20px]">verified</span>
                            </div>
                        </div>
                        <div class="my-space-xs flex items-baseline gap-2">
                            <span
                                class="font-metric-display text-metric-display text-secondary">{{ number_format($lpsLimitGeneral, 2) }}%</span>
                            <span class="font-body-sm text-body-sm text-on-surface-variant">Umum (BPR:
                                {{ number_format($lpsLimitBpr, 2) }}%)</span>
                        </div>
                        <div class="flex items-center justify-between pt-space-xs">
                            <span
                                class="inline-flex items-center gap-1 font-label-sm text-label-sm text-on-surface-variant bg-surface-container-low px-2 py-0.5 rounded">
                                Maks. Rp 2 Miliar / Nasabah
                            </span>
                            <span class="font-body-sm text-body-sm text-on-surface-variant">Regulasi LPS</span>
                        </div>
                    </div>
                </section>

                <!-- Main Workspace Grid: Left Table (8 cols), Right Sidebar Widgets (4 cols) -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter items-start">

                    <!-- Top Deposito Table Matrix (Cols 8) -->
                    <section class="lg:col-span-8 flex flex-col gap-space-md" id="tabel-deposito">

                        <!-- Section Bar & Filters -->
                        <div
                            class="flex flex-col sm:flex-row sm:items-center justify-between gap-space-md bg-surface-container-lowest p-space-lg rounded-xl shadow-sm">
                            <div>
                                <h2 class="font-headline-lg text-headline-lg text-on-surface">Peringkat Suku Bunga
                                    Deposito Tertinggi</h2>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">Diurutkan berdasarkan
                                    penawaran imbal hasil terverifikasi pasar saat ini</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="bg-surface-container-low p-1 rounded-lg flex items-center" id="filter-tabs">
                                    <button
                                        class="filter-btn px-3 py-1.5 rounded-md font-label-md text-label-md bg-surface-container-lowest text-secondary shadow-sm transition-all"
                                        data-category="all" type="button">Semua</button>
                                    <button
                                        class="filter-btn px-3 py-1.5 rounded-md font-label-md text-label-md text-on-surface-variant hover:text-on-surface transition-all"
                                        data-category="promo" type="button">Bunga Tinggi</button>
                                    <button
                                        class="filter-btn px-3 py-1.5 rounded-md font-label-md text-label-md text-on-surface-variant hover:text-on-surface transition-all"
                                        data-category="digital" type="button">Digital</button>
                                    <button
                                        class="filter-btn px-3 py-1.5 rounded-md font-label-md text-label-md text-on-surface-variant hover:text-on-surface transition-all"
                                        data-category="konvensional" type="button">Konvensional</button>
                                    <button
                                        class="filter-btn px-3 py-1.5 rounded-md font-label-md text-label-md text-on-surface-variant hover:text-on-surface transition-all"
                                        data-category="bpr" type="button">BPR</button>
                                </div>
                                <span class="font-label-md text-label-md text-secondary ml-2 hidden sm:inline-block"
                                    id="tab-count-badge">({{ $topRates->count() }} Pilihan)</span>
                            </div>
                        </div>

                        <!-- Filter Deposito Multi-Kriteria Interactive Control Panel -->
                        <div class="bg-surface-container-lowest p-space-lg rounded-xl shadow-sm border border-outline-variant/30 flex flex-col gap-space-md"
                            id="filter-deposito-panel">
                            <!-- Filter Header -->
                            <div
                                class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-surface-container-low gap-3">
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-9 h-9 rounded-xl bg-secondary/10 text-secondary flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-[22px]">tune</span>
                                    </div>
                                    <div>
                                        <h3
                                            class="font-headline-sm text-headline-sm text-on-surface font-bold flex items-center gap-2">
                                            Filter Deposito
                                            <span
                                                class="text-xs font-normal px-2 py-0.5 rounded-full bg-secondary/10 text-secondary">Interaktif</span>
                                        </h3>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant">Saring pilihan
                                            produk deposito berdasarkan suku bunga, tenor, nominal, dan fitur penjaminan
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 self-start sm:self-auto">
                                    <span class="font-label-md text-label-md text-on-surface-variant">
                                        Hasil: <strong id="filter-result-count"
                                            class="text-secondary font-bold">{{ $topRates->count() }}</strong> produk
                                    </span>
                                    <button id="btn-reset-filters" type="button"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-outline-variant/60 text-on-surface-variant hover:text-on-surface hover:bg-surface-container-low font-label-md text-label-md transition-all">
                                        <span class="material-symbols-outlined text-[16px]">restart_alt</span>
                                        Reset Filter
                                    </button>
                                </div>
                            </div>

                            <!-- Filter Inputs Matrix (3 Columns: Min Bunga, Min Tenor, Min Deposito) -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-space-lg">
                                <!-- 1. Minimal Bunga (%) -->
                                <div
                                    class="flex flex-col gap-2 bg-surface-container-low/50 p-space-md rounded-xl border border-outline-variant/20">
                                    <div class="flex items-center justify-between">
                                        <label for="filter-min-rate"
                                            class="font-label-md text-label-md text-on-surface font-semibold flex items-center gap-1.5">
                                            <span
                                                class="material-symbols-outlined text-[18px] text-secondary">percent</span>
                                            Minimal Bunga (%)
                                        </label>
                                        <span id="filter-min-rate-display"
                                            class="px-2.5 py-0.5 rounded-md bg-secondary text-on-secondary font-metric-table text-metric-table font-bold shadow-sm">
                                            4.5%
                                        </span>
                                    </div>
                                    <div class="pt-1">
                                        <input type="range" id="filter-min-rate" min="2.0" max="9.0" step="0.25"
                                            value="4.5"
                                            class="w-full accent-secondary cursor-pointer h-2 bg-surface-container rounded-lg appearance-none">
                                        <div
                                            class="flex justify-between font-label-sm text-label-sm text-on-surface-variant mt-1.5">
                                            <span>2.0%</span>
                                            <span class="text-secondary font-medium">4.5%</span>
                                            <span>9.0%</span>
                                        </div>
                                    </div>
                                    <span
                                        class="font-body-sm text-[12px] text-on-surface-variant leading-snug">Menampilkan
                                        suku bunga &ge; nilai slider</span>
                                </div>

                                <!-- 2. Rentang Tenor (Bulan): Single Dual-Handle Slider -->
                                <div
                                    class="flex flex-col gap-2.5 bg-surface-container-low/50 p-space-md rounded-xl border border-outline-variant/20">
                                    <div class="flex items-center justify-between">
                                        <label
                                            class="font-label-md text-label-md text-on-surface font-semibold flex items-center gap-1.5">
                                            <span
                                                class="material-symbols-outlined text-[18px] text-secondary">calendar_month</span>
                                            Rentang Tenor (Bulan)
                                        </label>
                                        <span id="filter-tenor-range-display"
                                            class="px-2.5 py-0.5 rounded-md bg-secondary text-on-secondary font-metric-table text-metric-table font-bold shadow-sm transition-all">
                                            1 - 12 Bulan
                                        </span>
                                    </div>

                                    <!-- Single Dual-Handle Range Slider Component -->
                                    <div class="pt-2 pb-1">
                                        <div class="relative w-full h-8 flex items-center select-none"
                                            id="dual-range-container">
                                            <!-- Base Light Track (warna dasar abu-abu/biru muda terang) -->
                                            <div
                                                class="absolute w-full h-2 rounded-full bg-surface-container pointer-events-none">
                                            </div>

                                            <!-- Active Range Track (Solid Blue between Min & Max Handle) -->
                                            <div id="dual-range-fill"
                                                class="absolute h-2 rounded-full bg-secondary pointer-events-none transition-all duration-75"
                                                style="left: 0%; width: 100%;"></div>

                                            <!-- Step Ticks aligned with labels (0%, 33.33%, 66.67%, 100%) -->
                                            <div class="absolute w-full flex justify-between px-2 pointer-events-none">
                                                <span class="w-1.5 h-1.5 rounded-full bg-outline-variant/70"></span>
                                                <span class="w-1.5 h-1.5 rounded-full bg-outline-variant/70"></span>
                                                <span class="w-1.5 h-1.5 rounded-full bg-outline-variant/70"></span>
                                                <span class="w-1.5 h-1.5 rounded-full bg-outline-variant/70"></span>
                                            </div>

                                            <!-- Handle 1: Minimal Tenor (Step index 0 to 3) -->
                                            <input type="range" id="filter-min-tenor" min="0" max="3" step="1" value="0"
                                                class="dual-range-input absolute inset-0 w-full h-full appearance-none bg-transparent pointer-events-none z-10 m-0"
                                                aria-label="Minimal Tenor">

                                            <!-- Handle 2: Maksimal Tenor (Step index 0 to 3) -->
                                            <input type="range" id="filter-max-tenor" min="0" max="3" step="1" value="3"
                                                class="dual-range-input absolute inset-0 w-full h-full appearance-none bg-transparent pointer-events-none z-20 m-0"
                                                aria-label="Maksimal Tenor">
                                        </div>

                                        <!-- Aligned Step Labels: 1 Bln, 3 Bln, 6 Bln, 12 Bln -->
                                        <div
                                            class="flex justify-between font-label-sm text-[11px] text-on-surface-variant px-1 mt-1 font-medium">
                                            <span class="cursor-pointer hover:text-secondary transition-colors"
                                                onclick="setTenorByIndex(0, null)">1 Bln</span>
                                            <span class="cursor-pointer hover:text-secondary transition-colors"
                                                onclick="setTenorByIndex(null, 1)">3 Bln</span>
                                            <span class="cursor-pointer hover:text-secondary transition-colors"
                                                onclick="setTenorByIndex(null, 2)">6 Bln</span>
                                            <span class="cursor-pointer hover:text-secondary transition-colors"
                                                onclick="setTenorByIndex(null, 3)">12 Bln</span>
                                        </div>
                                    </div>

                                    <!-- Dynamic text at bottom -->
                                    <span class="font-body-sm text-[12px] text-on-surface-variant leading-snug">
                                        Menampilkan tenor antara <strong id="filter-tenor-desc-min"
                                            class="text-secondary font-bold">1</strong> s.d. <strong
                                            id="filter-tenor-desc-max" class="text-secondary font-bold">12</strong>
                                        bulan
                                    </span>
                                </div>

                                <!-- 3. Minimal Deposito -->
                                <div
                                    class="flex flex-col gap-2 bg-surface-container-low/50 p-space-md rounded-xl border border-outline-variant/20">
                                    <div class="flex items-center justify-between">
                                        <label for="filter-min-deposit"
                                            class="font-label-md text-label-md text-on-surface font-semibold flex items-center gap-1.5">
                                            <span
                                                class="material-symbols-outlined text-[18px] text-secondary">payments</span>
                                            Minimal Deposito
                                        </label>
                                        <span class="font-label-sm text-label-sm text-on-surface-variant">Batas
                                            Minimum</span>
                                    </div>
                                    <div class="relative">
                                        <span
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center font-label-md text-label-md text-on-surface-variant pointer-events-none font-semibold">Rp</span>
                                        <input type="text" id="filter-min-deposit" value="5.000.000"
                                            placeholder="5.000.000"
                                            class="w-full pl-10 pr-3 py-1.5 bg-surface-container-lowest border border-outline-variant/60 rounded-lg font-headline-sm text-headline-sm text-on-surface focus:outline-none focus:ring-2 focus:ring-secondary/40 focus:border-secondary transition-all font-semibold">
                                    </div>
                                    <!-- Quick Chips -->
                                    <div class="flex items-center gap-1.5 flex-wrap pt-0.5">
                                        <button type="button"
                                            class="btn-quick-deposit text-[11px] px-2 py-0.5 rounded bg-surface-container hover:bg-surface-container-high text-on-surface transition-all"
                                            data-amount="1000000">1 Jt</button>
                                        <button type="button"
                                            class="btn-quick-deposit text-[11px] px-2 py-0.5 rounded bg-secondary text-on-secondary font-bold transition-all shadow-sm"
                                            data-amount="5000000">5 Jt</button>
                                        <button type="button"
                                            class="btn-quick-deposit text-[11px] px-2 py-0.5 rounded bg-surface-container hover:bg-surface-container-high text-on-surface transition-all"
                                            data-amount="10000000">10 Jt</button>
                                        <button type="button"
                                            class="btn-quick-deposit text-[11px] px-2 py-0.5 rounded bg-surface-container hover:bg-surface-container-high text-on-surface transition-all"
                                            data-amount="25000000">25 Jt</button>
                                        <button type="button"
                                            class="btn-quick-deposit text-[11px] px-2 py-0.5 rounded bg-surface-container hover:bg-surface-container-high text-on-surface transition-all"
                                            data-amount="100000000">100 Jt</button>
                                    </div>
                                </div>
                            </div>

                            <!-- 4. Fitur Tambahan (Checkboxes) -->
                            <div
                                class="pt-3 border-t border-surface-container-low flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-6">
                                    <span
                                        class="font-label-md text-label-md text-on-surface font-semibold shrink-0 flex items-center gap-1">
                                        <span
                                            class="material-symbols-outlined text-[18px] text-secondary">checklist</span>
                                        Fitur Tambahan:
                                    </span>
                                    <div class="flex flex-wrap items-center gap-4 sm:gap-6">
                                        <!-- Checkbox: Tergaransi LPS -->
                                        <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                                            <input type="checkbox" id="filter-lps-insured"
                                                class="w-4 h-4 rounded text-secondary focus:ring-secondary/30 accent-secondary cursor-pointer">
                                            <span
                                                class="font-body-sm text-body-sm text-on-surface flex items-center gap-1">
                                                <span
                                                    class="material-symbols-outlined text-[16px] text-green-700">verified_user</span>
                                                Tergaransi LPS
                                            </span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Active Filter Summary Pill -->
                                <div id="active-filter-summary"
                                    class="hidden sm:inline-flex items-center gap-1.5 font-label-sm text-[11px] text-on-surface-variant bg-surface-container-low px-2.5 py-1 rounded-full">
                                    <span class="w-1.5 h-1.5 rounded-full bg-secondary animate-pulse"></span>
                                    <span id="active-filter-summary-text">Bunga &ge; 4.5% &bull; Tenor &ge; 6 Bln &bull;
                                        Deposito &le; Rp 5 Jt</span>
                                </div>
                            </div>
                        </div>

                        <!-- Table Card Container -->
                        <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr
                                            class="bg-surface-container-low text-on-surface-variant font-label-sm text-label-sm uppercase tracking-wider">
                                            <th class="py-3.5 px-space-md w-12 text-center">Rank</th>
                                            <th class="py-3.5 px-space-md">Entitas Perbankan</th>
                                            <th class="py-3.5 px-space-md">Suku Bunga</th>
                                            <th class="py-3.5 px-space-md">Tenor &amp; Minimal</th>
                                            <th class="py-3.5 px-space-md">Status Penjaminan</th>
                                            <th class="py-3.5 px-space-md text-right">Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-surface-container-low" id="rates-table-body">
                                        @forelse($topRates as $index => $rate)
                                            @php
                                                $bank = $rate->product?->bank;
                                                $isBpr = $bank && $bank->type === 'bpr';
                                                $limit = $isBpr ? $lpsLimitBpr : $lpsLimitGeneral;
                                                $isExceedLps = $rate->interest_rate > $limit;
                                                $isHighRate = $rate->interest_rate > 5;
                                                $categories = ($bank->type ?? 'konvensional') . ($isHighRate ? ' promo' : '');
                                                $isLpsGuaranteed = ($bank && $bank->is_lps_insured && !$isExceedLps);
                                            @endphp

                                            <tr class="bank-row hover:bg-surface-container-low/60 transition-colors relative"
                                                data-category="{{ $categories }}" data-rate="{{ $rate->interest_rate }}"
                                                data-tenor="{{ $rate->duration_months }}"
                                                data-min-deposit="{{ (float) ($rate->product->min_deposit ?? 0) }}"
                                                data-lps="{{ $isLpsGuaranteed ? '1' : '0' }}">
                                                <td class="py-space-md px-space-md text-center">
                                                    <span
                                                        class="row-rank-badge inline-flex w-7 h-7 rounded-full {{ $index === 0 ? 'bg-secondary-fixed text-on-secondary-fixed' : 'bg-surface-container text-on-surface' }} font-metric-table text-metric-table items-center justify-center font-bold">
                                                        {{ $index + 1 }}
                                                    </span>
                                                </td>

                                                <td class="py-space-md px-space-md">
                                                    <div class="flex items-center gap-space-md">
                                                        @if($bank && $bank->logo_url)
                                                            <a href="{{ $bank ? route('bank.detail', $bank->id) : '#' }}"
                                                                class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center overflow-hidden border border-outline-variant/30 shrink-0 hover:opacity-85 transition-opacity"
                                                                title="Lihat detail {{ $bank->name }}">
                                                                <img src="{{ asset('storage/' . $bank->logo_url) }}"
                                                                    alt="{{ $bank->name }}"
                                                                    class="w-full h-full object-contain p-1">
                                                            </a>
                                                        @else
                                                            <a href="{{ $bank ? route('bank.detail', $bank->id) : '#' }}"
                                                                class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center font-bold text-on-surface text-label-lg shrink-0 hover:opacity-85 transition-opacity"
                                                                title="Lihat detail {{ $bank->name ?? '' }}">
                                                                {{ strtoupper(substr($bank->name ?? 'BNK', 0, 3)) }}
                                                            </a>
                                                        @endif

                                                        <div>
                                                            <div
                                                                class="font-headline-sm text-headline-sm text-on-surface flex items-center gap-2">
                                                                <a href="{{ $bank ? route('bank.detail', $bank->id) : '#' }}"
                                                                    class="hover:text-secondary hover:underline transition-colors font-bold"
                                                                    title="Lihat profil dan detail bunga {{ $bank->name ?? '' }}">
                                                                    {{ $bank->name ?? '-' }}
                                                                </a>
                                                                @if($bank && $bank->type === 'digital')
                                                                    <span
                                                                        class="font-label-sm text-label-sm text-secondary bg-surface-container-high px-2 py-0.5 rounded font-bold uppercase">Bank
                                                                        Digital</span>
                                                                @elseif($bank && $bank->type === 'bpr')
                                                                    <span
                                                                        class="font-label-sm text-label-sm text-amber-800 bg-amber-100 px-2 py-0.5 rounded font-bold uppercase">BPR</span>
                                                                @else
                                                                    <span
                                                                        class="font-label-sm text-label-sm text-on-surface-variant bg-surface-container px-2 py-0.5 rounded font-bold uppercase">Konvensional</span>
                                                                @endif
                                                            </div>
                                                            <span class="font-body-sm text-body-sm text-on-surface-variant">
                                                                {{ $rate->product->name ?? 'Deposito Berjangka' }}
                                                                @if($bank && $bank->code_saham)
                                                                    &bull; Emiten: {{ $bank->code_saham }}
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="py-space-md px-space-md">
                                                    <div class="flex flex-col">
                                                        <span
                                                            class="font-metric-display text-metric-display {{ $isHighRate ? 'text-secondary' : 'text-on-surface' }} leading-none">
                                                            {{ number_format($rate->interest_rate, 2) }}%
                                                        </span>
                                                        <span
                                                            class="font-label-sm text-label-sm text-on-surface-variant uppercase mt-1">p.a.</span>
                                                    </div>
                                                </td>

                                                <td class="py-space-md px-space-md">
                                                    <div class="font-body-sm text-body-sm text-on-surface font-semibold">
                                                        Tenor {{ $rate->duration_months }} Bulan
                                                    </div>
                                                    <div class="font-label-sm text-label-sm text-on-surface-variant">
                                                        Min. Rp
                                                        {{ number_format($rate->product->min_deposit ?? 0, 0, ',', '.') }}
                                                    </div>
                                                </td>

                                                <td class="py-space-md px-space-md">
                                                    @if($isLpsGuaranteed)
                                                        <div class="inline-flex flex-col">
                                                            <span
                                                                class="inline-flex items-center gap-1 font-label-sm text-label-sm text-green-700 bg-green-100 px-2 py-0.5 rounded font-bold">
                                                                <span
                                                                    class="material-symbols-outlined text-[13px]">verified_user</span>
                                                                Dijamin LPS
                                                            </span>
                                                            <span
                                                                class="font-label-sm text-label-sm text-on-surface-variant mt-0.5">Sesuai
                                                                Syarat 3T</span>
                                                        </div>
                                                    @else
                                                        <div class="inline-flex flex-col">
                                                            <span
                                                                class="inline-flex items-center gap-1 font-label-sm text-label-sm text-error bg-error-container/60 px-2 py-0.5 rounded font-bold">
                                                                <span
                                                                    class="material-symbols-outlined text-[13px]">warning</span>
                                                                Di Atas LPS
                                                            </span>
                                                            <span
                                                                class="font-label-sm text-label-sm text-on-surface-variant mt-0.5">Non-Guaranteed
                                                                (&gt;{{ $limit }}%)</span>
                                                        </div>
                                                    @endif
                                                </td>

                                                <td class="py-space-md px-space-md text-right">
                                                    <div class="inline-flex items-center justify-end gap-1.5 flex-wrap">
                                                        <button type="button"
                                                            class="btn-apply-rate px-3 py-2 bg-surface-container hover:bg-surface-container-high text-on-surface rounded-lg font-label-md text-label-md transition-all inline-flex items-center gap-1 shadow-sm border border-outline-variant/30 cursor-pointer"
                                                            data-rate="{{ $rate->interest_rate }}"
                                                            data-tenor="{{ $rate->duration_months }}"
                                                            data-min-deposit="{{ (float) ($rate->product->min_deposit ?? 0) }}"
                                                            data-bank="{{ $bank->name ?? '' }}"
                                                            data-product="{{ $rate->product->name ?? 'Deposito Berjangka' }}"
                                                            title="Simulasikan suku bunga {{ $rate->interest_rate }}% & tenor {{ $rate->duration_months }} bulan di kalkulator">
                                                            <span
                                                                class="material-symbols-outlined text-[16px] text-secondary">calculate</span>
                                                            <span>Simulasi</span>
                                                        </button>

                                                        @if($rate->product?->referral_link)
                                                            <a href="{{ $rate->product->referral_link }}" target="_blank"
                                                                rel="noopener noreferrer"
                                                                class="px-3.5 py-2 bg-secondary text-on-secondary rounded-lg font-label-md text-label-md hover:bg-secondary-container transition-all inline-flex items-center gap-1 shadow-sm"
                                                                title="Buka rekening deposito langsung di situs resmi">
                                                                <span>Buka Deposito</span>
                                                                <span
                                                                    class="material-symbols-outlined text-[16px]">open_in_new</span>
                                                            </a>
                                                        @else
                                                            <a href="{{ $bank ? route('bank.detail', $bank->id) : '#' }}"
                                                                class="px-3.5 py-2 bg-secondary text-on-secondary rounded-lg font-label-md text-label-md hover:bg-secondary-container transition-all inline-block shadow-sm">
                                                                <span>Buka Deposito</span>
                                                                <span
                                                                    class="material-symbols-outlined text-[16px]">open_in_new</span>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="py-12 text-center text-on-surface-variant">
                                                    <span
                                                        class="material-symbols-outlined text-4xl mb-2 text-outline">search_off</span>
                                                    <div class="font-headline-sm">Belum ada data suku bunga deposito</div>
                                                    <p class="font-body-sm text-outline mt-1">Data suku bunga akan tampil di
                                                        sini setelah diinput melalui panel admin.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                        <tr id="filter-no-results-row" style="display: none;">
                                            <td colspan="6" class="py-12 text-center text-on-surface-variant">
                                                <span
                                                    class="material-symbols-outlined text-4xl mb-2 text-outline">filter_list_off</span>
                                                <div class="font-headline-sm text-on-surface font-bold">Tidak ada produk
                                                    deposito yang memenuhi kriteria filter</div>
                                                <p class="font-body-sm text-on-surface-variant mt-1 max-w-md mx-auto">
                                                    Coba turunkan batas minimal bunga, sesuaikan tenor, atau ubah
                                                    nominal deposito pada panel filter di atas.
                                                </p>
                                                <button type="button" id="btn-reset-filters-empty"
                                                    class="mt-4 px-4 py-2 bg-secondary text-on-secondary rounded-lg font-label-md text-label-md hover:bg-secondary-container transition-all inline-flex items-center gap-1.5 shadow-sm">
                                                    <span
                                                        class="material-symbols-outlined text-[18px]">restart_alt</span>
                                                    Reset Filter ke Default
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Table Footer Intelligence Bar -->
                            <div
                                class="p-space-md bg-surface-container-low flex flex-col sm:flex-row items-center justify-between gap-space-sm text-on-surface-variant">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[18px] text-secondary">info</span>
                                    <span class="font-body-sm text-body-sm">Pajak penghasilan (PPh Final 20%) dikenakan
                                        atas imbal hasil bunga simpanan dengan nominal penempatan di atas Rp 7,5
                                        Juta.</span>
                                </div>
                                <a class="font-label-md text-label-md text-secondary hover:underline shrink-0"
                                    href="#regulasi-lps">Pelajari Ketentuan LPS &rarr;</a>
                            </div>
                        </div>

                        <!-- Analytical Market Comparison Insight Strip -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md">
                            <div
                                class="bg-surface-container-lowest p-space-lg rounded-xl shadow-sm flex items-center justify-between">
                                <div class="flex flex-col gap-1">
                                    <span
                                        class="font-label-md text-label-md text-on-surface-variant uppercase">Rata-rata
                                        Deposito Bank Konvensional</span>
                                    <span
                                        class="font-metric-display text-metric-display text-on-surface">{{ number_format($avgKonvensional, 2) }}%</span>
                                    <span class="font-body-sm text-body-sm text-on-surface-variant">Stabilitas
                                        likuiditas perbankan umum</span>
                                </div>
                                <!-- Trend SVG Mini Chart -->
                                <svg class="w-24 h-12 text-secondary shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 100 40">
                                    <path d="M 0 35 Q 25 32, 50 20 T 100 10" stroke-linecap="round" stroke-width="3">
                                    </path>
                                    <path d="M 0 35 Q 25 32, 50 20 T 100 10 L 100 40 L 0 40 Z" fill="currentColor"
                                        fill-opacity="0.1" stroke="none"></path>
                                </svg>
                            </div>

                            <div
                                class="bg-surface-container-lowest p-space-lg rounded-xl shadow-sm flex items-center justify-between">
                                <div class="flex flex-col gap-1">
                                    <span
                                        class="font-label-md text-label-md text-on-surface-variant uppercase">Rata-rata
                                        Bank Digital</span>
                                    <span
                                        class="font-metric-display text-metric-display text-on-surface">{{ number_format($avgDigital, 2) }}%</span>
                                    <span class="font-body-sm text-body-sm text-on-surface-variant">Penetrasi nasabah
                                        aktif mobile banking</span>
                                </div>
                                <!-- Trend SVG Mini Chart -->
                                <svg class="w-24 h-12 text-secondary shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 100 40">
                                    <path d="M 0 30 Q 30 15, 60 22 T 100 5" stroke-linecap="round" stroke-width="3">
                                    </path>
                                    <path d="M 0 30 Q 30 15, 60 22 T 100 5 L 100 40 L 0 40 Z" fill="currentColor"
                                        fill-opacity="0.1" stroke="none"></path>
                                </svg>
                            </div>
                        </div>

                    </section>

                    <!-- Right Column: Interactive Simulator & Institutional Advisory (Cols 4) -->
                    <aside class="lg:col-span-4 flex flex-col gap-gutter" id="simulator">

                        <!-- Interactive Deposit Calculator -->
                        <div
                            class="bg-surface-container-lowest p-space-xl rounded-xl shadow-sm flex flex-col gap-space-md">
                            <div class="flex items-center justify-between pb-2">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-surface-container-low flex items-center justify-center text-secondary">
                                        <span class="material-symbols-outlined text-[20px]">calculate</span>
                                    </div>
                                    <h3 class="font-headline-md text-headline-md text-on-surface">Simulasi Deposito
                                        Cepat</h3>
                                </div>
                                <span
                                    class="font-label-sm text-label-sm text-on-surface-variant bg-surface-container-low px-2 py-0.5 rounded">Otomatis</span>
                            </div>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">
                                Hitung estimasi pengembalian bunga bersih setelah dipotong pajak penghasilan
                                obligatoris.
                            </p>

                            <!-- Selected Bank Info (Optional badge) -->
                            <div id="sim-bank-badge"
                                class="hidden p-2 rounded bg-surface-container-high text-secondary font-label-md flex items-center justify-between">
                                <span>Simulasi Bank: <strong id="sim-bank-name">-</strong></span>
                                <button type="button" id="btn-reset-sim-bank"
                                    class="text-xs text-on-surface-variant hover:text-on-surface">&times;</button>
                            </div>

                            <!-- Input Nominal -->
                            <div class="flex flex-col gap-1.5">
                                <label class="font-label-md text-label-md text-on-surface" for="deposit-amount">Nominal
                                    Penempatan (IDR)</label>
                                <div
                                    class="flex rounded-lg overflow-hidden bg-surface-container-low focus-within:ring-2 focus-within:ring-secondary/50 transition-all">
                                    <span
                                        class="px-3 py-2.5 font-label-md text-label-md bg-surface-container text-on-surface-variant flex items-center">Rp</span>
                                    <input
                                        class="w-full bg-transparent px-3 py-2.5 font-headline-sm text-headline-sm text-on-surface focus:outline-none"
                                        id="deposit-amount" type="text" inputmode="numeric" value="10,000,000"
                                        placeholder="10,000,000" autocomplete="off" />
                                </div>
                                <div class="flex gap-2 pt-1 flex-wrap">
                                    <button
                                        class="quick-amt text-label-sm font-label-sm px-2 py-1 rounded bg-surface-container hover:bg-surface-container-high transition-colors"
                                        data-amt="5000000" type="button">5 Jt</button>
                                    <button
                                        class="quick-amt text-label-sm font-label-sm px-2 py-1 rounded bg-surface-container hover:bg-surface-container-high transition-colors"
                                        data-amt="10000000" type="button">10 Jt</button>
                                    <button
                                        class="quick-amt text-label-sm font-label-sm px-2 py-1 rounded bg-surface-container hover:bg-surface-container-high transition-colors"
                                        data-amt="25000000" type="button">25 Jt</button>
                                    <button
                                        class="quick-amt text-label-sm font-label-sm px-2 py-1 rounded bg-surface-container hover:bg-surface-container-high transition-colors"
                                        data-amt="50000000" type="button">50 Jt</button>
                                </div>
                            </div>

                            <!-- Tenor Selector -->
                            <div class="flex flex-col gap-1.5">
                                <label class="font-label-md text-label-md text-on-surface">Pilih Tenor Simpanan</label>
                                <div class="grid grid-cols-4 gap-2">
                                    <button
                                        class="tenor-pill py-2 text-center rounded-lg font-label-md text-label-md bg-surface-container-low text-on-surface hover:bg-surface-container transition-all"
                                        data-tenor="1" type="button">1 Bulan</button>
                                    <button
                                        class="tenor-pill py-2 text-center rounded-lg font-label-md text-label-md bg-surface-container-low text-on-surface hover:bg-surface-container transition-all"
                                        data-tenor="3" type="button">3 Bulan</button>
                                    <button
                                        class="tenor-pill py-2 text-center rounded-lg font-label-md text-label-md bg-surface-container-low text-on-surface hover:bg-surface-container transition-all"
                                        data-tenor="6" type="button">6 Bulan</button>
                                    <button
                                        class="tenor-pill py-2 text-center rounded-lg font-label-md text-label-md bg-secondary text-on-secondary font-bold shadow-sm"
                                        data-tenor="12" type="button">12 Bulan</button>
                                </div>
                            </div>

                            <!-- Rate Selection -->
                            <div class="flex flex-col gap-1.5">
                                <label class="font-label-md text-label-md text-on-surface flex justify-between"
                                    for="interest-rate">
                                    <span>Suku Bunga (% p.a.)</span>
                                    <span class="text-secondary font-bold"
                                        id="rate-display">{{ number_format($highestRate, 2) }}%</span>
                                </label>
                                <input
                                    class="w-full accent-secondary cursor-pointer h-2 bg-surface-container rounded-lg appearance-none"
                                    id="interest-rate" max="15.0" min="1.0" step="0.25" type="range"
                                    value="{{ $highestRate }}" />
                            </div>

                            <!-- Simulation Result Box -->
                            <div class="bg-surface-container p-space-md rounded-xl flex flex-col gap-space-sm mt-1">
                                <div class="flex items-center justify-between">
                                    <span class="font-body-sm text-body-sm text-on-surface-variant">Estimasi Bunga
                                        Kotor</span>
                                    <span class="font-label-md text-label-md text-on-surface" id="gross-interest">Rp
                                        800.000</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="font-body-sm text-body-sm text-on-surface-variant">Pajak Penghasilan
                                        (20%)</span>
                                    <span class="font-label-md text-label-md text-error" id="tax-amount">- Rp
                                        160.000</span>
                                </div>
                                <div class="h-px bg-outline-variant/40 my-1"></div>
                                <div class="flex items-center justify-between">
                                    <span class="font-headline-sm text-headline-sm text-on-surface font-bold">Estimasi
                                        Bunga Bersih</span>
                                    <span class="font-headline-md text-headline-md text-secondary font-bold"
                                        id="net-interest">Rp 640.000</span>
                                </div>
                                <div class="flex items-center justify-between pt-1">
                                    <span class="font-label-sm text-label-sm text-on-surface-variant">Total Akhir
                                        Simpanan</span>
                                    <span class="font-label-lg text-label-lg text-on-surface font-bold"
                                        id="total-received">Rp 10.640.000</span>
                                </div>
                            </div>

                            <a href="#tabel-deposito"
                                class="w-full py-2.5 rounded-lg bg-secondary text-on-secondary font-label-lg text-label-lg hover:bg-secondary-container transition-colors shadow-sm mt-1 text-center block">
                                Lihat Rekomendasi Bank
                            </a>
                        </div>

                        <!-- Institutional LPS Regulatory Notice Card -->
                        <div class="bg-surface-container-lowest p-space-xl rounded-xl shadow-sm flex flex-col gap-space-md relative overflow-hidden"
                            id="regulasi-lps">
                            <div class="flex items-center gap-space-sm">
                                <div
                                    class="w-8 h-8 rounded-lg bg-error-container flex items-center justify-center text-error">
                                    <span class="material-symbols-outlined text-[20px]">shield</span>
                                </div>
                                <div>
                                    <h3 class="font-headline-sm text-headline-sm text-on-surface">Penting: Batas
                                        Penjaminan LPS</h3>
                                    <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">Edukasi
                                        Regulasi Keuangan</span>
                                </div>
                            </div>
                            <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                                Sesuai regulasi Lembaga Penjamin Simpanan (LPS), simpanan dijamin hingga batas maksimal
                                <strong>Rp 2 Miliar</strong> per nasabah per bank dengan syarat kriteria 3T:
                            </p>
                            <ul class="flex flex-col gap-space-sm text-body-sm font-body-sm text-on-surface">
                                <li class="flex items-start gap-2">
                                    <span
                                        class="material-symbols-outlined text-secondary text-[18px] shrink-0 mt-0.5">check_circle</span>
                                    <span><strong>Tercatat:</strong> Dalam pembukuan bank resmi berizin dan diawasi
                                        OJK.</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span
                                        class="material-symbols-outlined text-secondary text-[18px] shrink-0 mt-0.5">check_circle</span>
                                    <span><strong>Tingkat bunga wajar:</strong> Tidak melebihi
                                        <strong>{{ number_format($lpsLimitGeneral, 2) }}% p.a.</strong> (Bank Umum) dan
                                        <strong>{{ number_format($lpsLimitBpr, 2) }}% p.a.</strong> (BPR).</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span
                                        class="material-symbols-outlined text-secondary text-[18px] shrink-0 mt-0.5">check_circle</span>
                                    <span><strong>Tidak merugikan:</strong> Tidak melakukan tindakan melawan hukum
                                        perbankan.</span>
                                </li>
                            </ul>
                            <div class="p-3 bg-surface-container-low rounded-lg flex items-start gap-2.5">
                                <span
                                    class="material-symbols-outlined text-outline text-[20px] shrink-0 mt-0.5">help_outline</span>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">
                                    Deposito dengan suku bunga <strong>&gt;
                                        {{ number_format($lpsLimitGeneral, 2) }}%</strong> <em>tidak dijamin oleh
                                        LPS</em> jika bank mengalami likuidasi.
                                </p>
                            </div>
                            <a class="font-label-md text-label-md text-secondary hover:underline flex items-center gap-1"
                                href="https://www.lps.go.id" target="_blank" rel="noopener noreferrer">
                                Kunjungi Portal Resmi LPS &rarr;
                            </a>
                        </div>

                    </aside>
                </div>
            </div>
        </div>

        <!-- Simulation & Filter Script -->
        <script>
            (function () {
                // Dynamic Simulation Calculator Logic
                const amountInput = document.getElementById('deposit-amount');
                const rateInput = document.getElementById('interest-rate');
                const rateDisplay = document.getElementById('rate-display');
                const tenorPills = document.querySelectorAll('.tenor-pill');
                const quickAmts = document.querySelectorAll('.quick-amt');

                const grossDisplay = document.getElementById('gross-interest');
                const taxDisplay = document.getElementById('tax-amount');
                const netDisplay = document.getElementById('net-interest');
                const totalDisplay = document.getElementById('total-received');

                let currentTenor = 12;

                function formatRupiah(number) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        maximumFractionDigits: 0
                    }).format(number).replace('Rp', 'Rp ');
                }

                function formatWithCommas(val) {
                    if (!val && val !== 0) return '';
                    const digits = val.toString().replace(/\D/g, '');
                    if (!digits) return '';
                    return digits.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                }

                function calculateYield() {
                    const rawVal = (amountInput.value || '').replace(/\D/g, '');
                    const amount = parseFloat(rawVal) || 0;
                    const rate = parseFloat(rateInput.value) || 0;
                    rateDisplay.textContent = rate.toFixed(2) + '%';

                    // Annualized interest based on tenor months
                    const annualInterest = amount * (rate / 100);
                    const gross = annualInterest * (currentTenor / 12);

                    // Indonesian tax rule: 20% PPh if deposit amount > 7,500,000 IDR
                    const taxRate = amount > 7500000 ? 0.20 : 0.0;
                    const tax = gross * taxRate;
                    const net = gross - tax;
                    const total = amount + net;

                    grossDisplay.textContent = formatRupiah(gross);
                    taxDisplay.textContent = '- ' + formatRupiah(tax);
                    netDisplay.textContent = formatRupiah(net);
                    totalDisplay.textContent = formatRupiah(total);
                }

                // Proteksi dan pemformatan koma pada Nominal Penempatan
                if (amountInput) {
                    // Cegah pengetikan manual karakter koma atau titik karena koma otomatis dibuat
                    amountInput.addEventListener('keydown', (e) => {
                        if (e.key === ',' || e.key === '.') {
                            e.preventDefault();
                            return;
                        }

                        const pos = amountInput.selectionStart;
                        const end = amountInput.selectionEnd;

                        if (pos === end) {
                            // Backspace tepat setelah koma: hapus digit di depan koma
                            if (e.key === 'Backspace' && pos > 0) {
                                if (amountInput.value[pos - 1] === ',') {
                                    e.preventDefault();
                                    const val = amountInput.value;
                                    const digitsBefore = val.slice(0, pos - 1).replace(/\D/g, '').length;
                                    const newVal = val.slice(0, pos - 2) + val.slice(pos);
                                    const formatted = formatWithCommas(newVal);
                                    amountInput.value = formatted;

                                    const targetDigits = Math.max(0, digitsBefore - 1);
                                    let newPos = 0;
                                    let count = 0;
                                    while (newPos < formatted.length && count < targetDigits) {
                                        if (/\d/.test(formatted[newPos])) count++;
                                        newPos++;
                                    }
                                    amountInput.setSelectionRange(newPos, newPos);
                                    calculateYield();
                                }
                            }

                            // Delete tepat sebelum koma: hapus digit setelah koma
                            if (e.key === 'Delete' && pos < amountInput.value.length) {
                                if (amountInput.value[pos] === ',') {
                                    e.preventDefault();
                                    const val = amountInput.value;
                                    const digitsBefore = val.slice(0, pos).replace(/\D/g, '').length;
                                    const newVal = val.slice(0, pos) + val.slice(pos + 2);
                                    const formatted = formatWithCommas(newVal);
                                    amountInput.value = formatted;

                                    let newPos = 0;
                                    let count = 0;
                                    while (newPos < formatted.length && count < digitsBefore) {
                                        if (/\d/.test(formatted[newPos])) count++;
                                        newPos++;
                                    }
                                    amountInput.setSelectionRange(newPos, newPos);
                                    calculateYield();
                                }
                            }
                        }
                    });

                    // Format otomatis ribuan dengan koma seiring pengetikan angka
                    amountInput.addEventListener('input', () => {
                        const val = amountInput.value;
                        const selStart = amountInput.selectionStart || 0;
                        const digitsBefore = val.slice(0, selStart).replace(/\D/g, '').length;

                        const formatted = formatWithCommas(val);
                        amountInput.value = formatted;

                        let newPos = 0;
                        let count = 0;
                        while (newPos < formatted.length && count < digitsBefore) {
                            if (/\d/.test(formatted[newPos])) count++;
                            newPos++;
                        }
                        amountInput.setSelectionRange(newPos, newPos);

                        calculateYield();
                    });

                    amountInput.addEventListener('blur', () => {
                        if (!amountInput.value.trim()) {
                            amountInput.value = '10,000,000';
                            calculateYield();
                        }
                    });
                }

                rateInput.addEventListener('input', calculateYield);

                quickAmts.forEach(btn => {
                    btn.addEventListener('click', () => {
                        amountInput.value = formatWithCommas(btn.dataset.amt);
                        calculateYield();
                    });
                });

                tenorPills.forEach(pill => {
                    pill.addEventListener('click', () => {
                        tenorPills.forEach(p => {
                            p.classList.remove('bg-secondary', 'text-on-secondary', 'font-bold', 'shadow-sm');
                            p.classList.add('bg-surface-container-low', 'text-on-surface');
                        });
                        pill.classList.remove('bg-surface-container-low', 'text-on-surface');
                        pill.classList.add('bg-secondary', 'text-on-secondary', 'font-bold', 'shadow-sm');
                        currentTenor = parseInt(pill.dataset.tenor, 10);
                        calculateYield();
                    });
                });

                // --- MULTI-CRITERIA DEPOSIT FILTER LOGIC ---
                const filterMinRateInput = document.getElementById('filter-min-rate');
                const filterMinRateDisplay = document.getElementById('filter-min-rate-display');

                // Dual-Handle Tenor Slider Mapping: Step 0=1 Bln, Step 1=3 Bln, Step 2=6 Bln, Step 3=12 Bln
                const TENOR_STEPS = [1, 3, 6, 12];
                const filterMinTenorInput = document.getElementById('filter-min-tenor');
                const filterMaxTenorInput = document.getElementById('filter-max-tenor');
                const dualRangeFill = document.getElementById('dual-range-fill');
                const filterTenorRangeDisplay = document.getElementById('filter-tenor-range-display');
                const filterTenorDescMin = document.getElementById('filter-tenor-desc-min');
                const filterTenorDescMax = document.getElementById('filter-tenor-desc-max');

                function updateTenorRangeDisplay() {
                    let minIdx = parseInt(filterMinTenorInput ? filterMinTenorInput.value : 0, 10);
                    let maxIdx = parseInt(filterMaxTenorInput ? filterMaxTenorInput.value : 3, 10);

                    if (isNaN(minIdx)) minIdx = 0;
                    if (isNaN(maxIdx)) maxIdx = 3;

                    const minTenor = TENOR_STEPS[minIdx] !== undefined ? TENOR_STEPS[minIdx] : 1;
                    const maxTenor = TENOR_STEPS[maxIdx] !== undefined ? TENOR_STEPS[maxIdx] : 12;

                    // Persyaratan Visual: Beri warna biru solid tepat di antara handle min dan max
                    if (dualRangeFill) {
                        const leftPercent = (minIdx / 3) * 100;
                        const widthPercent = ((maxIdx - minIdx) / 3) * 100;
                        dualRangeFill.style.left = leftPercent + '%';
                        dualRangeFill.style.width = widthPercent + '%';
                    }

                    // Persyaratan Fungsional: Indikator kanan atas & teks dinamis bawah
                    if (filterTenorRangeDisplay) {
                        if (minTenor === maxTenor) {
                            filterTenorRangeDisplay.textContent = minTenor + ' Bulan';
                        } else {
                            filterTenorRangeDisplay.textContent = `${minTenor} - ${maxTenor} Bulan`;
                        }
                    }

                    if (filterTenorDescMin) filterTenorDescMin.textContent = minTenor;
                    if (filterTenorDescMax) filterTenorDescMax.textContent = maxTenor;
                }

                window.setTenorByIndex = function (minIdx, maxIdx) {
                    if (minIdx !== null && filterMinTenorInput) {
                        filterMinTenorInput.value = minIdx;
                        const curMax = parseInt(filterMaxTenorInput ? filterMaxTenorInput.value : 3, 10);
                        if (minIdx > curMax && filterMaxTenorInput) {
                            filterMaxTenorInput.value = minIdx;
                        }
                    }
                    if (maxIdx !== null && filterMaxTenorInput) {
                        filterMaxTenorInput.value = maxIdx;
                        const curMin = parseInt(filterMinTenorInput ? filterMinTenorInput.value : 0, 10);
                        if (maxIdx < curMin && filterMinTenorInput) {
                            filterMinTenorInput.value = maxIdx;
                        }
                    }
                    updateTenorRangeDisplay();
                    applyAllFilters();
                };

                const filterMinDepositInput = document.getElementById('filter-min-deposit');
                const quickDepositBtns = document.querySelectorAll('.btn-quick-deposit');

                const filterLpsCheckbox = document.getElementById('filter-lps-insured');

                const filterResultCount = document.getElementById('filter-result-count');
                const tabCountBadge = document.getElementById('tab-count-badge');
                const noResultsRow = document.getElementById('filter-no-results-row');
                const summaryText = document.getElementById('active-filter-summary-text');

                const btnResetFilters = document.getElementById('btn-reset-filters');
                const btnResetFiltersEmpty = document.getElementById('btn-reset-filters-empty');

                const filterButtons = document.querySelectorAll('.filter-btn');
                const rows = document.querySelectorAll('.bank-row');
                const searchInput = document.getElementById('header-search-input');

                let activeCategory = 'all';

                function parseDepositVal(val) {
                    if (!val) return 0;
                    const clean = val.toString().replace(/[^\d]/g, '');
                    return clean ? parseInt(clean, 10) : 0;
                }

                function formatDepositDisplay(num) {
                    return new Intl.NumberFormat('id-ID').format(num);
                }

                function updateActiveSummary() {
                    if (!summaryText) return;
                    const rateVal = filterMinRateInput ? filterMinRateInput.value : '4.5';
                    const minIdx = parseInt(filterMinTenorInput ? filterMinTenorInput.value : 0, 10);
                    const maxIdx = parseInt(filterMaxTenorInput ? filterMaxTenorInput.value : 3, 10);
                    const minTenor = TENOR_STEPS[minIdx] !== undefined ? TENOR_STEPS[minIdx] : 1;
                    const maxTenor = TENOR_STEPS[maxIdx] !== undefined ? TENOR_STEPS[maxIdx] : 12;

                    const depVal = parseDepositVal(filterMinDepositInput ? filterMinDepositInput.value : '5000000');
                    const depFormatted = depVal >= 1000000 ? (depVal / 1000000).toLocaleString('id-ID') + ' Jt' : formatRupiah(depVal);

                    const tenorSummary = (minTenor === maxTenor) ? `Tenor: ${minTenor} Bln` : `Tenor: ${minTenor} - ${maxTenor} Bln`;

                    let parts = [
                        `Bunga \u2265 ${rateVal}%`,
                        tenorSummary,
                        `Deposito \u2264 Rp ${depFormatted}`
                    ];
                    if (filterLpsCheckbox && filterLpsCheckbox.checked) parts.push('LPS');

                    summaryText.textContent = parts.join(' \u2022 ');
                }

                function applyAllFilters() {
                    const minRate = parseFloat(filterMinRateInput ? filterMinRateInput.value : 0);
                    const minIdx = parseInt(filterMinTenorInput ? filterMinTenorInput.value : 0, 10);
                    const maxIdx = parseInt(filterMaxTenorInput ? filterMaxTenorInput.value : 3, 10);
                    const minTenor = TENOR_STEPS[minIdx] !== undefined ? TENOR_STEPS[minIdx] : 1;
                    const maxTenor = TENOR_STEPS[maxIdx] !== undefined ? TENOR_STEPS[maxIdx] : 12;
                    const maxAffordableDeposit = parseDepositVal(filterMinDepositInput ? filterMinDepositInput.value : 0);

                    const reqLps = filterLpsCheckbox ? filterLpsCheckbox.checked : false;

                    const searchQuery = (searchInput ? searchInput.value : '').toLowerCase().trim();

                    let visibleCount = 0;

                    rows.forEach(row => {
                        const rowCategory = row.dataset.category || '';
                        const rowRate = parseFloat(row.dataset.rate || 0);
                        const rowTenor = parseInt(row.dataset.tenor || 0, 10);
                        const rowMinDeposit = parseFloat(row.dataset.minDeposit || 0);
                        const rowLps = row.dataset.lps === '1';
                        const rowText = row.textContent.toLowerCase();

                        // 1. Category tab match
                        const matchCategory = (activeCategory === 'all') || rowCategory.includes(activeCategory);

                        // 2. Minimal Bunga (%): row rate >= minimal rate
                        const matchRate = isNaN(minRate) || (rowRate >= minRate);

                        // 3. Rentang Tenor (Bulan): minTenor <= rowTenor <= maxTenor
                        const matchTenor = (isNaN(minTenor) || rowTenor >= minTenor) &&
                            (isNaN(maxTenor) || rowTenor <= maxTenor);

                        // 4. Minimal Deposito: row minimum required deposit <= user budget
                        const matchDeposit = (maxAffordableDeposit <= 0) || (rowMinDeposit <= maxAffordableDeposit);

                        // 5. Fitur Tambahan (LPS)
                        const matchLps = !reqLps || rowLps;

                        // 6. Header search query match
                        const matchSearch = !searchQuery || rowText.includes(searchQuery);

                        const isVisible = matchCategory && matchRate && matchTenor && matchDeposit && matchLps && matchSearch;

                        if (isVisible) {
                            row.style.display = '';
                            visibleCount++;

                            // Dynamically renumber rank badges
                            const rankBadge = row.querySelector('.row-rank-badge');
                            if (rankBadge) {
                                rankBadge.textContent = visibleCount;
                                if (visibleCount === 1) {
                                    rankBadge.className = 'row-rank-badge inline-flex w-7 h-7 rounded-full bg-secondary-fixed text-on-secondary-fixed font-metric-table text-metric-table items-center justify-center font-bold';
                                } else {
                                    rankBadge.className = 'row-rank-badge inline-flex w-7 h-7 rounded-full bg-surface-container text-on-surface font-metric-table text-metric-table items-center justify-center font-bold';
                                }
                            }
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    if (filterResultCount) {
                        filterResultCount.textContent = visibleCount;
                    }
                    if (tabCountBadge) {
                        tabCountBadge.textContent = `(${visibleCount} Pilihan)`;
                    }
                    if (noResultsRow) {
                        noResultsRow.style.display = visibleCount === 0 ? '' : 'none';
                    }

                    updateActiveSummary();
                }

                // Slider 1: Minimal Bunga (%)
                if (filterMinRateInput && filterMinRateDisplay) {
                    filterMinRateInput.addEventListener('input', function () {
                        filterMinRateDisplay.textContent = parseFloat(this.value).toFixed(1) + '%';
                        applyAllFilters();
                    });
                }

                // Slider 2: Single Dual-Handle Range Slider (Minimal & Maksimal Tenor)
                if (filterMinTenorInput) {
                    filterMinTenorInput.addEventListener('input', function () {
                        let minIdx = parseInt(this.value, 10);
                        let maxIdx = parseInt(filterMaxTenorInput ? filterMaxTenorInput.value : 3, 10);
                        if (minIdx > maxIdx) {
                            this.value = maxIdx;
                        }
                        this.style.zIndex = '25';
                        if (filterMaxTenorInput) filterMaxTenorInput.style.zIndex = '20';
                        updateTenorRangeDisplay();
                        applyAllFilters();
                    });
                }

                if (filterMaxTenorInput) {
                    filterMaxTenorInput.addEventListener('input', function () {
                        let maxIdx = parseInt(this.value, 10);
                        let minIdx = parseInt(filterMinTenorInput ? filterMinTenorInput.value : 0, 10);
                        if (maxIdx < minIdx) {
                            this.value = minIdx;
                        }
                        this.style.zIndex = '25';
                        if (filterMinTenorInput) filterMinTenorInput.style.zIndex = '20';
                        updateTenorRangeDisplay();
                        applyAllFilters();
                    });
                }

                // Input 3: Minimal Deposito
                if (filterMinDepositInput) {
                    filterMinDepositInput.addEventListener('input', function () {
                        const val = parseDepositVal(this.value);
                        if (val > 0) {
                            this.value = formatDepositDisplay(val);
                        }
                        quickDepositBtns.forEach(b => {
                            if (parseInt(b.dataset.amount, 10) === val) {
                                b.className = 'btn-quick-deposit text-[11px] px-2 py-0.5 rounded bg-secondary text-on-secondary font-bold transition-all shadow-sm';
                            } else {
                                b.className = 'btn-quick-deposit text-[11px] px-2 py-0.5 rounded bg-surface-container hover:bg-surface-container-high text-on-surface transition-all';
                            }
                        });
                        applyAllFilters();
                    });
                }

                quickDepositBtns.forEach(btn => {
                    btn.addEventListener('click', function () {
                        const amt = parseInt(this.dataset.amount, 10);
                        if (filterMinDepositInput) {
                            filterMinDepositInput.value = formatDepositDisplay(amt);
                        }
                        quickDepositBtns.forEach(b => {
                            b.className = 'btn-quick-deposit text-[11px] px-2 py-0.5 rounded bg-surface-container hover:bg-surface-container-high text-on-surface transition-all';
                        });
                        this.className = 'btn-quick-deposit text-[11px] px-2 py-0.5 rounded bg-secondary text-on-secondary font-bold transition-all shadow-sm';
                        applyAllFilters();
                    });
                });

                // Checkbox 4: Fitur Tambahan
                if (filterLpsCheckbox) {
                    filterLpsCheckbox.addEventListener('change', applyAllFilters);
                }

                // Category Tabs
                filterButtons.forEach(btn => {
                    btn.addEventListener('click', () => {
                        filterButtons.forEach(b => {
                            b.classList.remove('bg-surface-container-lowest', 'text-secondary', 'shadow-sm');
                            b.classList.add('text-on-surface-variant');
                        });
                        btn.classList.add('bg-surface-container-lowest', 'text-secondary', 'shadow-sm');
                        btn.classList.remove('text-on-surface-variant');

                        activeCategory = btn.dataset.category || 'all';
                        applyAllFilters();
                    });
                });

                // Reset Filters to initial requirements
                function resetFiltersToDefault() {
                    if (filterMinRateInput) {
                        filterMinRateInput.value = '4.5';
                        if (filterMinRateDisplay) filterMinRateDisplay.textContent = '4.5%';
                    }
                    if (filterMinTenorInput) {
                        filterMinTenorInput.value = '0';
                    }
                    if (filterMaxTenorInput) {
                        filterMaxTenorInput.value = '3';
                    }
                    updateTenorRangeDisplay();
                    if (filterMinDepositInput) {
                        filterMinDepositInput.value = '5.000.000';
                    }
                    quickDepositBtns.forEach(b => {
                        if (b.dataset.amount === '5000000') {
                            b.className = 'btn-quick-deposit text-[11px] px-2 py-0.5 rounded bg-secondary text-on-secondary font-bold transition-all shadow-sm';
                        } else {
                            b.className = 'btn-quick-deposit text-[11px] px-2 py-0.5 rounded bg-surface-container hover:bg-surface-container-high text-on-surface transition-all';
                        }
                    });

                    if (filterLpsCheckbox) filterLpsCheckbox.checked = false;

                    activeCategory = 'all';
                    filterButtons.forEach(b => {
                        if (b.dataset.category === 'all') {
                            b.classList.add('bg-surface-container-lowest', 'text-secondary', 'shadow-sm');
                            b.classList.remove('text-on-surface-variant');
                        } else {
                            b.classList.remove('bg-surface-container-lowest', 'text-secondary', 'shadow-sm');
                            b.classList.add('text-on-surface-variant');
                        }
                    });

                    if (searchInput) searchInput.value = '';

                    applyAllFilters();
                }

                btnResetFilters?.addEventListener('click', resetFiltersToDefault);
                btnResetFiltersEmpty?.addEventListener('click', resetFiltersToDefault);

                // Row Action: Click "Simulasi" button to load rate, min deposit & tenor directly into calculator
                document.querySelectorAll('.btn-apply-rate').forEach(btn => {
                    btn.addEventListener('click', function () {
                        const rate = parseFloat(this.dataset.rate);
                        const tenor = this.dataset.tenor;
                        const minDeposit = parseFloat(this.dataset.minDeposit) || 0;
                        const bankName = this.dataset.bank;
                        const productName = this.dataset.product || 'Deposito';

                        // 1. Suku Bunga (% p.a.)
                        if (!isNaN(rate)) {
                            rateInput.value = rate;
                            rateDisplay.textContent = rate.toFixed(2) + '%';
                        }

                        // 2. Minimal Penempatan (Nominal)
                        if (amountInput) {
                            const nominalToSet = minDeposit > 0 ? minDeposit : 10000000;
                            amountInput.value = formatWithCommas(nominalToSet);
                        }

                        // 3. Tenor (Bulan)
                        if (tenor) {
                            let matched = false;
                            tenorPills.forEach(pill => {
                                if (pill.dataset.tenor === tenor) {
                                    pill.click();
                                    matched = true;
                                }
                            });
                            if (!matched) {
                                currentTenor = parseInt(tenor, 10);
                                tenorPills.forEach(p => {
                                    p.classList.remove('bg-secondary', 'text-on-secondary', 'font-bold', 'shadow-sm');
                                    p.classList.add('bg-surface-container-low', 'text-on-surface');
                                });
                            }
                        }

                        // 4. Badge Info Bank & Produk
                        if (bankName) {
                            const badge = document.getElementById('sim-bank-badge');
                            const nameSpan = document.getElementById('sim-bank-name');
                            if (badge && nameSpan) {
                                nameSpan.textContent = `${bankName} (${productName} • ${tenor} Bln @ ${rate.toFixed(2)}%)`;
                                badge.classList.remove('hidden');
                            }
                        }

                        // 5. Jalankan kalkulasi simulasi
                        calculateYield();

                        // 6. Smooth scroll & efek sorot pada kalkulator
                        const simSection = document.getElementById('simulator');
                        if (simSection) {
                            simSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            const simCard = simSection.querySelector('.bg-surface-container-lowest') || simSection;
                            simCard.classList.add('ring-2', 'ring-secondary', 'shadow-lg');
                            setTimeout(() => {
                                simCard.classList.remove('ring-2', 'ring-secondary', 'shadow-lg');
                            }, 1600);
                        }
                    });
                });

                // Reset Bank Badge in Simulator
                document.getElementById('btn-reset-sim-bank')?.addEventListener('click', function () {
                    document.getElementById('sim-bank-badge')?.classList.add('hidden');
                });

                // Live search from header input
                if (searchInput) {
                    searchInput.addEventListener('input', applyAllFilters);
                }

                // Initial calculation and filtering run
                updateTenorRangeDisplay();
                calculateYield();
                applyAllFilters();
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
                    <span class="font-body-sm text-body-sm text-on-surface-variant">&mdash; Platform Analisis &amp;
                        Komparasi Suku Bunga Perbankan Indonesia</span>
                </div>
                <div class="flex items-center gap-space-md">
                    <div
                        class="flex items-center gap-1.5 px-3 py-1 rounded bg-surface-container-low text-on-surface-variant">
                        <span class="material-symbols-outlined text-[16px] text-secondary">verified_user</span>
                        <span class="font-label-sm text-label-sm uppercase font-bold text-on-surface">Data Terkoreksi
                            Harian</span>
                    </div>
                    <div
                        class="flex items-center gap-1.5 px-3 py-1 rounded bg-surface-container-low text-on-surface-variant">
                        <span class="material-symbols-outlined text-[16px] text-secondary">shield</span>
                        <span class="font-label-sm text-label-sm uppercase font-bold text-on-surface">Lembaga Penjamin
                            Simpanan (LPS)</span>
                    </div>
                </div>
            </div>
            <div
                class="pt-space-md flex flex-col md:flex-row items-start md:items-center justify-between gap-space-sm text-on-surface-variant">
                <p class="font-body-sm text-body-sm max-w-4xl text-on-surface-variant leading-relaxed">
                    Data suku bunga dihimpun langsung dari laporan publikasi harian bank devisa, BUKU 1-4 / KBMI 1-4,
                    serta agregator resmi Otoritas Jasa Keuangan (OJK) dan Bank Indonesia (BI). Simpanan dijamin oleh
                    LPS sesuai dengan ketentuan dan batasan maksimal saldo serta tingkat bunga penjaminan yang berlaku.
                </p>
                <p class="font-body-sm text-body-sm shrink-0">&copy; {{ date('Y') }} BankRate ID. Hak Cipta Dilindungi.
                </p>
            </div>
        </div>
    </footer>

    <!-- Progressive Web App Script -->
    <script src="{{ asset('js/pwa.js') }}"></script>
</body>

</html>