<div class="modal fade" id="addModal" data-backdrop="static">
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
            <?= form_open(route_to('savePermission'), ['class' => 'formSave']); ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name" class="col-form-label">Nama</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-code"></i></span>
                        </div>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                    <small class="text-danger errorName"></small>
                </div>
                <div class="form-group">
                    <label for="name" class="col-form-label">Keterangan</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                        </div>
                        <input type="text" name="description" id="description" class="form-control">
                    </div>
                    <small class="text-danger errorDescription"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="simpan">
                    <i class="fas fa-save"> <span class='d-none d-lg-inline-flex'> Simpan</span></i>
                </button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.formSave').submit(function (e) {
            e.preventDefault();

            setAjax($(this).attr("action"), $(this).attr("method"), $(this).serialize(), function (response) {
                if (response.length === undefined) {
                    $('.errorName').html(response.name);
                    $('.errorDescription').html(response.description);
                    return false;
                }

                simpleSweetAlert('success', 'Permission berhasil disimpan').then(() => {
                    $('.viewData').html(response);
                    $('#addModal').modal('hide');
                })
            })
        })
    })
</script>