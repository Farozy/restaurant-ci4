<div class="modal fade" id="detailModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?= $title ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-7">
                        <table class="table table-bordered table-hover">
                            <tr>
                                <th>Nama</th>
                                <td><?= $employee->name ?></td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td><?= $employee->gender === 'male' ? 'Laki-laki' : 'Perempuan' ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal Lahir</th>
                                <td><?= format_day($employee->date_of_birth) ?></td>
                            </tr>
                            <tr>
                                <th>Tempat lahir</th>
                                <td><?= $employee->place_of_birth ?></td>
                            </tr>
                            <tr>
                                <th>Telepon</th>
                                <td><?= $employee->phone ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?= $employee->email ?></td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td><?= $employee->address ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col">
                        <h5 class="font-weight-bold">Foto</h5>
                        <div class="text-center">
                            <img src="<?= base_url() ?>/uploads/images/employee/<?= $employee->image ?>" alt="image"
                                 class="img-fluid rounded" width="170" style="height: 170px">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>