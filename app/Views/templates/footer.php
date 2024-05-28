<!-- Main Footer -->
<footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
        <!-- Anything you want -->
    </div>
    <!-- Default to the left -->
    <!-- <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved. -->
</footer>
</div>
<!-- ./wrapper -->

<script>
    (() => {
        // $('[data-toggle="tooltip"]').tooltip();
        // var i = "theme",
        //     o = /\btheme-[a-z0-9]+\b/g,
        //     r = document.getElementById("toggle-dark");


        // function l(e) {
        //     var t = arguments.length > 1 && void 0 !== arguments[1] && arguments[1];
        //     (document.body.className = document.body.className.replace(o, "")),
        //     document.body.classList.add(e),
        //         (r.checked = "light-mode" == e),
        //         t || localStorage.setItem(i, e);
        // }

        // r.addEventListener("input", function(e) {
        //     if (e.target.checked) {
        //         l("light-mode");
        //         $('body').removeClass('dark-mode')
        //     } else {
        //         l("dark-mode");
        //         $('body').removeClass('light-mode')
        //     }
        // }),

        // document.addEventListener("DOMContentLoaded", function() {
        //     var e;
        //     if ((e = localStorage.getItem(i))) return l(e);
        //     if (window.matchMedia) {
        //         var t = window.matchMedia("(prefers-color-scheme: light)");
        //         return (
        //             t.addEventListener("change", function(e) {
        //                 return l(e.matches ? "light-mode" : "dark-mode", !0);
        //             }),
        //             l(t.matches ? "light-mode" : "dark-mode", !0)
        //         );
        //     }
        // });

        $('#logout').click(function (e) {
            e.preventDefault();
            questionSweetAlert('Yakin', 'Anda mau keluar dari aplikasi ini?', 'question').then((result) => {
                if (result.isConfirmed) window.location.href = '<?= base_url(); ?>/logout';
            })
        })

        <?php if (getFlashdata('save')) : ?>
        showToast('Simpan', "<?= getFlashdata('save') ?>", 'success', '#0d6efd', '#eee');
        <?php elseif (getFlashdata('update')) : ?>
        showToast('Update', "<?= getFlashdata('update') ?>", 'warning', '#8A6D3B', '#F8F9FA');
        <?php elseif (getFlashdata('delete')) : ?>
        showToast('Hapus', "<?= getFlashdata('delete'); ?>", 'info', '#dc3545', '#eee');
        <?php elseif (getFlashdata('error')) : ?>
        showToast('Error', "<?= getFlashdata('error') ?>", 'error', '#DC3545', '#F8F9FA');
        <?php endif; ?>
    })();

    function showToast(heading, text, icon, bgColor, textColor) {
        $.toast({
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
        });
    };

    function setAjax(url, type, params, successCallback, errorCallback) {
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

    function oLanguageDt() {
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

    function simpleSweetAlert(icon, title, text) {
        return Swal.fire({
            icon: icon,
            title: title,
            text: text !== '' ? text : false,
            showConfirmButton: false,
            timer: 1500
        })
    }

    function questionSweetAlert(title, text, icon) {
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

    function formatRupiah(angka) {
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

        return split[1] !== undefined ? angka_hasil + ',' + split[1] : angka_hasil;
    }

    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                $('#previewImage').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function setSelect2(id, inf, ph, clear) {
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
        }).on("select2:opening select2:closing", function () {
            $('body').css('overflow-x', 'hidden');
        });
    }
</script>
</body>

</html>