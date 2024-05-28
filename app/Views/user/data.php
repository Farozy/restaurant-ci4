<div class="card">
    <div class="card-body">
        <table class="table table-striped table-sm table-bordered" width="100%" id="tblUser">
            <thead>
            <tr>
                <th width="3%">No.</th>
                <th class="text-center">Nama</th>
                <th class="text-center" width="10%">Role</th>
                <th width="15%" class="text-center">Status</th>
                <th class="text-center">Foto</th>
                <th width="15%" class="text-center">Aksi</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#tblUser').DataTable({
            responsive: true,
            processing: true,
            dom: "<'row'<'col-sm-5'l><'col-sm-2 btnAdd text-center text-sm-start mb-2 mb-sm-0 mt-3 mt-sm-0'><'col-sm-5'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            oLanguage: oLanguageDt(),
            'serverSide': true,
            'order': [],
            'ajax': {
                'url': "<?= route_to('listUser') ?>",
                'type': 'post'
            },
            'columnDefs': [
                {
                    "orderable": false,
                    "targets": [0, 2, 4, 5]
                },
                {
                    "orderable": true,
                    "targets": [1, 3]
                },
                {
                    className: "align-middle",
                    targets: [1]
                },
                {
                    className: "text-center align-middle",
                    targets: [0, 2, 3, 4, 5]
                },
            ],
        })

        $('.btnAdd').html(`
            <a href="<?= route_to('createUser') ?>" class="btn btn-primary btn-sm" onclick="btnTambah()">
                <i class="fas fa-plus"> Tambah</i>
            </a>
        `);
    })

    function detail(id) {
        setAjax("<?= route_to('detailUser') ?>", 'post', {id}, function (response) {
            $('.viewModal').html(response);
            $('#detailModal').modal('show');
        })
    }

    function destroy(id) {
        questionSweetAlert('Yakin?', 'User akan dihapus', 'warning').then((result) => {
            if (result.isConfirmed) {
                setAjax("<?= route_to('deleteUser') ?>", 'post', {id}, function (response) {
                    simpleSweetAlert('success', 'User berhasil dihapus').then(() => {
                        if (result) $('.viewData').html(response);
                    })
                })
            }
        })
    }

    function toggle(id) {
        setAjax("<?= route_to('toggleUser') ?>", 'post', {id}, function (response) {
            $('.viewData').html(response);
        })
    }
</script>