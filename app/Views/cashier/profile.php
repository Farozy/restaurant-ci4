<?= $this->include('templates/cashier/header'); ?>
    <div class="card" style="height: 36.8em;">
        <div class="card-header text-center" style="border-radius: 20px;">
            <h1 class="font-weight-bold"><u>Profile</u></h1>
        </div>
        <?= form_open_multipart(route_to('updateProfileCashier'), ['class' => 'formUpdate'], ['id' => $id, 'oldImage' => $user->image, 'employee_id' => $employee->id]); ?>
        <?= csrf_field(); ?>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3 row">
                        <label for="employee" class="col-form-label col-md-4 text-sm-left text-md-left text-lg-right">Nama</label>
                        <div class="col">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-file"></i></span>
                                <input type="text" name="employee" id="employee" class="form-control"
                                       value="<?= $employee->name ?>" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email" class="col-form-label col-md-4 text-sm-left text-md-left text-lg-right">Email</label>
                        <div class="col">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-at"></i></span>
                                <input type="text" name="email" id="email" class="form-control" autocomplete="off"
                                       value="<?= $user->email ?>" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="username" class="col-form-label col-md-4 text-sm-left text-md-left text-lg-right">Username</label>
                        <div class="col">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                                <input type="text" name="username" id="username" class="form-control" autocomplete="off"
                                       value="<?= $user->username ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mx-auto">
                    <h5 class="header-title font-weight-bold">Foto</h5>
                    <div class="text-center">
                        <img id="previewImage" src="<?= base_url('/uploads/images/user'); ?>/<?= $user->userImage ?>"
                             alt="image"
                             class="img-fluid rounded" width="170" style="height: 150px">
                    </div>
                    <div class="mb-3 mt-2 text-center" style="margin: 0 0 15px 32.5%;">
                        <input type="file"
                               class="form-control <?= $validation->hasError('image') ? 'is-invalid' : '' ?>"
                               id="btnImage" name="image" style="display:none">
                        <button type="button" style="display:block;" class="btn btn-secondary btn-sm"
                                onclick="document.getElementById('btnImage').click()">Pilih Foto
                        </button>
                        <small class="<?= $validation->hasError('image') ? 'text-danger' : '' ?> errorFoto">
                            <?= $validation->getError('image') ?>
                        </small>
                    </div>
                    <div class="mb-3 text-center">
                        <a href="<?= base_url('cashier') ?>" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
                            Kembali</a>
                        <button class="btn btn-warning"><i class="fas fa-retweet"></i> Update</button>
                    </div>
                </div>
            </div>
        </div>
        <?= form_close(); ?>
    </div>

    <script>
        $(function () {
            $("#btnImage").change(function () {
                previewImage(this);
            });
        })
    </script>

<?= $this->include('templates/cashier/footer') ?>