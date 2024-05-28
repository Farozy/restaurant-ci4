<style>
    .table tr {
        font-size: 15px;
    }
</style>
<div class="modal fade" id="detailModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
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
                <h5 class="text-center font-weight-bold"><?= $menu->name ?></h5>
                <div class="row mt-3">
                    <div class="col-md-4 text-center">
                        <img src="<?= base_url('uploads/images/menu') . '/' . $menu->image; ?>"
                             style="width: 150px; height: 190px;" alt="image">
                    </div>
                    <div class="col-md-8">
                        <table class="table">
                            <tr>
                                <th>Diskon</th>
                                <td class="text-right">
                                    <?php if ($menu->discount != 0) : ?>
                                        <?= $menu->discount ?>%
                                    <?php else : ?>
                                        0
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Harga Pokok</th>
                                <td class="text-right">
                                    <?= rupiah($menu->cost) ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Harga Jual</th>
                                <td class="text-right">
                                    <?php if ($menu->discount != 0) : ?>
                                        <del><?= rupiah($menu->sell) ?></del>
                                        <?php
                                        $discount = ($menu->discount / 100) * $menu->sell;
                                        echo rupiah($menu->sell - $discount)
                                        ?>
                                    <?php else : ?>
                                        <?= rupiah($menu->sell) ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td class="text-right"><?= ucwords($menu->categoryName) ?></td>
                            </tr>
                            <tr>
                                <th>Stok</th>
                                <td class="text-right">
                                    <?php $stockColor ?>
                                    <?php if ($menu->stock >= 10) : ?>
                                        <?php $stockColor = 'primary' ?>
                                    <?php elseif ($menu->stock >= 5 && $menu->stock < 10) : ?>
                                        <?php $stockColor = 'warning' ?>
                                    <?php else : ?>
                                        <?php $stockColor = 'danger' ?>
                                    <?php endif; ?>
                                    <span class="badge badge-<?= $stockColor ?>"><?= rupiah($menu->stock) ?></span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>