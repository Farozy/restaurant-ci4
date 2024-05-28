<?= $this->extend('templates/main') ?>

<?= $this->section('content') ?>

    <div class="card">
        <div class="card-body">
            <?= form_open_multipart(route_to('saveEmployee')) ?>
            <?= csrf_field(); ?>
            <div class="row">
                <div class="col-12 col-sm-8">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Karyawan</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text"
                                   class="form-control <?= $validation->hasError('name') ? 'is-invalid' : ''; ?>"
                                   name="name" placeholder="Nama" aria-label="name" aria-describedby="name" id="name"
                                   value="<?= old('name') ?>">
                        </div>
                        <div class="<?= $validation->hasError('name') ? 'text-danger small' : '' ?>">
                            <?= $validation->getError('name'); ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <div class="input-group">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input gender <?= $validation->hasError('gender') ? 'is-invalid' : ''; ?>"
                                       type="radio" name="gender" id="male" value="male">
                                <label class="form-check-label" for="male">Laki-laki</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input gender <?= $validation->hasError('gender') ? 'is-invalid' : ''; ?>"
                                       type="radio" name="gender" id="female" value="female">
                                <label class="form-check-label" for="female">Perempuan</label>
                            </div>
                        </div>
                        <div class="<?= $validation->hasError('gender') ? 'text-danger small' : '' ?>">
                            <?= $validation->getError('gender'); ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="datepicker" class="form-label">Tanggal Lahir</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></i></span>
                            <input type="text" id="datepicker" data-toggle="datetimepicker"
                                   class="form-control <?= $validation->hasError('date_of_birth') ? 'is-invalid' : ''; ?>"
                                   autocomplete="off" data-target="#datepicker" name="date_of_birth"
                                   value="<?= old('date_of_birth') ?>" placeholder="Tanggal Lahir">
                        </div>
                        <div class="<?= $validation->hasError('date_of_birth') ? 'text-danger small' : '' ?>">
                            <?= $validation->getError('date_of_birth'); ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="place_of_birth">Tempat Lahir</label>
                        <div class="input-group">
                            <span class="input-group-text"><i
                                        class="fas fa-location-arrow"></i></span>
                            <input type="text"
                                   class="form-control <?= $validation->hasError('place_of_birth') ? 'is-invalid' : ''; ?>"
                                   name="place_of_birth" id="place_of_birth" value="<?= old('place_of_birth') ?>"
                                   placeholder="Tempat Lahir">
                        </div>
                        <div class="<?= $validation->hasError('place_of_birth') ? 'text-danger small' : '' ?>">
                            <?= $validation->getError('place_of_birth'); ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Telepon</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-address-book"></i></span>
                            <input type="text"
                                   class="form-control <?= $validation->hasError('phone') ? 'is-invalid' : ''; ?>"
                                   name="phone" id="phone" placeholder="Telepon" aria-label="phone"
                                   aria-describedby="phone" value="<?= old('phone') ?>">
                        </div>
                        <div class="<?= $validation->hasError('phone') ? 'text-danger small' : '' ?>">
                            <?= $validation->getError('phone'); ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="text"
                                   class="form-control <?= $validation->hasError('email') ? 'is-invalid' : ''; ?>"
                                   name="email" id="email" placeholder="Email" aria-label="email"
                                   aria-describedby="email" value="<?= old('email') ?>">
                        </div>
                        <div class="<?= $validation->hasError('email') ? 'text-danger small' : '' ?>">
                            <?= $validation->getError('email'); ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                            <textarea class="form-control" id="address" name="address"><?= old('address') ?></textarea>
                        </div>
                        <div class="<?= $validation->hasError('address') ? 'text-danger small' : '' ?>">
                            <?= $validation->getError('address'); ?>
                        </div>
                    </div>
                </div>
                <div class="col col-sm-4">
                    <div class="mb-3">
                        <h5 class="font-weight-bold text-center mt-2">Foto</h5>
                        <div class="text-center">
                            <img id="previewImage" src="<?= base_url('/uploads/images/default'); ?>/no-photo.png"
                                 alt="image" class="img-fluid rounded" width="170" style="height: 150px">
                        </div>
                        <div class="mb-3 mt-2">
                            <input type="file"
                                   class="form-control <?= $validation->hasError('image') ? 'is-invalid' : '' ?>"
                                   id="btnImage" name="image" style="display:none">
                            <button type="button" class="btn btn-secondary btn-sm mx-auto d-block"
                                    onclick="document.getElementById('btnImage').click()">Pilih Foto
                            </button>
                            <small class="<?= $validation->hasError('image') ? 'text-danger' : '' ?> errorFoto">
                                <?= $validation->getError('image') ?>
                            </small>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <a href="<?= route_to('indexEmployee') ?>" class="btn btn-danger">
                            <i class="fas fa-reply"> <span class='d-none d-lg-inline-flex'> Batal</span></i>
                        </a>
                        <button class="btn btn-primary">
                            <i class="fas fa-save"> <span class='d-none d-lg-inline-flex'> Simpan</span></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?= form_close() ?>
    </div>

    <script>
        $(function () {
            $('.gender').change(function () {
                let foto;
                if ($(this).val() === 'male') {
                    foto = "<?= base_url() ?>/uploads/images/default/employee-male.png";
                } else {
                    foto = "<?= base_url() ?>/uploads/images/default/employee-female.png";
                }
                $('#previewImage').attr('src', foto);
            })

            $('#datepicker').datetimepicker({
                format: "DD-MM-YYYY",
                useCurrent: false
            })

            $('.fa-calendar').click(function () {
                $("#datepicker").datetimepicker('show');
            });
        })

        $("#btnImage").change(function () {
            previewImage(this);
        });
    </script>

<?= $this->endSection() ?>