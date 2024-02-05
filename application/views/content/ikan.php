
<div id="inputan"class="row sembunyi">
  <div class="col-md-12">
    <div class="tile">
      <div class="title-page">
        <h3 class="tile-title"><i class="fa fa-list" aria-hidden="true"></i> ADD NAMA IKAN</h3>
        <div class="nav-back">
          <div class="btn-group" role="group" aria-label="Basic example">
            <button class="btn btn-sm btn-danger" id="btn-close"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
          </div>
        </div>
      </div>
      <div class="tile-body">
        <form id="form-add" method="post" role="form" class="was-validated" action="<?php echo base_url();?>ikan/save">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="col-form-label">Nama Ikan</label>
                <input type="text" class="form-control" name="ikan" id="ikan" required autofocus>
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
        <h3 class="tile-title"><i class="fa fa-list" aria-hidden="true"></i> ADD NAMA IKAN</h3>
        <div class="nav-back">
          <div class="btn-group" role="group" aria-label="Basic example">
            <button class="btn btn-sm btn-primary" id="btn-add"><i class="fa fa-plus-square" aria-hidden="true"></i> Tambah</button>
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
                <th>NAMA IKAN</th>
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
	$('#settings').addClass('active');
	$('#user').addClass('radius-bawah');
	$('#pengaturan').addClass('radius-atas');

	$('#btn-add').click(function() {
		$('#inputan').removeClass('sembunyi');
		$('#isi-datane').addClass('sembunyi');
		$('#ikan').focus();
	});
	
	$('#btn-close').click(function() {
		$('#inputan').addClass('sembunyi');
		$('#isi-datane').removeClass('sembunyi');
	});
	$(function() {
		$('#form-add').submit(function(evt) {
			$('.loading').fadeIn('fast');
			evt.preventDefault();
			evt.stopImmediatePropagation();
			var url = $(this).attr('action');
			var formData = new FormData($(this)[0]);
			$.ajax({
				url: url,
				type: "POST",
				dataType: "JSON",
				data: formData,
				processData: false,
				contentType: false,
				success: function(data) {
					if (data.status) {
						$('.loading').fadeOut('fast');
						reset_form();
						reload_table();
						$('#f-input').addClass('sembunyi');
						$('#f-data').removeClass('sembunyi');
						
					} else {
						$('.loading').fadeOut('fast');
						Swal.fire("Gagal Simpan!", "Mohon periksa kembali inputan anda!", "error");
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					$('.loading').fadeOut('fast');
					Swal.fire('Upss..!', 'Terjadi kesalahan jaringan error message: ' + errorThrown, 'error');
				}
			});
		});
	});
	function reset_form() {
		$('#form-add')[0].reset();
		$('#btn-save').html('Save');
		$('#form-add').attr('action', '<?php echo base_url();?>ikan/save');
		$('#inputan').addClass('sembunyi');
		$('#isi-datane').removeClass('sembunyi');
		$('#nama_ikan').focus();
	}
	function edit_data(id) {
		$('.loading').fadeIn('fast');
		$('#form-add')[0].reset();
		$('#form-add').attr('action', "<?php echo base_url('ikan/update?q=');?>" + id);
		$.ajax({
			url: "<?php echo site_url('ikan/edit')?>",
			type: "POST",
			data: {
				q: id
			},
			dataType: "JSON",
			success: function(data) {
				$('.loading').fadeOut('fast');
				$('#ikan').val(data.ikan);
				$('#btn-save').text('i class="fa fa-floppy-o"></i> Update');
				$('#inputan').removeClass('sembunyi');
				$('#isi-datane').addClass('sembunyi');
				$('#ikan').focus();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				$('.loading').fadeOut('fast');
				Swal.fire('Upss..!', 'Terjadi kesalahan jaringan error message: ' + errorThrown, 'error');
			}
		});
	}
	
	function delete_data(x) {
		Swal.fire({
			title: "DELETE NAMA IKAN. HATI-HATI!",
			text: "Sebelum anda menghapus data ikan ini. Pastikan tidak ada data yang terkait dengan ikan ini. Kesalahan penghapusan menyebabkan terhapusnya data yang terkait dengan ikan ini?",
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
					url: "<?php echo site_url('ikan/delete')?>",
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
			"url": "<?php echo site_url('ikan/ajax_list')?>",
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
		}]
	});
	
	
	function reload_table() {
		table.ajax.reload(null, false); //reload datatable ajax
	}
		

</script> 
