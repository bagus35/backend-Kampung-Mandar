<?php

date_default_timezone_set( 'Asia/Jakarta' );
$id = encrypt_url( $isi->id_perahu );
$foto = $isi->foto_perahu ? : 'aset/img/belum_diupload.jpg';
$b = $nelayan->num_rows();
$nel = $nelayan->result();
$row = intval( $b ) + 5;
?>
<div id="isi-datane" class="row">
  <div class="col-md-12">
    <div class="tile">
      <div class="title-page">
        <h3 class="tile-title"><i class="fa fa-list" aria-hidden="true"></i> DETAIL REKAPITULASI PER PERAHU</h3>
        <div class="nav-back">
          <div class="btn-group" role="group" aria-label="Basic example"> <a href="<?php echo base_url();?>produksi/rekapitulasi" class="btn btn-sm btn-danger"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a> </div>
        </div>
      </div>
      <div class="tile-body">
        <table class="table">
          <tbody>
            <tr>
              <td rowspan="<?php echo $row;?>" width="200"><img class="img-fluid" src="<?php echo base_url().$foto;?>"</td>
              <td width="120">Tanggal</td>
              <td width="10">:</td>
              <td><?php echo $periode;?></td>
              <td width="100"></td>
              <td width="120">Total Ikan</td>
              <td width="10">:</td>
              <td><?php echo $total_ikan.' KG';?></td>
            </tr>
            <tr>
              <td>Nama Perahu</td>
              <td>:</td>
              <td><?php echo $isi->nama_perahu;?></td>
              <td></td>
              <td>Total Pendapatan</td>
              <td>:</td>
              <td><?php echo 'Rp. '.$total_pendapatan;?></td>
            </tr>
            <tr>
              <td colspan="7"><strong>Nama Nelayan</strong></td>
            </tr>
            <?php $no=0; foreach($nel as $n): $no++;?>
            <tr>
              <td colspan="7"><?php echo $no.'. '. $n->nama_nelayan;?></td>
            </tr>
            <?php endforeach ?>
            <tr>
              <td colspan="7"><strong>Konsumsi BBM</strong></td>
            </tr>
          <td>Bensin</td>
            <td>:</td>
            <td><?php echo $total_bensin;?></td>
            <td></td>
            <td width="150">Solar</td>
            <td width="10">:</td>
            <td><?php echo $total_solar;?></td>
          <tr>
            <td colspan="8"></td>
          </tr>
          </tbody>
          
        </table>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <div class="title-page">
        <h3 class="tile-title"><i class="fa fa-list" aria-hidden="true"></i> DETAIL TANGKAPAN</h3>
      </div>
      <div class="tile-body">
        <table id="table" class="table table-bordered">
          <thead>
            <tr>
              <th>NO</th>
              <th>NAMA IKAN</th>
              <th>BERAT (kg)</th>
              <th>TOTAL PENDAPATAN</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <div class="title-page">
        <h3 class="tile-title"><i class="fa fa-list" aria-hidden="true"></i> DETAIL TIMBANGAN</h3>
      </div>
      <div class="tile-body">
        <table id="table-timbangan" class="table table-bordered">
          <thead>
            <tr>
              <th>NO</th>
              <th>FOTO</th>
              <th>TEMPAT</th>
              <th>JENIS IKAN</th>
              <th>BERAT</th>
              <th>HARGA</th>
              <th>TOTAL</th>
              <th>PEMBELI</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
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
			"url": "<?php echo site_url('produksi/ajax_list_tangkapan')?>",
			"type": "POST",
			data: function(d){
            	d.tanggal_awal =  '<?php echo $start;?>';
            	d.tanggal_akhir = '<?php echo $end;?>';
				d.id ='<?php echo $id;?>';
        	}
		},
		"columnDefs": [{
			className: "text-center khusus",
			"targets": [0],
			width: '80'
		},{
			className: "dt-right",
			"targets": [2],
		},{
			className: "dt-right",
			"targets": [3],
		}]
	});
	
var table_timbang = $('#table-timbangan').DataTable({
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
			"url": "<?php echo site_url('produksi/ajax_list_timbangan')?>",
			"type": "POST",
			data: function(d){
            	d.tanggal_awal =  '<?php echo $start;?>';
            	d.tanggal_akhir = '<?php echo $end;?>';
				d.id ='<?php echo $id;?>';
        	}
		},
		"columnDefs": [{
			className: "text-center khusus",
			"targets": [0],
			width: '80'
		},{
			className: "text-center khusus",
			"targets": [1],
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
		}]
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
