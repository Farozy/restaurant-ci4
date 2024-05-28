<div class="card">
    <div class="card-body">
        <table class="table table-bordered dataTable no-footer" cellspacing="0" width="100%" id="tblEmployee">
            <thead>
            <tr>
                <th width="3%" class="text-center">No.</th>
                <th class="text-center">Nama</th>
                <th class="text-center">Jenis Kelamin</th>
                <th class="text-center">Alamat</th>
                <th class="text-center">Status</th>
                <th class="text-center">Foto</th>
                <th width="25%" class="text-center">Aksi</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#tblEmployee').DataTable({
            responsive: true,
            dom: "<'row'<'col-sm-5'l><'col-sm-2 btnAdd text-center text-sm-start mb-2 mb-sm-0 mt-3 mt-sm-0'><'col-sm-5'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            oLanguage: oLanguageDt(),
            'processing': true,
            'serverSide': true,
            'order': [],
            'ajax': {
                'url': "<?= route_to('listEmployee') ?>",
                'type': 'post'
            },
            'columnDefs': [{
                "orderable": false,
                "targets": [0, 3, 4, 5, 6]
            },
                {
                    "orderable": true,
                    "targets": [1, 2]
                },
                {
                    className: "align-middle",
                    targets: [1, 3]
                },
                {
                    className: "text-center align-middle",
                    targets: [0, 2, 4, 5, 6]
                },
                // {className: "text-center align-middle pb-0", targets: [3]},
            ],
        })

        $('.btnAdd').html(`
            <a href="<?= route_to('createEmployee') ?>" class="btn btn-primary btn-sm" onclick="btnTambah()">
                <i class="fas fa-plus"> Tambah</i>
            </a>
        `);
    })

    function destroy(id) {
        questionSweetAlert('Yakin?', 'Karyawan akan dihapus', 'warning').then((result) => {
            if (result.isConfirmed) {
                setAjax("<?= route_to('deleteEmployee') ?>", 'post', {id}, function (response) {
                    simpleSweetAlert('success', 'Karyawan berhasil dihapus').then(() => {
                        if (result) $('.viewData').html(response);
                    })
                })
            }
        })
    }

    function detail(id) {
        setAjax("<?= route_to('detailEmployee') ?>", 'post', {id}, function(response) {
            $('.viewModal').html(response);
            $('#detailModal').modal('show');
        })
    }

    function toggle(id) {
        setAjax("<?= route_to('toggleEmployee') ?>", 'post', {id}, function (response) {
            $('.viewData').html(response);
        })
    }
</script>