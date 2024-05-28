<div class="modal fade" id="detailModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?= $title ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <table class="table table-bordered table-striped table-hover">
                            <tr>
                                <th>Email</th>
                                <td><?= $user->email; ?></td>
                            </tr>
                            <tr>
                                <th>Username</th>
                                <td><?= $user->username ?></td>
                            </tr>
                            <tr>
                                <th>Role</th>
                                <td><?= ucwords(str_replace('_', ' ', $user->roleName)) ?></td>
                            </tr>
                            <tr>
                                <th>Status User</th>
                                <td>
                                    <?php if ($user->active != 1) : ?>
                                        <span class="badge bg-danger p-2">Tidak Aktif</span>
                                    <?php else : ?>
                                        <span class="badge bg-success p-2">Aktif</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col">
                        <h5 class="font-weight-bold">Foto</h5>
                        <div class="text-center">
                            <img src="<?= base_url('/uploads/images/user') ?>/<?= $user->image ?>" alt="image"
                                 class="img-fluid rounded" width="170" style="height: 170px">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="resetPassword(<?= $user->user_id; ?>)">
                    <i class="fas fa-trash-restore-alt"> Reset Password</i>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function UbahPass(id) {
        $.ajax({
            url: '<?= site_url('User/UbahPassword'); ?>',
            type: 'post',
            data: {
                id: id
            },
            dataType: 'json',
            beforeSend: function () {
                $('.ubah').html('<i class="fas fa-circle-notch fa-spin"></i>');
            },
            complete: function () {
                $('.ubah').html('Ubah Password');
            },
            success: function (response) {
                $('#detailModal').modal('hide');
                $('.modal-backdrop').hide();
                $('.viewModal').html(response.data);
                $('#ubahPassModal').modal('show');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    }

    function resetPassword(id) {
        questionSweetAlert('Peringatan !', 'Password akan direset & sama dengan username', 'question').then((result) => {
            if (result.isConfirmed) {
                setAjax('<?= base_url('user/reset-password'); ?>', 'post', {id}, function (response) {
                    simpleSweetAlert('success', 'Reset password user berhasil').then(() => {
                        if (result) {
                            $('#detailModal').modal('hide');
                            $('.viewData').html(response.data);
                        }
                    })
                })
            }
        })
    }
</script>