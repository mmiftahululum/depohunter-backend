@extends('layouts.admin')

@section('title', 'Suku Bunga Deposito')
@section('page_title', 'Master Suku Bunga Deposito')
@section('page_description', 'Kelola suku bunga (p.a) per tenor dan evaluasi batasan LPS')

@section('breadcrumb')
    <li class="breadcrumb-item active">Suku Bunga Deposito</li>
@endsection

@section('content')
    <!-- Filter & Action Card -->
    <div class="filter-card">
        <form action="{{ route('admin.deposit-rates.index') }}" method="GET">
            <div class="row align-items-center">
                <!-- Filter Bank -->
                <div class="col-lg-3 col-md-6 mb-2">
                    <label class="text-xs text-muted mb-1 font-weight-bold">FILTER BANK</label>
                    <select name="bank_filter" class="form-control select2" onchange="this.form.submit()">
                        <option value="">-- Semua Bank --</option>
                        @foreach($banks as $b)
                            <option value="{{ $b->id }}" {{ request('bank_filter') == $b->id ? 'selected' : '' }}>
                                {{ $b->name }} ({{ ucfirst($b->type) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Produk Deposito -->
                <div class="col-lg-3 col-md-6 mb-2">
                    <label class="text-xs text-muted mb-1 font-weight-bold">FILTER PRODUK</label>
                    <select name="deposit_product_id" class="form-control select2" onchange="this.form.submit()">
                        <option value="">-- Semua Produk --</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}" {{ request('deposit_product_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->name }} ({{ $p->bank->name ?? '' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Tenor -->
                <div class="col-lg-2 col-md-6 mb-2">
                    <label class="text-xs text-muted mb-1 font-weight-bold">FILTER TENOR</label>
                    <select name="duration_months" class="custom-select" onchange="this.form.submit()">
                        <option value="">-- Semua Tenor --</option>
                        <option value="1" {{ request('duration_months') == '1' ? 'selected' : '' }}>1 Bulan</option>
                        <option value="3" {{ request('duration_months') == '3' ? 'selected' : '' }}>3 Bulan</option>
                        <option value="6" {{ request('duration_months') == '6' ? 'selected' : '' }}>6 Bulan</option>
                        <option value="12" {{ request('duration_months') == '12' ? 'selected' : '' }}>12 Bulan</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="col-lg-4 col-md-6 mb-2 text-md-right pt-md-3">
                    @if(request('bank_filter') || request('deposit_product_id') || request('duration_months') || request('search'))
                        <a href="{{ route('admin.deposit-rates.index') }}" class="btn btn-outline-secondary mr-1">
                            <i class="fas fa-times mr-1"></i> Reset
                        </a>
                    @endif
                    <a href="{{ route('admin.deposit-rates.create', [
        'bank_filter' => request('bank_filter'),
        'deposit_product_id' => request('deposit_product_id')
    ]) }}" class="btn btn-primary shadow-sm">
                        <i class="fas fa-plus mr-1"></i> Tambah Bunga
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">
                <i class="fas fa-chart-line text-indigo mr-1"></i> Suku Bunga Deposito (Diurutkan dari Bunga Tertinggi)
            </h3>
            <span class="badge badge-light border px-2 py-1">Total: {{ $rates->total() }} Data</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom table-hover">
                    <thead>
                        <tr>
                            <th>Bank</th>
                            <th>Produk Deposito</th>
                            <th class="text-center">Tenor</th>
                            <th class="text-center">Bunga (p.a)</th>
                            <th class="text-center">Evaluasi LPS</th>
                            <th class="text-center">Pajak</th>
                            <th class="text-right" style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $lpsLimitGeneral = $settings->get('lps_limit_general')?->value ?? 4.25;
                            $lpsLimitBpr = $settings->get('lps_limit_bpr')?->value ?? 6.75;
                        @endphp

                        @forelse($rates as $rate)
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
                                            <div class="bank-logo-thumb mr-2" style="width: 34px; height: 34px;">
                                                <img src="{{ asset('storage/' . $bank->logo_url) }}" alt="{{ $bank->name }}">
                                            </div>
                                        @else
                                            <div class="bank-logo-placeholder mr-2"
                                                style="width: 34px; height: 34px; font-size: 0.85rem;">
                                                {{ substr($bank->name ?? 'B', 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-weight-bold text-dark">{{ $bank->name ?? '-' }}</div>
                                            <span
                                                class="text-xs badge badge-light border">{{ ucfirst($bank->type ?? '') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="font-weight-600 text-dark">{{ $rate->product->name ?? '-' }}</span>
                                </td>
                                <td class="text-center font-weight-600">
                                    <span class="badge badge-light border px-2 py-1 font-weight-bold"
                                        style="font-size: 0.85rem;">
                                        {{ $rate->duration_months }} Bulan
                                    </span>
                                </td>
                                <td class="text-center">
                                    <!-- Logika Warna Filament: > 5% Success (Hijau), <= 5% Primary (Biru) -->
                                    <span
                                        class="badge {{ $rate->interest_rate > 5 ? 'badge-success' : 'badge-primary' }} px-3 py-2 font-weight-bold"
                                        style="font-size: 1rem; border-radius: 8px;">
                                        {{ number_format($rate->interest_rate, 2) }}%
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($isExceedLps)
                                        <span class="badge badge-warning px-2 py-1 text-dark"
                                            title="Suku bunga melebihi batas penjaminan LPS ({{ $limit }}%)">
                                            <i class="fas fa-exclamation-triangle mr-1"></i> Di atas LPS (Maks {{ $limit }}%)
                                        </span>
                                    @else
                                        <span class="badge badge-success px-2 py-1"
                                            title="Suku bunga memenuhi batas penjaminan LPS (Maks {{ $limit }}%)">
                                            <i class="fas fa-shield-alt mr-1"></i> Dijamin LPS
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center text-muted font-weight-500">
                                    {{ number_format($rate->tax_percent, 0) }}%
                                </td>
                                <td class="text-right text-nowrap">
                                    <div class="d-inline-flex align-items-center">
                                        <a href="{{ route('admin.deposit-rates.edit', $rate->id) }}"
                                            class="btn btn-sm btn-warning mr-1" title="Edit Suku Bunga">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('admin.deposit-rates.destroy', $rate->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger btn-delete-action"
                                                data-name="Rate {{ $rate->interest_rate }}% ({{ $rate->duration_months }} Bulan)"
                                                title="Hapus Suku Bunga">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="fas fa-percentage fa-3x text-muted mb-3 d-block opacity-50"></i>
                                    Tidak ada data suku bunga deposito yang sesuai kriteria.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($rates->hasPages())
            <div class="card-footer bg-white d-flex justify-content-end py-3">
                {{ $rates->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
@endsection