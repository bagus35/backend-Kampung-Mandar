
<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <div class="title-page">
        <h3 class="tile-title"><i class="fa fa-users" aria-hidden="true"></i> LIST ANDROID USER</h3>
<!--
        <div class="nav-back">
          <div class="btn-group" role="group" aria-label="Basic example">
            <button class="btn btn-sm btn-success" onClick="cetak()" id="btn-add-keluar"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export to Excel</button>
            <button class="btn btn-sm btn-warning" onClick="cetak_pdf()" id="btn-add-keluar"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Export to PDF</button>
          </div>
        </div>
-->
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
                  <label class="control-label">Cari Pengguna</label>
                  <div class="input-group flex-nowrap">
                    <div class="input-group-prepend"> <span class="input-group-text bg-kuning" id="addon-wrapping"><i class="fa fa-user-o" aria-hidden="true"></i></span> </div>
                    <input type="text" class="form-control" name="cari" id="cari">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <table id="table" class="table table-bordered">
            <thead>
              <tr>
				  <th class="text-uppercase v-m-align">Status</th>
                <th class="text-uppercase v-m-align">No</th>
                <th class="text-uppercase v-m-align">Foto Profil</th>
                <th class="text-uppercase v-m-align">Nama</th>
                <th class="text-uppercase v-m-align">No HP</th>
                <th class="text-uppercase v-m-align">Alamat</th>
                
                <th class="text-uppercase v-m-align">st</th>
                <th class="text-uppercase v-m-align">Jumlah Laporan</th>
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
	
	$('#kontrol').addClass('active');


	var jenis = 0;
	

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
				"url": "<?php echo site_url('kontrol_user_android/ajax_list')?>",
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
				width: '10'
			}, {
				className: "text-center khusus",
				"targets": [1],
				width: '10'
			}, {
				className: "dt-center",
				"targets": [2],
				width: '5'
			}, {
				className: "dt-center",
				"targets": [4],
				width: '5'
			},{
                "targets": [ 6 ],
                "visible": false
            },{
				className: "text-center khusus",
				"targets": [7],
				width: '10'
			}],"drawCallback": function( settings ) {
         		$('.onoff').bootstrapToggle();
    		},
      'rowCallback': function(row, data, index){
       
   
		 var st = data[6];
		  if(st == 2){
			  $(row).addClass('bg-merah-ind');
		  }
		  
		
  }
		
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


	function get_desa_filter(id_kecamatan) {
		$.ajax({
			url: "<?php echo site_url('komplain/get_desa')?>",
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
	

		$(function() {
		reload_table();
		});
	
	
		function update_status(id){
		 $( '.loading' ).fadeIn( 'fast' );
		var status = 2;
		if($('#'+id).is(":checked")){
			 status = 1;
		}
		  $.ajax( {
                    url: "<?php echo site_url('kontrol_user_android/update_status')?>",
                    type: "POST",
                    data: {
                        key: id,
						st : status
                    },
                    dataType: "JSON",
                    success: function ( data ) {
                        $( '.loading' ).fadeOut( 'fast' );
						reload_table();
                  
                    },
                    error: function ( jqXHR, textStatus, errorThrown ) {
                        $( '.loading' ).fadeOut( 'fast' );
                        Swal.fire( "Upss...!", "Terjadi kesalahan jaringan pesan error : !" + errorThrown, "error" );
                    }
                } );
	}
	
		
</script> 
