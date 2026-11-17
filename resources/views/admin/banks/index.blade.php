@extends('layouts.admin')

@section('title', 'Data Bank')
@section('page_title', 'Master Data Bank')
@section('page_description', 'Kelola daftar lembaga perbankan (Bank Digital, Konvensional, dan BPR)')

@section('breadcrumb')
    <li class="breadcrumb-item active">Data Bank</li>
@endsection

@section('content')
    <!-- Filter & Action Card -->
    <div class="filter-card">
        <div class="row align-items-center">
            <div class="col-md-8">
                <form action="{{ route('admin.banks.index') }}" method="GET" class="form-inline">
                    <div class="input-group mr-2 mb-2 mb-md-0" style="min-width: 250px;">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama bank / kode saham..."
                            value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group mr-2 mb-2 mb-md-0">
                        <select name="type" class="custom-select" onchange="this.form.submit()">
                            <option value="">-- Semua Tipe Bank --</option>
                            <option value="digital" {{ request('type') === 'digital' ? 'selected' : '' }}>Bank Digital
                            </option>
                            <option value="konvensional" {{ request('type') === 'konvensional' ? 'selected' : '' }}>Bank
                                Konvensional</option>
                            <option value="bpr" {{ request('type') === 'bpr' ? 'selected' : '' }}>BPR</option>
                        </select>
                    </div>

                    @if(request('search') || request('type'))
                        <a href="{{ route('admin.banks.index') }}" class="btn btn-outline-secondary btn-sm mb-2 mb-md-0">
                            <i class="fas fa-times mr-1"></i> Reset
                        </a>
                    @endif
                </form>
            </div>
            <div class="col-md-4 text-md-right mt-2 mt-md-0 d-flex justify-content-md-end align-items-center">
                <a href="{{ route('admin.rate-matrix.index') }}" class="btn btn-success shadow-sm mr-2"
                    id="btn-update-with-table" title="Kelola suku bunga deposito dengan tampilan tabel matriks interaktif">
                    <i class="fas fa-table mr-1"></i> Update with table
                </a>
                <a href="{{ route('admin.banks.create') }}" class="btn btn-primary shadow-sm">
                    <i class="fas fa-plus mr-1"></i> Tambah Bank Baru
                </a>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">
                <i class="fas fa-university text-primary mr-1"></i> Daftar Bank (Total: {{ $banks->total() }})
            </h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom table-hover">
                    <thead>
                        <tr>
                            <th style="width: 70px;">Logo</th>
                            <th>Nama Bank</th>
                            <th>Tipe</th>
                            <th class="text-center">Kode Saham</th>
                            <th class="text-center">OJK</th>
                            <th class="text-center">LPS</th>
                            <th class="text-center">Produk</th>
                            <th class="text-right" style="width: 290px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($banks as $bank)
                            <tr>
                                <td>
                                    @if($bank->logo_url)
                                        <div class="bank-logo-thumb">
                                            <img src="{{ asset('storage/' . $bank->logo_url) }}" alt="{{ $bank->name }}">
                                        </div>
                                    @else
                                        <div class="bank-logo-placeholder">
                                            {{ substr($bank->name, 0, 1) }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="font-weight-bold text-dark" style="font-size: 1rem;">
                                        {{ $bank->name }}
                                    </div>
                                    @if($bank->description)
                                        <small class="text-muted text-truncate d-inline-block" style="max-width: 280px;"
                                            title="{{ $bank->description }}">
                                            {{ Str::limit($bank->description, 50) }}
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    @if($bank->type === 'digital')
                                        <span class="badge badge-primary px-2 py-1">Bank Digital</span>
                                    @elseif($bank->type === 'konvensional')
                                        <span class="badge badge-success px-2 py-1">Konvensional</span>
                                    @else
                                        <span class="badge badge-warning px-2 py-1 text-dark">BPR</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($bank->code_saham)
                                        <span class="badge badge-dark px-2 py-1">{{ $bank->code_saham }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($bank->is_ojk_verified)
                                        <span class="text-success" title="Terdaftar OJK"><i
                                                class="fas fa-check-circle fa-lg"></i></span>
                                    @else
                                        <span class="text-danger" title="Belum Terverifikasi"><i
                                                class="fas fa-times-circle fa-lg"></i></span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($bank->is_lps_insured)
                                        <span class="text-success" title="Dijamin LPS"><i
                                                class="fas fa-check-circle fa-lg"></i></span>
                                    @else
                                        <span class="text-danger" title="Tidak Dijamin LPS"><i
                                                class="fas fa-times-circle fa-lg"></i></span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-light border px-2 py-1 font-weight-bold">
                                        {{ $bank->products_count }} Produk
                                    </span>
                                </td>
                                <td class="text-right text-nowrap">
                                    <div class="d-inline-flex align-items-center">
                                        <!-- Tombol Update with Table Matriks -->
                                        <a href="{{ route('admin.rate-matrix.index', ['bank_id' => $bank->id]) }}"
                                            class="btn btn-sm btn-success mr-1"
                                            title="Update Suku Bunga Deposito dengan Tabel Matriks">
                                            <i class="fas fa-table"></i> Table
                                        </a>

                                        <!-- Tombol Lihat Produk (Fitur Filament) -->
                                        <a href="{{ route('admin.deposit-products.index', ['bank_id' => $bank->id]) }}"
                                            class="btn btn-sm btn-info mr-1" title="Lihat Daftar Produk Deposito Bank Ini">
                                            <i class="fas fa-list-ul"></i> Produk
                                        </a>

                                        <a href="{{ route('admin.banks.edit', $bank->id) }}" class="btn btn-sm btn-warning mr-1"
                                            title="Edit Bank">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('admin.banks.destroy', $bank->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger btn-delete-action"
                                                data-name="{{ $bank->name }}" title="Hapus Bank">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">
                                    <i class="fas fa-university fa-3x text-muted mb-3 d-block opacity-50"></i>
                                    Tidak ada data bank ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($banks->hasPages())
            <div class="card-footer bg-white d-flex justify-content-end py-3">
                {{ $banks->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
@endsection