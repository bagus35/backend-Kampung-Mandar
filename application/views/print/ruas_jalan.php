<?php
ob_start();
date_default_timezone_set( 'Asia/Jakarta' );
class MYPDF extends TCPDF {
  public function Footer() {
    $complex_cell_border = array(
      'T' => array( 'width' => 0.25, 'color' => array( 0, 0, 0 ), 'solid' => 1, 'cap' => 'butt' )
    );
    $this->SetFont( 'opencondensed', 'I', 7 );
    $this->Cell( 0, 0, "", $complex_cell_border );
    $this->Cell( 0, 5, 'dicetak tanggal : ' . date( "d/m/Y" ) . ' || halaman : ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M' );
  }
}
$pdf = new MYPDF( "P", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false );
// set document information
$pdf->SetCreator( PDF_CREATOR );
$pdf->SetAuthor( 'DINAS PEKERJAAN UMUM BINA MARGA DAN PENATAAN RUANG KABUPATEN BOJONEGORO' );
$pdf->SetTitle( 'REKAP DATA RUAS JALAN' );
$pdf->SetSubject( 'REKAP DATA RUAS JALAN' );
$pdf->SetKeywords( 'REKAP DATA RUAS JALAN' );
// set default header data
// set header and footer fonts
$pdf->setHeaderFont( Array( PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN ) );
$pdf->setFooterFont( Array( PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA ) );
// set default monospaced font
$pdf->SetDefaultMonospacedFont( PDF_FONT_MONOSPACED );
// set margins
$pdf->SetMargins( 5, 10, 5, true );
$pdf->SetHeaderMargin( "1" );
$pdf->SetFooterMargin( PDF_MARGIN_FOOTER );
// set auto page breaks
$pdf->SetAutoPageBreak( TRUE, PDF_MARGIN_BOTTOM );
// set image scale factor
$pdf->setImageScale( PDF_IMAGE_SCALE_RATIO );
// set some language-dependent strings (optional)
if ( @file_exists( dirname( __FILE__ ) . '/lang/eng.php' ) ) {
  require_once( dirname( __FILE__ ) . '/lang/eng.php' );
  $pdf->setLanguageArray( $l );
}
// ---------------------------------------------------------
// set font
// add a page
$pdf->AddPage();
$pdf->Ln( 2 );

$pdf->Image( base_url() . 'aset/img/logo_bojonegoro.png', 2, 12, 15, 0, 'PNG', '', '', true, 150, '', false, false, 0, false, false, false );
$pdf->setCellPaddings( 23, 0, 0, 0 );
$pdf->SetFont( 'opencondensed', 'B', 12 );
$pdf->Cell( 0, 4, "PEMERINTAH KABUPATEN BOJONEGORO", 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Ln( 5 );
$pdf->Cell( 0, 4, "DINAS PEKERJAAN UMUM, BINA MARGA DAN PENATAAN RUANG", 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Ln( 5 );
$pdf->SetFont( 'opencondensed', '', 11 );
$pdf->Cell( 0, 4, "Jl. Lettu Suyitno 39, Bojonegoro - Jawa Timur", 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Ln( 10 );

$pdf->setCellPaddings( 0, 0, 0, 0 );
$pdf->SetFont( 'opencondensed', 'B', 16 );
$pdf->Write( 0, 'DATA RUAS JALAN', '', 0, 'C', true, 0, false, false, 0 );
$pdf->Ln( 5 );
$pdf->SetFont( 'opencondensed', 'B', 12 );
$pdf->Write( 0, $desa . $kecamatan, '', 0, 'L', true, 0, false, false, 0 );
$pdf->Ln( 0 );

$content = '';
$content .= '
<style>
th{
	font-size:11px !important;
	vertical-align: middle !important;
	font-weight:bold;
	border :solid 1px #000;
	text-align: center;
}
.ngantuk td{
	font-size:11px !important;
	vertical-align: middle !important;
border :solid 1px #000;
vertical-align: middle !important;
}
.tebal{
font-weight:bold;
}
.garis-bawah{
	text-decoration: underline;
	font-weight:bold;
		text-transform: uppercase;
}
.judul{
width:100%;
}
.judul h3{
text-align:center;
margin:-5px;
}
</style>
<div class="ngantuk">
<table cellpadding="2">
<thead>
 <tr>
                <th width="50" valign="middle" rowspan="2" >No Ruas</th>
                <th width="135" rowspan="2" >Nama Ruas</th>
                <th width="50" rowspan="2" >Kecamatan</th>
                <th width="50" rowspan="2" >Desa/Kel</th>
                <th width="60" rowspan="2" >Status Jalan</th>
				<th width="40" rowspan="2" >Panjang<br>
                  <i>(m)</i></th>
                <th width="40" rowspan="2" >Lebar<br>
                  <i>(m)</i></th>
                <th width="160" colspan="4" >Kondisi</th>
                
                <th width="60" rowspan="2" >Titik Awal</th>
                <th width="60" rowspan="2" >Titik Akhir</th>
            
              </tr>
              <tr>
                <th  width="40" class="v-m-align">Baik</th>
                <th  width="40" class="v-m-align">Sedang</th>
                <th  width="40" class="v-m-align">R. Ringan</th>
                <th  width="40" class="v-m-align">R. Berat</th>
              </tr>
</thead>
<tbody>';
$pdf->SetFont( 'opencondensed', '', 11 );
// BATAS ATAS ==========================================
$no = 0;
foreach ( $isi as $p ) {
  $no++;

  $status_jalan = $p->status_jalan;
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


  $content .=
    '<tr>
		<td width="50" align="center">' . $p->no_ruas . '</td>
		<td width="135">' . $p->nama_ruas . '</td>
		<td width="50">' . $p->kecamatan . '</td>
		<td width="50">' . $p->desa . '</td>
		<td width="60">' . $status_jalan . '</td>
		<td width="40" align="center">' . number_format( $p->panjang, 0, ',', '.' ) . '</td>
		<td width="40" align="center">' . number_format( $p->lebar, 2, ',', '.' ) . '</td>
		<td width="40" align="center">' . number_format( $p->kondisi_baik, 0, ',', '.' ) . '%</td>
		<td width="40" align="center">' . number_format( $p->kondisi_sedang, 0, ',', '.' ) . '%</td>
		<td width="40" align="center">' . number_format( $p->kondisi_rusak_ringan, 0, ',', '.' ) . '%</td>
		<td width="40" align="center">' . number_format( $p->kondisi_rusak_berat, 0, ',', '.' ) . '%</td>
		<td width="60">' . $p->titik_awal . '</td>
		<td width="60">' . $p->titik_akhir . '</td>
	</tr>';
}
// BATAS BAWAH ==============================================================
$content .=
  '</tbody></table>';

$pdf->writeHTMLCell( 0, 0, '', '', $content, 0, 1, 0, true, '', true );
ob_clean();
$pdf->Output( 'rekap_ruas_jalan.pdf', 'I' );