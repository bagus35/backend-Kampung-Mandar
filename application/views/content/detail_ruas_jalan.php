<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAzAJjugfRy2xtB9mAPDvcJKxXt_hiwWGI&callback=initMap"></script>
<?php

$foto = $isi->foto;

if ( $foto == NULL ) {
  $foto = 'aset/img/k_no_logo.png';
}

$status_jalan = $isi->status_jalan;
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
        <h3 class="tile-title"><i class="fa fa-road" aria-hidden="true"></i> DETAIL RUAS JALAN</h3>
        <div class="nav-back">
          <div class="btn-group" role="group" aria-label="Basic example"> <a href="<?php echo base_url();?>ruas_jalan" class="btn btn-sm btn-danger"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a> </div>
        </div>
      </div>
      <div class="tile-body">
        <div class="isi-data">
          <div class="row">
            <div class="col-md-12">
              <div class="isi-detail">
                <table class="table">
                  <tbody>
                    <tr>
                      <td width="120">Nomor Ruas</td>
                      <td width="4">:</td>
                      <td width="200"><?php echo $isi->no_ruas;?></td>
                      <td width="30"></td>
                      <td width="120">Kondisi</td>
                      <td width="4">:</td>
                      <td width="200">Baik : <?php echo  number_format($isi->persen_baik,0,',','.');?>% Sedang : <?php echo  number_format($isi->persen_sedang,0,',','.');?>% Rusak Ringan : <?php echo number_format($isi->persen_rusak_ringan,0,',','.');?>% Rusak Berat : <?php echo number_format($isi->persen_rusak_berat,0,',','.');?>%</td>
                    </tr>
                    <tr>
                      <td width="120">Nama Ruas</td>
                      <td width="4">:</td>
                      <td><b><?php echo strtoupper($isi->nama_ruas);?></b></td>
                      <td></td>
                      <td>Panjang</td>
                      <td>:</td>
                      <td><?php echo number_format($isi->panjang,0,',','.');?>m</td>
                    </tr>
                    <tr>
                      <td>Kecamatan</td>
                      <td>:</td>
                      <td><?php echo $isi->kecamatan;?></td>
                      <td></td>
                      <td>Lebar</td>
                      <td>:</td>
                      <td><?php echo number_format($isi->lebar,2,',','.');?>m</td>
                    </tr>
                    <tr>
                      <td>Desa/Kelurahan</td>
                      <td>:</td>
                      <td><?php echo $isi->desa;?></td>
                      <td></td>
                      <td>Titik Awal</td>
                      <td>:</td>
                      <td><?php echo $isi->titik_awal;?></td>
                    </tr>
                    <tr>
                      <td>Status Jalan</td>
                      <td>:</td>
                      <td><?php echo $status_jalan;?></td>
                      <td></td>
                      <td>Titik Akhir</td>
                      <td>:</td>
                      <td><?php echo $isi->titik_akhir;?></td>
                    </tr>
					  <tr>
					  	<td colspan="7"></td>
					  </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
	
          <div class="row">
            <div class="col-md-6">
              <div class="foto-komplain"> <a href="javascript:void(0)" onClick="lihat_foto()">
                <div class="mask-foto"> <img src="<?php echo base_url();?>aset/img/ic_search.png"> </div>
                <img src="<?php echo base_url().$foto;?>" class="img-fluid"></a> </div>
            </div>
            <div class="col-md-6">
              <div class="bungkus-map">
                <div class="isi-detail">
                  <div id="panel"></div>
                  <div id="map" style="height: 500px;"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="fotone" class="sembunyi"> <a href="<?php echo base_url().$foto;?>" id="img-fotone"> <img src="<?php echo base_url().$foto;?>" class="img-fluid"> </a> </div>
<script> 
	
		$(document).ready(function() {
		lightGallery(document.getElementById('fotone'), {
			thumbnail: true,
			animateThumb: false,
			showThumbByDefault: false
		});
	});
	
	$('#ruas-jalan').addClass('active');
 $(function() {
	initMap();
});

var asal = '<?php echo trim($isi->koordinat_titik_awal);?>';
var a = asal.split(",")
var b = parseFloat(a[0]);
var c = parseFloat(a[1])
var tujuan = '<?php echo trim($isi->koordinat_titik_akhir);?>';
var t = tujuan.split(",");
var u = parseFloat(t[0]);
var v = parseFloat(t[1]);

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
	}]; //some array
	var boundse = new google.maps.LatLngBounds();
	for (var i = 0; i < markerse.length; i++) {
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
	var info = new google.maps.InfoWindow({
		content: '<?php echo $isi->nama_ruas;?>',
		disableAutoPan: false,
		maxWidth: 150,
		pixelOffset: new google.maps.Size(0, 0),
		zIndex: null,
		boxStyle: {
			background: "url('http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/examples/tipbox.gif') no-repeat",
			opacity: 0.75,
			width: "200px"
		},
		closeBoxMargin: "12px 4px 2px 2px",
		closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif",
		infoBoxClearance: new google.maps.Size(1, 1)
	});
	calculateAndDisplayRoute(directionsService, map, icon_awal, icon_akhir, info);
	he = document.querySelector('.mask-foto').offsetHeight;
	let tinggi = he - (he/2);
	console.log(tinggi+ "|"+he);
	$('#map').css('height', he+'px');
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

	if (requestArray.length > 0) {
		directionsService.route(requestArray[cur], directionResults);
	}

	function directionResults(result, status) {
		if (status == google.maps.DirectionsStatus.OK) {
			renderArray[cur] = new google.maps.DirectionsRenderer({
				preserveViewport: true,
				suppressMarkers: true
			});
			renderArray[cur].setMap(map);
			renderArray[cur].setDirections(result);
		}
		cur++;
		if (cur < requestArray.length) {
			directionsService.route(requestArray[cur], directionResults);
		}
	}
}
	
		function lihat_foto() {
		$('#img-fotone')[0].click();
	};
</script> 
