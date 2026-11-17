@extends('layouts.admin')

@section('title', 'Tambah Produk Deposito')
@section('page_title', 'Tambah Produk Deposito')
@section('page_description', 'Tambahkan jenis/produk deposito untuk bank tertentu')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.deposit-products.index') }}">Produk Deposito</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-primary card-outline shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title">
                    <i class="fas fa-plus-circle text-primary mr-1"></i> Form Produk Deposito Baru
                </h3>
            </div>
            
            <form action="{{ route('admin.deposit-products.store') }}" method="POST">
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

                    <!-- Pilih Bank -->
                    <div class="form-group">
                        <label for="bank_id">Pilih Lembaga Bank <span class="text-danger">*</span></label>
                        <select name="bank_id" id="bank_id" class="form-control select2 @error('bank_id') is-invalid @enderror" required>
                            <option value="">-- Cari atau Pilih Bank --</option>
                            @foreach($banks as $b)
                                <option value="{{ $b->id }}" {{ (old('bank_id', $defaultBankId) == $b->id) ? 'selected' : '' }}>
                                    {{ $b->name }} ({{ ucfirst($b->type) }})
                                </option>
                            @endforeach
                        </select>
                        @error('bank_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nama Produk -->
                    <div class="form-group">
                        <label for="name">Nama Produk Deposito <span class="text-danger">*</span></label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            class="form-control @error('name') is-invalid @enderror" 
                            placeholder="Contoh: Deposito Maksi, Deposito Wow, Deposito Fleksibel" 
                            value="{{ old('name') }}" 
                            required
                        >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Minimal Penempatan -->
                    <div class="form-group">
                        <label for="min_deposit">Minimal Penempatan Saldo <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-bold">Rp</span>
                            </div>
                            <input 
                                type="text" 
                                name="min_deposit" 
                                id="min_deposit" 
                                class="form-control input-rupiah @error('min_deposit') is-invalid @enderror" 
                                placeholder="Contoh: 1.000.000" 
                                value="{{ old('min_deposit', '1000000') }}" 
                                required
                            >
                        </div>
                        <small class="text-muted">Nominal minimum saldo awal yang dipersyaratkan untuk membuka deposito.</small>
                        @error('min_deposit')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Link Referral (Affiliate) -->
                    <div class="form-group">
                        <label for="referral_link">Link Referral / Pendaftaran (Affiliate)</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-link"></i></span>
                            </div>
                            <input 
                                type="url" 
                                name="referral_link" 
                                id="referral_link" 
                                class="form-control @error('referral_link') is-invalid @enderror" 
                                placeholder="https://bank.com/ref/depohunter" 
                                value="{{ old('referral_link') }}"
                            >
                        </div>
                        <small class="text-muted">Tautan afiliasi atau halaman registrasi pembukaan rekening deposito.</small>
                        @error('referral_link')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Deskripsi Produk -->
                    <div class="form-group">
                        <label for="description">Deskripsi / Ketentuan Tambahan (Opsional)</label>
                        <textarea 
                            name="description" 
                            id="description" 
                            rows="3" 
                            class="form-control @error('description') is-invalid @enderror" 
                            placeholder="Catatan tambahan mengenai produk deposito ini..."
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status Aktif -->
                    <div class="card bg-light border p-3">
                        <div class="custom-control custom-switch">
                            <input 
                                type="checkbox" 
                                name="is_active" 
                                value="1" 
                                class="custom-control-input" 
                                id="is_active" 
                                {{ old('is_active', '1') ? 'checked' : '' }}
                            >
                            <label class="custom-control-label font-weight-600" for="is_active">
                                Aktifkan Produk Deposito Ini
                            </label>
                            <small class="d-block text-muted">Produk yang aktif akan tampil di perhitungan rekomendasi nasabah.</small>
                        </div>
                    </div>

                </div>

                <div class="card-footer bg-white d-flex justify-content-between">
                    <a href="{{ route('admin.deposit-products.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <i class="fas fa-save mr-1"></i> Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
