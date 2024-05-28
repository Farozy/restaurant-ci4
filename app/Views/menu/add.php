<?= $this->extend('templates/main'); ?>

<?= $this->section('content'); ?>

    <div class="card">
        <div class="card-header text-center">
            <h2 class="font-weight-bold">
                <?= $sub_title; ?>
            </h2>
        </div>
        <div class="card-body">
            <?= form_open_multipart(route_to('saveMenu')); ?>
            <?= csrf_field(); ?>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name" class="col-form-label">Nama</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-sticky-note"></i></span>
                            </div>
                            <input type="text" name="name" id="name"
                                   class="form-control <?= $validation->hasError('name') ? 'is-invalid' : ''; ?>"
                                   value="<?= old('name'); ?>" placeholder="Nama">
                            <div class="<?= $validation->hasError('name') ? 'invalid-feedback' : ''; ?>">
                                <?= $validation->getError('name'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="category_id" class="col-form-label">Pilih Kategori</label>
                        <select name="category_id" id="category_id"
                                class="form-control <?= $validation->hasError('category_id') ? 'is-invalid' : ''; ?>">
                            <option></option>
                            <?php foreach ($category as $row) : ?>
                                <option value="<?= $row->id; ?>"><?= $row->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="<?= $validation->hasError('category_id') ? 'invalid-feedback' : '' ?>">
                            <?= $validation->getError('category_id'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="stock" class="col-form-label">Stok</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-archive"></i></span>
                            </div>
                            <input type="text" name="stock" id="stock" placeholder="Stok"
                                   class="form-control tl <?= $validation->hasError('stock') ? 'is-invalid' : ''; ?>"
                                   value="<?= old('stock'); ?>">
                            <div class="<?= $validation->hasError('stock') ? 'invalid-feedback' : ''; ?>">
                                <?= $validation->getError('stock'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="cost" class="col-form-label">Harga Pokok</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><b>Rp.</b></span>
                            </div>
                            <input type="text" name="cost" id="cost" placeholder="Harga Pokok"
                                   class="form-control price <?= $validation->hasError('cost') ? 'is-invalid' : ''; ?>"
                                   value="<?= old('cost'); ?>">
                            <div class="<?= $validation->hasError('cost') ? 'invalid-feedback' : ''; ?>">
                                <?= $validation->getError('cost'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sell" class="col-form-label">Harga Jual</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><b>Rp.</b></span>
                            </div>
                            <input type="text" name="sell" id="sell" placeholder="Harga Jual"
                                   class="form-control price <?= $validation->hasError('sell') ? 'is-invalid' : ''; ?>"
                                   value="<?= old('sell'); ?>">
                            <div class="<?= $validation->hasError('sell') ? 'invalid-feedback' : ''; ?>">
                                <?= $validation->getError('sell'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="discount" class="col-form-label">Diskon</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-percent"></i></span>
                                    </div>
                                    <input type="number" min="0" max="100" name="discount" id="discount"
                                           class="form-control" value="<?= old('discount') ?>" readonly
                                           placeholder="Diskon">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="result" class="col-form-label">Hasil</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-clipboard-check"></i></span>
                                    </div>
                                    <input type="text" id="result"
                                           class="form-control" disabled placeholder="Hasil">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <h5 class="font-weight-bold text-center mt-2">Gambar</h5>
                    <div class="text-center">
                        <img id="previewImage" src="<?= base_url('/uploads/images/default'); ?>/no-photo.png"
                             alt="image" class="img-fluid rounded" width="170" style="height: 150px">
                    </div>
                    <div class="mb-3 mt-2">
                        <input type="file"
                               class="form-control <?= $validation->hasError('image') ? 'is-invalid' : '' ?>"
                               id="buttonImage" name="image" style="display:none">
                        <button type="button" class="btn btn-secondary btn-sm mx-auto d-block"
                                onclick="document.getElementById('buttonImage').click()">Pilih Gambar
                        </button>
                        <small class="<?= $validation->hasError('image') ? 'text-danger' : '' ?> errorFoto">
                            <?= $validation->getError('image') ?>
                        </small>
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <a href="<?= route_to('indexMenu') ?>" class="btn btn-danger"><i class="fas fa-reply"> <span class='d-none d-lg-inline-flex'> Batal</span></i></a>
                <button class="btn btn-primary"><i class="fas fa-save"></i> <span class='d-none d-lg-inline-flex'> Simpan</span>
                </button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#datepicker').datetimepicker({
                format: "DD-MM-YYYY",
                useCurrent: false
            })

            $('.fa-calendar').click(function () {
                $("#datepicker").datetimepicker('show');
            });

            setSelect2('#category_id', Infinity, 'Pilih Kategori', true);

            $('.price').on('keyup', function () {
                const result = formatRupiah($(this).val());

                $(this).val(result);
            });

            $('#sell, #cost').keyup(function () {
                let cost = $('#cost').val().replaceAll('.', '');
                let sell = $(this).val().replaceAll('.', '');

                if (cost !== '' && sell !== '') {
                    $('#discount').prop('readonly', false);
                    $('#discount').val(0)
                } else {
                    $('#discount').prop('readonly', true);
                    $('#discount').val('')
                }
            })

            $('#discount').keyup(function () {
                let value = $(this).val();
                const sell = $('#sell').val().replace(/\./g, "");
                if (value > 100) {
                    $(this).val('')
                }

                const result = sell - (sell * value) / 100;
                $('#result').val(formatRupiah(result.toString()));
            })
        })

        $("#buttonImage").change(function () {
            previewImage(this);
        });
    </script>
<?= $this->endSection(); ?>