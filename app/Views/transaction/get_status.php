<table class="table table-bordered dataTable no-footer" cellspacing="0" width="100%" id="tTransaksi">
    <thead>
        <tr>
            <th width="3%" class="text-center">No.</th>
            <th class="text-center">Kasir</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">No. Pesanan</th>
            <th class="text-center">Customer</th>
            <th class="text-center">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($transaksi as $x => $row) : ?>
            <tr>
                <td class="text-center"><?= $x + 1 ?></td>
                <td class="text-center"><?= $row['nama_karyawan'] ?></td>
                <td class="text-center"><?= date('d-m-Y', strtotime($row['tanggal_pesanan'])) ?></td>
                <td class="text-center"><a id="detail" data-toggle="tooltip" title="Detail" onclick="detail(`<?= $row['no_pesanan'] ?>`, `<?= $row['tanggal_pesanan'] ?>`)"><?= $row['no_pesanan'] ?></a></td>
                <td class="text-center"><?= $row['customer'] ?></td>
                <td class="text-center">
                    <?php if ($row['status_transaksi'] != 0) : ?>
                        <span class="badge badge-success rounded-circle p-2"><i class="fas fa-check"></i></span>
                    <?php else : ?>
                        <span class="badge badge-danger p-2 rounded-circle">
                            <i class="fas fa-times-circle"></i>
                        </span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        var table = $('#tTransaksi').on('draw.dt', function() {
            $('[data-toggle="tooltip"]').tooltip();
        }).DataTable({
            "lengthMenu": [
                [10, 20, 50, -1],
                [10, 20, 50, "All"]
            ],
            responsive: true,
            dom: "<'row'<'col-sm-2'l><'col-sm-2 text-center FilterTrans'><'col-sm-2 text-center dariTanggal'><'col-sm-2 text-center sampaiTanggal'><'col-sm-2 buttonTrans pt-1'><'col-sm-2'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            oLanguage: {
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
            },
            drawCallback: function() {
                $('a.paginate_button').addClass('btn btn-sm rounded');
                $('#tTransaksi_paginate').addClass("mt-3 mt-md-2");
                $('#tTransaksi_paginate').addClass("pagination-sm");
            },
            'columnDefs': [{
                    "orderable": false,
                    "targets": [0, 2, 3]
                },
                {
                    "orderable": true,
                    "targets": [1, 4]
                },
                {
                    className: "text-center align-middle",
                    targets: [0, 2, 3, 4]
                },
                {
                    className: "align-middle",
                    targets: [1]
                },
                // {className: "text-center align-middle pb-0", targets: [3]},
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip({
                    "html": true,
                    "delay": {
                        "show": 500,
                        "hide": 0
                    },
                });
            }
        })

        $('div.dataTables_filter input').focus();
        $('thead tr th').addClass("bg-dark text-white").css("font-size", "0.85rem");
        $('#tTransaksi_filter input').css('height', '35px');

        $('.FilterTrans').html(`
            <select name="status_transaksi" id="status_transaksi" class="form-control">
                <option></option>
				<option value="1">Lunas</option>
				<option value="0">Belum Lunas</option>
            </select>
        `)

        $('.dariTanggal').html(`
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-calendar"></i></i></span>
                <input type="text" id="dari_tanggal" class="form-control" autocomplete="off" name="dari_tanggal" style="height: 35px" placeholder="Dari Tanggal" data-toggle="datetimepicker" data-target="#dari_tanggal">
            </div>
        `)

        $('.sampaiTanggal').html(`
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></i></span>
                <input type="text" id="sampai_tanggal" class="form-control" autocomplete="off" name="sampai_tanggal" style="height: 35px" placeholder="Sampai Tanggal" data-toggle="datetimepicker" data-target="#sampai_tanggal">
            </div>
        `)

        $('.buttonTrans').html(`
            <button class="btn btn-success btn-sm btnExcel" disabled><i class="fas fa-file-excel"></i> Excel</button>
            <button class="btn btn-secondary btn-sm btnPrint" disabled><i class="fas fa-print"></i> Print</button>
        `)

        $('#dari_tanggal').datetimepicker({
            format: "DD-MM-YYYY",
            useCurrent: false
        })

        $('#sampai_tanggal').datetimepicker({
            format: "DD-MM-YYYY",
            useCurrent: false
        })

        $('#sampai_tanggal').on("change.datetimepicker", function(e) {
            let sampaiTanggal = $(this).val();
            let dariTanggal = $('#dari_tanggal').val();

            if (dariTanggal != '') {
                $.ajax({
                    url: '<?= base_url('Transaction/getTanggal'); ?>',
                    type: 'post',
                    data: {
                        dari_tanggal: dariTanggal,
                        sampai_tanggal: sampaiTanggal
                    },
                    type: 'post',
                    dataType: 'json',
                    success: function(response) {
                        let trans = response.data;

                        if (trans.length != 0) {
                            $('.btnExcel').attr('disabled', false);
                            $('.btnPrint').attr('disabled', false);
                            $('.btnExcel').attr('onclick', 'btnExport(`' + dariTanggal + '`, `' + sampaiTanggal + '`)');
                            $('.btnPrint').attr('onclick', 'btnPrint(`' + dariTanggal + '`, `' + sampaiTanggal + '`)');
                        } else {
                            $('.btnExcel').attr('disabled', true);
                            $('.btnPrint').attr('disabled', true);
                        }
                    }
                })
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Dari tanggal belum diisi',
                    showConfirmButton: false,
                    timer: 1500
                }).then((result) => {
                    $(this).val('');
                })
            }
            return false;
        })

        $('#status_transaksi').select2({
            minimumResultsForSearch: Infinity,
            placeholder: "Status Transaction",
            width: '100%',
            tags: true,
            allowClear: true,
            language: "id",
            "language": {
                "noResults": function() {
                    return "Belum ada data pengurus";
                }
            },
        });

        $('#status_transaksi').change(function() {
            let value = $(this).val();

            $.ajax({
                url: '<?= base_url('Transaction/getStatusTransaksi'); ?>',
                type: 'post',
                data: {
                    value: value
                },
                dataType: 'json',
                success: function(response) {
                    $('.dataTables_wrapper').remove();
                    $('.showTrans').html(response.data)
                }
            })
        })
    })

    function detail(no_pesanan, tanggal_pesanan) {
        $.ajax({
            url: '<?= base_url('Transaction/detail') ?>',
            type: 'post',
            data: {
                no_pesanan: no_pesanan,
                tanggal_pesanan: tanggal_pesanan
            },
            dataType: 'json',
            success: function(response) {
                $('.viewModal').html(response.data);
                $('#detailModal').modal({
                    backdrop: "static"
                });
                $('#detailModal').modal('show');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    }

    function btnExport(dari_tanggal, sampai_tanggal) {
        window.open('<?= base_url('Transaction/exportExcel'); ?>' + '/' + dari_tanggal + '/' + sampai_tanggal);
    }

    function btnPrint(dari_tanggal, sampai_tanggal) {
        window.open('<?= base_url('Transaction/printTransaksi'); ?>' + '/' + dari_tanggal + '/' + sampai_tanggal);
    }
</script>