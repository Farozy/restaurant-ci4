<div class="card mx-3">
    <div class="card-body">
        <table class="table table-striped table-bordered" id="tblDistribution" width="100%">
            <thead>
            <tr>
                <th width="10%">No.</th>
                <th class="text-center">Nama</th>
                <th class="text-center">Harga</th>
                <th class="text-center">Aksi</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($distribution as $x => $row) : ?>
                <tr>
                    <td class="text-center"><?= $x + 1; ?></td>
                    <td><?= $row->name ?></td>
                    <td class="text-right"><?= number_format($row->cost, 0, ',', '.') ?></td>
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
        $('#tblDistribution').DataTable({
            processing: true,
            responsive: true,
            dom: "<'row'<'col-sm-5'l><'col-sm-2 btnAdd text-center text-sm-start mb-2 mb-sm-0 mt-3 mt-sm-0'><'col-sm-5'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            oLanguage: oLanguageDt(),
            'columnDefs': [{
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
                    targets: [2]
                },
            ]
        })

        $('.btnAdd').html(`
            <button type="button" class="btn btn-primary btn-sm" onclick="btnTambah()">
                <span class="icon">
                    <i class="fas fa-plus"> Tambah</i>
                </span>
            </button>
        `);
    })

    function btnTambah() {
        setAjax("<?= route_to('createDistribution')  ?>", 'get', '', function (response) {
            $('.viewModal').html(response);
            $('#addModal').modal('show');
        })
    }

    function btnEdit(id) {
        setAjax("<?= route_to('editDistribution')  ?>", 'get', {id}, function (response) {
            $('.viewModal').html(response);
            $('#editModal').modal('show');
        })
    }

    function btnDelete(id) {
        questionSweetAlert('Yakin?', 'Distribusi akan dihapus', 'warning').then((result) => {
            if (result.isConfirmed) {
                setAjax("<?= route_to('deleteDistribution') ?>", 'post', {id}, function (response) {
                    simpleSweetAlert('success', 'Distribusi berhasil dihapus').then(() => {
                        if (result) $('.viewData').html(response);
                    })
                })
            }
        })
    }
</script>