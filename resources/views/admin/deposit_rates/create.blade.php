@extends('layouts.admin')

@section('title', 'Tambah Suku Bunga Deposito')
@section('page_title', 'Tambah Suku Bunga Deposito')
@section('page_description', 'Tentukan tingkat bunga tahunan (p.a) dan jangka waktu tenor simpanan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.deposit-rates.index') }}">Suku Bunga</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-primary card-outline shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title">
                    <i class="fas fa-plus-circle text-primary mr-1"></i> Form Suku Bunga Baru
                </h3>
            </div>
            
            <form action="{{ route('admin.deposit-rates.store') }}" method="POST">
                @csrf
                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <strong>Terdapat kesalahan pada input Anda:</strong>
                            <ul class="mb-0 mt-1 pl-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <!-- Step 1: Pilih Bank Terlebih Dahulu (Dependent Dropdown) -->
                    <div class="form-group">
                        <label for="bank_filter">Langkah 1: Pilih Bank Terlebih Dahulu <span class="text-danger">*</span></label>
                        <select id="bank_filter" class="form-control select2">
                            <option value="">-- Pilih Bank --</option>
                            @foreach($banks as $b)
                                <option value="{{ $b->id }}" {{ (old('bank_filter', $defaultBankId) == $b->id) ? 'selected' : '' }}>
                                    {{ $b->name }} ({{ ucfirst($b->type) }})
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Pilih bank untuk memuat daftar produk deposito yang tersedia.</small>
                    </div>

                    <!-- Step 2: Pilih Produk Deposito -->
                    <div class="form-group">
                        <label for="deposit_product_id">Langkah 2: Pilih Produk Deposito <span class="text-danger">*</span></label>
                        <select 
                            name="deposit_product_id" 
                            id="deposit_product_id" 
                            class="form-control @error('deposit_product_id') is-invalid @enderror" 
                            data-initial-value="{{ old('deposit_product_id', $defaultProductId) }}"
                            required
                        >
                            <option value="">-- Pilih Bank Terlebih Dahulu --</option>
                            @foreach($products as $p)
                                <option value="{{ $p->id }}" {{ (old('deposit_product_id', $defaultProductId) == $p->id) ? 'selected' : '' }}>
                                    {{ $p->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('deposit_product_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tenor (Durasi) -->
                    <div class="form-group">
                        <label for="duration_months">Tenor (Durasi Simpanan) <span class="text-danger">*</span></label>
                        <select name="duration_months" id="duration_months" class="custom-select @error('duration_months') is-invalid @enderror" required>
                            <option value="">-- Pilih Tenor --</option>
                            <option value="1" {{ old('duration_months') == '1' ? 'selected' : '' }}>1 Bulan</option>
                            <option value="3" {{ old('duration_months') == '3' ? 'selected' : '' }}>3 Bulan</option>
                            <option value="6" {{ old('duration_months') == '6' ? 'selected' : '' }}>6 Bulan</option>
                            <option value="12" {{ old('duration_months') == '12' ? 'selected' : '' }}>12 Bulan</option>
                        </select>
                        @error('duration_months')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <!-- Suku Bunga (p.a) -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="interest_rate">Suku Bunga (p.a) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input 
                                        type="number" 
                                        step="0.01" 
                                        min="0" 
                                        max="100" 
                                        name="interest_rate" 
                                        id="interest_rate" 
                                        class="form-control font-weight-bold @error('interest_rate') is-invalid @enderror" 
                                        placeholder="Contoh: 5.25" 
                                        value="{{ old('interest_rate') }}" 
                                        required
                                    >
                                    <div class="input-group-append">
                                        <span class="input-group-text font-weight-bold">%</span>
                                    </div>
                                </div>
                                <small class="text-muted">Persentase bunga per tahun.</small>
                                @error('interest_rate')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Pajak Bunga -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tax_percent">Pajak Bunga <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input 
                                        type="number" 
                                        step="0.01" 
                                        min="0" 
                                        max="100" 
                                        name="tax_percent" 
                                        id="tax_percent" 
                                        class="form-control @error('tax_percent') is-invalid @enderror" 
                                        value="{{ old('tax_percent', '20') }}" 
                                        required
                                    >
                                    <div class="input-group-append">
                                        <span class="input-group-text font-weight-bold">%</span>
                                    </div>
                                </div>
                                <small class="text-muted">PPh final bunga deposito (standar 20%).</small>
                                @error('tax_percent')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Live LPS Threshold Indicator -->
                    <div 
                        id="lpsThresholdAlert" 
                        class="alert d-none mt-2" 
                        data-limit-general="{{ $settings->get('lps_limit_general')?->value ?? 4.25 }}" 
                        data-limit-bpr="{{ $settings->get('lps_limit_bpr')?->value ?? 6.75 }}"
                    >
                    </div>

                </div>

                <div class="card-footer bg-white d-flex justify-content-between">
                    <a href="{{ route('admin.deposit-rates.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <i class="fas fa-save mr-1"></i> Simpan Suku Bunga
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/admin/deposit-rate-form.js') }}"></script>
@endpush
