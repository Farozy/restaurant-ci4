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
            <?= form_open_multipart(route_to('updateUser'), [], ['id' => $user->id]); ?>
            <?= csrf_field(); ?>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3 row">
                            <label for="email" class="col-form-label col-md-3">Email</label>
                            <div class="col">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="text" name="email" id="email" class="form-control"
                                           autocomplete="off" readonly value="<?= $user->email ?>">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="username" class="col-form-label col-md-3">Username</label>
                            <div class="col">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-file-signature"></i></span>
                                    <input type="text" name="username" id="username" class="form-control"
                                           autocomplete="off" readonly value="<?= $user->username ?>">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="password" class="col-form-label col-md-3">password</label>
                            <div class="col">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    <input type="password" name="password" id="password" class="form-control" readonly
                                           value="<?= $user->username ?>">
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
                                        <option value="<?= $gr->id; ?>" <?= $user->group_id == $gr->id ? 'selected' : '' ?>>
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
                        <div class="text-center mb-3">
                            <img id="previewImage" src="<?= base_url('/uploads/images/user'); ?>/<?= $user->image ?>"
                                 alt="image" class="img-fluid rounded" width="170" style="height: 150px">
                        </div>
                        <div class="mb-3 text-center">
                            <a href="<?= route_to('indexUser') ?>" class="btn btn-danger"><i class="fas fa-reply"></i>
                                <span class='d-none d-lg-inline-flex'> Batal</span></a>
                            <button class="btn btn-warning"><i class="fas fa-retweet"></i> <span class='d-none d-lg-inline-flex'> Update</span></button>
                        </div>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>

    <script>
        $(function () {
            setSelect2('#group_id', Infinity, 'Pilih Role', true);
        })
    </script>

<?= $this->endSection(); ?>