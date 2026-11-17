@extends('layouts.admin')

@section('title', 'Matriks Suku Bunga Deposito')
@section('page_title', 'Matriks Suku Bunga Deposito')
@section('page_description', 'Kelola dan perbarui suku bunga deposito per nominal dan tenor secara interaktif langsung dari tabel')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.banks.index') }}">Data Bank</a></li>
    <li class="breadcrumb-item active">Matriks Suku Bunga</li>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/rate-matrix.css') }}">
@endpush

@section('content')
<div id="rate-matrix-app" v-cloak>

    <!-- Filter & Control Card -->
    <div class="filter-card">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="form-row align-items-center">
                    <!-- Bank Selector -->
                    <div class="col-md-5 mb-2 mb-md-0">
                        <label class="font-weight-600 text-dark mb-1 d-block">
                            <i class="fas fa-university text-primary mr-1"></i> Pilih Bank:
                        </label>
                        <select 
                            v-model="selectedBankId" 
                            @change="onBankChange" 
                            class="custom-select font-weight-bold shadow-sm"
                            style="border-color: #cbd5e1;"
                        >
                            <option v-for="b in banks" :key="b.id" :value="b.id">
                                @{{ b.name }} (@{{ b.type ? b.type.toUpperCase() : 'BANK' }}) - @{{ b.products_count }} Produk
                            </option>
                        </select>
                    </div>

                    <!-- Product Selector -->
                    <div class="col-md-5 mb-2 mb-md-0">
                        <label class="font-weight-600 text-dark mb-1 d-block">
                            <i class="fas fa-filter text-primary mr-1"></i> Filter Produk / Tier:
                        </label>
                        <select 
                            v-model="selectedProductId" 
                            @change="onProductChange" 
                            class="custom-select shadow-sm"
                            style="border-color: #cbd5e1;"
                        >
                            <option value="">-- Semua Produk / Tier Nominal --</option>
                            <option v-for="p in productsList" :key="p.id" :value="p.id">
                                @{{ p.name }} (@{{ p.min_deposit_formatted }})
                            </option>
                        </select>
                    </div>

                    <!-- Reset / Reload -->
                    <div class="col-md-2 mb-2 mb-md-0 d-flex align-items-end">
                        <button 
                            type="button" 
                            class="btn btn-outline-secondary btn-block shadow-sm" 
                            @click="loadMatrixData" 
                            :disabled="loading"
                            title="Segarkan data tabel"
                        >
                            <i class="fas fa-sync-alt mr-1" :class="{'fa-spin': loading}"></i> Refresh
                        </button>
                    </div>
                </div>
            </div>

            <!-- Action Navigation -->
            <div class="col-lg-4 text-lg-right mt-3 mt-lg-0">
                <a href="{{ route('admin.banks.index') }}" class="btn btn-outline-secondary mr-2 shadow-sm">
                    <i class="fas fa-arrow-left mr-1"></i> Data Bank
                </a>
                <a href="{{ route('admin.deposit-rates.index') }}" class="btn btn-outline-primary shadow-sm">
                    <i class="fas fa-list mr-1"></i> List Bunga
                </a>
            </div>
        </div>
    </div>

    <!-- Instruction / Shortcuts Banner -->
    <div class="matrix-legend-banner shadow-sm">
        <div>
            <i class="fas fa-info-circle mr-1 fa-lg text-primary"></i>
            <strong>Cara Edit Cepat:</strong> Klik pada nilai bunga untuk mengedit langsung. Tekan <kbd>Enter</kbd> untuk menyimpan, <kbd>Esc</kbd> untuk batal, atau <kbd>Tab</kbd> untuk lanjut ke cell berikutnya.
        </div>
        <div class="d-none d-md-flex align-items-center gap-3">
            <span class="badge badge-light border text-muted px-2 py-1 mr-2">
                <i class="fas fa-mouse-pointer mr-1"></i> Klik = Edit
            </span>
            <span class="badge badge-light border text-muted px-2 py-1 mr-2">
                <i class="fas fa-keyboard mr-1"></i> Enter = Simpan
            </span>
            <span class="badge badge-light border text-muted px-2 py-1">
                <i class="fas fa-exchange-alt mr-1"></i> Tab = Cell Berikutnya
            </span>
        </div>
    </div>

    <!-- Matrix Card Component -->
    <div class="rate-matrix-card">

        <!-- Card Header with Bank Banner -->
        <div class="matrix-header-bar" v-if="bank">
            <div class="matrix-bank-info">
                <div class="matrix-bank-logo" v-if="bank.logo_url">
                    <img :src="bank.logo_url" :alt="bank.name">
                </div>
                <div class="matrix-bank-placeholder" v-else>
                    @{{ bank.name ? bank.name.charAt(0) : 'B' }}
                </div>
                <div>
                    <h4 class="mb-0 font-weight-bold text-white d-flex align-items-center">
                        @{{ bank.name }}
                        <span v-if="bank.code_saham" class="badge badge-dark ml-2 text-xs font-weight-normal">
                            @{{ bank.code_saham }}
                        </span>
                    </h4>
                    <div class="d-flex align-items-center mt-1 text-sm text-light opacity-90">
                        <span class="badge badge-primary mr-2 text-capitalize">@{{ bank.type }}</span>
                        <span v-if="bank.is_ojk_verified" class="mr-2 text-success" title="Terverifikasi OJK">
                            <i class="fas fa-check-circle"></i> OJK
                        </span>
                        <span v-if="bank.is_lps_insured" class="text-success" title="Dijamin LPS">
                            <i class="fas fa-check-circle"></i> LPS
                        </span>
                    </div>
                </div>
            </div>

            <!-- Stats Chips -->
            <div class="d-flex flex-wrap align-items-center gap-2">
                <div class="stat-chip">
                    <i class="fas fa-layer-group"></i>
                    <span>Tier Nominal: <strong>@{{ stats.totalRows }}</strong></span>
                </div>
                <div class="stat-chip">
                    <i class="fas fa-columns"></i>
                    <span>Tenor: <strong>@{{ tenors.length }} Kolom</strong></span>
                </div>
                <div class="stat-chip" v-if="stats.highestRate > 0">
                    <i class="fas fa-arrow-up text-success"></i>
                    <span>Tertinggi: <strong class="text-success">@{{ stats.highestRate }}%</strong></span>
                </div>
                <div class="stat-chip" v-if="stats.avgRate > 0">
                    <i class="fas fa-chart-line text-info"></i>
                    <span>Rata-rata: <strong>@{{ stats.avgRate }}%</strong></span>
                </div>
            </div>
        </div>

        <!-- Table Container with Sticky Horizontal & Vertical Scroll -->
        <div class="matrix-table-container">

            <!-- Loading Spinner Overlay -->
            <div class="matrix-loading-overlay" v-if="loading">
                <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                    <span class="sr-only">Memuat data...</span>
                </div>
                <div class="font-weight-600 text-dark">Memuat matriks suku bunga deposito...</div>
            </div>

            <table class="table table-matrix" v-if="rows.length > 0">
                <thead>
                    <tr>
                        <th class="sticky-col">
                            <i class="fas fa-coins text-warning mr-1"></i> Minimal Penempatan (IDR)
                        </th>
                        <th v-for="tenor in tenors" :key="tenor" class="text-center">
                            <div class="font-weight-bold" style="font-size: 0.95rem;">
                                @{{ tenor }} Bulan
                            </div>
                            <small class="text-muted text-xs font-weight-normal">Tenor @{{ tenor }}M</small>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, rowIdx) in rows" :key="row.product_id">
                        <!-- Sticky Row Header: Minimum Deposit Amount -->
                        <td class="sticky-col">
                            <div class="nominal-label">
                                @{{ row.min_deposit_formatted }}
                            </div>
                            <div class="product-subname">
                                <i class="fas fa-tag text-muted text-xs mr-1"></i> @{{ row.product_name }}
                            </div>
                        </td>

                        <!-- Tenor Rate Cells -->
                        <td v-for="(tenor, tenorIdx) in tenors" :key="tenor">
                            
                            <!-- State: Editing Cell -->
                            <div 
                                v-if="isCellEditing(row.product_id, tenor)" 
                                class="cell-edit-wrapper"
                                @click.stop
                            >
                                <div class="input-group input-group-sm">
                                    <input 
                                        type="text" 
                                        v-model="editingCell.currentValue"
                                        class="form-control cell-edit-input"
                                        :ref="'input_' + row.product_id + '_' + tenor"
                                        placeholder="0.00"
                                        @keydown="onCellKeydown($event, rowIdx, tenorIdx, row.product_id, tenor)"
                                        @blur="saveCell(row.product_id, tenor)"
                                    >
                                    <div class="input-group-append">
                                        <span class="input-group-text font-weight-bold px-2 bg-light">%</span>
                                    </div>
                                </div>
                                <button 
                                    type="button" 
                                    class="btn btn-success btn-sm cell-btn-save" 
                                    @mousedown.prevent="saveCell(row.product_id, tenor)" 
                                    title="Simpan (Enter)"
                                >
                                    <i class="fas fa-check"></i>
                                </button>
                                <button 
                                    type="button" 
                                    class="btn btn-outline-secondary btn-sm cell-btn-cancel" 
                                    @mousedown.prevent="cancelEdit" 
                                    title="Batal (Esc)"
                                >
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>

                            <!-- State: Saving Indicator -->
                            <div 
                                v-else-if="isCellSaving(row.product_id, tenor)" 
                                class="rate-cell is-saving"
                            >
                                <span class="spinner-border spinner-border-sm text-primary mr-1" role="status"></span>
                                <small class="text-primary font-weight-bold">Menyimpan...</small>
                            </div>

                            <!-- State: Display Value (Click to edit) -->
                            <div 
                                v-else 
                                :class="['rate-cell', getCellStatusClass(row.product_id, tenor)]"
                                @click="startEdit(row, tenor)"
                                :title="'Klik untuk mengubah bunga tenor ' + tenor + ' bulan'"
                            >
                                <!-- Ada data suku bunga -->
                                <template v-if="row.rates && row.rates[tenor]">
                                    <span 
                                        class="rate-value" 
                                        :class="{'is-high': row.rates[tenor].interest_rate >= 6.0}"
                                    >
                                        @{{ formatRate(row.rates[tenor]) }}
                                    </span>
                                    <span class="edit-hint">
                                        <i class="fas fa-pencil-alt"></i>
                                    </span>
                                </template>

                                <!-- Belum ada data suku bunga untuk tenor ini -->
                                <template v-else>
                                    <span class="rate-value empty-rate">
                                        <i class="fas fa-plus text-xs mr-1"></i> Tambah
                                    </span>
                                    <span class="edit-hint">
                                        <i class="fas fa-pencil-alt"></i>
                                    </span>
                                </template>
                            </div>

                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Empty State -->
            <div v-else-if="!loading" class="text-center py-5">
                <i class="fas fa-piggy-bank fa-3x text-muted mb-3 d-block opacity-50"></i>
                <h5 class="font-weight-bold text-dark">Belum Ada Data Produk Deposito</h5>
                <p class="text-muted mb-3" style="max-width: 450px; margin: 0 auto;">
                    Bank yang dipilih belum memiliki data produk deposito dengan nominal penempatan minimum.
                </p>
                <a 
                    :href="'{{ route('admin.deposit-products.create') }}?bank_id=' + selectedBankId" 
                    class="btn btn-primary shadow-sm"
                >
                    <i class="fas fa-plus mr-1"></i> Tambah Produk Deposito Baru
                </a>
            </div>

        </div>

        <!-- Card Footer -->
        <div class="card-footer bg-white border-top d-flex justify-content-between align-items-center py-3">
            <div class="text-muted text-sm">
                <i class="fas fa-check-circle text-success mr-1"></i>
                Perubahan tersimpan otomatis secara real-time ke database.
            </div>
            <div class="text-muted text-sm font-weight-500">
                Total @{{ rows.length }} Nominal Tier &bull; @{{ tenors.length }} Tenor
            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<!-- Vue.js 3 Production CDN -->
<script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>

<script>
    // Inisialisasi variabel global dari backend Blade
    window.INITIAL_BANK_ID = {{ $selectedBankId ? json_encode((int) $selectedBankId) : 'null' }};
    window.INITIAL_PRODUCT_ID = {{ $selectedProductId ? json_encode((int) $selectedProductId) : 'null' }};
    window.MATRIX_DATA_URL = "{{ route('admin.rate-matrix.data') }}";
    window.UPDATE_RATE_URL = "{{ route('admin.rate-matrix.update-rate') }}";

    // Data Bank untuk Vue dropdown
    window.BANKS_LIST = @json($banks);
</script>

<!-- Custom Rate Matrix Vue App -->
<script src="{{ asset('js/admin/rate-matrix.js') }}"></script>

<script>
    // Set banks list to Vue state upon initialization
    if (window.BANKS_LIST) {
        // Vue app will receive banks list from window
    }
</script>
@endpush
