<style>
	.col-form-label {
		text-align: right;
	}

	.row .col .input-group {
		width: 85%;
	}

	@media screen and (max-device-width: 768px) {
		.col-form-label {
			text-align: left;
		}

		.row .col .input-group {
			width: 100%;
		}
	}
</style>
<div class="modal fade" id="ubahPassModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><?= $title ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?= form_open('User/simpanUbahPassword', ['class' => 'UbahPassword'], ['id' => $user->id]); ?>
			<?= csrf_field(); ?>
			<div class="modal-body">
				<div class="container">
					<div class="mb-3 row">
						<label for="passwordLama" class="col-form-label col-md-4">Password Lama</label>
						<div class="col">
							<div class="input-group">
								<span class="input-group-text" id="fullname"><i class="fas fa-unlock"></i></span>
								<input type="password" name="passwordLama" id="passwordLama" class="form-control" autocomplete="off">
							</div>
							<div class="errorpasswordlama">
								<div class="errorPasswordLama"></div>
							</div>
						</div>
					</div>
					<div class="mb-3 row">
						<label for="passwordBaru" class="col-form-label col-md-4">Password Baru</label>
						<div class="col">
							<div class="input-group">
								<span class="input-group-text" id="basic-addon2"><i class="fas fa-lock"></i></span>
								<input type="password" name="passwordBaru" id="passwordBaru" class="form-control" autocomplete="off">
							</div>
							<div class="errorpasswordbaru">
								<div class="errorPasswordBaru"></div>
							</div>
						</div>
					</div>
					<div class="mb-3 row">
						<label for="passwordUlang" class="col-form-label col-md-4">Ulangi Password</label>
						<div class="col">
							<div class="input-group">
								<span class="input-group-text" id="basic-addon2"><i class="fas fa-lock"></i></span>
								<input type="password" name="passwordUlang" id="passwordUlang" class="form-control">
							</div>
							<div class="errorpasswordulang">
								<div class="errorPasswordUlang"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button class="btn btn-primary" id="simpanUbahPassword">Simpan</button>
			</div>
			<?= form_close() ?>
		</div>
	</div>
</div>

<script>
	$(function() {
		$('.UbahPassword').submit(function() {
			$.ajax({
				url: $(this).attr('action'),
				type: 'post',
				data: $(this).serialize(),
				dataType: 'json',
				beforeSend: function() {
					$('#simpanUbahPassword').html('<i class="fas fa-circle-notch fa-spin"></i>');
				},
				complete: function() {
					$('#simpanUbahPassword').html('Simpan');
				},
				success: function(response) {
					if (response.errors) {
						if (response.errors.passwordLama) {
							$('#passwordLama').addClass('is-invalid');
							$('.errorPasswordLama').addClass('invalid-feedback');
							$('.errorPasswordLama').css('display', 'block');
							$('.errorPasswordLama').html(response.errors.passwordLama)
						} else {
							$('.errorPasswordLama').css('display', 'none');
							$('#passwordLama').removeClass('is-invalid');
						}

						if (response.errors.passwordBaru) {
							$('#passwordBaru').addClass('is-invalid');
							$('.errorPasswordBaru').addClass('invalid-feedback');
							$('.errorPasswordBaru').css('display', 'block');
							$('.errorPasswordBaru').html(response.errors.passwordBaru)
						} else {
							$('.errorPasswordBaru').css('display', 'none');
							$('#passwordBaru').removeClass('is-invalid');
						}

						if (response.errors.passwordUlang) {
							$('#passwordUlang').addClass('is-invalid');
							$('.errorPasswordUlang').addClass('invalid-feedback');
							$('.errorPasswordUlang').css('display', 'block');
							$('.errorPasswordUlang').html(response.errors.passwordUlang)
						} else {
							$('.errorPasswordUlang').css('display', 'none');
							$('#passwordUlang').removeClass('is-invalid');
						}
						window.setTimeout(function() {
							$('.errorPasswordLama').fadeTo(1500, 0).fadeTo(1500, 0).slideUp(1500, function() {
								$('#passwordLama').removeClass('is-invalid');
								$('.errorPasswordLama').remove();
								$('.errorpasswordlama').append(
									`<div class="errorPasswordLama"></div>`
								)
							})
							$('.errorPasswordBaru').fadeTo(1500, 0).fadeTo(1500, 0).slideUp(1500, function() {
								$('#passwordBaru').removeClass('is-invalid');
								$('.errorPasswordBaru').remove();
								$('.errorpasswordbaru').append(
									`<div class="errorPasswordBaru"></div>`
								)
							})
							$('.errorPasswordUlang').fadeTo(1500, 0).fadeTo(1500, 0).slideUp(1500, function() {
								$('#passwordUlang').removeClass('is-invalid');
								$('.errorPasswordUlang').remove();
								$('.errorpasswordulang').append(
									`<div class="errorPasswordUlang"></div>`
								)
							})
						}, 3000);
					} else {
						if (response.data.icon == 'error') {
							Swal.fire({
								icon: response.data.icon,
								title: response.data.text,
								showConfirmButton: false,
								timer: 2000
							})
						} else {
							Swal.fire({
								icon: response.data.icon,
								title: response.data.text,
								showConfirmButton: false,
								timer: 2000
							})
							if (response.data.view != null) {
								$('#ubahPassModal').modal('hide');
								window.location.href = '<?= base_url('logout'); ?>'
							}
						}
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
				}
			})
			return false;
		})
	})
</script>