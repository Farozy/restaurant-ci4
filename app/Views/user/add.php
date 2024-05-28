<?= $this->extend('templates/main'); ?>

<?= $this->section('content'); ?>
    <style>
        .col-form-label {
            text-align: right;
        }

        @media screen and (max-device-width: 768px) {
            .col-form-label {
                text-align: left;
            }
        }
    </style>
    <div class="container-fluid">
        <div class="card">
            <?= form_open_multipart(route_to('saveUser')); ?>
            <?= csrf_field(); ?>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3 row">
                            <label for="employee_id" class="col-form-label col-md-3">Karyawan</label>
                            <div class="col">
                                <select id="employee_id" class="form-control" name="employee_id">
                                    <option></option>
                                    <?php foreach ($employee as $row) : ?>
                                        <option value="<?= $row['id']; ?>"><?= $row['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="<?= $validation->hasError('employee_id') ? 'text-danger' : ''; ?>">
                                    <?= $validation->getError('employee_id'); ?>
                                </small>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="email" class="col-form-label col-md-3">Email</label>
                            <div class="col">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="text" name="email" id="email" class="form-control"
                                           autocomplete="off" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="username" class="col-form-label col-md-3">Username</label>
                            <div class="col">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-file-signature"></i></span>
                                    <input type="text" name="username" id="username" class="form-control"
                                           autocomplete="off" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="password" class="col-form-label col-md-3">password</label>
                            <div class="col">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    <input type="password" name="password" id="password" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="group_id" class="col-form-label col-md-3">Role</label>
                            <div class="col">
                                <select name="group_id" id="group_id"
                                        class="form-control <?= $validation->hasError('group_id') ? 'is-invalid' : ''; ?>">
                                    <option></option>
                                    <?php foreach ($group as $gr) : ?>
                                        <option value="<?= $gr->id; ?>"
                                            <?= set_select('group', $gr->id, old('group_id') == $gr->id); ?>>
                                            <?= ucwords(str_replace('_', ' ', $gr->name)); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="<?= $validation->hasError('group_id') ? 'text-danger' : ''; ?>">
                                    <?= $validation->getError('group_id'); ?>
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mx-auto">
                        <h5 class="header-title font-weight-bold">Foto</h5>
                        <div class="text-center">
                            <img id="previewImage" src="<?= base_url('/uploads/images/default'); ?>/no-photo.png"
                                 alt="image" class="img-fluid rounded" width="170" style="height: 150px">
                            <input type="hidden" name="id_employee" id="id_employee">
                        </div>
                        <div class="mb-3 mt-2 text-center">
                            <input type="file"
                                   class="form-control <?= $validation->hasError('image') ? 'is-invalid' : '' ?>"
                                   id="btnImage" name="image" style="display:none">
                            <button type="button" class="btn btn-secondary btn-sm mx-auto d-block"
                                    onclick="document.getElementById('btnImage').click()">Pilih Foto
                            </button>
                            <small class="<?= $validation->hasError('image') ? 'text-danger text-center' : '' ?> errorFoto">
                                <?= $validation->getError('image') ?>
                            </small>
                        </div>
                        <div class="mb-3 text-center">
                            <a href="<?= route_to('indexUser') ?>" class="btn btn-danger"><i class="fas fa-reply"></i>
                                <span class='d-none d-lg-inline-flex'> Batal</span></a>
                            <button class="btn btn-primary"><i class="fas fa-save"></i> <span class='d-none d-lg-inline-flex'> Simpan</span></button>
                        </div>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>

    <script>
        $(function () {
            setSelect2('#employee_id', false, 'Pilih Karyawan', true);
            setSelect2('#group_id', Infinity, 'Pilih Role', true);

            $('#employee_id').change(function () {
                let id = $(this).val();
                let image;

                setAjax('<?= base_url('user/getEmployee'); ?>', 'post', {id}, function (response) {
                    $('#email').val(response.email.replaceAll(' ', '_').toLowerCase());
                    $('#username').val(response.name.replaceAll(' ', '_').toLowerCase());
                    $('#password').val(response.name.replaceAll(' ', '_').toLowerCase());
                    $('#id_employee').val(response.id.replaceAll(' ', '_'));

                    const image = "<?= base_url('uploads/images/employee') ?>/" + response.image;
                    $('#previewImage').attr('src', image);
                })
            })

            $("#btnImage").change(function () {
                previewImage(this);
            });
        })
    </script>

<?= $this->endSection(); ?>