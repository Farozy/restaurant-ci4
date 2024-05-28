<div class="card mx-3">
    <div class="card-body">
        <table class="table table-striped table-bordered table-sm" id="tblRole" width="100%">
            <thead>
            <tr>
                <th width="10%">No.</th>
                <th class="text-center">Nama</th>
                <th class="text-center">Deskripsi</th>
                <th width="20%" class="text-center">Aksi</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($permission as $x => $permiss) : ?>
                <tr>
                    <td><?= $x + 1 ?></td>
                    <td><?= $permiss->name ?></td>
                    <td><?= $permiss->description ?></td>
                    <td class="text-center">
                        <button class="btn btn-warning btn-sm" onclick="btnEdit(<?= $permiss->id ?>)">
                            <i class="fas fa-edit"> <span class="d-none d-lg-inline">Edit</span></i>
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="btnDelete(<?= $permiss->id ?>)">
                            <i class="fas fa-trash"> <span class="d-none d-lg-inline">Hapus</span></i>
                        </button>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#tblRole').DataTable({
            processing: true,
            responsive: true,
            dom: "<'row'<'col-sm-5'l><'col-sm-2 btnAdd text-center text-sm-start mb-2 mb-sm-0 mt-3 mt-sm-0'><'col-sm-5'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            oLanguage: oLanguageDt(),
            'order': [],
            'columnDefs': [
                {
                    "orderable": false,
                    "targets": [0, 2, 3]
                },
                {
                    "orderable": true,
                    "targets": [1]
                },
                {
                    className: "text-center align-middle",
                    targets: [0, 1]
                },
                {
                    className: "align-middle",
                    targets: [2, 3]
                },
            ]
        })

        $('.btnAdd').html(`
            <button type="button" class="btn btn-primary btn-sm" onclick="btnTambah()">
                <i class="fas fa-plus"> Tambah</i>
            </button>
        `);
    })

    function btnTambah() {
        setAjax("<?= route_to('createPermission') ?>", 'get', '', function (response) {
            $('.viewModal').html(response);
            $('#addModal').modal('show');
        })
    }

    function btnEdit(id) {
        setAjax("<?= route_to('editPermission') ?>", 'get', {id}, function (response) {
            $('.viewModal').html(response);
            $('#editModal').modal('show');
        })
    }

    function btnDelete(id) {
        questionSweetAlert('Yakin?', 'Permission akan dihapus', 'warning').then((result) => {
            if (result.isConfirmed) {
                setAjax('<?= route_to('deletePermission') ?>', 'post', {id}, function (response) {
                    simpleSweetAlert('success', 'Permission berhasil dihapus').then(() => {
                        if (result) $('.viewData').html(response);
                    })
                })
            }
        })
    }
</script>