<!-- custom js -->
<script src="<?= base_url('templates/cashier'); ?>/js/custom.js"></script>
<script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>
<!-- isotope js -->

<script>
    $(function () {
        $('#logout').click(function (e) {
            e.preventDefault();
            questionSweetAlert('Yakin', 'Anda mau keluar dari aplikasi ini?', 'question').then((result) => {
                if (result.isConfirmed) window.location.href = '<?= base_url(); ?>/logout';
            })
        })

        <?php if (session()->getFlashdata('save')) : ?>
            toast('Simpan', "<?= session()->getFlashdata('save'); ?>", 'success', '#0d6efd', '#eee');
        <?php elseif (session()->getFlashdata('update')) : ?>
            toast('Update', "<?= session()->getFlashdata('update'); ?>", 'warning', '#ffc107', '#000');
        <?php elseif (session()->getFlashdata('delete')) : ?>
            toast('Hapus', "<?= session()->getFlashdata('delete'); ?>", 'info', '#dc3545', '#eee');
        <?php elseif (session()->getFlashdata('error')) : ?>
            toast('Error', "<?= session()->getFlashdata('error'); ?>", 'error', 'red', '#000');
        <?php endif; ?>
    })

    const toast = (heading, text, icon, bgColor, textColor) => {
        return {
            heading,
            text,
            position: 'top-right',
            showHideTransition: 'slide',
            icon,
            bgColor,
            textColor,
            allowToastClose: false,
            hideAfter: 3000,
            stack: 3,
            textAlign: 'left',
        };
    };

    const oLanguageDt = () => {
        return {
            sProcessing: "<i class='fa fa-spinner fa-spin' style='font-size:24px;'></i>",
            "sSearch": "",
            "sSearchPlaceholder": "Pencarian...",
            "sLengthMenu": "Tampilkan _MENU_ data per halaman",
            "sInfo": "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
            "sInfoEmpty": "Menampilkan 0 s/d 0 dari 0 data",
            "sZeroRecords": "Data tidak ditemukan",
            "sInfoFiltered": "(di filter dari _MAX_ total data)",
            "sInfoFiltered": "",
            "sLengthMenu": 'Tampilkan <select class="form-control-sm">' +
                '<option value="10">10</option>' +
                '<option value="20">20</option>' +
                '<option value="50">50</option>' +
                '<option value="-1">All</option>' +
                '</select> data',
        }
    }

    const setAjax = (url, type, params, successCallback, errorCallback) => {
        $.ajax({
            url: url,
            type: type,
            data: params !== '' ? params : null,
            dataType: 'json',
            success: successCallback,
            error: errorCallback !== "" ? errorCallback : function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    const setSelect2 = (id, inf, ph, clear) => {
        $(id).select2({
            minimumResultsForSearch: inf,
            placeholder: ph,
            width: '100%',
            allowClear: clear,
            "language": {
                "noResults": function () {
                    return "Data tidak ditemukan";
                }
            },
        })
    }

    const questionSweetAlert = (title, text, icon) => {
        return Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
        })
    }

    const simpleSweetAlert = (icon, title, text) => {
        return Swal.fire({
            icon: icon,
            title: title,
            text: text !== '' ? text : false,
            showConfirmButton: false,
            timer: 1500
        })
    }

    const formatRupiah = (angka) => {
        let number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            angka_hasil = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        let separator;
        if (ribuan) {
            separator = sisa ? '.' : '';
            angka_hasil += separator + ribuan.join('.');
        }

        angka_hasil = split[1] !== undefined ? angka_hasil + ',' + split[1] : angka_hasil;
        return angka_hasil;
    }

    const previewImage = (input) => {
        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                $('#previewImage').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    const checkResolution = () => {
        if (window.matchMedia('(max-width: 780px)').matches) {
            $('.colMenu2').show();
        } else {
            $('.colMenu2').show();
        }
    }
</script>