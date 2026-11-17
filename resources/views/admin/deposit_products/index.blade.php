@extends('layouts.admin')

@section('title', 'Produk Deposito')
@section('page_title', 'Master Produk Deposito')
@section('page_description', 'Kelola produk simpanan deposito, ketentuan minimum saldo, dan link referral')

@section('breadcrumb')
    <li class="breadcrumb-item active">Produk Deposito</li>
@endsection

@section('content')
    <!-- Filter & Action Card -->
    <div class="filter-card">
        <div class="row align-items-center">
            <div class="col-md-8">
                <form action="{{ route('admin.deposit-products.index') }}" method="GET" class="form-inline">
                    <!-- Search -->
                    <div class="input-group mr-2 mb-2 mb-md-0" style="min-width: 240px;">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama produk / bank..."
                            value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Filter per Bank (Fitur Filament) -->
                    <div class="form-group mr-2 mb-2 mb-md-0">
                        <select name="bank_id" class="custom-select select2" onchange="this.form.submit()"
                            style="min-width: 220px;">
                            <option value="">-- Semua Bank --</option>
                            @foreach($banks as $b)
                                <option value="{{ $b->id }}" {{ request('bank_id') == $b->id ? 'selected' : '' }}>
                                    {{ $b->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if(request('search') || request('bank_id'))
                        <a href="{{ route('admin.deposit-products.index') }}"
                            class="btn btn-outline-secondary btn-sm mb-2 mb-md-0">
                            <i class="fas fa-times mr-1"></i> Reset
                        </a>
                    @endif
                </form>
            </div>
            <div class="col-md-4 text-md-right mt-2 mt-md-0">
                <a href="{{ route('admin.deposit-products.create', ['bank_id' => request('bank_id')]) }}"
                    class="btn btn-primary shadow-sm">
                    <i class="fas fa-plus mr-1"></i> Tambah Produk
                </a>
            </div>
        </div>
    </div>

    @if($selectedBank)
        <div class="alert alert-info d-flex align-items-center mb-3">
            <i class="fas fa-filter fa-lg mr-2"></i>
            <div>
                Menampilkan produk deposito khusus untuk: <strong>{{ $selectedBank->name }}</strong>
                <a href="{{ route('admin.deposit-products.index') }}" class="badge badge-light ml-2 font-weight-bold">
                    Tampilkan Semua Bank
                </a>
            </div>
        </div>
    @endif

    <!-- Table Card -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">
                <i class="fas fa-piggy-bank text-success mr-1"></i> Daftar Produk Deposito (Total: {{ $products->total() }})
            </h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom table-hover">
                    <thead>
                        <tr>
                            <th>Bank</th>
                            <th>Nama Produk</th>
                            <th class="text-right">Min. Penempatan</th>
                            <th class="text-center">Status</th>
                            <th>Link Referral</th>
                            <th class="text-center">Rate</th>
                            <th class="text-right" style="width: 220px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($product->bank && $product->bank->logo_url)
                                            <div class="bank-logo-thumb mr-2" style="width: 36px; height: 36px;">
                                                <img src="{{ asset('storage/' . $product->bank->logo_url) }}"
                                                    alt="{{ $product->bank->name }}">
                                            </div>
                                        @else
                                            <div class="bank-logo-placeholder mr-2"
                                                style="width: 36px; height: 36px; font-size: 0.9rem;">
                                                {{ substr($product->bank->name ?? 'B', 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <a href="{{ route('admin.deposit-products.index', ['bank_id' => $product->bank_id]) }}"
                                                class="font-weight-bold text-dark">
                                                {{ $product->bank->name ?? '-' }}
                                            </a>
                                            <div class="text-xs text-muted">
                                                {{ ucfirst($product->bank->type ?? '') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="font-weight-600 text-dark">{{ $product->name }}</div>
                                    @if($product->description)
                                        <small class="text-muted text-truncate d-inline-block" style="max-width: 220px;"
                                            title="{{ $product->description }}">
                                            {{ Str::limit($product->description, 40) }}
                                        </small>
                                    @endif
                                </td>
                                <td class="text-right font-weight-bold text-dark">
                                    Rp {{ number_format($product->min_deposit, 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    @if($product->is_active)
                                        <span class="badge badge-success px-2 py-1">
                                            <i class="fas fa-check-circle mr-1"></i> Aktif
                                        </span>
                                    @else
                                        <span class="badge badge-secondary px-2 py-1">
                                            <i class="fas fa-ban mr-1"></i> Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($product->referral_link)
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-xs btn-outline-info btn-copy-link mr-2"
                                                data-link="{{ $product->referral_link }}" title="Salin Link Referral">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                            <a href="{{ $product->referral_link }}" target="_blank" rel="noopener noreferrer"
                                                class="text-truncate d-inline-block text-primary text-sm" style="max-width: 140px;">
                                                <i class="fas fa-external-link-alt mr-1"></i> {{ $product->referral_link }}
                                            </a>
                                        </div>
                                    @else
                                        <span class="text-muted text-sm">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-info px-2 py-1">
                                        {{ $product->rates_count }} Tenor
                                    </span>
                                </td>
                                <td class="text-right text-nowrap">
                                    <div class="d-inline-flex align-items-center">
                                        <!-- Tombol Rate -->
                                        <a href="{{ route('admin.deposit-rates.index', ['deposit_product_id' => $product->id]) }}"
                                            class="btn btn-sm btn-success mr-1"
                                            title="Lihat Daftar Suku Bunga Deposito Produk Ini">
                                            <i class="fas fa-dollar-sign"></i> Rate
                                        </a>

                                        <!-- Tombol Edit -->
                                        <a href="{{ route('admin.deposit-products.edit', $product->id) }}"
                                            class="btn btn-sm btn-warning mr-1" title="Edit Produk">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('admin.deposit-products.destroy', $product->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" class="btn btn-sm btn-danger btn-delete-action"
                                                data-name="{{ $product->name }}" title="Hapus Produk">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="fas fa-piggy-bank fa-3x text-muted mb-3 d-block opacity-50"></i>
                                    Tidak ada data produk deposito ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($products->hasPages())
            <div class="card-footer bg-white d-flex justify-content-end py-3">
                {{ $products->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
@endsection