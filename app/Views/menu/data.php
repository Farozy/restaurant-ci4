<div class="card">
    <div class="card-body">
        <table class="table table-striped table-sm table-bordered" id="tblMenu" width="100%">
            <thead>
            <tr>
                <th width="3%" class="text-center">No.</th>
                <th class="text-center">Nama</th>
                <th class="text-center">Kategori</th>
                <th width="5%" class="text-center">Stok</th>
                <th class="text-center">Pokok</th>
                <th class="text-center">Jual</th>
                <th class="text-center">Gambar</th>
                <th class="text-center">Aksi</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#tblMenu').DataTable({
            processing: true,
            responsive: true,
            dom: "<'row'<'col-sm-5'l><'col-sm-2 btnAdd text-center text-sm-start mb-2 mb-sm-0 mt-3 mt-sm-0'><'col-sm-5'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            oLanguage: oLanguageDt(),
            'processing': true,
            'serverSide': true,
            'order': [],
            'ajax': {
                'url': "<?= route_to('listMenu') ?>",
                'type': 'post'
            },
            'columnDefs': [
                {
                    "orderable": false,
                    "targets": [0, 4, 5, 6, 7]
                },
                {
                    "orderable": true,
                    "targets": [1, 2, 3]
                },
                {
                    className: "align-middle",
                    targets: [1]
                },
                {
                    className: "text-center align-middle",
                    targets: [0, 2, 3, 6, 7]
                },
                {
                    className: "text-right align-middle",
                    targets: [4, 5]
                }
            ]
        })

        $('.btnAdd').html(`
            <a href="<?= base_url('menu/create'); ?>" class="btn btn-primary btn-sm" onclick="btnTambah()">
                <i class="fas fa-plus"> Tambah</i>
            </a>
        `);
    })

    function btnDelete(id) {
        questionSweetAlert('Yakin?', 'Menu akan dihapus', 'warning').then((result) => {
            if (result.isConfirmed) {
                setAjax("<?= route_to('deleteMenu') ?>", 'post', {id}, function (response) {
                    simpleSweetAlert('success', 'Menu berhasil dihapus').then(() => {
                        if (result) $('.viewData').html(response);
                    })
                })
            }
        })
    }

    function detail(id) {
        setAjax("<?= route_to('detailMenu') ?>", 'post', {id}, function (response) {
            $('.viewModal').html(response);
            $('#detailModal').modal('show');
        })
    }
</script>