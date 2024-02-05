<div id="inputan"class="row sembunyi">
  <div class="col-md-12">
    <div class="tile">
      <div class="title-page">
        <h3 class="tile-title"><i class="fa fa-picture-o" aria-hidden="true"></i> ADD BANNER SLIDE</h3>
        <div class="nav-back">
          <div class="btn-group" role="group" aria-label="Basic example">
            <button class="btn btn-sm btn-danger" id="btn-close"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
          </div>
        </div>
      </div>
      <div class="tile-body">
        <form id="form-add" method="post" role="form" class="was-validated" action="<?php echo base_url();?>slide/save" enctype="multipart/form-data">
          <div class="row">
			  <div class="col-md-3">
              <div class="form-group">
                <label class="control-label">No Urut</label>
                <input type="text" class="form-control" name="no_urut" id="no_urut" required autofocus>
                <div class="valid-feedback"><i>*valid</i> </div>
                <div class="invalid-feedback"><i>*required</i> </div>
              </div>
            </div>
           
            <div class="col-md-9">
              <div class="form-group">
                <label class="control-label">Banner Slide <i>( jpg|jpeg|png )</i></label>
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
        <h3 class="tile-title"><i class="fa fa-picture-o" aria-hidden="true"></i> BANNER SLIDE</h3>
        <div class="nav-back">
          <div class="btn-group" role="group" aria-label="Basic example">
            <button class="btn btn-sm btn-primary" id="btn-add"><i class="fa fa-plus-square" aria-hidden="true"></i> Add Banner Slide</button>
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
            </div>
          </div>
          <table id="table" class="table table-bordered">
            <thead>
              <tr>
                <th class="text-uppercase v-m-align">Actions</th>
                <th valign="center" class="text-uppercase v-m-align">No</th>
                <th valign="center" class="text-uppercase v-m-align">No Urut</th>
                <th valign="center" class="text-uppercase v-m-align">Banner Slide</th>
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
<script type="text/javascript">
	
	$('#slide').addClass('active');


	var jenis = 0;
	$('#btn-add').click(function() {
		$('#inputan').removeClass('sembunyi');
		$('#isi-datane').addClass('sembunyi');
		$('#no_urut').focus();
	});
	
	$('#btn-close').click(function() {
		$('#inputan').addClass('sembunyi');
		$('#isi-datane').removeClass('sembunyi');
	});

	function show_data() {
		var a = $('#show').val();
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
				"url": "<?php echo site_url('slide/ajax_list')?>",
				"type": "POST",
				"data": {
					show: a,
				}
			},
			"columnDefs": [{
				className: "text-center",
				"targets": [0],
				width: '10'
			}, {
				className: "text-center khusus",
				"targets": [1],
				width: '10'
			}, {
				className: "text-center khusus",
				"targets": [2],
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

	$('#show').change(function() {
		reload_table();
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
		$('#form-add').attr('action', '<?php echo base_url();?>slide/save');
		$('#foto-file').prop('required', true);
		$('#no_urut').focus();
	}

	function edit_data(id) {
		$('.loading').fadeIn('fast');
		$('#form-add')[0].reset();
		$('#form-add').attr('action', "<?php echo base_url('slide/update?q=');?>" + id);
		$.ajax({
			url: "<?php echo site_url('slide/edit')?>",
			type: "POST",
			data: {
				q: id
			},
			dataType: "JSON",
			success: function(data) {
				$('.loading').fadeOut('fast');
				$('#foto-file').removeAttr('required');
				$('#no_urut').val(data.no_urut);
				$('#btn-save').text('Update');
				$('#inputan').removeClass('sembunyi');
				$('#isi-datane').addClass('sembunyi');
				$('#no_urut').focus();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				$('.loading').fadeOut('fast');
				swal('Upss..!', 'Terjadi kesalahan jaringan error message: ' + errorThrown, 'error');
			}
		});
	}

	function delete_data(x) {
		Swal.fire({
			title: "DELETE BANNER",
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
					url: "<?php echo site_url('slide/delete')?>",
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

</script> 
