<div class="modal fade" id="detailModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-light">
                <h4 class="modal-title"><?= $title ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-md-4">
                        <h6><b>Kasir: <?= $trans['nama_karyawan'] ?></b></h6>
                    </div>
                    <div class="col-md-4 text-center">
                        <h6><b>No. Pesanan: <?= $trans['no_pesanan'] ?></b></h6>
                    </div>
                    <div class="col-md-4 text-right">
                        <h6><b>Tanggal: <?= date('d-m-Y', strtotime($trans['tanggal_pesanan'])) ?></b></h6>
                    </div>
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Nama Menu</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">Diskon</th>
                            <th class="text-center">Harga</th>
                            <th class="text-center">Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transaksi as $x => $row) : ?>
                            <tr>
                                <td class="text-center"><?= $x + 1 ?></td>
                                <td><?= $row['nama_menu'] ?></td>
                                <td class="text-center"><?= $row['jumlah'] ?></td>
                                <td class="text-center"><?= $row['diskon'] != 0 ? $row['diskon'] . '%' : '0'; ?></td>
                                <td class="text-right">
                                    <?php if ($row['diskon'] != 0) : ?>
                                        <del><?= number_format($row['jumlah'] * $row['harga_jual'], 0, ',', '.') ?></del>
                                        <?php
                                        $diskon = ($row['diskon'] / 100) * $row['harga_jual'];
                                        echo number_format($row['harga_jual'] - $diskon, 0, ',', '.')
                                        ?>
                                    <?php else : ?>
                                        <?php
                                        $diskon = ($row['diskon'] / 100) * $row['harga_jual'];
                                        echo number_format($row['harga_jual'] - $diskon, 0, ',', '.')
                                        ?>
                                    <?php endif; ?>
                                </td>
                                <td class="text-right">
                                    <?php if ($row['diskon'] != 0) : ?>
                                        <?php
                                        $diskon = ($row['diskon'] / 100) * $row['harga_jual'];
                                        $harga = $row['harga_jual'] - $diskon;
                                        echo number_format($row['jumlah'] * $harga, 0, ',', '.')
                                        ?>
                                    <?php else : ?>
                                        <?= number_format($row['jumlah'] * $row['harga_jual'], 0, ',', '.') ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tr>
                        <th colspan="5" class="text-center">Total</th>
                        <th class="text-right">Rp. <?= number_format($row['sub_total'], 0, ',', '.') ?></th>
                    </tr>
                    <tr>
                        <th colspan="5" class="text-center">Bayar</th>
                        <th class="text-right">Rp. <?= number_format($row['bayar'], 0, ',', '.') ?></th>
                    </tr>
                    <tr>
                        <th colspan="5" class="text-center">Kembalian</th>
                        <th class="text-right">Rp. <?= number_format($row['kembalian'], 0, ',', '.') ?></th>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button> -->
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>