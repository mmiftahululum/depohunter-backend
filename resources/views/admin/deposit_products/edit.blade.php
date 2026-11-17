@extends('layouts.admin')

@section('title', 'Edit Produk: ' . $depositProduct->name)
@section('page_title', 'Edit Produk Deposito')
@section('page_description', 'Perbarui detail produk, syarat minimal saldo, dan link pendaftaran')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.deposit-products.index') }}">Produk Deposito</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-warning card-outline shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title">
                    <i class="fas fa-edit text-warning mr-1"></i> Edit Produk: <strong>{{ $depositProduct->name }}</strong>
                </h3>
            </div>
            
            <form action="{{ route('admin.deposit-products.update', $depositProduct->id) }}" method="POST">
                @csrf
                @method('PUT')
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
                        <label for="bank_id">Lembaga Bank <span class="text-danger">*</span></label>
                        <select name="bank_id" id="bank_id" class="form-control select2 @error('bank_id') is-invalid @enderror" required>
                            @foreach($banks as $b)
                                <option value="{{ $b->id }}" {{ (old('bank_id', $depositProduct->bank_id) == $b->id) ? 'selected' : '' }}>
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
                            value="{{ old('name', $depositProduct->name) }}" 
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
                                value="{{ old('min_deposit', number_format($depositProduct->min_deposit, 0, ',', '.')) }}" 
                                required
                            >
                        </div>
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
                                value="{{ old('referral_link', $depositProduct->referral_link) }}"
                            >
                        </div>
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
                        >{{ old('description', $depositProduct->description) }}</textarea>
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
                                {{ old('is_active', $depositProduct->is_active) ? 'checked' : '' }}
                            >
                            <label class="custom-control-label font-weight-600" for="is_active">
                                Aktifkan Produk Deposito Ini
                            </label>
                        </div>
                    </div>

                </div>

                <div class="card-footer bg-white d-flex justify-content-between">
                    <a href="{{ route('admin.deposit-products.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-warning shadow-sm font-weight-bold">
                        <i class="fas fa-save mr-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
