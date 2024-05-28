<div class="card mx-3">
    <div class="card-body">
        <table class="table table-striped table-bordered" id="tblCategory" width="100%">
            <thead>
            <tr>
                <th width="10%">No.</th>
                <th class="text-center">Nama</th>
                <th class="text-center">Aksi</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($category as $x => $row) : ?>
                <tr>
                    <td class="text-center"><?= $x + 1; ?></td>
                    <td><?= $row->name ?></td>
                    <td class="text-center">
                        <button class="btn btn-warning btn-sm" onclick="btnEdit(<?= $row->id ?>)">
                            <i class="fas fa-edit"> <span class="d-none d-lg-inline">Edit</span></i>
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="btnDelete(<?= $row->id ?>)">
                            <i class="fas fa-trash"> <span class="d-none d-lg-inline">Hapus</span></i>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#tblCategory').DataTable({
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
                    "targets": [0, 2]
                },
                {
                    "orderable": true,
                    "targets": [1]
                },
                {
                    className: "text-center align-middle",
                    targets: [0, 2]
                },
                {
                    className: "align-middle",
                    targets: [1, 2]
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
        setAjax("<?= route_to('createCategory') ?>", 'get', '', function (response) {
            $('.viewModal').html(response);
            $('#addModal').modal('show');
        })
    }

    function btnEdit(id) {
        setAjax("<?= route_to('editCategory') ?>", 'get', {id}, function (response) {
            $('.viewModal').html(response);
            $('#editModal').modal('show');
        })
    }

    function btnDelete(id) {
        questionSweetAlert('Yakin?', 'Kategori akan dihapus', 'warning').then((result) => {
            if (result.isConfirmed) {
                setAjax('<?= route_to('deleteCategory') ?>', 'post', {id}, function (response) {
                    simpleSweetAlert('success', 'Kategori berhasil dihapus').then(() => {
                        if (result) $('.viewData').html(response);
                    })
                })
            }
        })
    }
</script>