@extends('layouts.admin')

@section('title', 'Edit Pengaturan: ' . $setting->label)
@section('page_title', 'Edit Nilai Pengaturan')
@section('page_description', 'Perbarui nilai persentase parameter acuan nasional')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.settings.index') }}">Pengaturan Global</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card card-warning card-outline shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title">
                    <i class="fas fa-edit text-warning mr-1"></i> Edit Pengaturan: <strong>{{ $setting->label }}</strong>
                </h3>
            </div>
            
            <form action="{{ route('admin.settings.update', $setting->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <strong>Terdapat kesalahan:</strong>
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

                    <!-- Label (Disabled seperti di Filament) -->
                    <div class="form-group">
                        <label for="label">Nama / Deskripsi Parameter</label>
                        <input 
                            type="text" 
                            id="label" 
                            class="form-control bg-light" 
                            value="{{ $setting->label }}" 
                            disabled
                        >
                        <small class="text-muted">Label tidak dapat diubah untuk menjaga integritas sistem.</small>
                    </div>

                    <!-- Kunci Konfigurasi -->
                    <div class="form-group">
                        <label for="key">Kunci Konfigurasi (Key)</label>
                        <input 
                            type="text" 
                            id="key" 
                            class="form-control bg-light" 
                            value="{{ $setting->key }}" 
                            disabled
                        >
                    </div>

                    <!-- Nilai (%) -->
                    <div class="form-group">
                        <label for="value">Nilai Persentase (%) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input 
                                type="number" 
                                step="0.01" 
                                min="0" 
                                max="100" 
                                name="value" 
                                id="value" 
                                class="form-control font-weight-bold @error('value') is-invalid @enderror" 
                                style="font-size: 1.2rem;"
                                value="{{ old('value', $setting->value) }}" 
                                required 
                                autofocus
                            >
                            <div class="input-group-append">
                                <span class="input-group-text font-weight-bold" style="font-size: 1.1rem;">%</span>
                            </div>
                        </div>
                        <small class="text-muted">Masukkan nilai suku bunga atau batasan dalam satuan persen (%).</small>
                        @error('value')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="card-footer bg-white d-flex justify-content-between">
                    <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-warning shadow-sm font-weight-bold">
                        <i class="fas fa-save mr-1"></i> Simpan Nilai Baru
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
