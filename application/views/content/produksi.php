<?php

 date_default_timezone_set( 'Asia/Jakarta' );
?>
<div id="inputan"class="row sembunyi">
  <div class="col-md-12">
    <div class="tile">
      <div class="title-page">
        <h3 class="tile-title"><i class="fa fa-list" aria-hidden="true"></i> ADD DATA PRODUKSI</h3>
        <div class="nav-back">
          <div class="btn-group" role="group" aria-label="Basic example">
            <button class="btn btn-sm btn-danger" id="btn-close"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
          </div>
        </div>
      </div>
      <div class="tile-body">
        <form id="form-add" method="post" role="form" class="was-validated" action="<?php echo base_url();?>produksi/save">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label class="control-label">Foto <i>( jpg|jpeg|png )</i></label>
                <input id="input-file" class="sem" type="file" accept="image/*" name="userfile">
                <div class="input-group mb-6">
                  <input id="foto-file" type="text" class="form-control file-preview-filename">
                  <div class="input-group-append">
                    <button id="btn-clear" type="button" class="btn btn-info sem">Clear</button>
                    <button id="btn-browse" type="button" class="btn btn-danger"><i class="fa fa-folder-open-o" aria-hidden="true"></i><span id="bs">Browse</span></button>
                  </div>
                  <div class="valid-feedback"><i>*valid</i> </div>
                  <div class="invalid-feedback"><i>*required</i> </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="control-label">Tanggal</label>
                <input type="text" class="form-control tgl" placeholder="__/__/____" name="tanggal" id="tanggal" value="<?php echo date('d/m/Y');?>" required autofocus>
                <div class="valid-feedback"><i>*valid</i> </div>
                <div class="invalid-feedback"><i>*required</i> </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="control-label">Tempat</label>
                <div class="input-group mb-3">
                  <select class="form-control boot-select-no" name="id_tempat_lelang" id="id_tempat_lelang"  required>
                   
                    <?php
                    foreach ( $tempat_lelang as $k ) {
                      echo '<option value="' . encrypt_url( $k->id_tempat_lelang ) . '">' . $k->tempat_lelang . '</option>';
                    }
                    ?>
                  </select>
                  <div class="valid-feedback"><i>*valid</i> </div>
                  <div class="invalid-feedback"><i>*required</i> </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="control-label">Nama Perahu</label>
                <div class="input-group mb-3">
                  <select class="form-control boot-select" name="id_perahu" id="id_perahu"  required>
            
                    <?php
                    foreach ( $perahu as $k ) {
                      echo '<option value="' . encrypt_url( $k->id_perahu ) . '">' . $k->nama_perahu . '</option>';
                    }
                    ?>
                  </select>
                  <div class="valid-feedback"><i>*valid</i> </div>
                  <div class="invalid-feedback"><i>*required</i> </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="control-label">Jenis Ikan</label>
                <div class="input-group mb-3">
                  <select class="form-control boot-select" name="id_ikan" id="id_ikan"  required>
               
                    <?php
                    foreach ( $ikan as $k ) {
                      echo '<option value="' . encrypt_url( $k->id_ikan ) . '">' . $k->ikan . '</option>';
                    }
                    ?>
                  </select>
                  <div class="valid-feedback"><i>*valid</i> </div>
                  <div class="invalid-feedback"><i>*required</i> </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="control-label">Berat (kg)</label>
                <input type="text" class="form-control ribuan" name="berat" id="berat" required>
                <div class="valid-feedback"><i>*valid</i> </div>
                <div class="invalid-feedback"><i>*required</i> </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="control-label">Harga</label>
                <input type="text" class="form-control ribuan" name="harga" id="harga" required>
                <div class="valid-feedback"><i>*valid</i> </div>
                <div class="invalid-feedback"><i>*required</i> </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="control-label">Nama Pembeli</label>
                <div class="input-group mb-3">
                  <select class="form-control boot-select" name="id_pembeli" id="id_pembeli">
           
                    <?php
                    foreach ( $pembeli as $k ) {
                      echo '<option value="' . encrypt_url( $k->id_pembeli ) . '">' . $k->nama_pembeli . '</option>';
                    }
                    ?>
                  </select>
                  <div class="valid-feedback"><i>*valid</i> </div>
                  <div class="invalid-feedback"><i>*required</i> </div>
                </div>
              </div>
            </div>
			<!-- yoshe ubah tambah kode inputan buat nomor hp pembeli (kode yg bawah ini) -->
			<!-- <div class="col-md-4"> 
              <div class="form-group">
                <label class="control-label">No Hp Pembeli</label>
                <div class="input-group mb-3">
                  <select class="form-control boot-select" name="no_hp" id="no_hp">
           
                    <?php
                    foreach ( $pembeli as $k ) {
                      echo '<option value="' . encrypt_url( $k->id_pembeli ) . '">' . $k->no_hp . '</option>';
                    }
                    ?>
                  </select>
                  <div class="valid-feedback"><i>*valid</i> </div>
                  <div class="invalid-feedback"><i>*required</i> </div>
                </div>
              </div>
            </div> -->
            <div class="col-md-4 btn-kebawah-2">
              <div class="btn-group d-flex">
                <button id="btn-save" type="submit" class="btn btn-sm btn-primary w-100"><i class="fa fa-floppy-o"></i> Save</button>
                <button id="btn-reset" type="reset" onClick="reset_form()" class="btn btn-sm btn-warning w-100"><i class="fa fa-retweet"></i> Reset</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div id="isi-datane" class="row">
  <div class="col-md-12">
    <div class="tile">
      <div class="title-page">
        <h3 class="tile-title"><i class="fa fa-list" aria-hidden="true"></i> DATA PRODUKSI</h3>
        <div class="nav-back">
          <div class="btn-group" role="group" aria-label="Basic example">
            <button class="btn btn-sm btn-primary" id="btn-add"><i class="fa fa-plus-square" aria-hidden="true"></i> Tambah</button>
			  <a href="<?php echo base_url();?>produksi/rekapitulasi" class="btn btn-sm btn-danger"><i class="fa fa-list" aria-hidden="true"></i> Rekap</a>
          </div>
        </div>
      </div>
      <div class="tile-body">
        <div class="table-responsive">
          <table id="table" class="table table-bordered">
            <thead>
              <tr>
                <th>ACTIONS</th>
                <th>NO</th>
                <th>FOTO</th>
                <th>TANGGAL</th>
                <th>TEMPAT</th>
                <th>NAMA PERAHU</th>
                <th>JENIS IKAN</th>
                <th>BERAT</th>
                <th>HARGA</th>
                <th>TOTAL</th>
                <th>PEMBELI</th>
				<th>NO HP PEMBELI</th>
				<!-- yoshe ubah yg atas td yg no hp -->
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="fotone" class="show-fotone sembunyi"> <a href="#" id="img-fotone"> <img id="isi-fotone" class="img-fluid"> </a> </div>
<script type="text/javascript">
	$('#produksi').addClass('active');
	$('#nelayan').addClass('radius-bawah');
	$('#bbm').addClass('radius-atas');
	
	var table = $('#table').DataTable({
		"oLanguage": {
			"sSearch": "Search: ",
			"sSearchPlaceholder": ""
		},
	 "processing": true,
        responsive: true,
        "serverSide": true,
        'paging': true,
        'lengthChange': true,
        'ordering': false,
        'info': false,
        'autoWidth': false,
        "aLengthMenu": [
            [ 25, 50, 100, -1 ],
            [ 25, 50, 100, "Semua" ]
        ],
		"ajax": {
			"url": "<?php echo site_url('produksi/ajax_list')?>",
			"type": "POST"
		},
		"columnDefs": [{
			className: "text-center khusus",
			"targets": [0],
			width: '10'
		},{
			className: "text-center khusus",
			"targets": [1],
			width: '80'
		},{
			className: "text-center khusus",
			"targets": [2],
			width: '80'
		}]
	});
	
	function reload_table() {
		table.ajax.reload(null, false); //reload datatable ajax
	}
	
	$('#btn-add').click(function() {
		$('#inputan').removeClass('sembunyi');
		$('#isi-datane').addClass('sembunyi');
		var fieldInput = $('#tanggal');
		var fldLength= fieldInput.val().length;
		fieldInput.focus();
		fieldInput[0].setSelectionRange(fldLength, fldLength);
		$('.boot-select-no').val("").trigger('change');
		$('.boot-select').val("").trigger('change');
	
	});
	
	$('#btn-close').click(function() {
		$('#inputan').addClass('sembunyi');
		$('#isi-datane').removeClass('sembunyi');
	});
	$(function() {
		$('#form-add').submit(function(evt) {
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
						reset_form();
						reload_page_upload();
						reload_table();
	
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
	function reset_form() {
		$('#form-add')[0].reset();
		$('#btn-save').html('<i class="fa fa-floppy-o"></i> Save');
		$('#form-add').attr('action', '<?php echo base_url();?>produksi/save');
		$('#inputan').addClass('sembunyi');
		$('#isi-datane').removeClass('sembunyi');
		$('.boot-select').val("").trigger('change');
		$('.boot-select-no').val("").trigger('change');
		$('#nama_nelayan').focus();
		$('#btn-clear').trigger('click');
	}
	function edit_data(id) {
		$('.loading').fadeIn('fast');
		$('#form-add')[0].reset();
		$('.boot-select').val("").trigger('change');
		$('.boot-select-no').val("").trigger('change');
		$('#form-add').attr('action', "<?php echo base_url('produksi/update?q=');?>" + id);
		$.ajax({
			url: "<?php echo site_url('produksi/edit')?>",
			type: "POST",
			data: {
				q: id
			},
			dataType: "JSON",
			success: function(data) {
				$('.loading').fadeOut('fast');
				$('#tanggal').val(data.tanggal);
				$('#harga').val(data.harga);
				$('#berat').val(data.berat);
				$('#id_perahu').val(data.id_perahu).trigger('change');
				$('#id_ikan').val(data.id_ikan).trigger('change');
				$('#id_tempat_lelang').val(data.id_tempat_lelang).trigger('change');
				$('#id_pembeli').val(data.id_pembeli).trigger('change');
				$('#btn-save').html('<i class="fa fa-floppy-o"></i> Update');
				$('#inputan').removeClass('sembunyi');
				$('#isi-datane').addClass('sembunyi');
				var fieldInput = $('#tanggal');
				var fldLength= fieldInput.val().length;
				fieldInput.focus();
				fieldInput[0].setSelectionRange(fldLength, fldLength);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				$('.loading').fadeOut('fast');
				Swal.fire('Upss..!', 'Terjadi kesalahan jaringan error message: ' + errorThrown, 'error');
			}
		});
	}
	
	function delete_data(x) {
		Swal.fire({
			title: "DELETE DATA NELAYAN",
			text: "Apakah anda yakin akan menghapus data produksi ini?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, Hapus!',
			cancelButtonText: "No, Batalkan!",
		}).then((result) => {
			if (result.value) {
				$('.loading').fadeIn('fast');
				$.ajax({
					url: "<?php echo site_url('produksi/delete')?>",
					type: "POST",
					data: {
						q: x
					},
					dataType: "JSON",
					success: function(data) {
						$('.loading').fadeOut('fast');
						if (data.status) {
							Swal.fire('Berhasil...!', 'Data berhasil dihapus!', 'success');
							reload_table();
						} else {
							Swal.fire('Upss...!!', 'Data gagal dihapus!', 'error');
						}
					},
					error: function(jqXHR, textStatus, errorThrown) {
						$('.loading').fadeOut('fast');
						Swal.fire("Upss...!", "Terjadi kesalahan jaringan pesan error : !" + errorThrown, "error");
					}
				});
			}
		});
	}

	function reload_page_upload() {
		Swal.fire({
			title: "BERHASIL",
			text: "Data berhasil ditambahkan",
			type: "success",
			showCancelButton: false,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ok',
			cancelButtonText: "No, Batalkan!",
		}).then((result) => {
			if (result.value) {
				reload_table();
				reset_form();
				$( '#nama_nelayan' ).focus();
			}
		});
	}



	$(document).on('click', '#btn-browse', function() {
		var file = $(this).parent().parent().parent().find('#input-file');
		file.trigger('click');
	});
	$(function() {
		$('#btn-clear').click(function() {
			$('.file-preview-filename').val("");
			$('.image-preview-clear').hide();
			$('#input-file').val("");
			$("#bs").text("Browse");
			$("#btn-browse").removeClass("btn-warning");
			$("#btn-browse").addClass("btn-success");
			$(this).hide();
		});
		$("#input-file").change(function(e) {
			var fileName = e.target.files[0].name;
			$('.file-preview-filename').val(fileName);
			$("#bs").text("Change");
			$("#btn-browse").removeClass("btn-success");
			$("#btn-browse").addClass("btn-warning");
			$('#btn-clear').show();
		});
	});

	
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

		

</script> 
