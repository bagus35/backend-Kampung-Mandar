<?php
class Libku {
	function hitung_jam( $a, $b ) {
		$awal = strtotime( $a );
		$akhir = strtotime( $b );
		$diff = $akhir - $awal;
		$jam = floor( $diff / ( 60 * 60 ) );
		$menit = $diff - $jam * ( 60 * 60 );
		$hasil = $jam . ',' . floor( $menit / 60 );
		return $hasil;
	}

	function tglindo( $date ) {
		if ( $date == "0000-00-00" ) {
			$result = '-';
		} else {
			$BulanIndo = array( "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember" );
			$tahun = substr( $date, 0, 4 );
			$bulan = substr( $date, 5, 2 );
			$tgl = substr( $date, 8, 2 );
			$result = $tgl . " " . $BulanIndo[ ( int )$bulan - 1 ] . " " . $tahun;
		}
		return $result;
	}

	function tglindofull( $date ) {
		if ( $date == "0000-00-00" ) {
			$result = '-';
		} else {
			$BulanIndo = array( "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember" );
			$hari = array( 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu' );
			$x = date( 'N', strtotime( $date ) );
			$tahun = substr( $date, 0, 4 );
			$bulan = substr( $date, 5, 2 );
			$tgl = substr( $date, 8, 2 );
			$result = $hari[ ( int )$x - 1 ] . ', ' . $tgl . " " . $BulanIndo[ ( int )$bulan - 1 ] . " " . $tahun;
		}
		return $result;
	}

	function bulanindo( $bulan ) {
		$BulanIndo = array( "Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des" );
		$result = $BulanIndo[ ( int )$bulan - 1 ];
		return $result;
	}

	function tapel() {
		date_default_timezone_set( 'Asia/Jakarta' );
		$tahun = date( 'Y' );
		$bulan = date( 'm' );
		$thn_awal = "";
		$thn_akhir = "";
		if ( intval( $bulan ) > 6 ) {
			$thn_awal = $tahun;
			$thn_akhir = intval( $tahun ) + 1;
		} else {
			$thn_awal = intval( $tahun ) - 1;
			$thn_akhir = intval( $tahun );
		}
		$hasil[ 'tahun_awal' ] = $thn_awal;
		$hasil[ 'tahun_akhir' ] = $thn_akhir;
		return $hasil;
	}

	function tglindo_2( $date ) {
		if ( $date == "0000-00-00" ) {
			$result = '-';
		} else {
			$BulanIndo = array( "Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des" );
			$tahun = substr( $date, 0, 4 );
			$bulan = substr( $date, 5, 2 );
			$tgl = substr( $date, 8, 2 );
			$result = $tgl . " " . $BulanIndo[ ( int )$bulan - 1 ] . " " . $tahun;
		}
		return $result;
	}

	function tglDateTime( $date ) {
		$tgl = new DateTime( $date );
		$tanggal = $date->format( 'd-m-Y H:i:s' );
		return $tanggal;
	}

	function tglfromsql( $date ) {
		if ( $date == "0000-00-00" ) {
			$result = '-';
		} else if ( $date == NULL ) {
			$result = '-';
		} else {
			$tahun = substr( $date, 0, 4 );
			$bulan = substr( $date, 5, 2 );
			$tgl = substr( $date, 8, 2 );
			$result = $tgl . "/" . $bulan . "/" . $tahun;
		}
		return ( $result );
	}

	function desimal( $angka ) {
		if ( $angka == null ) {
			$hasil = '0';
		} else {
			$x = str_replace( ",", "", $angka );
			$hasil = number_format( $x, 0, ',', '.' );
		}
		echo $hasil;
	}

	function desimalkoma( $angka ) {
		if ( $angka == null ) {
			$hasil = '0,00';
		} else {
			$x = str_replace( ",", "", $angka );
			$hasil = number_format( $x, 2, ',', '.' );
		}
		return ( $hasil );
	}

	function angkasql( $angka ) {
		if ( $angka == null ) {
			$hasil = '0,00';
		} else {
			$x = str_replace( ",", "", $angka );
			$y = str_replace( ".", ",", $x );
			$hasil = $y;
		}
		return ( $hasil );
	}

	function ribuansql( $angka ) {
		if ( $angka == null ) {
			$hasil = '0';
		} else {
			$hasil = str_replace( ".", "", $angka );
		}
		return ( $hasil );
	}

	function inputAngka( $angka ) {
		if ( $angka == null ) {
			$hasil = '0';
		} else {
			$h = str_replace( ".", "", $angka );
			$hasil = str_replace( ",", ".", $h );
		}
		return ( $hasil );
	}

	function cekkosong( $isi ) {
		if ( $isi == null ) {
			$hasil = "-";
		} else {
			$hasil = $isi;
		}
		echo $hasil;
	}

	function tgl_mysql( $tgl ) {
		$pecahan = explode( "/", $tgl );
		$pc1 = $pecahan[ 0 ];
		$pc2 = $pecahan[ 1 ];
		$pc3 = $pecahan[ 2 ];
		$tgljadi = $pc3 . '-' . $pc2 . '-' . $pc1;
		return $tgljadi;
	}
	
	
	

	function hitung_umur( $tanggal_lahir ) {
		list( $year, $month, $day ) = explode( "-", $tanggal_lahir );
		$year_diff = date( "Y" ) - $year;
		$month_diff = date( "m" ) - $month;
		$day_diff = date( "d" ) - $day;
		if ( $month_diff < 0 )$year_diff--;
		elseif ( ( $month_diff == 0 ) && ( $day_diff < 0 ) )$year_diff--;
		return $year_diff;
	}

	function selisih_hari( $tgl_awal, $tgl_akhir ) {
		$tgl1 = new DateTime( $tgl_awal );
		$tgl2 = new DateTime( $tgl_akhir );
		$d = $tgl2->diff( $tgl1 )->days;
		return $d . " hari";
	}

	function kunci( $str ) {
		$kunci = 's8aya46daladljasfdln3dn74337';
		for ( $i = 0; $i < strlen( $str ); $i++ ) {
			$karakter = substr( $str, $i, 1 );
			$kuncikarakter = substr( $kunci, ( $i % strlen( $kunci ) ) - 1, 1 );
			$karakter = chr( ord( $karakter ) + ord( $kuncikarakter ) );
			$hasil .= $karakter;
		}
		return urlencode( base64_encode( $hasil ) );
	}

	function buka_kunci( $str ) {
		$str = base64_decode( urldecode( $str ) );
		$hasil = '';
		$kunci = 's8aya46daladljasfdln3dn74337';
		for ( $i = 0; $i < strlen( $str ); $i++ ) {
			$karakter = substr( $str, $i, 1 );
			$kuncikarakter = substr( $kunci, ( $i % strlen( $kunci ) ) - 1, 1 );
			$karakter = chr( ord( $karakter ) - ord( $kuncikarakter ) );
			$hasil .= $karakter;
		}
		return $hasil;
	}

	function sendNotifikasi( $token, $body, $title ) {
		$response = array();
		$msg = array(
			'body' => $body,
			'title' => $title,
			"sound" => "ring.mp3"
		);
		$fields = array(
			'to' => $token,
			'notification' => $msg
		);
		$headers = array(
			'Authorization: key=AAAAV3E3Bew:APA91bGgzW2stFgiT9GL4XF48KNJVIWgMUbNKDVLlIxF6UUbX-bmH7dcboqwZi90MpINBUdGA6z6ypswD9RbuSFstS3H7lk9H-e88caG75RPbdKEUjLZCFHwvrNSzRGQ17ElX2rshmlU',
			'Content-Type: application/json'
		);
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec( $ch );
		curl_close( $ch );
		echo $result;
	}
	
	function romawibulan($bln){
        	switch ($bln){
                    case 1: 
                        return "I";
                        break;
                    case 2:
                        return "II";
                        break;
                    case 3:
                        return "III";
                        break;
                    case 4:
                        return "IV";
                        break;
                    case 5:
                        return "V";
                        break;
                    case 6:
                        return "VI";
                        break;
                    case 7:
                        return "VII";
                        break;
                    case 8:
                        return "VIII";
                        break;
                    case 9:
                        return "IX";
                        break;
                    case 10:
                        return "X";
                        break;
                    case 11:
                        return "XI";
                        break;
                    case 12:
                        return "XII";
                        break;
              }
       }
}
?>