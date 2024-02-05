<?php

date_default_timezone_set( 'Asia/Jakarta' );
?>
<div id="isi-datane" class="row">
  <div class="col-md-12">
    <div class="tile">
      <div class="title-page">
        <h3 class="tile-title"><i class="fa fa-list" aria-hidden="true"></i> REKAPITULASI PRODUKSI</h3>
        <div class="nav-back">
          <div class="btn-group" role="group" aria-label="Basic example"> <a href="<?php echo base_url();?>produksi" class="btn btn-sm btn-danger"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a> </div>
        </div>
      </div>
      <div class="tile-body">
        <div class="table-responsive">
          <div class="filtere">
            <div class="row">
              <div class="col-md-12">
                <div class="input-group mb-3">
                  <div class="input-group-prepend"> <span class="input-group-text">Tgl Awal : </span> </div>
                	<input id="tgl_awal" type="date" class="form-control" placeholder="--/--/----" value="<?php echo date('Y-m-01');?>">
               
                </div>
              </div>
            </div>
			  
			              <div class="row">
              <div class="col-md-12">
                <div class="input-group mb-3">
                  <div class="input-group-prepend"> <span class="input-group-text">Tgl Akhir : </span> </div>
              
                  <input id="tgl_akhir" type="date" class="form-control" placeholder="--/--/----"  value="<?php echo date('Y-m-d');?>">
              
                </div>
              </div>
            </div>
          </div>
          <table id="table" class="table table-bordered">
            <thead>
              <tr>
                <th rowspan="3">ACTIONS</th>
                <th rowspan="3">NO</th>
                <th rowspan="3">TANGGAL</th>
                <th rowspan="3">NAMA PERAHU</th>
                <th colspan="2">HASIL TANGKAPAN</th>
                <th colspan="6">KONSUMSI BBM</th>
              </tr>
              <tr>
                <th rowspan="2">BERAT (kg)</th>
                <th rowspan="2">TOTAL PENDAPATAN</th>
                <th colspan="2">BENSIN</th>
                <th colspan="2">SOLAR</th>
                <th colspan="2">TOTAL BBM</th>
              </tr>
              <tr>
                <th>LITER</th>
                <th>NOMINAL</th>
                <th>LITER</th>
                <th>NOMINAL</th>
                <th>LITER</th>
                <th>NOMINAL</th>
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
			"url": "<?php echo site_url('produksi/ajax_list_rekapitulasi')?>",
			"type": "POST",
			data: function(d){
            	d.tanggal_awal =  $('#tgl_awal').val();
            	d.tanggal_akhir = $('#tgl_akhir').val();
        	}
		},
		"columnDefs": [{
			className: "text-center khusus",
			"targets": [0],
			width: '10'
		},{
			className: "text-center khusus",
			"targets": [1],
			width: '10'
		},{
			className: "text-center khusus",
			"targets": [2],
			width: '80'
		},{
			className: "dt-right",
			"targets": [4],
		},{
			className: "dt-right",
			"targets": [5],
		},{
			className: "dt-right",
			"targets": [6],
		},{
			className: "dt-right",
			"targets": [7],
		},{
			className: "dt-right",
			"targets": [8],
		},{
			className: "dt-right",
			"targets": [9],
		},{
			className: "dt-right",
			"targets": [10],
		},{
			className: "dt-right",
			"targets": [11],
		}]
	});
	
	function reload_table() {
		table.ajax.reload(null, false); //reload datatable ajax
	}
	
	$( function () {
			
		$('#tgl_awal').change(function(){
			var x = $(this).val();
			if(x.length == 10){
				reload_table();
			}
		});
		
		$('#tgl_akhir').change(function(){
			var x = $(this).val();
			if(x.length == 10){
				reload_table();
			}
		});

		$('#btn-bersih').click(function(){
			$('#tgl_awal').val("<?php echo date('01/m/Y');?>");
			$('#tgl_akhir').val("<?php echo date('t/m/Y');?>");
			reload_table();
		});
		
    } );
	
	function detail_data(id){
		var start_date = $('#tgl_awal').val();
		var end_date = $('#tgl_akhir').val();
		var x ="<?php echo base_url();?>produksi/detail_rekap?q="+id+"&start_date="+start_date+"&end_date="+end_date;
		window.location.href = x;
	}

</script> 
