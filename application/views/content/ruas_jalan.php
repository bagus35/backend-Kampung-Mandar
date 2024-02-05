<div id="inputan"class="row sembunyi">
  <div class="col-md-12">
    <div class="tile">
      <div class="title-page">
        <h3 class="tile-title"><i class="fa fa-road" aria-hidden="true"></i> ADD RUAS JALAN</h3>
        <div class="nav-back">
          <div class="btn-group" role="group" aria-label="Basic example">
            <button class="btn btn-sm btn-danger" id="btn-close"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
          </div>
        </div>
      </div>
      <div class="tile-body">
        <form id="form-add" method="post" role="form" class="was-validated" action="<?php echo base_url();?>ruas_jalan/save" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label class="control-label">Nomor Ruas</label>
                <input type="text" class="form-control" name="no_ruas" id="no_ruas" required autofocus>
                <div class="valid-feedback"><i>*valid</i> </div>
                <div class="invalid-feedback"><i>*required</i> </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Nama Ruas</label>
                <input type="text" class="form-control" name="nama_ruas" id="nama_ruas" required autofocus>
                <div class="valid-feedback"><i>*valid</i> </div>
                <div class="invalid-feedback"><i>*required</i> </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="control-label">Foto Jalan <i>( jpg|jpeg|png )</i></label>
                <input id="input-file" class="sem" type="file" accept="image/*" name="userfile">
                <div class="input-group mb-3">
                  <input id="foto-file" type="text" class="form-control file-preview-filename" required>
                  <div class="input-group-append">
                    <button id="btn-clear" type="button" class="btn btn-info sem">Clear</button>
                    <button id="btn-browse" type="button" class="btn btn-danger"><i class="fa fa-folder-open-o" aria-hidden="true"></i><span id="bs">Browse</span></button>
                  </div>
                  <div class="valid-feedback"><i>*valid</i> </div>
                  <div class="invalid-feedback"><i>*required</i> </div>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="control-label">Kecamatan</label>
                <div class="input-group mb-3">
                  <select class="form-control" name="id_kecamatan" id="id_kecamatan"  required>
                    <option value=""></option>
                    <?php
                    foreach ( $kecamatan as $k ) {
                      echo '<option value="' . encrypt_url( $k->id_kecamatan ) . '">' . $k->kecamatan . '</option>';
                    }
                    ?>
                  </select>
                  <div class="valid-feedback"><i>*valid</i> </div>
                  <div class="invalid-feedback"><i>*required</i> </div>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="control-label">Desa</label>
                <div class="input-group mb-3">
                  <select class="form-control" name="id_desa" id="id_desa"  required>
                    <option value=""></option>
                  </select>
                  <div class="valid-feedback"><i>*valid</i> </div>
                  <div class="invalid-feedback"><i>*required</i> </div>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="control-label">Panjang <i>(meter)</i></label>
                <input type="text" class="form-control ribuan" name="panjang" id="panjang" required>
                <div class="valid-feedback"><i>*valid</i> </div>
                <div class="invalid-feedback"><i>*required</i> </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="control-label">Lebar <i>(meter)</i></label>
                <input type="text" class="form-control angka" name="lebar" id="lebar" required>
                <div class="valid-feedback"><i>*valid</i> </div>
                <div class="invalid-feedback"><i>*required</i> </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="control-label">Kondisi Baik <i>(m)</i></label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control ribuan" name="kondisi_baik" id="kondisi_baik">
                  <div class="valid-feedback"><i>*valid</i> </div>
                  <div class="invalid-feedback"><i>*required</i> </div>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="control-label">Kondisi Sedang <i>(m)</i></label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control ribuan" name="kondisi_sedang" id="kondisi_sedang">
                  <div class="valid-feedback"><i>*valid</i> </div>
                  <div class="invalid-feedback"><i>*required</i> </div>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="control-label">Kondisi Rusak Ringan <i>(m)</i></label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control ribuan" name="kondisi_rusak_ringan" id="kondisi_rusak_ringan">
                  <div class="valid-feedback"><i>*valid</i> </div>
                  <div class="invalid-feedback"><i>*required</i> </div>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="control-label">Kondisi Rusak Berat <i>(m)</i></label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control ribuan" name="kondisi_rusak_berat" id="kondisi_rusak_berat">
                  <div class="valid-feedback"><i>*valid</i> </div>
                  <div class="invalid-feedback"><i>*required</i> </div>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="control-label">Status Jalan</label>
                <div class="input-group mb-3">
                  <select class="form-control" name="status_jalan" id="status_jalan"  required>
                    <option value=""></option>
                    <!--
                    <option value="1">Nasional</option>
                    <option value="2">Provinsi</option>
-->
                    <option value="3">Kabupaten</option>
                    <option value="4">Kota</option>
                    <option value="5">Desa</option>
                  </select>
                  <div class="valid-feedback"><i>*valid</i> </div>
                  <div class="invalid-feedback"><i>*required</i> </div>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="control-label">Titik Awal</label>
                <input type="text" class="form-control" name="titik_awal" id="titik_awal" required>
                <div class="valid-feedback"><i>*valid</i> </div>
                <div class="invalid-feedback"><i>*required</i> </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="control-label">Titik Akhir</label>
                <input type="text" class="form-control" name="titik_akhir" id="titik_akhir" required>
                <div class="valid-feedback"><i>*valid</i> </div>
                <div class="invalid-feedback"><i>*required</i> </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="control-label">Koordinat Titik Awal</label>
                <input type="text" class="form-control" name="koordinat_titik_awal" id="koordinat_titik_awal" required>
                <div class="valid-feedback"><i>*valid</i> </div>
                <div class="invalid-feedback"><i>*required</i> </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="control-label">Koordinat Titik Tengah</label>
                <input type="text" class="form-control" name="koordinat_titik_tengah" id="koordinat_titik_tengah" required>
                <div class="valid-feedback"><i>*valid</i> </div>
                <div class="invalid-feedback"><i>*required</i> </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="control-label">Koordinat Titik Akhir</label>
                <input type="text" class="form-control" name="koordinat_titik_akhir" id="koordinat_titik_akhir" required>
                <div class="valid-feedback"><i>*valid</i> </div>
                <div class="invalid-feedback"><i>*required</i> </div>
              </div>
            </div>
            <div class="col-md-3 btn-kebawah">
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
        <h3 class="tile-title"><i class="fa fa-road" aria-hidden="true"></i> RUAS JALAN</h3>
        <div class="nav-back">
          <div class="btn-group" role="group" aria-label="Basic example">
            <button class="btn btn-sm btn-primary" id="btn-add"><i class="fa fa-plus-square" aria-hidden="true"></i> Add Ruas Jalan</button>
            <button class="btn btn-sm btn-success" onClick="cetak()" id="btn-add-keluar"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export to Excel</button>
            <button class="btn btn-sm btn-warning" onClick="cetak_pdf()" id="btn-add-keluar"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Export to PDF</button>
          </div>
        </div>
      </div>
      <div class="tile-body">
        <div class="table-responsive">
          <div class="menu-filter">
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label class="control-label">Show Data</label>
                  <div class="input-group flex-nowrap">
                    <div class="input-group-prepend"> <span class="input-group-text bg-biru" id="addon-wrapping"><i class="fa fa-filter" aria-hidden="true"></i> </span> </div>
                    <select class="form-control" name="show" id="show">
                      <option value="15">15</option>
                      <option value="25">25</option>
                      <option value="50">50</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label">Kecamatan</label>
                  <div class="input-group flex-nowrap">
                    <div class="input-group-prepend"> <span class="input-group-text bg-merah" id="addon-wrapping"><i class="fa fa-map" aria-hidden="true"></i></span> </div>
                    <select class="form-control" name="f-kecamatan" id="f-kecamatan">
                      <option value="-1">All</option>
                      <?php foreach($kecamatan as $p):?>
                      <option value="<?php echo encrypt_url($p->id_kecamatan);?>"><?php echo $p->kecamatan;?></option>
                      <?php endforeach;?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label">Desa</label>
                  <div class="input-group flex-nowrap">
                    <div class="input-group-prepend"> <span class="input-group-text bg-hijau" id="addon-wrapping"><i class="fa fa-street-view" aria-hidden="true"></i></span> </div>
                    <select class="form-control" name="f-desa" id="f-desa">
                      <option value="-1">All</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label">Cari Ruas Jalan</label>
                  <div class="input-group flex-nowrap">
                    <div class="input-group-prepend"> <span class="input-group-text bg-kuning" id="addon-wrapping"><i class="fa fa-search" aria-hidden="true"></i></span> </div>
                    <input type="text" class="form-control" name="cari" id="cari">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <table id="table" class="table table-bordered">
            <thead>
              <tr>
                <th rowspan="3" class="text-uppercase v-m-align">Actions</th>
                <th valign="center" rowspan="3" class="text-uppercase v-m-align">No</th>
                <th valign="center" rowspan="3" class="text-uppercase v-m-align">No Ruas</th>
                <th rowspan="3" class="text-uppercase v-m-align">Nama Ruas</th>
                <th rowspan="3" class="text-uppercase v-m-align">Foto</th>
                <th rowspan="3" class="text-uppercase v-m-align">Status</th>
                <th rowspan="3" class="text-uppercase v-m-align">Kecamatan</th>
                <th rowspan="3" class="text-uppercase v-m-align">Desa/Kelurahan</th>
                <th rowspan="3" class="text-uppercase v-m-align">Panjang<br>
                  <i>(m)</i></th>
                <th rowspan="3" class="text-uppercase v-m-align">Lebar<br>
                  <i>(m)</i></th>
                <th colspan="8" class="text-uppercase v-m-align">Kondisi</th>
                <th rowspan="3" class="text-uppercase v-m-align">Titik Awal</th>
                <th rowspan="3" class="text-uppercase v-m-align">Titik Akhir</th>
                <th colspan="3" rowspan="2" class="text-uppercase v-m-align">Koordinat</th>
              </tr>
              <tr>
                <th class="v-m-align" colspan="2">Baik</th>
                <th class="v-m-align" colspan="2">Sedang</th>
                <th class="v-m-align" colspan="2">Rusak Ringan</th>
                <th class="v-m-align" colspan="2">Rusak Berat</th>
              </tr>
              <tr>
                <th class="v-m-align">m</th>
                <th class="v-m-align">%</th>
                <th class="v-m-align">m</th>
                <th class="v-m-align">%</th>
                <th class="v-m-align">m</th>
                <th class="v-m-align">%</th>
                <th class="v-m-align">m</th>
                <th class="v-m-align">%</th>
                <th class="v-m-align">Awal</th>
                <th class="v-m-align">Tengah</th>
                <th class="v-m-align">Akhir</th>
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
	
	$('#ruas-jalan').addClass('active');



	var jenis = 0;
	$('#btn-add').click(function() {
		$('#inputan').removeClass('sembunyi');
		$('#isi-datane').addClass('sembunyi');
		$('#nama-ruas').focus();
	});
	
	$('#btn-close').click(function() {
		$('#inputan').addClass('sembunyi');
		$('#isi-datane').removeClass('sembunyi');
	});

	function show_data() {
		var a = $('#cari').val();
		var b = $('#show').val();
		var c = $('#f-desa').val();
		var d = $('#f-kecamatan').val();
		table = $('#table').DataTable({
			"oLanguage": {
				"sSearch": "Search: ",
				"sSearchPlaceholder": ""
			},
			"processing": true,
			responsive: true,
			"serverSide": true,
			'paging': true,
			'lengthChange': false,
			'ordering': false,
			'info': false,
			'autoWidth': false,
			"searching": false,
			"aLengthMenu": [
				[15, 25, 50],
				[15, 25, 50]
			],
			"ajax": {
				"url": "<?php echo site_url('ruas_jalan/ajax_list')?>",
				"type": "POST",
				"data": {
					cari: a,
					show: b,
					id_desa: c,
					id_kecamatan: d,
				}
			},
			"columnDefs": [{
				className: "text-center",
				"targets": [0],
				width: '330'
			}, {
				className: "text-center khusus",
				"targets": [1],
				width: '10'
			}, {
				className: "text-center khusus",
				"targets": [7],
				width: '10'
			}, {
				className: "text-center khusus",
				"targets": [8],
				width: '10'
			}, {
				className: "text-right khusus",
				"targets": [9],
				width: '10'
			}, {
				className: "text-right khusus",
				"targets": [10],
				width: '10'
			}],
		
		});
	}

	$('#btn-refresh').click(function() {
		reload_table();
	});

	function reload_table() {
		$('#table').DataTable().destroy();
		show_data();
	}
	$('#cari').keyup(function() {
		reload_table();
		$('#cari').focus();
	});
	$('#show,#f-desa').change(function() {
		reload_table();
	});
	
	$('#f-kecamatan').change(function() {
		$('.loading').fadeIn('fast');
		get_desa_filter($(this).val());
	});
	$('#btn-close').click(function() {
		$('#f-input').addClass('sembunyi');
		$('#f-data').removeClass('sembunyi');
	});

	$(function() {
		reload_table();
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
		$('#btn-save').text('Save');
		$('#form-add').attr('action', '<?php echo base_url();?>ruas_jalan/save');
		$("#id_paket").val("").trigger("change");
		$('#foto-file').prop('required', true);
		$('#nama_ruas').focus();
	}

	function edit_data(id) {
		$('.loading').fadeIn('fast');
		$('#form-add')[0].reset();
		$('#form-add').attr('action', "<?php echo base_url('ruas_jalan/update?q=');?>" + id);
		$.ajax({
			url: "<?php echo site_url('ruas_jalan/edit')?>",
			type: "POST",
			data: {
				q: id
			},
			dataType: "JSON",
			success: function(data) {
				var mt = data.id_paket;
				if (!!mt) {
					var x = mt.split(',');
					$('#id_paket').val(x).trigger('change');
				}
				$('.loading').fadeOut('fast');
				get_desa_edit(data.id_kecamatan, data.id_desa);
				$('#no_ruas').val(data.no_ruas);
				$('#nama_ruas').val(data.nama_ruas);
				$('#id_kecamatan').val(data.id_kecamatan);
				$('#foto-file').removeAttr('required');
				$('#status_jalan').val(data.status_jalan);
				$('#panjang').val(data.panjang);
				$('#kondisi_baik').val(data.kondisi_baik);
				$('#kondisi_sedang').val(data.kondisi_sedang);
				$('#kondisi_rusak_ringan').val(data.kondisi_rusak_ringan);
				$('#kondisi_rusak_berat').val(data.kondisi_rusak_berat);
				$('#lebar').val(data.lebar);
				$('#titik_awal').val(data.titik_awal);
				$('#titik_akhir').val(data.titik_akhir);
				$('#koordinat_titik_awal').val(data.koordinat_titik_awal);
				$('#koordinat_titik_tengah').val(data.koordinat_titik_tengah);
				$('#koordinat_titik_akhir').val(data.koordinat_titik_akhir);
				$('#btn-save').text('Update');
				$('#inputan').removeClass('sembunyi');
				$('#isi-datane').addClass('sembunyi');
				$('#nama-ruas').focus();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				$('.loading').fadeOut('fast');
				swal('Upss..!', 'Terjadi kesalahan jaringan error message: ' + errorThrown, 'error');
			}
		});
	}

	function delete_data(x) {
		Swal.fire({
			title: "DELETE DATA!",
			text: "Apakah anda yakin akan menghapus data ini?",
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
					url: "<?php echo site_url('ruas_jalan/delete')?>",
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
				 $( '#nama_ruas' ).focus();
			}
		});
	}


	$('#id_kecamatan').change(function() {
		$('.loading').fadeIn('fast');
		get_desa($(this).val());
	});

	function get_desa_edit(id_kecamatan, id_desa) {

		$.ajax({
			url: "<?php echo site_url('ruas_jalan/get_desa')?>",
			type: "POST",
			data: {
				q: id_kecamatan
			},
			dataType: "JSON",
			success: function(data) {
				$('.loading').fadeOut('fast');
				var select = $('#id_desa');
				select.empty();

				var isine = '<option value=""></option>';

				$.each(data.isi, function(i, item) {
					isine += '<option value="' + item.id_desa + '">' + item.desa + '</option>';
				});
				select.append(isine);

				$('#id_desa').val(id_desa);
				//reload_table();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				$('.loading').fadeOut('fast');
				swal('Upss..!', 'Terjadi kesalahan jaringan error message: ' + errorThrown, 'error');
			}
		});
	}

	function get_desa(id_kecamatan) {
		$.ajax({
			url: "<?php echo site_url('ruas_jalan/get_desa')?>",
			type: "POST",
			data: {
				q: id_kecamatan
			},
			dataType: "JSON",
			success: function(data) {
				$('.loading').fadeOut('fast');
				var select = $('#id_desa');
				select.empty();

				var isine = '<option value=""></option>';

				$.each(data.isi, function(i, item) {
					isine += '<option value="' + item.id_desa + '">' + item.desa + '</option>';
				});
				select.append(isine);
				//reload_table();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				$('.loading').fadeOut('fast');
				swal('Upss..!', 'Terjadi kesalahan jaringan error message: ' + errorThrown, 'error');
			}
		});
	}

	
	function get_desa_filter(id_kecamatan) {
		$.ajax({
			url: "<?php echo site_url('ruas_jalan/get_desa')?>",
			type: "POST",
			data: {
				q: id_kecamatan
			},
			dataType: "JSON",
			success: function(data) {
				$('.loading').fadeOut('fast');
				var select = $('#f-desa');
				select.empty();

				var isine = '<option value="-1">All</option>';

				$.each(data.isi, function(i, item) {
					isine += '<option value="' + item.id_desa + '">' + item.desa + '</option>';
				});
				select.append(isine);
				reload_table();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				$('.loading').fadeOut('fast');
				swal('Upss..!', 'Terjadi kesalahan jaringan error message: ' + errorThrown, 'error');
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

	function upload_logo(url) {
		window.open(url, '_blank');
	}
		
	
		function cetak() {
			var id_kecamatan = $('#f-kecamatan').val();
			var id_desa = $('#f-desa').val();
			window.open("<?php echo base_url();?>ruas_jalan/cetak?k="+id_kecamatan+"&d="+id_desa, '_blank').focus();
	}
	
	function cetak_pdf() {
		var id_kecamatan = $('#f-kecamatan').val();
			var id_desa = $('#f-desa').val();
			window.open("<?php echo base_url();?>ruas_jalan/cetak_pdf?k="+id_kecamatan+"&d="+id_desa, '_blank').focus();
		
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
</script> 
