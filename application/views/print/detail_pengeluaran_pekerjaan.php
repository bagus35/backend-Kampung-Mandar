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


$sp2d = $isi->sp2d;
$target = intval($sp2d) - intval($total_rap);


$pdf->setCellPaddings( 0, 0, 0, 0 );
$pdf->SetFont( 'opencondensed', 'B', 16 );
$pdf->Write( 0, 'DETAIL PENGELUARAN PEKERJAAN', '', 0, 'C', true, 0, false, false, 0 );
$pdf->Ln( 7 );


$pdf->SetFont( 'opencondensed', 'B', 11 );
$pdf->Cell( 139, 4, 'INFORMASI PEKERJAAN', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Ln( 5 );
$pdf->SetFont( 'opencondensed', '', 11 );
$pdf->Cell( 35, 4, 'Tahun', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Cell( 4, 4, ':', 0, false, 'C', 0, '', 0, false, 'T', 'M' );
$pdf->Cell( 100, 4, $isi->tahun, 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Ln( 5 );
$pdf->Cell( 35, 4, 'Nama Pekerjaan', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Cell( 4, 4, ':', 0, false, 'C', 0, '', 0, false, 'T', 'M' );
$pdf->Cell( 100, 4, $isi->nama_pekerjaan, 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Ln( 5 );
$pdf->Cell( 35, 4, 'Nilai Kontrak', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Cell( 4, 4, ':', 0, false, 'C', 0, '', 0, false, 'T', 'M' );
$pdf->Cell( 100, 4, number_format($isi->nilai_kontrak,0,',','.'), 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Ln( 5 );
$pdf->Cell( 35, 4, 'SP2D', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Cell( 4, 4, ':', 0, false, 'C', 0, '', 0, false, 'T', 'M' );
$pdf->Cell( 100, 4, number_format($isi->sp2d,0,',','.'), 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Ln( 8 );
$pdf->SetFont( 'opencondensed', 'B', 11 );
$pdf->Cell( 139, 4, 'RENCANA ANGGARAN BIAYA', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Ln( 5 );
$pdf->SetFont( 'opencondensed', '', 11 );
$pdf->Cell( 35, 4, 'RAP', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Cell( 4, 4, ':', 0, false, 'C', 0, '', 0, false, 'T', 'M' );
$pdf->Cell( 100, 4, number_format($total_rap,0,',','.'), 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Ln( 5 );
$pdf->Cell( 35, 4, 'Estimasi Pendapatan', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Cell( 4, 4, ':', 0, false, 'C', 0, '', 0, false, 'T', 'M' );
$pdf->Cell( 100, 4, number_format($target,0,',','.'), 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Ln( 8 );

$pdf->SetFont( 'opencondensed', 'B', 11 );
$pdf->Cell( 139, 4, 'DETAIL PENGELUARAN', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Ln( 5 );
$pdf->SetFont( 'opencondensed', '', 11 );
$pdf->Cell( 35, 4, 'RAP', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Cell( 4, 4, ':', 0, false, 'C', 0, '', 0, false, 'T', 'M' );
$pdf->Cell( 100, 4, number_format($total_rap,0,',','.'), 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Ln( 5 );
$pdf->Cell( 35, 4, 'Pengeluaran Tunai', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Cell( 4, 4, ':', 0, false, 'C', 0, '', 0, false, 'T', 'M' );
$pdf->Cell( 100, 4, number_format($total_tunai,0,',','.'), 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Ln( 5 );
$pdf->Cell( 35, 4, 'Pengeluaran Non Tunai', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Cell( 4, 4, ':', 0, false, 'C', 0, '', 0, false, 'T', 'M' );
$pdf->Cell( 100, 4, number_format($total_non_tunai,0,',','.'), 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Ln( 5 );
$pdf->Cell( 35, 4, 'Total Pengeluaran', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Cell( 4, 4, ':', 0, false, 'C', 0, '', 0, false, 'T', 'M' );
$pdf->Cell( 100, 4, number_format($total,0,',','.'), 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Ln( 5 );
$pdf->Cell( 35, 4, 'Selisih', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Cell( 4, 4, ':', 0, false, 'C', 0, '', 0, false, 'T', 'M' );
$pdf->Cell( 100, 4, number_format($selisih,0,',','.'), 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Ln( 5 );
$pdf->Cell( 35, 4, 'Persentase', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Cell( 4, 4, ':', 0, false, 'C', 0, '', 0, false, 'T', 'M' );
$pdf->Cell( 100, 4, number_format($persen,0,',','.').' %', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
$pdf->Ln( 5 );

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

.ngantuk h3{
font-size:14px !important;
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
padding:0px;
}
</style>';







$content .= '<div class="ngantuk">
<h3>TOTAL PER KATEGORI</h3>
<table cellpadding="2">
<thead>
<tr>
<th width="60">No</th>
<th width="545">Kategori</th>
<th width="100">Jumlah</th>
</tr>
</thead>
<tbody>';
$pdf->SetFont( 'opencondensed', '', 12 );
// BATAS ATAS ==========================================
foreach ( $kategori as $b ) {
	$no++;
 	$content .=
	 '<tr>
		<td width="60" align="center">' . $b[0] . '</td>
		<td width="545">' .$b[1]. '</td>
		<td width="100" align="right">' . $b[2] . '</td>
	</tr>';
}
// BATAS BAWAH ==============================================================
$content .= 
	'
	<tr>
		<td colspan="2" align="right">Total</td>
		<td width="100" align="right">' . number_format($total,0,',','.') . '</td>
	</tr>
	</tbody></table></div>';

$content .= '<div class="ngantuk">
<h3>RINCIAN TRANSAKSI</h3>
<table cellpadding="2">
<thead>
<tr>
<th width="60">No</th>
<th width="100">Tanggal</th>
<th width="100">Kategori</th>
<th width="345">Uraian</th>
<th width="100">Jumlah</th>
</tr>
</thead>
<tbody>';
$pdf->SetFont( 'opencondensed', '', 12 );
// BATAS ATAS ==========================================
$content .=
	 '<tr>
		<td width="705" colspan="5"><strong>TRANSAKSI TUNAI</strong></td>
	</tr>';


$no=0;
foreach ( $tunai as $b ) {
	$no++;
 	$content .=
	 '<tr>
		<td width="60" align="center">' . $no . '</td>
		<td width="100">' .$b[0]. '</td>
		<td width="100">' . $b[1] . '</td>
		<td width="345">' . $b[2] . '</td>
		<td width="100" align="right">' . $b[3] . '</td>
	</tr>';
}
// BATAS BAWAH ==============================================================
$content .= 
	'
	<tr>
		<td colspan="4" align="right">Total</td>
		<td width="100" align="right">' . number_format($total_tunai,0,',','.') . '</td>
	</tr>';
$content .=
	 '<tr>
		<td colspan="5"><strong>TRANSAKSI TUNAI</strong></td>
	</tr>';
$no=0;
foreach ( $non as $b ) {
	$no++;
 	$content .=
	 '<tr>
		<td width="60" align="center">' . $no . '</td>
		<td width="100">' .$b[0]. '</td>
		<td width="100">' . $b[1] . '</td>
		<td width="345">' . $b[2] . '</td>
		<td width="100" align="right">' . $b[3] . '</td>
	</tr>';
}

$content .= 
	'
	<tr>
		<td colspan="4" align="right">Total</td>
		<td width="100" align="right">' . number_format($total_non_tunai,0,',','.') . '</td>
	</tr>
	</tbody></table></div>';


$pdf->writeHTMLCell( 0, 0, '', '', $content, 0, 1, 0, true, '', true );
ob_clean();
$pdf->Output( 'pengeluaran_pekerjaan.pdf', 'I' );