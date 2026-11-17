@extends('layouts.admin')

@section('title', 'Pengaturan Global')
@section('page_title', 'Pengaturan Parameter Global')
@section('page_description', 'Kelola suku bunga acuan BI Rate dan batas penjaminan simpanan LPS')

@section('breadcrumb')
    <li class="breadcrumb-item active">Pengaturan Global</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- Info Alert -->
        <div class="alert alert-info shadow-sm mb-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-shield-alt fa-2x mr-3 text-info"></i>
                <div>
                    <h6 class="font-weight-bold mb-1">Pentingnya Parameter Regulasi Nasional</h6>
                    <p class="mb-0 text-sm">
                        Nilai batas penjaminan LPS dan BI Rate di bawah ini digunakan secara otomatis oleh sistem backend dan API rekomendasi untuk menentukan apakah simpanan nasabah memenuhi kriteria aman penjaminan simpanan.
                    </p>
                </div>
            </div>
        </div>

        <div class="card card-primary card-outline shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title">
                    <i class="fas fa-sliders-h text-primary mr-1"></i> Daftar Parameter Global Sistem
                </h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-custom table-hover">
                        <thead>
                            <tr>
                                <th>Deskripsi Pengaturan</th>
                                <th>Kunci Konfigurasi (Key)</th>
                                <th class="text-center">Nilai Acuan</th>
                                <th class="text-center">Terakhir Diperbarui</th>
                                <th class="text-right" style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($settings as $setting)
                                <tr>
                                    <td>
                                        <div class="font-weight-bold text-dark" style="font-size: 1rem;">
                                            {{ $setting->label }}
                                        </div>
                                    </td>
                                    <td>
                                        <code class="text-indigo bg-light px-2 py-1 rounded">{{ $setting->key }}</code>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-primary px-3 py-2 font-weight-bold" style="font-size: 1.05rem; border-radius: 8px;">
                                            {{ number_format($setting->value, 2) }}%
                                        </span>
                                    </td>
                                    <td class="text-center text-muted text-sm">
                                        {{ $setting->updated_at ? $setting->updated_at->diffForHumans() : '-' }}
                                    </td>
                                    <td class="text-right">
                                        <a 
                                            href="{{ route('admin.settings.edit', $setting->id) }}" 
                                            class="btn btn-sm btn-warning" 
                                            title="Edit Nilai Pengaturan"
                                        >
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Belum ada pengaturan global yang terdaftar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
