<?php
$id = encrypt_url($isi->id_nelayan);
$foto = $isi->foto ?: 'aset/img/belum_diupload.jpg';
$ktp = $isi->ktp ?: 'aset/img/no_berkas.jpg';
$npwp = $isi->npwp ?: 'aset/img/no_berkas.jpg';
$kusuka = $isi->kusuka ?: 'aset/img/no_berkas.jpg';
$nib = $isi->nib ?: 'aset/img/no_berkas.jpg';
?>
<div class="row">
	<div class="col-md-12">
		<div class="tile">
			<div class="title-page">
				<h3 class="tile-title"><i class="fa fa-list" aria-hidden="true"></i> DATA NELAYAN</h3>
				<div class="nav-back">
					<div class="btn-group" role="group" aria-label="Basic example"> <a href="javascript:;" class="btn btn-sm btn-danger btn-rounded" onClick="delete_data('<?php echo $id; ?>')"><i class="fa fa-close" aria-hidden="true"></i>Delete</a> <a href="<?php base_url(); ?>nelayan/cetak_pdf?q=<?php echo $id; ?>" class="btn btn-sm btn-warning" id="btn-close"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Cetak</a> </div>
				</div>
			</div>
			<div class="tile-body">
				<div class="row">
					<div class="col-md-12">
						<table class="table">
							<tbody>
								<tr>
									<td rowspan="5" width="150"><img class="img-fluid" src="<?php echo base_url() . $foto; ?>" </td>
									<td width="150">Nama Nelayan</td>
									<td width="40">:</td>
									<td><?php echo $isi->nama_nelayan; ?></td>
								</tr>
								<tr>
									<td>Nama Perahu</td>
									<td>:</td>
									<td><?php echo $isi->nama_perahu; ?></td>
								</tr>
								<tr>
									<td>Kepemilikan Perahu</td>
									<td>:</td>
									<td><?php echo $isi->kepemilikkan_perahu == 1 ? 'Milik Sendiri' : 'Orang Lain'; ?></td>
								</tr>
								<tr>
									<td>Nama Kelompok</td>
									<td>:</td>
									<td><?php echo $isi->nama_kelompok; ?></td>
								</tr>
								<tr>
									<td>Metod Tangkap</td>
									<td>:</td>
									<td><?php echo $isi->metode_tangkap; ?></td>
								</tr>
								<tr>
									<td colspan="4"></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="tile">
			<div class="title-page">
				<h3 class="tile-title"><i class="fa fa-list" aria-hidden="true"></i> BERKAS NELAYAN</h3>
			</div>
			<div class="tile-body">
				<div class="row">
					<div class="col-md-6">
						<div class="berkas-nelayan">
							<h1>FOTO KTP</h1>
							<form method="post" role="form" class="was-validated" action="<?php echo base_url(); ?>nelayan/upload_ktp" enctype="multipart/form-data">
								<div class="form-group">
									<label class="control-label">Upload KTP <i>( jpg|jpeg|png )</i></label>
									<input id="input-ktp" class="sem" type="file" 
									accept="image/*" name="ktp">
									<input type="hidden" name="id_nelayan" value="<?php echo $id; ?>" class="form-control" required>
									<div class="input-group mb-3">
										<input id="foto-ktp" type="text" class="form-control" required>
										<div class="input-group-append">
											<button id="btn-clear-ktp" type="button" class="btn btn-warning sem"><i class="fa fa-refresh " aria-hidden="true"></i>Clear</button>
											<button id="btn-browse-ktp" type="button" class="btn btn-danger"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Browse</button>
											<button id="btn-ktp" type="submit" class="btn btn-primary sem"><i class="fa fa-floppy-o " aria-hidden="true"></i>Upload</button>
										</div>
										<div class="valid-feedback"><i>*valid</i> </div>
										<div class="invalid-feedback"><i>*required</i> </div>
									</div>
								</div>
							</form>
							<a href="javascript:void(0)" onclick="lihat_foto('<?php echo base_url() . $ktp; ?> ')">
								<div class="berkas"> <img id="ktp" src="<?php echo base_url() . $ktp; ?>" class="img-fluid"> </div>
							</a>
						</div>
					</div>
					<div class="col-md-6">
						<div class="berkas-nelayan">
							<h1>FOTO NPWP</h1>
							<form method="post" role="form" class="was-validated" action="<?php echo base_url(); ?>nelayan/upload_npwp" enctype="multipart/form-data">
								<div class="form-group">
									<label class="control-label">Upload NPWP <i>( jpg|jpeg|png )</i></label>
									<input id="input-npwp" class="sem" 
									type="file" accept="image/*" name="npwp">
									<input type="hidden" name="id_nelayan" value="<?php echo $id; ?>" class="form-control" required>
									<div class="input-group mb-3">
										<input id="foto-npwp" type="text" class="form-control" required>
										<div class="input-group-append">
											<button id="btn-clear-npwp" type="button" class="btn btn-warning sem"><i class="fa fa-refresh " aria-hidden="true"></i>Clear</button>
											<button id="btn-browse-npwp" type="button" class="btn btn-danger"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Browse</button>
											<button id="btn-npwp" type="submit" class="btn btn-primary sem"><i class="fa fa-floppy-o " aria-hidden="true"></i>Upload</button>
										</div>
										<div class="valid-feedback"><i>*valid</i> </div>
										<div class="invalid-feedback"><i>*required</i> </div>
									</div>
								</div>
							</form>
							<a href="javascript:void(0)" onclick="lihat_foto('<?php echo base_url() . $npwp; ?> ')">
								<div id="ktp" class="berkas"> <img src="<?php echo base_url() . $npwp; ?>" class="img-fluid"> </div>
							</a>
						</div>
					</div>
					<div class="col-md-6">
						<div class="berkas-nelayan">
							<h1>FOTO KUSUKA</h1>
							<form method="post" role="form" class="was-validated" action="<?php echo base_url(); ?>nelayan/upload_kusuka" enctype="multipart/form-data">
								<div class="form-group">
									<label class="control-label">Upload Kusuka <i>( jpg|jpeg|png )</i></label>
									<input id="input-kusuka" class="sem" type="file" accept="image/*" name="kusuka">
									<input type="hidden" name="id_nelayan" value="<?php echo $id; ?>" class="form-control" required>
									<div class="input-group mb-3">
										<input id="foto-kusuka" type="text" class="form-control" required>
										<div class="input-group-append">
											<button id="btn-clear-kusuka" type="button" class="btn btn-warning sem"><i class="fa fa-refresh " aria-hidden="true"></i>Clear</button>
											<button id="btn-browse-kusuka" type="button" class="btn btn-danger"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Browse</button>
											<button id="btn-kusuka" type="submit" class="btn btn-primary sem"><i class="fa fa-floppy-o " aria-hidden="true"></i>Upload</button>
										</div>
										<div class="valid-feedback"><i>*valid</i> </div>
										<div class="invalid-feedback"><i>*required</i> </div>
									</div>
								</div>
							</form>
							<a href="javascript:void(0)" onclick="lihat_foto('<?php echo base_url() . $kusuka; ?> ')">
								<div id="ktp" class="berkas"> <img src="<?php echo base_url() . $kusuka; ?>" class="img-fluid"> </div>
							</a>
						</div>
					</div>
					<div class="col-md-6">
						<div class="berkas-nelayan">
							<h1>FOTO NIB</h1>
							<form method="post" role="form" class="was-validated" action="<?php echo base_url(); ?>nelayan/upload_nib" enctype="multipart/form-data">
								<div class="form-group">
									<label class="control-label">Upload NIB <i>( jpg|jpeg|png )</i></label>
									<input id="input-nib" class="sem" type="file" accept="image/*" name="nib">
									<input type="hidden" name="id_nelayan" value="<?php echo $id; ?>" class="form-control" required>
									<div class="input-group mb-3">
										<input id="foto-nib" type="text" class="form-control" required>
										<div class="input-group-append">
											<button id="btn-clear-nib" type="button" class="btn btn-warning sem"><i class="fa fa-refresh " aria-hidden="true"></i>Clear</button>
											<button id="btn-browse-nib" type="button" class="btn btn-danger"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Browse</button>
											<button id="btn-nib" type="submit" class="btn btn-primary sem"><i class="fa fa-floppy-o " aria-hidden="true"></i>Upload</button>
										</div>
										<div class="valid-feedback"><i>*valid</i> </div>
										<div class="invalid-feedback"><i>*required</i> </div>
									</div>
								</div>
							</form>
							<a href="javascript:void(0)" onclick="lihat_foto('<?php echo base_url() . $nib; ?> ')">
								<div id="ktp" class="berkas"> <img src="<?php echo base_url() . $nib; ?>" class="img-fluid"> </div>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="fotone" class="show-fotone sembunyi"> <a href="#" id="img-fotone"> <img id="isi-fotone" class="img-fluid"> </a> </div>
<script type="text/javascript">
	$('#nelayan').addClass('active');
	$('#perahu').addClass('radius-bawah');
	$('#produksi').addClass('radius-atas');

	function show_data() {
		$.ajax({
			url: "<?php echo site_url('nelayan/get_berkas') ?>",
			type: "POST",
			data: {
				q: "<?php echo $id; ?>"
			},
			dataType: "JSON",
			success: function(data) {
				$('.loading').fadeOut('fast');

				$('#ktp').attr('src', data.ktp);
				$('#npwp').attr('src', data.npwp);
				$('#kusuka').attr('src', data.kusuka);
				$('#nib').attr('src', data.nib);;
			},
			error: function(jqXHR, textStatus, errorThrown) {
				$('.loading').fadeOut('fast');
				Swal.fire('Upss..!', 'Terjadi kesalahan jaringan error message: ' + errorThrown, 'error');
			}
		});
	}

	function lihat_foto(b) {
		$('#isi-fotone').attr('src', b);
		$('#img-fotone').attr('href', b);
		lightGallery(document.getElementById('fotone'), {
			thumbnail: true,
			animateThumb: false,
			showThumbByDefault: false
		});
		$('#img-fotone')[0].click();
	};

	$(document).on('click', '#btn-browse-ktp', function() {
		var file = $(this).parent().parent().parent().find('#input-ktp');
		file.trigger('click');
	});
	$(function() {
		$('#btn-clear-ktp').click(function() {
			$('#foto-ktp').val("");
			$('#input-ktp').val("");
			$("#btn-browse-ktp").show();
			$("#btn-ktp").hide();
			$(this).hide();
		});
		$("#input-ktp").change(function(e) {
			var fileName = e.target.files[0].name;
			$('#foto-ktp').val(fileName);
			$('#btn-clear-ktp').show();
			$("#btn-browse-ktp").hide();
			$("#btn-ktp").show();
		});
	});


	$(document).on('click', '#btn-browse-npwp', function() {
		var file = $(this).parent().parent().parent().find('#input-npwp');
		file.trigger('click');
	});
	$(function() {
		$('#btn-clear-npwp').click(function() {
			$('#foto-npwp').val("");
			$('#input-npwp').val("");
			$("#btn-browse-npwp").show();
			$("#btn-npwp").hide();
			$(this).hide();
		});
		$("#input-npwp").change(function(e) {
			var fileName = e.target.files[0].name;
			$('#foto-npwp').val(fileName);
			$('#btn-clear-npwp').show();
			$("#btn-browse-npwp").hide();
			$("#btn-npwp").show();
		});
	});

	$(document).on('click', '#btn-browse-kusuka', function() {
		var file = $(this).parent().parent().parent().find('#input-kusuka');
		file.trigger('click');
	});
	$(function() {
		show_data();
		$('#btn-clear-kusuka').click(function() {
			$('#foto-kusuka').val("");
			$('#input-kusuka').val("");
			$("#btn-browse-kusuka").show();
			$("#btn-kusuka").hide();
			$(this).hide();
		});
		$("#input-kusuka").change(function(e) {
			var fileName = e.target.files[0].name;
			$('#foto-kusuka').val(fileName);
			$('#btn-clear-kusuka').show();
			$("#btn-browse-kusuka").hide();
			$("#btn-kusuka").show();
		});
	});

	$(document).on('click', '#btn-browse-nib', function() {
		var file = $(this).parent().parent().parent().find('#input-nib');
		file.trigger('click');
	});
	$(function() {
		$('#btn-clear-nib').click(function() {
			$('#foto-nib').val("");
			$('#input-nib').val("");
			$("#btn-browse-nib").show();
			$("#btn-nib").hide();
			$(this).hide();
		});
		$("#input-nib").change(function(e) {
			var fileName = e.target.files[0].name;
			$('#foto-nib').val(fileName);
			$('#btn-clear-nib').show();
			$("#btn-browse-nib").hide();
			$("#btn-nib").show();
		});
	});

	$(function() {
		$('.was-validated').submit(function(evt) {
			evt.preventDefault();
			evt.stopImmediatePropagation();
			$('.loading').fadeOut('fast');
			$('.loading-1').fadeIn('fast');
			$('.progress-bar').css('width', "0%");
			$('.progress-bar').html("0%");
			$('.progress-bar').removeClass('bg-success').addClass('bg-info');
			$('#jml_qr').text('[ 0% ]');
			var url = $(this).attr('action');
			var formData = new FormData($(this)[0]);
			$.ajax({
				xhr: function() {
					var xhr = new window.XMLHttpRequest();
					xhr.upload.addEventListener("progress", function(evt) {
						if (evt.lengthComputable) {
							var percentComplete = evt.loaded / evt.total;
							percentComplete = parseInt(percentComplete * 100);
							$('.progress-bar').css('width', percentComplete + "%");
							$('.progress-bar').html(percentComplete + "%");
							$('#jml_qr').text('[ ' + percentComplete + "% ]");
							if (percentComplete === 100) {
								$('.progress-bar').removeClass('bg-info').addClass('bg-success');
							}
						}
					});
					return xhr;
				},
				url: url,
				type: "POST",
				data: formData,
				dataType: "JSON",
				processData: false,
				contentType: false,
				success: function(data) {
					$('.loading-1').fadeOut('fast');
					if (data.status) {
						$('.loading').fadeOut('fast');
						$('#btn-clear-ktp').trigger('click');
						$('#btn-clear-npwp').trigger('click');
						$('#btn-clear-kusuka').trigger('click');
						$('#btn-clear-nib').trigger('click');
						location.reload();
					} else {
						Swal.fire("Upss... !", data.pesan, "error");
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					$('.loading-1').fadeOut('fast');
					Swal.fire('Upss..!', 'Terjadi kesalahan jaringan error message: ' + errorThrown, 'error');
				}
			});

		});
	});
</script>