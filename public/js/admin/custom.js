/**
 * AdminLTE Custom Scripts for Depo Hunter (jQuery)
 */
$(document).ready(function () {
    // 1. Inisialisasi Tooltip Bootstrap
    $('[data-toggle="tooltip"]').tooltip();

    // 2. Inisialisasi Select2 jika tersedia
    if ($.fn.select2) {
        $('.select2').select2({
            theme: 'bootstrap4',
            width: '100%'
        });
    }

    // 3. Konfirmasi Hapus dengan SweetAlert2
    $(document).on('click', '.btn-delete-action', function (e) {
        e.preventDefault();
        const form = $(this).closest('form');
        const itemName = $(this).data('name') || 'data ini';

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: `Data "${itemName}" akan dihapus permanen!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: '<i class="fas fa-trash-alt mr-1"></i> Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-secondary'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    // 4. File input preview gambar (Logo Bank)
    $(document).on('change', '.custom-file-input', function (e) {
        const file = e.target.files[0];
        const previewContainer = $('#imagePreviewContainer');
        const previewImage = $('#imagePreview');
        const fileNameLabel = $(this).next('.custom-file-label');

        if (file) {
            fileNameLabel.text(file.name);
            const reader = new FileReader();
            reader.onload = function (event) {
                if (previewImage.length) {
                    previewImage.attr('src', event.target.result);
                    if (previewContainer.length) {
                        previewContainer.removeClass('d-none');
                    }
                }
            };
            reader.readAsDataURL(file);
        }
    });

    // 5. Inisialisasi DataTables jika elemen memiliki class datatable-custom
    if ($.fn.DataTable && $('.datatable-custom').length > 0) {
        $('.datatable-custom').DataTable({
            responsive: true,
            paging: false, // menggunakan pagination bawaan Laravel
            info: false,
            searching: false,
            ordering: false,
            language: {
                emptyTable: "Tidak ada data yang tersedia"
            }
        });
    }

    // 6. Format Input Angka Rupiah
    $('.input-rupiah').on('input', function () {
        let val = $(this).val().replace(/[^0-9]/g, '');
        if (val) {
            val = new Intl.NumberFormat('id-ID').format(val);
            $(this).val(val);
        }
    });

    // 7. Salin link referral ke clipboard
    $(document).on('click', '.btn-copy-link', function (e) {
        e.preventDefault();
        const link = $(this).data('link');
        if (link) {
            navigator.clipboard.writeText(link).then(function () {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Link berhasil disalin ke clipboard!',
                    showConfirmButton: false,
                    timer: 2500
                });
            });
        }
    });
});
