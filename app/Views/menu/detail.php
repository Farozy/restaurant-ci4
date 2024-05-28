<div class="modal fade" id="detailModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?= $title ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-7">
                        <table class="table table-bordered table-hover">
                            <tr>
                                <th>Nama</th>
                                <td><?= $menu->name ?></td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td><?= $menu->category_name ?></td>
                            </tr>
                            <tr>
                                <th>Stok</th>
                                <td><?= $menu->stock ?></td>
                            </tr>
                            <tr>
                                <th>Pokok</th>
                                <td><?= rupiah($menu->cost) ?></td>
                            </tr>
                            <tr>
                                <th>Jual</th>
                                <td><?= rupiah($menu->sell) ?></td>
                            </tr>
                            <tr>
                                <th>Diskon</th>
                                <td><?= (int)$menu->discount !== 0 ? $menu->discount . '%' : '-' ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col">
                        <h5 class="font-weight-bold">Foto</h5>
                        <div class="text-center">
                            <img src="<?= base_url() ?>/uploads/images/menu/<?= $menu->image ?>" alt="image"
                                 class="img-fluid rounded" width="170" style="height: 170px">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>