<?= $this->extend('auth/templates/main') ?>

<?= $this->section('content'); ?>

<!-- <div class="card-header text-center">
    <h2 class="sr-only">Login Form</h2>
</div> -->
<div class="card-body">
    <form action="<?= route_to('attemptLogin') ?>" method="post">
        <?= csrf_field() ?>
        <div class="illustration"><i class="icon ion-android-restaurant"></i></div>
        <?php if ($config->validFields === ['email']) : ?>
            <div class="form-group">
                <input class="form-control" type="email" name="login" placeholder="<?= lang('Auth.email') ?>" autofocus required="" oninvalid="this.setCustomValidity('Field username / email belum diisi')" oninput="setCustomValidity('')" autocomplete="off" />
            </div>
        <?php else : ?>
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="login" placeholder="<?= lang('Auth.emailOrUsername') ?>" autofocus required="" oninvalid="this.setCustomValidity('Field username / email belum diisi')" oninput="setCustomValidity('')" autocomplete="off" />
            </div>
        <?php endif; ?>
        <div class="form-group">
            <input class="form-control" type="password" name="password" placeholder="Password" required="" oninvalid="this.setCustomValidity('Field password belum diisi')" oninput="setCustomValidity('')">
        </div>
        <div class="row">
            <?php if ($config->allowRemembering) : ?>
                <div class="col-8">
                    <div class="icheck-primary">
                        <input type="checkbox" name="remember" class="form-check-input" <?php if (old('remember')) : ?> checked <?php endif ?>>
                        <label for="remember">
                            <?= lang('Auth.rememberMe') ?>
                        </label>
                    </div>
                </div>
                <div class="col-4">
                    <!-- <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.loginAction') ?></button> -->
                </div>
            <?php else : ?>
                <div class="col-4 offset-4">
                    <!-- <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.loginAction') ?></button> -->
                </div>
            <?php endif; ?>
            <!-- /.col -->
            <!-- /.col -->
        </div>
        <div class="form-group" style="margin-top: -20px;">
            <button class="btn btn-primary btn-block" type="submit"><?= lang('Auth.loginAction') ?></button>
        </div>
        <!-- <a href="" class="forgot">Forgot your email or password?</a> -->
    </form>
</div>
<!-- /.card-body -->

<?= $this->endSection(); ?>