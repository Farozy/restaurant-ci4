<?= $this->include('templates/cashier/header'); ?>
<div class="card">
    <div class="card-header text-center" style="border-radius: 20px;">
        <h1 class="font-weight-bold font-dancing">Cek Pesanan</h1>
    </div>
    <div class="card-body">
        <?= form_open(route_to('saveOrderCashier'), ['class' => 'saveTransaction'], ['code' => $code, 'menuId[]' => $menuId, 'amount[]' => $amount, 'request[]' => $request]) ?>
        <div class="row">
            <div class="col-12 col-md-9">
                <table class="table table-bordered table-striped table-responsive" id="tblCheckOrder" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center" width="3%">No.</th>
                            <th class="text-center">Nama Menu</th>
                            <th class="text-center">Request</th>
                            <th class="text-center" width="15%">Kategori</th>
                            <th class="text-center" width="7">Diskon</th>
                            <th class="text-center">Harga</th>
                            <th class="text-center" width="7%">Jumlah</th>
                            <th class="text-center">Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        $no = 1;
                        $count = 0;
                        ?>
                        <?php foreach ($menuId as $mId) : ?>
                            <?php foreach ($menu as $x => $row) : ?>
                                <?php if ($mId === $row->id) : ?>
                                    <?php if ($row->discount != 0) : ?>
                                        <?php
                                        $diskon = ($row->discount / 100) * $row->sell;
                                        $total += ($row->sell - $diskon) * $amount[$count]
                                        ?>
                                    <?php else : ?>
                                        <?php $total += $row->sell * $amount[$count] ?>
                                    <?php endif; ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td><?= $row->name ?></td>
                                        <?php if ($request[$count] !== ''): ?>
                                            <td><?= $request[$count] ?></td>
                                        <?php else: ?>
                                            <td class="text-center">-</td>
                                        <?php endif ?>
                                        <td class="text-center"><?= $row->categoryName ?></td>
                                        <td class="text-center"><?= $row->discount != 0 ? $row->discount . '%' : '-'; ?></td>
                                        <td class="text-right">
                                            <?php if ($row->discount != 0) : ?>
                                                <del><?= number_format($row->sell, 0, ',', '.') ?></del>
                                                <?php
                                                $diskon = ($row->discount / 100) * $row->sell;
                                                echo number_format($row->sell - $diskon, 0, ',', '.')
                                                ?>
                                            <?php else : ?>
                                                <?= number_format($row->sell, 0, ',', '.') ?>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?= $amount[$count] ?>
                                        </td>
                                        <td class="text-right">
                                            <?php if ($row->discount != 0) : ?>
                                                <?php
                                                $diskon = ($row->discount / 100) * $row->sell;
                                                echo rupiah(($row->sell - $diskon) * $amount[$count])
                                                ?>
                                            <?php else : ?>
                                                <?= rupiah($row->sell * $amount[$count]) ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php $count++ ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <table class="table" width="100%" style="border-left: 2px solid #DEE2E6; border-right: 2px solid #DEE2E6;">
                    <thead>
                    <tr>
                        <th class="text-right font-weight-bold">Total</th>
                        <th class="text-right">
                            <?= rupiah($total) ?>
                        </th>
                    </tr>
                    </thead>
                </table>
            </div>
            <div class="col col-md-3 mt-3">
                <input type="hidden" value="<?= $total ?>" name="subtotal" id="subtotal">
                <div class="form-group row">
                    <div class="col-md-6">Tanggal <span style="position: absolute; left: 80px;">:</span></div>
                    <div class="col-md-6 text-right"><?= $date ?></div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">Kasir <span style="position: absolute; left: 80px;">:</span></div>
                    <div class="col-md-6 text-right"><?= $user->employeeName ?></div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">Kode <span style="position: absolute; left: 80px;">:</span></div>
                    <div class="col-md-6 text-right"><?= $code ?></div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">Subtotal<span style="position: absolute; left: 80px;">:</span></div>
                    <div class="col-md-6 text-right subtotal"><?= rupiah($total) ?></div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">Distribusi <span style="position: absolute; left: 80px;">:</span></div>
                    <div class="col-md-6 text-right costDistribution">-</div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">Total<span style="position: absolute; left: 80px;">:</span></div>
                    <div class="col-md-6 text-right total font-weight-bold">-</div>
                </div>
                <div class="form-group">
                    <select name="distribution_id" id="distribution_id" class="form-control" required>
                        <option></option>
                        <?php foreach ($distribution as $row) : ?>
                            <option value="<?= $row->id; ?>"><?= $row->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control form-control-sm payOder" disabled name="pay"
                           placeholder="Bayar" autocomplete="off"/>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control form-control-sm change" name="change" placeholder="Kembalian"
                           readonly>
                </div>
                <div class="text-center my-3">
                    <a href="<?= base_url('cashier'); ?>" class="btn btn-danger"><i class="fas fa-reply"></i> Batal</a>
                    <button class="btn btn-primary btnPayOrder" disabled><i class="fas fa-paper-plane"></i> Simpan
                    </button>
                </div>
            </div>
        </div>
        <?= form_close(); ?>
    </div>
</div>

<?= $this->include('templates/cashier/footer'); ?>

<script>
    $(document).ready(function () {
        $('#tblCheckOrder').DataTable({
            scrollY: "333px",
            scrollX: false,
            scrollCollapse: true,
            paging: false,
            responsive: true,
            "bInfo": false,
            searching: false,
            info: false,
            oLanguage: oLanguageDt(),
            'order': [],
            'columnDefs': [{
                "orderable": false,
                "targets": [0, 2, 4, 5, 6, 7]
            },
                {
                    "orderable": true,
                    "targets": [1, 3]
                },
                {
                    className: "text-center align-middle",
                    targets: [0, 2, 3, 4, 6]
                },
                {
                    className: "align-middle text-right",
                    targets: [5, 7]
                },
            ],
        })

        setSelect2('#distribution_id', Infinity, "Pilih Distribusi", true);

        $('#distribution_id').change(function () {
            const val = $(this).val();
            const total = parseInt($('.subtotal').text().replace('.', ''));

            if (val === '') {
                $('.costDistribution').text('-');
                $('.total').text('-');
                $('.payOder').attr('disabled', true);
                return false;
            }

            $('.payOder').val('');
            $('.change').val('');

            setAjax("<?= route_to('getDistributionCashier') ?>", 'post', {id: val}, function (response) {
                const cost = parseInt(response.cost) + total;
                $('.costDistribution').text(formatRupiah(response.cost));
                $('.total').text(formatRupiah(cost.toString()));
            })

            $('.payOder').attr('disabled', false);
        })

        $('.payOder').keyup(function (e) {
            const val = $(this).val();
            $(this).val(formatRupiah(val));
            payOrder(val, e);
        })

        $('.saveTransaction').submit(function(e) {
            e.preventDefault();

            questionSweetAlert('Yakin', 'Mau melakukan proses pembayaran', 'question').then((result) => {
                if (result.isConfirmed) {
                    saveOrder($(this).attr('action'), $(this).attr('method'), $(this).serialize());
                }
            })
        })
    })

    const payOrder = (val, e) => {
        const subtotal = parseInt($('.total').text().replace('.', ''));
        const pay = parseInt(val.replace('.', ''));
        const key = e.keyCode || e.charCode;

        if (key === 8 || key === 46) {
            $('.payOder').val('');
        }

        if (pay >= subtotal) {
            $('.change').val(formatRupiah((pay - subtotal).toString()));
            $('.btnPayOrder').attr('disabled', false);
        } else {
            $('.change').val('');
            $('.btnPayOrder').attr('disabled', true);
        }
    }

    const saveOrder = (url, type, data) => {
        setAjax(url, type, data, function() {
            Swal.fire({
                title: "<strong><u>Pembayaran Berhasil</u></strong>",
                icon: "success",
                html: `Silahkan cetak invoice pembayaran`,
                allowOutsideClick: false,
                confirmButtonText: `<i class="fa fa-print"></i> Print`,
            }).then((result) => {
                if (result.isConfirmed) {
                    // Print invoice
                    alert('👉 Segera dibuat. Terima Kasih.....😁')
                }
            }) ;
            //simpleSweetAlert('success', 'Berhasil', 'Pembayaran dilakukan').then(() => {
            //    window.location.href = '<?php //= route_to("indexCashier") ?>//';
            //})
        })
    }
</script>