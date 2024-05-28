<?= $this->include('templates/cashier/header'); ?>
<div class="card" style="height: 36.8em;">
    <div class="card-header text-center" style="border-radius: 20px;">
        <h1 class="font-weight-bold"><u>Ubah Password</u></h1>
    </div>
    <?= form_open_multipart(route_to('updatePasswordCashier'), ['class' => 'updatePassword'], ['id' => $id]); ?>
    <?= csrf_field(); ?>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <div class="mb-3 row">
                    <label for="password" class="col-form-label col-md-4 text-sm-left text-md-left text-lg-right">Password Lama</label>
                    <div class="col">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-unlock"></i></span>
                            <input type="password" name="password" id="password" class="form-control"
                                   autocomplete="off">
                        </div>
                        <small class="text-danger errorPassword"></small>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="newPassword" class="col-form-label col-md-4 text-sm-left text-md-left text-lg-right">Password Baru</label>
                    <div class="col">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon2"><i class="fas fa-lock"></i></span>
                            <input type="password" name="newPassword" id="newPassword" class="form-control"
                                   autocomplete="off">
                        </div>
                        <small class="text-danger errorNewPassword"></small>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="confirmPassword" class="col-form-label col-md-4 text-sm-left text-md-left text-lg-right">Ulangi Password</label>
                    <div class="col">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon2"><i class="fas fa-lock"></i></span>
                            <input type="password" name="confirmPassword" id="confirmPassword" class="form-control">
                        </div>
                        <small class="text-danger errorConfirmPassword"></small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mx-auto">
                <div class="text-center">
                    <img id="previewFoto" src="<?= base_url('/uploads/images/user'); ?>/<?= $user->image ?>" alt="image"
                         class="img-fluid rounded" width="170" style="height: 150px">
                </div>
            </div>
        </div>
        <div class="mb-3 text-center">
            <a href="<?= base_url('cashier') ?>" class="btn btn-danger">
                <i class="fas fa-arrow-left"></i> Batal
            </a>
            <button class="btn btn-warning" id="btnUpdatePassword">
                <i class="fas fa-edit"></i> Update
            </button>
        </div>
        <?= form_close(); ?>
    </div>
</div>

<?= $this->include('templates/cashier/footer') ?>

<script>
    $(function () {
        $('.updatePassword').submit(function (e) {
            e.preventDefault();

            setAjax($(this).attr('action'), 'post', $(this).serialize(), function (response) {
                if (response.title === 'password') {
                    $('.errorPassword').html(response.password);
                } else if (response.title === 'new password' || response.length === undefined) {
                    $('.errorPassword').html(response.password);
                    $('.errorNewPassword').html(response.newPassword);
                    $('.errorConfirmPassword').html(response.confirmPassword);
                }

                if (response.icon === 'success') {
                    simpleSweetAlert(response.icon, response.text).then(() => {
                        location.reload();
                    })
                }
            })
        })
    })
</script>

</body>

</html>