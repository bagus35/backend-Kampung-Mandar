<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAzAJjugfRy2xtB9mAPDvcJKxXt_hiwWGI&callback=initMap"></script>
<?php
switch ( $isi->status ) {
  case '2':
    $status = "Peninjauan";
    break;
  case '3':
    $status = "Perencanaan";
    break;
  case '4':
    $status = "Pengerjaan";
    break;
  case '5':
    $status = "Selesa";
    break;
  case '0':
    $status = "Dibatalkan";
    break;
  default:
    $status = "Belum Ditanggapi";
    break;
}


$status_jalan = $ruas->status_jalan;
switch ( $status_jalan ) {
  case '1':
    $status_jalan = "Jalan Nasional";
    break;
  case '2':
    $status_jalan = "Jalan Propinsi";
    break;
  case '3':
    $status_jalan = "Jalan Kabupaten";
    break;
  case '4':
    $status_jalan = "Jalan Kota";
    break;
  case '4':
    $status_jalan = "Jalan Desa";
    break;
  default:
    $status_jalan = "-";
    break;
}


?>
<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <div class="title-page">
        <h3 class="tile-title"><i class="fa fa-road" aria-hidden="true"></i> COMPLAIN DETAILS</h3>
        <div class="nav-back">
          <div class="btn-group" role="group" aria-label="Basic example"> <a href="<?php echo base_url();?>komplain" class="btn btn-sm btn-danger"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            <button class="btn btn-sm btn-secondary" onClick="tanggapi()" id="btn-add-keluar"><i class="fa fa-commenting" aria-hidden="true"></i> Tanggapi</button>
          </div>
        </div>
      </div>
      <div class="tile-body">
        <div class="row">
          <div class="col-md-6">
            <table class="table">
              <tr>
                <td colspan="3"><a>KOMPLAIN</a></td>
              </tr>
              <tr>
                <td>Tanggal/Waktu</td>
                <td>:</td>
                <td><?php echo date('d/m/Y H:i',strtotime($isi->tanggal));?></td>
              </tr>
              <tr>
                <td>Status</td>
                <td>:</td>
                <td id="stt"><b><?php echo strtoupper($status);?></b></td>
              </tr>
              <tr>
                <td>Keterangan</td>
                <td>:</td>
                <td><?php echo $isi->keterangan?:'-';?></td>
              </tr>
              <tr>
                <td colspan="3"></td>
              </tr>
            </table>
            <table class="table">
              <tr>
                <td colspan="3"><b>PELAPOR</b></td>
              </tr>
              <tr>
                <td>Nama Pelapor</td>
                <td>:</td>
                <td><b><?php echo strtoupper($isi->nama);?></b></td>
              </tr>
              <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><?php echo $isi->alamat;?></td>
              </tr>
              <tr>
                <td>Desa/Kelurahan</td>
                <td>:</td>
                <td><?php echo $isi->desa;?></td>
              </tr>
              <tr>
                <td>Kecamatan</td>
                <td>:</td>
                <td><?php echo $isi->kecamatan;?></td>
              </tr>
              <tr>
                <td>No HP</td>
                <td>:</td>
                <td><?php echo $isi->no_hp;?></td>
              </tr>
              <tr>
                <td colspan="3"></td>
              </tr>
            </table>
          </div>
          <div class="col-md-6">
            <div class="foto-komplain"> <a href="javascript:void()" onClick="lihat_foto()">
              <div class="mask-foto"> <img src="<?php echo base_url();?>aset/img/ic_search.png"> </div>
              <img src="<?php echo base_url().$isi->foto_komplain;?>" class="img-fluid"></a> </div>
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
        <h3 class="tile-title"><i class="fa fa-commenting-o" aria-hidden="true"></i> TANGGAPAN</h3>
      </div>
      <div class="tile-body">
        <div class="table-responsive">
          <div class="menu-filter">
            <div class="row">
              <div class="col-md-4">
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
              <div class="col-md-8">
                <div class="form-group">
                  <label class="control-label">Cari</label>
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
                <th class="text-uppercase v-m-align">Actions</th>
                <th class="text-uppercase v-m-align">Tanggal</th>
                <th class="text-uppercase v-m-align">Tanggapan</th>
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
<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <div class="title-page">
        <h3 class="tile-title"><i class="fa fa-map-o" aria-hidden="true"></i> KOORDINAT DAN DATA RUAS JALAN</h3>
      </div>
      <div class="tile-body">
        <div class="isi-data">
          <div class="row">
            <div class="col-md-6">
              <div class="isi-detail">
                <div class="bungkus-map">
                  <div id="panel"></div>
                  <div id="map" style="height: 100px;"></div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <table class="table">
                <tbody>
                  <tr>
                    <td width="120">Nomor Ruas</td>
                    <td width="4">:</td>
                    <td><?php echo $ruas->no_ruas;?></td>
                  </tr>
                  <tr>
                    <td width="120">Nama Ruas</td>
                    <td width="4">:</td>
                    <td><?php echo $ruas->nama_ruas;?></td>
                  </tr>
                  <tr>
                    <td>Kecamatan</td>
                    <td>:</td>
                    <td><?php echo $ruas->kecamatan;?></td>
                  </tr>
                  <tr>
                    <td>Desa/Kelurahan</td>
                    <td>:</td>
                    <td><?php echo $ruas->desa;?></td>
                  </tr>
                  <tr>
                    <td>Status Jalan</td>
                    <td>:</td>
                    <td><?php echo $status_jalan;?></td>
                  </tr>
                  <tr>
                    <td>Kondisi</td>
                    <td>:</td>
                    <td>Baik : <?php echo  number_format($ruas->kondisi_baik,0,',','.');?>% Sedang : <?php echo  number_format($ruas->kondisi_sedang,0,',','.');?>% Rusak Ringan : <?php echo number_format($ruas->kondisi_rusak_ringan,0,',','.');?>% Rusak Berat : <?php echo number_format($ruas->kondisi_rusak_berat,0,',','.');?>%</td>
                  </tr>
                  <tr>
                    <td>Panjang</td>
                    <td>:</td>
                    <td><?php echo number_format($ruas->panjang,0,',','.');?>m</td>
                  </tr>
                  <tr>
                    <td>Lebar</td>
                    <td>:</td>
                    <td><?php echo number_format($ruas->lebar,2,',','.');?>m</td>
                  </tr>
                  <tr>
                    <td>Titik Awal</td>
                    <td>:</td>
                    <td><?php echo $ruas->titik_awal;?></td>
                  </tr>
                  <tr>
                    <td>Titik Akhir</td>
                    <td>:</td>
                    <td><?php echo $ruas->titik_akhir;?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="fotone" class="sembunyi"> <a href="<?php echo base_url().$isi->foto_komplain;?>" id="img-fotone"> <img src="<?php echo base_url().$isi->foto_komplain;?>" class="img-fluid"> </a> </div>
<div id="modal-tanggapi" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header bg-hijau">
        <h5 class="modal-title">Tanggapan Komplain</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body bg-putih">
        <form id="form-tanggapan" method="post" role="form" class="was-validated" action="<?php echo base_url();?>komplain/save_tanggapan">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="control-label">Status</label>
                <select class="form-control" name="status" id="status" required autofocus>
                  <option value=""></option>
                  <option value="2">Peninjauan</option>
                  <option value="3">Perencanaan</option>
                  <option value="4">Pengerjaan</option>
                  <option value="5">Selesai</option>
                  <option value="0">Batalkan</option>
                </select>
                <div class="valid-feedback"><i>*valid</i> </div>
                <div class="invalid-feedback"><i>*required</i> </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label class="control-label">Komentar</label>
                <textarea class="form-control" rows="4" name="komentar" id="komentar" required></textarea>
                <div class="valid-feedback"><i>*valid</i> </div>
                <div class="invalid-feedback"><i>*required</i> </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 btn-kebawah">
              <div class="btn-group d-flex">
                <button id="btn-save" type="submit" class="btn btn-sm btn-success w-100"><i class="fa fa-floppy-o"></i> Save</button>
                <button id="btn-reset" type="reset" onClick="reset_form()" class="btn btn-sm btn-secondary w-100"><i class="fa fa-retweet"></i> Reset</button>
              </div>
            </div>
          </div>
          <input type="hidden" name="id_komplain" id="id_komplain" value="<?php echo encrypt_url($isi->id_komplain);?>">
        </form>
      </div>
    </div>
  </div>
</div>
<script> 
	$(document).ready(function() {
		lightGallery(document.getElementById('fotone'), {
			thumbnail: true,
			animateThumb: false,
			showThumbByDefault: false
		});
	});
	$('#komplain').addClass('active');

	function lihat_foto() {
		$('#img-fotone')[0].click();
	};

	function tanggapi() {
		$('#modal-tanggapi').modal('show');
		reset_form();
		$('#status').val("<?php echo $isi->status;?>");
	}

	function show_data() {
		var a = $('#cari').val();
		var b = $('#show').val();
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
				"url": "<?php echo site_url('komplain/ajax_list_tanggapan')?>",
				"type": "POST",
				"data": {
					cari: a,
					show: b,
					id_komplain: "<?php echo encrypt_url($isi->id_komplain);?>",
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
			}],
		});
	}

	function reload_table() {
		$('#table').DataTable().destroy();
		show_data();
	}
	$('#cari').keyup(function() {
		reload_table();
		$('#cari').focus();
	});
	$('#show,#f-status').change(function() {
		reload_table();
	});
	$(function() {
		reload_table();
	});
	$(function() {
		$('#form-tanggapan').submit(function(evt) {
			$('.loading').fadeIn('fast');
			evt.preventDefault();
			evt.stopImmediatePropagation();
			var url = $(this).attr('action');
			var status = $("#status option:selected").text();
			var formData = new FormData($(this)[0]);
			$.ajax({
				url: url,
				type: "POST",
				dataType: "JSON",
				data: formData,
				processData: false,
				contentType: false,
				success: function(data) {
					if(data.status) {
						$('.loading').fadeOut('fast');
						reset_form();
						reload_table();
						$('#stt').html("<b>" + status.toUpperCase() + "</b>");
						$('#modal-tanggapi').modal('hide');
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
		$('#form-tanggapan')[0].reset();
		$('#btn-save').html('<i class="fa fa-floppy-o"></i> Save');
		$('#form-tanggapan').attr('action', '<?php echo base_url();?>komplain/save_tanggapan');
	}

	function edit_data(id) {
		$('.loading').fadeIn('fast');
		$('#form-tanggapan')[0].reset();
		$('#form-tanggapan').attr('action', "<?php echo base_url('komplain/update_tanggapan?q=');?>" + id);
		$.ajax({
			url: "<?php echo site_url('komplain/edit_tanggapan')?>",
			type: "POST",
			data: {
				q: id
			},
			dataType: "JSON",
			success: function(data) {
				$('.loading').fadeOut('fast');
				$('#status').val(data.status);
				$('#komentar').val(data.komentar);
				$('#btn-save').html('<i class="fa fa-floppy-o"></i> Update');
				$('#modal-tanggapi').modal('show');
			},
			error: function(jqXHR, textStatus, errorThrown) {
				$('.loading').fadeOut('fast');
				swal('Upss..!', 'Terjadi kesalahan jaringan error message: ' + errorThrown, 'error');
			}
		});
	}

	function delete_data(x) {
		Swal.fire({
			title: "DELETE TANGGAPAN!",
			text: "Anda akan menghapus tanggapan ini?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, Hapus!',
			cancelButtonText: "No, Batalkan!",
		}).then((result) => {
			if(result.value) {
				$('.loading').fadeIn('fast');
				$.ajax({
					url: "<?php echo site_url('komplain/delete_tanggapan')?>",
					type: "POST",
					data: {
						q: x
					},
					dataType: "JSON",
					success: function(data) {
						$('.loading').fadeOut('fast');
						if(data.status) {
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
	var asal = '<?php echo trim($ruas->koordinat_titik_awal);?>';
	var a = asal.split(",")
	var b = parseFloat(a[0]);
	var c = parseFloat(a[1])
	var tujuan = '<?php echo trim($ruas->koordinat_titik_akhir);?>';
	var t = tujuan.split(",");
	var u = parseFloat(t[0]);
	var v = parseFloat(t[1]);
	
		var rusak = '<?php echo trim($isi->koordinat);?>';
	var w = rusak.split(",");
	var x = parseFloat(w[0]);
	var y = parseFloat(w[1]);

	function initMap() {
		var directionsService = new google.maps.DirectionsService;
		var map = new google.maps.Map(document.getElementById('map'), {
			styles: [{
				"featureType": "poi",
				"stylers": [{
					"visibility": "off"
				}]
			}]
		});
		var markerse = [{
			lat: b,
			lng: c
		}, {
			lat: u,
			lng: v
		}, {
			lat: x,
			lng: y
		}]; //some array
		var boundse = new google.maps.LatLngBounds();
		for(var i = 0; i < markerse.length; i++) {
			boundse.extend(markerse[i]);
		}
		map.fitBounds(boundse);
		var icon_awal = {
			url: "<?php echo base_url('aset/img/ic_marker_awal.png');?>",
			scaledSize: new google.maps.Size(40, 40),
		};
		var icon_akhir = {
			url: "<?php echo base_url('aset/img/ic_marker_awal.png');?>",
			scaledSize: new google.maps.Size(40, 40),
		};
		var icon_rusak = {
			url: "<?php echo base_url('aset/img/ic_marker.png');?>",
			scaledSize: new google.maps.Size(50, 50),
		};
		var info = new google.maps.InfoWindow({
			content: '<?php echo $ruas->nama_ruas;?>',
			disableAutoPan: false,
			maxWidth: 150,
			pixelOffset: new google.maps.Size(0, 0),
			zIndex: null,
			boxStyle: {
				background: "url('http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/examples/tipbox.gif') no-repeat",
				opacity: 0.75,
				width: "100px"
			},
			closeBoxMargin: "12px 4px 2px 2px",
			closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif",
			infoBoxClearance: new google.maps.Size(1, 1)
		});
		calculateAndDisplayRoute(directionsService, map, icon_awal, icon_akhir, info);
		he = window.innerHeight;
		$('#map').css('height', '320px');
		
		new google.maps.Marker({
			position: new google.maps.LatLng(x, y),
			icon: icon_rusak,
			map: map
		});
		
	}

	function calculateAndDisplayRoute(directionsService, map, icon_awal, icon_akhir, info) {
		var requestArray = [],
			renderArray = [];
		var cur = 0;
		var bounds = new google.maps.LatLngBounds();
		var marker_awal = new google.maps.Marker({
			position: new google.maps.LatLng(b, c),
			icon: icon_awal,
			map: map,
		});
		marker_awal.addListener('click', function() {
			info.open(map, this);
		});
		var marker_akhir = new google.maps.Marker({
			position: new google.maps.LatLng(u, v),
			icon: icon_akhir,
			map: map
		});
		
		
	
		
		marker_akhir.addListener('click', function() {
			info.open(map, this);
		});
		var request = {
			origin: {
				lat: b,
				lng: c
			},
			destination: {
				lat: u,
				lng: v
			},
			travelMode: google.maps.DirectionsTravelMode.DRIVING
		};
		requestArray.push(request);
		if(requestArray.length > 0) {
			directionsService.route(requestArray[cur], directionResults);
		}

		function directionResults(result, status) {
			if(status == google.maps.DirectionsStatus.OK) {
				renderArray[cur] = new google.maps.DirectionsRenderer({
					preserveViewport: true,
					suppressMarkers: true
				});
				renderArray[cur].setMap(map);
				renderArray[cur].setDirections(result);
			}
			cur++;
			if(cur < requestArray.length) {
				directionsService.route(requestArray[cur], directionResults);
			}
		}
	}
	
	
	
</script> 
