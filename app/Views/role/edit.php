<div class="modal fade" id="editModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title font-weight-bold"><?= $title; ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </button>
            </div>
            <?= form_open(route_to('updateRole'), ['class' => 'formUpdate'], ['id' => $role->id]); ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-code"></i></span>
                        </div>
                        <input type="text" name="name" id="name" class="form-control" value="<?= $role->name ?>"
                               autocomplete="off">
                    </div>
                    <small class="text-danger errorName"></small>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                        </div>
                        <input type="text" name="description" id="description" class="form-control"
                               value="<?= $role->description ?>" autocomplete="off">
                    </div>
                    <small class="text-danger errorName"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-warning" id="update">
                    <i class="fas fa-retweet"> <span class='d-none d-lg-inline-flex'> Update</span></i>
                </button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.formUpdate').submit(function (e) {
            e.preventDefault();

            setAjax($(this).attr("action"), $(this).attr("method"), $(this).serialize(), function (response) {
                if (response.length === undefined) {
                    $('.errorName').html(response.name);
                    $('.errorDescription').html(response.description);
                    return false;
                }

                simpleSweetAlert('success', 'Role berhasil diupdate').then(() => {
                    $('.viewData').html(response);
                    $('#editModal').modal('hide');
                })
            })
        })
    })
</script>