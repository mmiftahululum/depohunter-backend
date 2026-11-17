@extends('layouts.admin')

@section('title', 'Edit Bank: ' . $bank->name)
@section('page_title', 'Edit Data Bank')
@section('page_description', 'Perbarui data bank, logo, dan regulasi')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.banks.index') }}">Data Bank</a></li>
    <li class="breadcrumb-item active">Edit Bank</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card card-warning card-outline shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title">
                    <i class="fas fa-edit text-warning mr-1"></i> Edit Data Bank: <strong>{{ $bank->name }}</strong>
                </h3>
            </div>
            
            <form action="{{ route('admin.banks.update', $bank->id) }}" method="POST" enctype="multipart/form-data">
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

                    <div class="row">
                        <!-- Nama Bank -->
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="name">Nama Bank <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    name="name" 
                                    id="name" 
                                    class="form-control @error('name') is-invalid @enderror" 
                                    value="{{ old('name', $bank->name) }}" 
                                    required
                                >
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tipe Bank -->
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="type">Tipe Bank <span class="text-danger">*</span></label>
                                <select name="type" id="type" class="custom-select @error('type') is-invalid @enderror" required>
                                    <option value="digital" {{ old('type', $bank->type) === 'digital' ? 'selected' : '' }}>Bank Digital</option>
                                    <option value="konvensional" {{ old('type', $bank->type) === 'konvensional' ? 'selected' : '' }}>Bank Umum Konvensional</option>
                                    <option value="bpr" {{ old('type', $bank->type) === 'bpr' ? 'selected' : '' }}>BPR (Bank Perekonomian Rakyat)</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Kode Saham -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="code_saham">Kode Saham (Ticker Emiten)</label>
                                <input 
                                    type="text" 
                                    name="code_saham" 
                                    id="code_saham" 
                                    class="form-control text-uppercase @error('code_saham') is-invalid @enderror" 
                                    value="{{ old('code_saham', $bank->code_saham) }}"
                                    maxlength="10"
                                >
                                <small class="text-muted">Opsional, jika bank tercatat di Bursa Efek Indonesia.</small>
                                @error('code_saham')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Warna Brand / Color Code -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="color_code">Warna Identitas Brand</label>
                                <div class="input-group">
                                    <input 
                                        type="color" 
                                        name="color_code" 
                                        id="color_code" 
                                        class="form-control form-control-color" 
                                        value="{{ old('color_code', $bank->color_code ?? '#4f46e5') }}" 
                                        style="max-width: 60px; height: 42px; padding: 4px;"
                                    >
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="colorCodeText" 
                                        value="{{ old('color_code', $bank->color_code ?? '#4f46e5') }}" 
                                        readonly
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload & Preview Logo Bank -->
                    <div class="form-group">
                        <label for="logo_url">Logo Bank</label>

                        @if($bank->logo_url)
                            <div class="d-flex align-items-center mb-2 p-2 bg-light rounded border">
                                <div class="bank-logo-thumb mr-3" style="width: 60px; height: 60px;">
                                    <img src="{{ asset('storage/' . $bank->logo_url) }}" alt="{{ $bank->name }}">
                                </div>
                                <div>
                                    <span class="d-block font-weight-bold text-dark text-sm">Logo Saat Ini Terpasang</span>
                                    <small class="text-muted">Unggah file baru di bawah ini untuk mengganti logo.</small>
                                </div>
                            </div>
                        @endif

                        <div class="custom-file mb-2">
                            <input 
                                type="file" 
                                name="logo_url" 
                                id="logo_url" 
                                class="custom-file-input @error('logo_url') is-invalid @enderror" 
                                accept="image/*"
                            >
                            <label class="custom-file-label" for="logo_url">Pilih logo baru jika ingin mengganti...</label>
                            @error('logo_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="imagePreviewContainer" class="d-none mt-2">
                            <label class="d-block text-muted text-xs">Preview Logo Baru:</label>
                            <div class="bank-logo-thumb" style="width: 80px; height: 80px;">
                                <img id="imagePreview" src="" alt="Preview Logo Baru">
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi Bank -->
                    <div class="form-group">
                        <label for="description">Deskripsi / Profil Singkat Bank</label>
                        <textarea 
                            name="description" 
                            id="description" 
                            rows="4" 
                            class="form-control @error('description') is-invalid @enderror"
                        >{{ old('description', $bank->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status Regulasi (OJK & LPS) -->
                    <div class="card bg-light border p-3">
                        <h6 class="font-weight-bold text-dark mb-3">Status Regulasi & Penjaminan</h6>
                        <div class="row">
                            <div class="col-md-6 mb-2 mb-md-0">
                                <div class="custom-control custom-switch">
                                    <input 
                                        type="checkbox" 
                                        name="is_ojk_verified" 
                                        value="1" 
                                        class="custom-control-input" 
                                        id="is_ojk_verified" 
                                        {{ old('is_ojk_verified', $bank->is_ojk_verified) ? 'checked' : '' }}
                                    >
                                    <label class="custom-control-label font-weight-600" for="is_ojk_verified">
                                        Terdaftar & Diawasi OJK
                                    </label>
                                    <small class="d-block text-muted">Bank berizin resmi dari Otoritas Jasa Keuangan.</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="custom-control custom-switch">
                                    <input 
                                        type="checkbox" 
                                        name="is_lps_insured" 
                                        value="1" 
                                        class="custom-control-input" 
                                        id="is_lps_insured" 
                                        {{ old('is_lps_insured', $bank->is_lps_insured) ? 'checked' : '' }}
                                    >
                                    <label class="custom-control-label font-weight-600" for="is_lps_insured">
                                        Peserta Penjaminan LPS
                                    </label>
                                    <small class="d-block text-muted">Simpanan nasabah dijamin oleh Lembaga Penjamin Simpanan.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-footer bg-white d-flex justify-content-between">
                    <a href="{{ route('admin.banks.index') }}" class="btn btn-secondary">
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

@push('scripts')
<script>
    $('#color_code').on('input', function() {
        $('#colorCodeText').val($(this).val());
    });
</script>
@endpush
