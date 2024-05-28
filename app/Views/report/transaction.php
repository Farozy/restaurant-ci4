<?= $this->extend('templates/main'); ?>

<?= $this->section('content'); ?>
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

    <div class="viewModal"></div>
    <script>
        $(document).ready(function () {
            let transactionTable = $('#tblTransaction').DataTable({
                responsive: true,
                dom: "<'row'<'col-sm-2'l><'col-sm-3 text-center fromDate'><'col-sm-3 text-center toDate'><'col-sm-2 buttonTrans pt-1 mb-3 mb-sm-0 text-center'><'col-sm-2'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                oLanguage: oLanguageDt(),
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
                        targets: [2, 4, 7]
                    },
                ]
            })

            $('.fromDate').html(`
            <div class="input-group mb-3 mb-sm-0">
                <span class="input-group-text"><i class="fas fa-calendar"></i></i></span>
                <input type="text" id="from_date" class="form-control" autocomplete="off" name="dari_tanggal" style="height: 35px" placeholder="Dari Tanggal" data-toggle="datetimepicker" data-target="#from_date">
            </div>
        `)

            $('.toDate').html(`
            <div class="input-group mb-3 mb-sm-0">
                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></i></span>
                <input type="text" id="to_date" class="form-control" autocomplete="off" name="sampai_tanggal" style="height: 35px" placeholder="Sampai Tanggal" data-toggle="datetimepicker" data-target="#to_date" disabled>
            </div>
        `)

            $('.buttonTrans').html(`
            <button class="btn btn-success btn-sm btnExcel" disabled><i class="fas fa-file-excel"><span class='d-none d-lg-inline-flex'> Excel</span></i></button>
            <button class="btn btn-secondary btn-sm btnPrint" disabled><i class="fas fa-print"><span class='d-none d-lg-inline-flex'> Print</span></i></button>
        `)

            $('#from_date').datetimepicker({
                format: "DD-MM-YYYY",
                showButtonPanel: true
            })

            $('#to_date').datetimepicker({
                format: "DD-MM-YYYY",
                useCurrent: false
            })

            $('#from_date').on("change.datetimepicker", function () {
                let value = $(this).val();
                if (value === '') {
                    $('#to_date').attr('disabled', true);
                } else {
                    $('#to_date').attr('disabled', false);
                }
            })

            $('#to_date').on("change.datetimepicker", function () {
                let toDate = $(this).val();
                let fromDate = $('#from_date').val();
                setAjax("<?= route_to('getTransactionDate') ?>", 'post', {fromDate, toDate}, function (response) {
                    if (response.length > 0) {
                        transactionTable.clear();

                        response.forEach(function (transaction, index) {
                            transactionTable.row.add([
                                index + 1,
                                transaction.code,
                                transaction.menuName,
                                transaction.categoryName,
                                transaction.employeeName,
                                transaction.date,
                                transaction.amount,
                                transaction.distributionName
                            ]).draw(false);
                        });

                        $('.btnExcel').attr('disabled', false);
                        $('.btnPrint').attr('disabled', false);
                        $('.btnExcel').attr('onclick', 'btnExport(`' + fromDate + '`, `' + toDate + '`)');
                        $('.btnPrint').attr('onclick', 'btnPrint(`' + fromDate + '`, `' + toDate + '`)');
                    } else {
                        $('.btnExcel').attr('disabled', true);
                        $('.btnPrint').attr('disabled', true);
                    }
                })
            })
        })

        function btnExport(fromDate, toDate) {
            let url = `<?= route_to("reportExcelTransaction", '', '') ?>${fromDate}/${toDate}`;
            window.open(url, '_blank');
        }

        function btnPrint(fromDate, toDate) {
            let url = `<?= route_to("reportPrintTransaction", '', '') ?>${fromDate}/${toDate}`;
            window.open(url, '_blank');
        }
    </script>
<?= $this->endSection(); ?>