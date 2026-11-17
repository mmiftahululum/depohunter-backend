/**
 * Interactive Deposit Rate Matrix (Vue.js 3)
 * AdminLTE Depo Hunter Backend
 */

(function () {
    if (typeof Vue === 'undefined') {
        console.error('Vue.js is not loaded.');
        return;
    }

    const { createApp, nextTick } = Vue;

    createApp({
        data() {
            return {
                selectedBankId: window.INITIAL_BANK_ID || null,
                selectedProductId: window.INITIAL_PRODUCT_ID || '',
                banks: window.BANKS_LIST || [],
                loading: false,
                bank: null,
                productsList: [],
                tenors: [],
                rows: [],

                // Inline editing state
                editingCell: null, // { productId, tenor, originalValue, currentValue }
                savingCell: null,  // { productId, tenor }
                cellStatus: {},    // { 'cell_{productId}_{tenor}': 'success' | 'error' }
            };
        },

        computed: {
            stats() {
                let allRates = [];
                this.rows.forEach(row => {
                    this.tenors.forEach(tenor => {
                        const r = row.rates && row.rates[tenor];
                        if (r && typeof r.interest_rate === 'number') {
                            allRates.push(r.interest_rate);
                        }
                    });
                });

                if (allRates.length === 0) {
                    return {
                        totalRows: this.rows.length,
                        totalCells: this.rows.length * this.tenors.length,
                        filledRates: 0,
                        highestRate: 0,
                        lowestRate: 0,
                        avgRate: 0,
                    };
                }

                const highest = Math.max(...allRates);
                const lowest = Math.min(...allRates);
                const sum = allRates.reduce((a, b) => a + b, 0);
                const avg = (sum / allRates.length).toFixed(2);

                return {
                    totalRows: this.rows.length,
                    totalCells: this.rows.length * this.tenors.length,
                    filledRates: allRates.length,
                    highestRate: highest.toFixed(2),
                    lowestRate: lowest.toFixed(2),
                    avgRate: avg,
                };
            }
        },

        mounted() {
            if (this.selectedBankId) {
                this.loadMatrixData();
            }
        },

        methods: {
            /**
             * Muat data matriks dari server via Ajax
             */
            async loadMatrixData() {
                if (!this.selectedBankId) return;

                this.loading = true;
                this.editingCell = null;

                try {
                    const url = new URL(window.MATRIX_DATA_URL, window.location.origin);
                    url.searchParams.set('bank_id', this.selectedBankId);
                    if (this.selectedProductId) {
                        url.searchParams.set('deposit_product_id', this.selectedProductId);
                    }

                    const response = await fetch(url.toString(), {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP Error ${response.status}`);
                    }

                    const data = await response.json();
                    if (data.success) {
                        this.bank = data.bank;
                        this.productsList = data.products_list;
                        this.tenors = data.tenors;
                        this.rows = data.rows;

                        // Perbarui URL browser tanpa reload
                        this.updateBrowserUrl();
                    } else {
                        this.notifyToast('error', data.message || 'Gagal memuat data matriks.');
                    }
                } catch (error) {
                    console.error('loadMatrixData error:', error);
                    this.notifyToast('error', 'Terjadi kesalahan saat memuat data matriks.');
                } finally {
                    this.loading = false;
                }
            },

            /**
             * Handler saat pilihan Bank di dropdown berubah
             */
            onBankChange() {
                this.selectedProductId = '';
                this.loadMatrixData();
            },

            /**
             * Handler saat pilihan Produk di dropdown berubah
             */
            onProductChange() {
                this.loadMatrixData();
            },

            /**
             * Perbarui query string di address bar browser
             */
            updateBrowserUrl() {
                const currentUrl = new URL(window.location.href);
                if (this.selectedBankId) {
                    currentUrl.searchParams.set('bank_id', this.selectedBankId);
                }
                if (this.selectedProductId) {
                    currentUrl.searchParams.set('deposit_product_id', this.selectedProductId);
                } else {
                    currentUrl.searchParams.delete('deposit_product_id');
                }
                window.history.replaceState({}, '', currentUrl.toString());
            },

            /**
             * Mulai inline editing pada cell tertentu
             */
            startEdit(row, tenor) {
                // Jika sedang proses simpan cell ini, jangan buka edit
                if (this.isCellSaving(row.product_id, tenor)) return;

                const currentRate = row.rates && row.rates[tenor] ? row.rates[tenor].interest_rate : null;

                this.editingCell = {
                    productId: row.product_id,
                    tenor: tenor,
                    originalValue: currentRate,
                    currentValue: currentRate !== null ? String(currentRate) : '',
                };

                // Auto fokus ke input pada render berikutnya
                nextTick(() => {
                    const inputRefKey = `input_${row.product_id}_${tenor}`;
                    const inputEl = this.$refs[inputRefKey];
                    if (inputEl) {
                        if (Array.isArray(inputEl)) {
                            if (inputEl[0]) {
                                inputEl[0].focus();
                                inputEl[0].select();
                            }
                        } else {
                            inputEl.focus();
                            inputEl.select();
                        }
                    }
                });
            },

            /**
             * Batalkan inline editing dan kembalikan ke nilai awal
             */
            cancelEdit() {
                this.editingCell = null;
            },

            /**
             * Simpan perubahan suku bunga pada cell ke database
             */
            async saveCell(productId, tenor) {
                if (!this.editingCell || this.editingCell.productId !== productId || this.editingCell.tenor !== tenor) {
                    return;
                }

                const rawVal = this.editingCell.currentValue.trim();

                // Jika input kosong dan sebelumnya memang kosong (null), batalkan saja
                if (rawVal === '' && this.editingCell.originalValue === null) {
                    this.cancelEdit();
                    return;
                }

                // Validasi numerik
                const numVal = parseFloat(rawVal.replace(',', '.'));
                if (isNaN(numVal) || numVal < 0 || numVal > 100) {
                    this.notifyToast('error', 'Suku bunga harus berupa angka yang valid antara 0% dan 100%.');
                    return;
                }

                // Cek jika tidak ada perubahan nilai dari data asli
                if (this.editingCell.originalValue !== null && Math.abs(numVal - this.editingCell.originalValue) < 0.0001) {
                    this.cancelEdit();
                    return;
                }

                // Mulai proses simpan
                this.savingCell = { productId, tenor };
                const savedOriginalValue = this.editingCell.originalValue;
                this.editingCell = null; // Tutup mode input

                const cellKey = `cell_${productId}_${tenor}`;

                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                    const response = await fetch(window.UPDATE_RATE_URL, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken || '',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            deposit_product_id: productId,
                            duration_months: tenor,
                            interest_rate: numVal,
                        })
                    });

                    const result = await response.json();

                    if (response.ok && result.success) {
                        // Perbarui data cell di reactive state rows
                        const targetRow = this.rows.find(r => r.product_id === productId);
                        if (targetRow) {
                            if (!targetRow.rates) targetRow.rates = {};
                            targetRow.rates[tenor] = result.data;
                        }

                        // Berikan visual feedback sukses (animasi hijau)
                        this.cellStatus[cellKey] = 'success';
                        setTimeout(() => {
                            delete this.cellStatus[cellKey];
                        }, 2500);

                        this.notifyToast('success', result.message || `Suku bunga ${tenor} bulan berhasil disimpan (${numVal}%).`);
                    } else {
                        // Jika gagal dari server, kembalikan nilai asli (preserve original value)
                        this.rollbackCell(productId, tenor, savedOriginalValue);
                        this.cellStatus[cellKey] = 'error';
                        setTimeout(() => {
                            delete this.cellStatus[cellKey];
                        }, 3000);

                        this.notifyToast('error', result.message || 'Gagal menyimpan perubahan suku bunga.');
                    }
                } catch (error) {
                    console.error('saveCell error:', error);
                    // Rollback ke nilai awal jika gagal koneksi
                    this.rollbackCell(productId, tenor, savedOriginalValue);
                    this.cellStatus[cellKey] = 'error';
                    setTimeout(() => {
                        delete this.cellStatus[cellKey];
                    }, 3000);

                    this.notifyToast('error', 'Terjadi kesalahan koneksi saat menyimpan suku bunga.');
                } finally {
                    this.savingCell = null;
                }
            },

            /**
             * Kembalikan nilai cell jika update gagal
             */
            rollbackCell(productId, tenor, originalValue) {
                const targetRow = this.rows.find(r => r.product_id === productId);
                if (targetRow && targetRow.rates) {
                    if (originalValue === null) {
                        targetRow.rates[tenor] = null;
                    } else if (targetRow.rates[tenor]) {
                        targetRow.rates[tenor].interest_rate = originalValue;
                    }
                }
            },

            /**
             * Handler Keyboard Navigation pada cell input
             */
            onCellKeydown(event, rowIdx, tenorIdx, productId, tenor) {
                if (event.key === 'Escape') {
                    event.preventDefault();
                    this.cancelEdit();
                } else if (event.key === 'Enter') {
                    event.preventDefault();
                    this.saveCell(productId, tenor);
                } else if (event.key === 'Tab') {
                    event.preventDefault();
                    // Simpan cell aktif terlebih dahulu
                    this.saveCell(productId, tenor);

                    // Pindah ke cell berikutnya
                    const isShift = event.shiftKey;
                    let nextRowIdx = rowIdx;
                    let nextTenorIdx = isShift ? tenorIdx - 1 : tenorIdx + 1;

                    if (nextTenorIdx >= this.tenors.length) {
                        nextTenorIdx = 0;
                        nextRowIdx++;
                    } else if (nextTenorIdx < 0) {
                        nextTenorIdx = this.tenors.length - 1;
                        nextRowIdx--;
                    }

                    if (nextRowIdx >= 0 && nextRowIdx < this.rows.length) {
                        const nextRow = this.rows[nextRowIdx];
                        const nextTenor = this.tenors[nextTenorIdx];
                        this.startEdit(nextRow, nextTenor);
                    }
                }
            },

            /**
             * Cek apakah cell sedang dalam proses edit
             */
            isCellEditing(productId, tenor) {
                return (
                    this.editingCell &&
                    this.editingCell.productId === productId &&
                    this.editingCell.tenor === tenor
                );
            },

            /**
             * Cek apakah cell sedang dalam proses simpan
             */
            isCellSaving(productId, tenor) {
                return (
                    this.savingCell &&
                    this.savingCell.productId === productId &&
                    this.savingCell.tenor === tenor
                );
            },

            /**
             * Ambil status animasi cell ('status-success' atau 'status-error')
             */
            getCellStatusClass(productId, tenor) {
                const key = `cell_${productId}_${tenor}`;
                const status = this.cellStatus[key];
                if (status === 'success') return 'status-success';
                if (status === 'error') return 'status-error';
                return '';
            },

            /**
             * Format suku bunga untuk tampilan (misal: "5.25%")
             */
            formatRate(rateObj) {
                if (!rateObj || typeof rateObj.interest_rate !== 'number') {
                    return null;
                }
                return Number(rateObj.interest_rate).toFixed(2) + '%';
            },

            /**
             * Tampilkan Toast Notification (SweetAlert2 atau fallback Alert)
             */
            notifyToast(icon, message) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: icon,
                        title: icon === 'success' ? 'Berhasil!' : 'Perhatian',
                        text: message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3500,
                        timerProgressBar: true,
                    });
                } else {
                    alert(message);
                }
            }
        }
    }).mount('#rate-matrix-app');
})();
