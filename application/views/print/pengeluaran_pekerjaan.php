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
$pdf->SetAuthor( 'PT. PRADNYA PARAMITA KONSULTAN' );
$pdf->SetTitle( 'PENGELUARAN' );
$pdf->SetSubject( 'PENGELUARAN' );
$pdf->SetKeywords( 'PENGELUARAN' );
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

$pdf->Image( base_url() . 'aset/img/ic_logo.png', 10, 12, 15, 0, 'PNG', '', '', true, 150, '', false, false, 0, false, false, false );
$pdf->setCellPaddings( 23, 0, 0, 0 );
$pdf->SetFont( 'opencondensed', 'B', 12 );
$pdf->Cell( 0, 4, "PT. PRADNYA PARAMITA KONSULTAN", 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Ln( 5 );
$pdf->SetFont( 'opencondensed', '', 11 );
$pdf->Cell( 0, 4, "Perum Kebalenan Baru II Blok F.13 RT. 02 RW. 04 Ling. Brawijaya Kel. Kebalenan Banyuwangi - Jawa Timur", 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Ln( 15 );

$pdf->setCellPaddings( 0, 0, 0, 0 );
$pdf->SetFont( 'opencondensed', 'B', 16 );
$pdf->Write( 0, 'PENGELUARAN PEKERJAAN', '', 0, 'C', true, 0, false, false, 0 );
$pdf->Ln( 7 );
$pdf->SetFont( 'opencondensed', '', 11 );
$pdf->Cell( 35, 4, 'Tahun', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Cell( 4, 4, ':', 0, false, 'C', 0, '', 0, false, 'T', 'M' );
$pdf->Cell( 100, 4, $tahun, 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Ln( 5 );
$pdf->Cell( 35, 4, 'Pengeluaran Tunai', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Cell( 4, 4, ':', 0, false, 'C', 0, '', 0, false, 'T', 'M' );
$pdf->Cell( 25, 4, $tunai, 0, false, 'R', 0, '', 0, false, 'T', 'M' );
$pdf->Ln( 5 );
$pdf->Cell( 35, 4, 'Pengeluaran Non Tunai', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Cell( 4, 4, ':', 0, false, 'C', 0, '', 0, false, 'T', 'M' );
$pdf->Cell( 25, 4, $non_tunai, 0, false, 'R', 0, '', 0, false, 'T', 'M' );
$pdf->Ln( 5 );
$pdf->Cell( 35, 4, 'Total Pengeluaran', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Cell( 4, 4, ':', 0, false, 'C', 0, '', 0, false, 'T', 'M' );
$pdf->SetFont( 'opencondensed', 'B', 11 );
$pdf->Cell( 25, 4, $total, 0, false, 'R', 0, '', 0, false, 'T', 'M' );
$pdf->Ln( 5 );

$pdf->SetFont( 'opencondensed', '', 11 );



$content = '';
$content .= '
<style>
th{
	font-size:12px !important;
	vertical-align: middle !important;
	font-weight:bold;
	border :solid 1px #000;
	text-align: center;
}
.ngantuk td{
	font-size:12px !important;
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
<th valign="middle" rowspan="2" width="30">NO</th>
<th rowspan="2" width="185">NAMA PEKERJAAN</th>
<th rowspan="2" width="70">SP2D</th>
<th rowspan="2" width="70">RAP</th>
<th colspan="3" width="210">PENGELUARAN</th>
<th rowspan="2" width="70">SELISIH</th>
<th rowspan="2" width="70">PERSENTASE</th>
</tr>
<tr>
<th width="70">Tunai</th>
<th width="70">Non Tunai</th>
<th width="70">Total</th>
</tr>
<tr>
<th>A</th>
<th>B</th>
<th>C</th>
<th>D</th>
<th>E</th>
<th>F</th>
<th>G = E + F</th>
<th>H = D - G</th>
<th>I</th>
</tr>
</thead>
<tbody>';
$pdf->SetFont( 'opencondensed', '', 12 );
// BATAS ATAS ==========================================
$no=0;
foreach ( $isi as $b ) {
	$no++;
 	$content .=
	 '<tr>
		<td width="30" align="center">' . $no . '</td>
		<td width="185">' .$b[0]. '</td>
		<td width="70" align="right">' . $b[1] . '</td>
		<td width="70" align="right">' . $b[2] . '</td>
		<td width="70" align="right">' . $b[3] . '</td>
		<td width="70" align="right">' . $b[4] . '</td>
		<td width="70" align="right">' . $b[5] . '</td>
		<td width="70" align="right">' . $b[6] . '</td>
		<td width="70" align="right">' . $b[7] . '</td>
	</tr>';
}
// BATAS BAWAH ==============================================================
$content .= 
	'</tbody></table>';

$pdf->writeHTMLCell( 0, 0, '', '', $content, 0, 1, 0, true, '', true );
ob_clean();
$pdf->Output( 'pengeluaran_pekerjaan.pdf', 'I' );