<div class="card mx-3">
    <div class="card-header text-center">
        <div class="h2 font-weight-bold"><?= $title; ?></div>
    </div>
    <div class="card-body">
        <?= form_open_multipart(route_to('saveProfile'), [], ['logoLama' => $logo['description'] ?? '']) ?>
        <div class="row">
            <div class="col-md-8">
                <div class="form-group row">
                    <label for="name" class="col-form-label col-md-3 font-weight-bold">Nama Restoran</label>
                    <div class="col">
                        <input class="form-control" id="name" name="name" autocomplete="off" required
                               value="<?= $name['description'] ?? old('name'); ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="address" class="col-form-label col-md-3 font-weight-bold my-auto">Alamat</label>
                    <div class="col">
                        <textarea name="address" id="address"
                                  class="form-control"><?= $address['description'] ?? old('address'); ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="district" class="col-form-label col-md-3 font-weight-bold">Kecamatan</label>
                    <div class="col">
                        <input class="form-control" id="district" name="district" autocomplete="off" required
                               value="<?= $district['description'] ?? old('district'); ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="regency" class="col-form-label col-md-3 font-weight-bold">Kabupaten</label>
                    <div class="col">
                        <input class="form-control" id="regency" name="regency" autocomplete="off" required
                               value="<?= $regency['description'] ?? old('regency'); ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="phone" class="col-form-label col-md-3 font-weight-bold">Telepon</label>
                    <div class="col">
                        <input class="form-control" id="phone" name="phone" autocomplete="off" required
                               value="<?= $phone['description'] ?? old('phone'); ?>">
                    </div>
                </div>
            </div>
            <div class="col-md-4 mx-auto">
                <h5 class="header-title font-weight-bold">Logo</h5>
                <div class="text-center">
                    <img id="previewImage"
                         src="<?= base_url(); ?>/uploads/images/icon/<?= !empty($logo['description']) ? $logo['description'] : 'logo_restaurant.png'; ?>"
                         alt="image" class="img-fluid rounded" width="170" style="height: 170px">
                </div>
                <div class="form-group">
                    <label for="inputZip" class="col-form-label">Upload Logo</label>
                    <input type="file" class="form-control" id="buttonImage" name="logo">
                </div>
            </div>
        </div>
        <div class="form-group text-center">
            <?php if (isset($name['description'])) : ?>
                <a href="<?= route_to('deleteProfile') ?>" class="btn btn-danger">
                    <i class="fas fa-trash"> <span class='d-none d-lg-inline-flex'> Hapus</span></i>
                </a>
                <button class="btn btn-warning">
                    <i class="fas fa-retweet"> <span class='d-none d-lg-inline-flex'> Update</span></i>
                </button>
            <?php else : ?>
                <button type="reset" class="btn btn-danger">
                    <i class="fas fa-trash-alt"><span class='d-none d-lg-inline-flex'> Reset</span></i>
                </button>
                <button class="btn btn-primary">
                    <i class="fas fa-save"> <span class='d-none d-lg-inline-flex'> Simpan</span></i>
                </button>
            <?php endif; ?>
        </div>
        <?= form_close() ?>
    </div>
</div>
<script>
    $("#buttonImage").change(function () {
        previewImage(this);
    });
</script>