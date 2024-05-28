<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped table-sm" width="100%" id="tblTransaction">
            <thead>
            <tr>
                <th width="3%" class="text-center">No.</th>
                <th class="text-center">Kode</th>
                <th class="text-center">Menu</th>
                <th class="text-center">Kategori</th>
                <th class="text-center">Kasir</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">Jumlah</th>
                <th class="text-center">Distribusi</th>
            </tr>
            </thead>
        </table>
        <div class="showTrans"></div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#tblTransaction').DataTable({
            responsive: true,
            oLanguage: oLanguageDt(),
            'processing': true,
            'serverSide': true,
            'order': [],
            'ajax': {
                'url': "<?= route_to('listTransaction') ?>",
                'type': 'post'
            },
            'columnDefs': [{
                "orderable": false,
                "targets": [0]
            },
                {
                    "orderable": true,
                    "targets": [1, 2, 3, 4, 5, 6, 7]
                },
                {
                    className: "text-center align-middle",
                    targets: [0, 1, 3, 5, 6]
                },
                {
                    className: "align-middle",
                    targets: [2, 4]
                },
            ]
        })
    })
</script>