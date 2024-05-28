<div class="card mx-3">
    <div class="card-body">
        <table class="table table-striped table-bordered table-sm" id="tblRole" width="100%">
            <thead>
            <tr>
                <th width="10%">No.</th>
                <th class="text-center">Nama</th>
                <th class="text-center">Deskripsi</th>
                <th class="text-center">Permission</th>
                <th width="20%" class="text-center">Aksi</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($group as $x => $row) : ?>
                <tr>
                    <td class="text-center"><?= $x + 1; ?></td>
                    <td>
                        <a class="text-dark font-weight-bold under"
                           href="<?= route_to('setPermissionRole', $row->id) ?>"><u><?= $row->name ?></u></a>
                    </td>
                    <td><?= $row->description ?></td>
                    <td>
                        <?php $checkRole = []; ?>
                        <?php foreach ($rolePemission as $rp) : ?>
                            <?php if ($row->id === $rp['idRole']) : ?>
                                <?php $checkRole[] = $rp['idRole'] ?>
                                <?php $permissionColor = '' ?>
                                <?php if (str_contains(strtolower($rp['permissionName']), 'read') || str_contains($rp['permissionName'], 'view')) : ?>
                                    <?php $permissionColor = 'info' ?>
                                <?php elseif (str_contains(strtolower($rp['permissionName']), 'create') || str_contains(strtolower($rp['permissionName']), 'save')) : ?>
                                    <?php $permissionColor = 'primary' ?>
                                <?php elseif (str_contains(strtolower($rp['permissionName']), 'edit') || str_contains(strtolower($rp['permissionName']), 'update')) : ?>
                                    <?php $permissionColor = 'warning' ?>
                                <?php elseif (str_contains(strtolower($rp['permissionName']), 'delete') || str_contains(strtolower($rp['permissionName']), 'remove') || str_contains(strtolower($rp['permissionName']), 'destroy')) : ?>
                                    <?php $permissionColor = 'danger' ?>
                                <?php else : ?>
                                    <?php $permissionColor = 'dark' ?>
                                <?php endif ?>
                                    <span class="badge badge-<?= $permissionColor ?>">
                                        <?= $rp['permissionName'] ?>
                                    </span>
                            <?php endif ?>
                        <?php endforeach ?>
                        <?= !in_array($row->id, $checkRole) ? '<div class="font-weight-bold text-center">-</div>' : '' ?>
                    </td>
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
                    "targets": [0, 2, 3, 4]
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
                    targets: [2, 3, 4]
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
        setAjax("<?= route_to('createRole') ?>", 'get', '', function (response) {
            $('.viewModal').html(response);
            $('#addModal').modal('show');
        })
    }

    function btnEdit(id) {
        setAjax("<?= route_to('editRole') ?>", 'get', {id}, function (response) {
            $('.viewModal').html(response);
            $('#editModal').modal('show');
        })
    }

    function btnDelete(id) {
        questionSweetAlert('Yakin?', 'Role akan dihapus', 'warning').then((result) => {
            if (result.isConfirmed) {
                setAjax('<?= route_to('deleteRole') ?>', 'post', {id}, function (response) {
                    simpleSweetAlert('success', 'Role berhasil dihapus').then(() => {
                        if (result) $('.viewData').html(response);
                    })
                })
            }
        })
    }
</script>