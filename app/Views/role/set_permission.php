<?= $this->extend('templates/main'); ?>

<?= $this->section('content'); ?>

<div class="card">
    <?= form_open(route_to('savePermissionRole')) ?>
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-8 col-sm-10">
                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control" value="<?= $role->name ?>" disabled>
                        <input type="hidden" name="role" value="<?= $role->id ?>">
                    </div>
                </div>
            </div>
            <div class="col-4 col-sm-2 text-center mt-3">
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-retweet d-none d-sm-inline"></i> Update
                </button>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Permission</label>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="checkAllPermission">
                <label class="form-check-label" for="checkAllPermission">All</label>
            </div>
        </div>
        <?php foreach ($rolePermission as $name => $permiss) : ?>
            <div class="row" style="border-bottom: 1px solid #E9E9E9; border-top: 1px solid #E9E9E9;">
                <div class="col-3 my-auto py-1">
                    <div class="form-check">
                        <input class="form-check-input ckRole checkRole<?= $name ?>" type="checkbox"
                               onclick="handleRole('<?= $name ?>')">
                        <label class="form-check-label"><?= $name ?></label>
                    </div>
                </div>
                <div class="col pt-2">
                    <?php foreach ($permiss as $per) : ?>
                        <div class="mb-3">
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input checkPermission <?= $name ?>"
                                       value="<?= $per['id'] ?>"
                                       name="permissionId[]" <?= in_array($per['id'], $idGroupPermission) ? 'checked' : '' ?>
                                       id="<?= $per['permissionName'] ?>">
                                <label class="form-check-label"
                                       for="<?= $per['permissionName'] ?>"><?= $per['permissionName'] ?></label>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        <?php endforeach ?>
    </div>
    <?= form_close() ?>
</div>

<script>
    $(function () {
        $('#checkAllRole').click(function () {
            if (this.checked) {
                $('.ckRole').prop('checked', true);
            } else {
                $('.ckRole').prop('checked', false);
            }
        })

        $('#checkAllPermission').click(function () {
            if (this.checked) {
                $('.checkPermission').prop('checked', true);
            } else {
                $('.checkPermission').prop('checked', false);
            }
        })
    })

    function handleRole(name) {
        const checkRole = $(`.checkRole${name}`);
        if (checkRole.is(':checked')) {
            $(`.${name}`).prop('checked', true);
        } else {
            $(`.${name}`).prop('checked', false);
        }
    }
</script>

<?= $this->endSection(); ?>
