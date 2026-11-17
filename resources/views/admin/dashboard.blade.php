@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard Utama')
@section('page_description', 'Ringkasan data perbankan dan suku bunga deposito terkini')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<!-- Hero Welcome Banner -->
<div class="card bg-gradient-primary text-white border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #312e81 0%, #4338ca 50%, #4f46e5 100%);">
    <div class="card-body p-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="font-weight-bold mb-2">Selamat Datang di Depo Hunter Admin!</h3>
                <p class="mb-0 text-white-50" style="font-size: 0.95rem;">
                    Kelola data master bank, produk deposito, suku bunga acuan, dan parameter LPS dengan mudah melalui panel AdminLTE ini.
                </p>
            </div>
            <div class="col-lg-4 text-lg-right mt-3 mt-lg-0">
                <a href="{{ route('admin.banks.create') }}" class="btn btn-light font-weight-bold text-primary mr-2 shadow-sm">
                    <i class="fas fa-plus"></i> Tambah Bank
                </a>
                <a href="{{ route('admin.deposit-rates.create') }}" class="btn btn-outline-light font-weight-bold shadow-sm">
                    <i class="fas fa-percent"></i> Input Bunga
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Stat Boxes -->
<div class="row">
    <!-- Total Banks -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalBanks }}</h3>
                <p>Total Data Bank</p>
            </div>
            <div class="icon">
                <i class="fas fa-university"></i>
            </div>
            <a href="{{ route('admin.banks.index') }}" class="small-box-footer">
                Kelola Bank <i class="fas fa-arrow-circle-right ml-1"></i>
            </a>
        </div>
    </div>

    <!-- Total Products -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $totalProducts }}</h3>
                <p>Produk Deposito</p>
            </div>
            <div class="icon">
                <i class="fas fa-piggy-bank"></i>
            </div>
            <a href="{{ route('admin.deposit-products.index') }}" class="small-box-footer">
                Kelola Produk <i class="fas fa-arrow-circle-right ml-1"></i>
            </a>
        </div>
    </div>

    <!-- Total Rates -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning text-white">
            <div class="inner text-white">
                <h3>{{ $totalRates }}</h3>
                <p>Suku Bunga Aktif</p>
            </div>
            <div class="icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <a href="{{ route('admin.deposit-rates.index') }}" class="small-box-footer text-white">
                Lihat Suku Bunga <i class="fas fa-arrow-circle-right ml-1"></i>
            </a>
        </div>
    </div>

    <!-- Global Settings Indicator -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ number_format($lpsLimitGeneral, 2) }}%</h3>
                <p>Batas LPS Umum (BPR: {{ number_format($lpsLimitBpr, 2) }}%)</p>
            </div>
            <div class="icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <a href="{{ route('admin.settings.index') }}" class="small-box-footer">
                Pengaturan LPS & BI <i class="fas fa-arrow-circle-right ml-1"></i>
            </a>
        </div>
    </div>
</div>

<!-- Main Row: Tables & Summaries -->
<div class="row">
    <!-- Top 5 Suku Bunga Tertinggi -->
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title text-primary">
                    <i class="fas fa-fire text-danger mr-1"></i> Top 5 Suku Bunga Tertinggi
                </h3>
                <a href="{{ route('admin.deposit-rates.index') }}" class="btn btn-sm btn-outline-primary">
                    Lihat Semua
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-custom table-hover">
                        <thead>
                            <tr>
                                <th>Bank & Produk</th>
                                <th class="text-center">Tenor</th>
                                <th class="text-center">Bunga (p.a)</th>
                                <th class="text-center">Status LPS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topRates as $rate)
                                @php
                                    $bank = $rate->product?->bank;
                                    $isBpr = $bank && $bank->type === 'bpr';
                                    $limit = $isBpr ? $lpsLimitBpr : $lpsLimitGeneral;
                                    $isExceedLps = $rate->interest_rate > $limit;
                                @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($bank && $bank->logo_url)
                                                <div class="bank-logo-thumb mr-2">
                                                    <img src="{{ asset('storage/' . $bank->logo_url) }}" alt="{{ $bank->name }}">
                                                </div>
                                            @else
                                                <div class="bank-logo-placeholder mr-2">
                                                    {{ substr($bank->name ?? 'B', 0, 1) }}
                                                </div>
                                            @endif
                                            <div>
                                                <div class="font-weight-bold text-dark">{{ $bank->name ?? '-' }}</div>
                                                <small class="text-muted">{{ $rate->product->name ?? '-' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center font-weight-600">
                                        <span class="badge badge-light border px-2 py-1">{{ $rate->duration_months }} Bulan</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge {{ $rate->interest_rate > 5 ? 'badge-success' : 'badge-primary' }} px-3 py-2" style="font-size: 0.95rem;">
                                            {{ $rate->interest_rate }}%
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($isExceedLps)
                                            <span class="badge badge-warning px-2 py-1 text-dark" title="Di atas batas LPS">
                                                <i class="fas fa-exclamation-circle mr-1"></i> > LPS ({{ $limit }}%)
                                            </span>
                                        @else
                                            <span class="badge badge-success px-2 py-1" title="Dijamin LPS">
                                                <i class="fas fa-shield-alt mr-1"></i> Dijamin LPS
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Belum ada data suku bunga</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Bank Terbaru & Tipe -->
    <div class="col-lg-5">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title text-indigo">
                    <i class="fas fa-university mr-1"></i> Bank Terbaru Ditambahkan
                </h3>
                <a href="{{ route('admin.banks.index') }}" class="btn btn-sm btn-outline-secondary">
                    Semua Bank
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-custom table-hover">
                        <thead>
                            <tr>
                                <th>Nama Bank</th>
                                <th>Tipe</th>
                                <th class="text-center">Produk</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentBanks as $bank)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($bank->logo_url)
                                                <div class="bank-logo-thumb mr-2" style="width: 32px; height: 32px;">
                                                    <img src="{{ asset('storage/' . $bank->logo_url) }}" alt="{{ $bank->name }}">
                                                </div>
                                            @else
                                                <div class="bank-logo-placeholder mr-2" style="width: 32px; height: 32px; font-size: 0.85rem;">
                                                    {{ substr($bank->name, 0, 1) }}
                                                </div>
                                            @endif
                                            <span class="font-weight-600">{{ $bank->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($bank->type === 'digital')
                                            <span class="badge badge-primary px-2 py-1">Digital</span>
                                        @elseif($bank->type === 'konvensional')
                                            <span class="badge badge-success px-2 py-1">Konvensional</span>
                                        @else
                                            <span class="badge badge-warning px-2 py-1 text-dark">BPR</span>
                                        @endif
                                    </td>
                                    <td class="text-center font-weight-bold">
                                        {{ $bank->products_count }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-3">Belum ada bank terdaftar</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Indikator Batas Acuan Nasional -->
        <div class="card bg-light border">
            <div class="card-body">
                <h6 class="font-weight-bold text-dark mb-3">
                    <i class="fas fa-info-circle text-primary mr-1"></i> Parameter Acuan Nasional
                </h6>
                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                    <span class="text-muted">BI Rate Acuan</span>
                    <span class="badge badge-primary font-weight-bold p-2" style="font-size: 0.9rem;">{{ number_format($biRate, 2) }}%</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                    <span class="text-muted">Batas Penjaminan LPS (Bank Umum)</span>
                    <span class="badge badge-info font-weight-bold p-2" style="font-size: 0.9rem;">{{ number_format($lpsLimitGeneral, 2) }}%</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted">Batas Penjaminan LPS (BPR)</span>
                    <span class="badge badge-warning font-weight-bold p-2 text-dark" style="font-size: 0.9rem;">{{ number_format($lpsLimitBpr, 2) }}%</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
