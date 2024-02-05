<?php
$id = encrypt_url($isi->id_coba);
$foto_depan_coba = $isi->foto_depan_coba ?: 'aset/img/belum_diupload.jpg';
$foto_samping_coba = $isi->foto_samping_coba ?: 'aset/img/no_berkas.jpg';
$sim = $isi->sim ?: 'aset/img/no_berkas.jpg';
?> 
<!-- ini vina -->
<div class="row">
	<div class="col-md-12">
		<div class="tile">
			<div class="title-page">
				<h3 class="tile-title"><i class="fa fa-list" aria-hidden="true"></i> DATA PERAHU</h3>
				<div class="nav-back">
					<div class="btn-group" role="group" aria-label="Basic example"> 
						<a href="javascript:;" class="btn btn-sm btn-danger btn-rounded" onClick="delete_data('<?php echo $id; ?>')"><i class="fa fa-close" aria-hidden="true"></i>Delete</a> <a href="<?php base_url(); ?>coba/cetak_pdf?q=<?php echo $id; ?>" class="btn btn-sm btn-warning" id="btn-close">
						<i class="fa fa-file-pdf-o" aria-hidden="true"></i> Cetak</a> 
					</div>
				</div>
			</div>
			<div class="tile-body">
				<div class="row">
					<div class="col-md-12">
						<table class="table">
							<tbody>
								<tr>
									<td width="150">Nama Perahu</td>
									<td width="40">:</td>
									<td><?php echo $isi->nama_coba; ?></td>
								</tr>
								<tr>
									<td>Nama Kelompok </td>
									<td>:</td>
									<td><?php echo $isi->nama_kelompok; ?></td>
								</tr>
								<tr>
									<td>Lebar <i>( meter )</i></td>
									<td>:</td>
									<td><?php echo $isi->lebar_perahu_coba; ?></td>
								</tr>
								<tr>
									<td>Panjang <i>( meter )</i></td>
									<td>:</td>
									<td><?php echo $isi->panjang_perahu_coba; ?></td>
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
				<h3 class="tile-title"><i class="fa fa-list" aria-hidden="true"></i> BERKAS PERAHU</h3>
			</div>
			<div class="tile-body">
				<div class="row">
					<div class="col-md-6">
						<div class="berkas-nelayan">
							<h1>FOTO SAMPING PERAHU</h1>
							<form method="post" role="form" class="was-validated" action="<?php echo base_url(); ?>coba/upload_foto_samping_coba" enctype="multipart/form-data">
								<div class="form-group">
									<label class="control-label">Upload Foto Samping Perahu <i>( jpg|jpeg|png )</i></label>
									<input id="input-foto_samping_coba" class="sem" type="file" accept="image/*" name="foto_samping_coba">
									<input type="hidden" name="id_coba" value="<?php echo $id; ?>" class="form-control" required>
									<div class="input-group mb-3">
										<input id="foto-foto_samping_coba" type="text" class="form-control" required>
										<div class="input-group-append">
											<button id="btn-clear-foto_samping_coba" type="button" class="btn btn-warning sem"><i class="fa fa-refresh " aria-hidden="true"></i>Clear</button>
											<button id="btn-browse-foto_samping_coba" type="button" class="btn btn-danger"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Browse</button>
											<button id="btn-foto_samping_coba" type="submit" class="btn btn-primary sem"><i class="fa fa-floppy-o " aria-hidden="true"></i>Upload</button>
										</div>
										<div class="valid-feedback"><i>*valid</i> </div>
										<div class="invalid-feedback"><i>*required</i> </div>
									</div>
								</div>
							</form>
							<a href="javascript:void(0)" onclick="lihat_foto('<?php echo base_url() . $foto_samping_coba; ?> ')">
								<div class="berkas"> <img id="foto_samping_coba" src="<?php echo base_url() . $foto_samping_coba; ?>" class="img-fluid"> </div>
							</a>
						</div>
					</div>
					<div class="col-md-6">
						<div class="berkas-nelayan">
							<h1>FOTO SIM NELAYAN</h1>
							<form method="post" role="form" class="was-validated" action="<?php echo base_url(); ?>coba/upload_sim" enctype="multipart/form-data">
								<div class="form-group">
									<label class="control-label">Upload SIM <i>( jpg|jpeg|png )</i></label>
									<input id="input-sim" class="sem" 
									type="file" accept="image/*" name="sim">
									<input type="hidden" name="id_coba" value="<?php echo $id; ?>" 
									class="form-control" required>
									<div class="input-group mb-3">
										<input id="foto-sim" type="text" class="form-control" required>
										<div class="input-group-append">
											<button id="btn-clear-sim" type="button" class="btn btn-warning sem"><i class="fa fa-refresh " aria-hidden="true"></i>Clear</button>
											<button id="btn-browse-sim" type="button" class="btn btn-danger"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Browse</button>
											<button id="btn-sim" type="submit" class="btn btn-primary sem"><i class="fa fa-floppy-o " aria-hidden="true"></i>Upload</button>
										</div>
										<div class="valid-feedback"><i>*valid</i> </div>
										<div class="invalid-feedback"><i>*required</i> </div>
									</div>
								</div>
							</form>
							<a href="javascript:void(0)" onclick="lihat_foto('<?php echo base_url() . $sim; ?> ')">
								<div id="sim" class="berkas"> <img src="<?php echo base_url() . $sim; ?>" class="img-fluid"> </div>
							</a>
						</div>
					</div>
					<div class="col-md-6">
                            <div class="berkas-nelayan">
                                <h1>FOTO PERAHU</h1>
                                <a href="javascript:void(0)" onclick="lihat_foto('<?php echo base_url() .
								 $foto_depan_coba; ?> ')">
                                    <div class="berkas">
                                        <img id="foto_depan_coba" src="<?php echo base_url() . 
										$foto_depan_coba; ?>" class="img-fluid">
                                    </div>
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
	$('#coba').addClass('active');
	$('#bbm').addClass('radius-bawah');
	$('#user').addClass('radius-atas');

	function show_data() {
		$.ajax({
			url: "<?php echo site_url('coba/get_berkas') ?>",
			type: "POST",
			data: {
				q: "<?php echo $id; ?>"
			},
			dataType: "JSON",
			success: function(data) {
				$('.loading').fadeOut('fast');

				$('#foto_samping_coba').attr('src', data.foto_samping_coba);
				$('#sim').attr('src', data.sim);
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

	$(document).on('click', '#btn-browse-foto_samping_coba', function() {
		var file = $(this).parent().parent().parent().find('#input-foto_samping_coba');
		file.trigger('click');
	});
	$(function() {
		$('#btn-clear-foto_samping_coba').click(function() {
			$('#foto-foto_samping_coba').val("");
			$('#input-foto_samping_coba').val("");
			$("#btn-browse-foto_samping_coba").show();
			$("#btn-foto_samping_coba").hide();
			$(this).hide();
		});
		$("#input-foto_samping_coba").change(function(e) {
			var fileName = e.target.files[0].name;
			$('#foto-foto_samping_coba').val(fileName);
			$('#btn-clear-foto_samping_coba').show();
			$("#btn-browse-foto_samping_coba").hide();
			$("#btn-foto_samping_coba").show();
		});
	});


	$(document).on('click', '#btn-browse-sim', function() {
		var file = $(this).parent().parent().parent().find('#input-sim');
		file.trigger('click');
	});
	$(function() {
		$('#btn-clear-sim').click(function() {
			$('#foto-sim').val("");
			$('#input-sim').val("");
			$("#btn-browse-sim").show();
			$("#btn-sim").hide();
			$(this).hide();
		});
		$("#input-sim").change(function(e) {
			var fileName = e.target.files[0].name;
			$('#foto-sim').val(fileName);
			$('#btn-clear-sim').show();
			$("#btn-browse-sim").hide();
			$("#btn-sim").show();
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
						$('#btn-clear-foto_samping_coba').trigger('click');
						$('#btn-clear-sim').trigger('click');
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