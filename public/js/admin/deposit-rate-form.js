/**
 * Deposit Rate Form Dependent Dropdown & LPS Warning Logic (jQuery)
 */
$(document).ready(function () {
    const bankSelect = $('#bank_filter');
    const productSelect = $('#deposit_product_id');
    const interestInput = $('#interest_rate');
    const lpsInfoBox = $('#lpsThresholdAlert');
    
    let currentBankData = null;

    // Fungsi load produk berdasarkan bank terpilih
    function loadProducts(bankId, selectedProductId) {
        if (!bankId) {
            productSelect.empty().append('<option value="">-- Pilih Bank Terlebih Dahulu --</option>').prop('disabled', true);
            currentBankData = null;
            checkLpsStatus();
            return;
        }

        productSelect.prop('disabled', true).html('<option value="">Memuat produk...</option>');

        const ajaxUrl = `/admin/ajax/products-by-bank/${bankId}`;

        $.ajax({
            url: ajaxUrl,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                currentBankData = response.bank;
                productSelect.empty().append('<option value="">-- Pilih Produk Deposito --</option>');

                if (response.products && response.products.length > 0) {
                    $.each(response.products, function (index, product) {
                        const isSelected = selectedProductId && (selectedProductId == product.id) ? 'selected' : '';
                        const minFormatted = new Intl.NumberFormat('id-ID').format(product.min_deposit);
                        productSelect.append(`<option value="${product.id}" ${isSelected}>${product.name} (Min: Rp ${minFormatted})</option>`);
                    });
                    productSelect.prop('disabled', false);
                } else {
                    productSelect.append('<option value="" disabled>Tidak ada produk aktif untuk bank ini</option>');
                    productSelect.prop('disabled', false);
                }

                checkLpsStatus();
            },
            error: function () {
                productSelect.empty().append('<option value="">Gagal memuat produk</option>');
                productSelect.prop('disabled', false);
            }
        });
    }

    // Fungsi mengecek status LPS terhadap bunga yang diinput
    function checkLpsStatus() {
        const rate = parseFloat(interestInput.val());
        if (isNaN(rate) || !currentBankData) {
            lpsInfoBox.addClass('d-none');
            return;
        }

        const isBpr = currentBankData.type === 'bpr';
        // Ambil batas dari data attributes di lpsInfoBox
        const lpsLimitGeneral = parseFloat(lpsInfoBox.data('limit-general')) || 4.25;
        const lpsLimitBpr = parseFloat(lpsInfoBox.data('limit-bpr')) || 6.75;
        const activeLimit = isBpr ? lpsLimitBpr : lpsLimitGeneral;
        const bankTypeLabel = isBpr ? 'BPR' : 'Bank Umum / Digital';

        lpsInfoBox.removeClass('d-none alert-success alert-warning alert-danger');

        if (rate > activeLimit) {
            lpsInfoBox.addClass('alert-warning').html(`
                <i class="fas fa-exclamation-triangle mr-2"></i>
                <strong>Perhatian:</strong> Suku bunga (${rate}%) berada <strong>di atas Batas Penjaminan LPS</strong> untuk ${bankTypeLabel} (${activeLimit}%). Simpanan nasabah berpotensi <u>tidak dijamin LPS</u> jika melebihi suku bunga penjaminan.
            `);
        } else {
            lpsInfoBox.addClass('alert-success').html(`
                <i class="fas fa-shield-alt mr-2"></i>
                <strong>Aman:</strong> Suku bunga (${rate}%) berada <strong>di dalam batas penjaminan LPS</strong> untuk ${bankTypeLabel} (Maks. ${activeLimit}%).
            `);
        }
    }

    // Event listener pergantian bank
    bankSelect.on('change', function () {
        const bankId = $(this).val();
        loadProducts(bankId, null);
    });

    // Event listener input bunga
    interestInput.on('input change', function () {
        checkLpsStatus();
    });

    // Initial check saat halaman edit atau jika bank sudah terpilih
    const initialBankId = bankSelect.val();
    const initialProductId = productSelect.data('initial-value') || productSelect.val();
    if (initialBankId) {
        loadProducts(initialBankId, initialProductId);
    }
});
