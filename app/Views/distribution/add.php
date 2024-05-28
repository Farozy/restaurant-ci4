<div class="modal fade" id="addModal">
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
            <?= form_open(route_to('saveDistribution'), ['class' => 'formSave']); ?>
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
                    <label for="cost" class="col-form-label">Harga</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-coins"></i></span>
                        </div>
                        <input type="text" name="cost" id="cost" class="form-control">
                    </div>
                    <small class="text-danger errorCost"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"> <span class='d-none d-lg-inline-flex'> Simpan</span></i>
                </button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#cost').on('keyup', function () {
            let number = $(this).val();

            $(this).val(formatRibuan(number));
        });

        $('.formSave').submit(function(e) {
            e.preventDefault();

            setAjax($(this).attr("action"), $(this).attr("method"), $(this).serialize(), function(response) {
                if(response.length === undefined) {
                    $('.errorName').html(response.name);
                    $('.errorCost').html(response.cost);
                    return false;
                }

                simpleSweetAlert('success', 'Distribusi berhasil disimpan').then(() => {
                    $('.viewData').html(response);
                    $('#addModal').modal('hide');
                })
            })
        })
    })
</script>