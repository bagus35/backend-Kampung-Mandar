<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Kas extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->load->model( array( 'm_kas', 'm_kategori_pengeluaran', 'm_pekerjaan', 'm_rap', 'm_pengeluaran', 'm_user', 'm_kasir', 'm_bank' ) );
    $this->load->library( array( 'form_validation', 'libku', 'phpexcel', 'pdf' ) );
    if ( !$this->auth->cek() ) {
      $this->session->sess_destroy();
      redirect( base_url() );
      exit();
    }
  }

  function index() {
    $data[ 'title' ] = "Kas";
    $data[ 'kategori' ] = $this->m_kategori_pengeluaran->get_all();
    $this->template->display( 'content/kas', $data );
  }

  function kasir() {
    $data[ 'title' ] = "Kasir";
    $this->template->display( 'content/kasir', $data );
  }

  function ajax_list() {
    $hak = $this->session->userdata( 'hak' );
    $list = $this->m_kas->get_datatables();
    $data = array();
    $no = $this->input->post( 'start' );
    foreach ( $list as $d ) {
      $debet = number_format( $d->debet, 0, ',', '.' );
      $kredit = number_format( $d->kredit, 0, ',', '.' );

      if ( $debet == 0 ) {
        $debet = "-";
      }
      if ( $kredit == 0 ) {
        $kredit = "-";
      }
      $no++;
      $row = array();
      $row[] = $no;
      if ( intval( $hak ) < 3 ) {
        $row[] = '<div class="btn-group">
			<a href="javascript:void(0)" class="btn btn-danger btn-ft" onclick="delete_data(' . "'" . encrypt_url( $d->id_kas ) . "'" . ')" title="delete"><i class="fa fa-trash"></i></a>
			<a href="javascript:void(0)" class="btn btn-warning btn-ft" onclick="edit_data(' . "'" . encrypt_url( $d->id_kas ) . "'" . ')" title="edit"><i class="fa fa-pencil-square"></i></a>
			</div>';
      }
      $row[] = date( 'd/m/Y', strtotime( $d->tanggal ) );
      $row[] = $d->uraian;
      $row[] = $debet;
      $row[] = $kredit;
      $row[] = '<div class="btn-group">
			<a href="javascript:void(0)" class="btn btn-primary btn-ft w-100" onclick="lihat_bukti(' . "'" . base_url() . $d->bukti . "'" . ')" title="lihat bukti"><i class="fa fa-file-image-o"></i></a>
			</div>';
      if ( intval( $hak ) < 3 ) {
        $row[] = $d->admin;
      }

      $data[] = $row;
    }
    $debet = $this->m_kas->saldo()->ttld;
    $kredit = $this->m_kas->saldo()->ttlk;
    $saldo = intval( $debet ) - intval( $kredit );
    $output = array(
      "draw" => $_POST[ 'draw' ],
      "recordsTotal" => $this->m_kas->count_all(),
      "recordsFiltered" => $this->m_kas->count_filtered(),
      "saldo" => number_format( $saldo, 0, ',', '.' ),
      "data" => $data,
    );
    echo json_encode( $output );
  }

  function edit() {
    $k = $this->m_kas->edit( decrypt_url( $this->input->post( 'q', TRUE ) ) );
    $data[ 'tanggal' ] = date( 'd/m/Y', strtotime( $k->tanggal ) );
    $data[ 'uraian' ] = $k->uraian;
    $data[ 'debet' ] = number_format( $k->debet, 0, ',', '.' );
    $data[ 'kredit' ] = number_format( $k->kredit, 0, ',', '.' );
    $data[ 'id_pekerjaan' ] = encrypt_url( $k->id_pekerjaan );
    $data[ 'id_kategori_pengeluaran' ] = encrypt_url( $k->id_kategori_pengeluaran );
    $data[ 'nama_pekerjaan' ] = $k->nama_pekerjaan;
    $data[ 'jenis' ] = $k->jenis;
    echo json_encode( $data );
  }


  function delete() {
    $id = decrypt_url( $this->input->post( "q" ) );
    if ( $id != "" || $id != NULL ) {
      $this->m_kas->delete_by_id( $id );
      echo json_encode( array( "status" => TRUE ) );
    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }

  function save_masuk() {
    $admin = $this->session->userdata( 'nama' );
    $id_user = $this->session->userdata( 'id_user' );
    $this->form_validation->set_rules( 'tanggal', 'tanggal', 'required' );
    $this->form_validation->set_rules( 'uraian', 'uraian', 'required' );
    $this->form_validation->set_rules( 'debet', 'debet', 'required' );
    if ( $this->form_validation->run() != false ) {
      $tanggal = $this->libku->tgl_mysql( $this->input->post( 'tanggal', TRUE ) );
      $uraian = $this->input->post( 'uraian', TRUE );
      $debet = $this->libku->ribuansql( $this->input->post( 'debet', TRUE ) );
      date_default_timezone_set( 'Asia/Jakarta' );
      $code = date( "HdmiYs" );
      $upload_conf = array(
        'upload_path' => realpath( './upload/bukti/' ),
        'allowed_types' => 'jpg|jpeg|png',
        'file_name' => $code
      );
      $this->upload->initialize( $upload_conf );
      if ( !$this->upload->do_upload( 'userfile' ) ) {
        $e = $this->upload->display_errors();
        echo json_encode( array( "status" => FALSE, "pesan" => "Mohon Upload Bukti Transaksi Terlebih Dahulu!" ) );
      } else {
        $upload_data = $this->upload->data();
        $data = array(
          'tanggal' => $tanggal,
          'uraian' => $uraian,
          'debet' => $debet,
          'bukti' => 'upload/bukti/' . $upload_data[ 'file_name' ],
          'jenis' => 0,
          'admin' => $admin,
          'id_user' => decrypt_url( $id_user )
        );
        $id = $this->m_kas->save( $data );
        echo json_encode( array( "status" => TRUE ) );
      }
    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }


  function save_keluar() {
    $admin = $this->session->userdata( 'nama' );
    $id_user = $this->session->userdata( 'id_user' );
    $this->form_validation->set_rules( 'tanggal', 'tanggal', 'required' );
    $this->form_validation->set_rules( 'uraian', 'uraian', 'required' );
    $this->form_validation->set_rules( 'kredit', 'kredit', 'required' );
    if ( $this->form_validation->run() != false ) {
      $tanggal = $this->libku->tgl_mysql( $this->input->post( 'tanggal', TRUE ) );
      $uraian = $this->input->post( 'uraian', TRUE );
      $kredit = $this->libku->ribuansql( $this->input->post( 'kredit', TRUE ) );
      date_default_timezone_set( 'Asia/Jakarta' );
      $code = date( "HdmiYs" );
      $upload_conf = array(
        'upload_path' => realpath( './upload/bukti/' ),
        'allowed_types' => 'jpg|jpeg|png',
        'file_name' => $code
      );
      $this->upload->initialize( $upload_conf );
      if ( !$this->upload->do_upload( "userfile" ) ) {
        $e = $this->upload->display_errors();
        echo json_encode( array( "status" => FALSE, "pesan" => "Mohon Upload Bukti Transaksi Terlebih Dahulu!" ) );
      } else {
        $upload_data = $this->upload->data();
        $data = array(
          'tanggal' => $tanggal,
          'uraian' => $uraian,
          'kredit' => $kredit,
          'bukti' => 'upload/bukti/' . $upload_data[ 'file_name' ],
          'jenis' => 1,
          'admin' => $admin,
          'id_user' => decrypt_url( $id_user )
        );
        $id = $this->m_kas->save( $data );
        echo json_encode( array( "status" => TRUE ) );
      }

    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }


  function save_keluar_pekerjaan() {
    $admin = $this->session->userdata( 'nama' );
    $id_user = $this->session->userdata( 'id_user' );
    $this->form_validation->set_rules( 'tanggal', 'tanggal', 'required' );
    $this->form_validation->set_rules( 'uraian', 'uraian', 'required' );
    $this->form_validation->set_rules( 'kredit', 'kredit', 'required' );
    $this->form_validation->set_rules( 'id_kategori_pengeluaran', 'id_kategori_pengeluaran', 'required' );
    $this->form_validation->set_rules( 'id_pekerjaan', 'id_pekerjaan', 'required' );
    if ( $this->form_validation->run() != false ) {
      $tanggal = $this->libku->tgl_mysql( $this->input->post( 'tanggal', TRUE ) );
      $id_kategori_pengeluaran = decrypt_url( $this->input->post( 'id_kategori_pengeluaran' ) );

      $id_pekerjaan = $this->input->post( 'id_pekerjaan' );
      if ( $id_pekerjaan != NULL || $id_pekerjaan != "" ) {
        $id_pekerjaan = decrypt_url( $id_pekerjaan );
      }

      $uraian = $this->input->post( 'uraian', TRUE );
      $kredit = $this->libku->ribuansql( $this->input->post( 'kredit', TRUE ) );
      date_default_timezone_set( 'Asia/Jakarta' );
      $code = date( "HdmiYs" );
      $upload_conf = array(
        'upload_path' => realpath( './upload/bukti/' ),
        'allowed_types' => 'jpg|jpeg|png',
        'file_name' => $code
      );
      $this->upload->initialize( $upload_conf );
      if ( !$this->upload->do_upload( "userfile" ) ) {
        $e = $this->upload->display_errors();
        echo json_encode( array( "status" => FALSE, "pesan" => "Mohon Upload Bukti Transaksi Terlebih Dahulu!" ) );
      } else {
        $upload_data = $this->upload->data();
        $data = array(
          'tanggal' => $tanggal,
          'uraian' => $uraian,
          'kredit' => $kredit,
          'id_pekerjaan' => $id_pekerjaan,
          'id_kategori_pengeluaran' => $id_kategori_pengeluaran,
          'bukti' => 'upload/bukti/' . $upload_data[ 'file_name' ],
          'jenis' => 2,
          'admin' => $admin,
          'id_user' => decrypt_url( $id_user )
        );
        $id = $this->m_kas->save( $data );
        echo json_encode( array( "status" => TRUE ) );
      }

    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }

  function update_masuk() {
    $admin = $this->session->userdata( 'nama' );
    $id = decrypt_url( $this->input->get( "q" ) );
    $this->form_validation->set_rules( 'tanggal', 'tanggal', 'required' );
    $this->form_validation->set_rules( 'uraian', 'uraian', 'required' );
    $this->form_validation->set_rules( 'debet', 'debet', 'required' );
    if ( $this->form_validation->run() != false ) {
      $tanggal = $this->libku->tgl_mysql( $this->input->post( 'tanggal', TRUE ) );
      $uraian = $this->input->post( 'uraian', TRUE );
      $debet = $this->libku->ribuansql( $this->input->post( 'debet', TRUE ) );
      date_default_timezone_set( 'Asia/Jakarta' );
      $code = date( "HdmiYs" );
      $upload_conf = array(
        'upload_path' => realpath( './upload/bukti/' ),
        'allowed_types' => 'jpg|jpeg|png',
        'file_name' => $code
      );
      $this->upload->initialize( $upload_conf );
      if ( !$this->upload->do_upload( "userfile" ) ) {
        $data = array(
          'tanggal' => $tanggal,
          'uraian' => $uraian,
          'debet' => $debet
        );
        $this->m_kas->update( array( 'id_kas' => $id ), $data );
        echo json_encode( array( "status" => TRUE ) );
      } else {
        $upload_data = $this->upload->data();
        $data = array(
          'tanggal' => $tanggal,
          'uraian' => $uraian,
          'debet' => $debet,
          'bukti' => 'upload/bukti/' . $upload_data[ 'file_name' ]
        );
        $this->m_kas->update( array( 'id_kas' => $id ), $data );
        echo json_encode( array( "status" => TRUE ) );
      }

    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }

  function update_keluar() {
    $admin = $this->session->userdata( 'nama' );
    $id = decrypt_url( $this->input->get( "q" ) );
    $this->form_validation->set_rules( 'tanggal', 'tanggal', 'required' );
    $this->form_validation->set_rules( 'uraian', 'uraian', 'required' );
    $this->form_validation->set_rules( 'kredit', 'kredit', 'required' );
    if ( $this->form_validation->run() != false ) {
      $tanggal = $this->libku->tgl_mysql( $this->input->post( 'tanggal', TRUE ) );
      $uraian = $this->input->post( 'uraian', TRUE );
      $kredit = $this->libku->ribuansql( $this->input->post( 'kredit', TRUE ) );
      date_default_timezone_set( 'Asia/Jakarta' );
      $code = date( "HdmiYs" );
      $upload_conf = array(
        'upload_path' => realpath( './upload/bukti/' ),
        'allowed_types' => 'jpg|jpeg|png',
        'file_name' => $code
      );
      $this->upload->initialize( $upload_conf );
      if ( !$this->upload->do_upload( "userfile" ) ) {
        $data = array(
          'tanggal' => $tanggal,
          'uraian' => $uraian,
          'kredit' => $kredit
        );
        $this->m_kas->update( array( 'id_kas' => $id ), $data );
        echo json_encode( array( "status" => TRUE ) );
      } else {
        $upload_data = $this->upload->data();
        $data = array(
          'tanggal' => $tanggal,
          'uraian' => $uraian,
          'kredit' => $kredit,
          'bukti' => 'upload/bukti/' . $upload_data[ 'file_name' ]
        );
        $this->m_kas->update( array( 'id_kas' => $id ), $data );
        echo json_encode( array( "status" => TRUE ) );
      }

    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }


  function update_keluar_pekerjaan() {
    $admin = $this->session->userdata( 'nama' );
    $id = decrypt_url( $this->input->get( "q" ) );
    $this->form_validation->set_rules( 'tanggal', 'tanggal', 'required' );
    $this->form_validation->set_rules( 'uraian', 'uraian', 'required' );
    $this->form_validation->set_rules( 'kredit', 'kredit', 'required' );
    $this->form_validation->set_rules( 'id_kategori_pengeluaran', 'id_kategori_pengeluaran', 'required' );
    $this->form_validation->set_rules( 'id_pekerjaan', 'id_pekerjaan', 'required' );
    if ( $this->form_validation->run() != false ) {
      $tanggal = $this->libku->tgl_mysql( $this->input->post( 'tanggal', TRUE ) );
      $id_kategori_pengeluaran = decrypt_url( $this->input->post( 'id_kategori_pengeluaran' ) );

      $id_pekerjaan = $this->input->post( 'id_pekerjaan' );
      if ( $id_pekerjaan != NULL || $id_pekerjaan != "" ) {
        $id_pekerjaan = decrypt_url( $id_pekerjaan );
      }

      $uraian = $this->input->post( 'uraian', TRUE );
      $kredit = $this->libku->ribuansql( $this->input->post( 'kredit', TRUE ) );
      date_default_timezone_set( 'Asia/Jakarta' );
      $code = date( "HdmiYs" );
      $upload_conf = array(
        'upload_path' => realpath( './upload/bukti/' ),
        'allowed_types' => 'jpg|jpeg|png',
        'file_name' => $code
      );
      $this->upload->initialize( $upload_conf );
      if ( !$this->upload->do_upload( "userfile" ) ) {
        $data = array(
          'tanggal' => $tanggal,
          'uraian' => $uraian,
          'kredit' => $kredit,
          'id_pekerjaan' => $id_pekerjaan,
          'id_kategori_pengeluaran' => $id_kategori_pengeluaran
        );
        $this->m_kas->update( array( 'id_kas' => $id ), $data );
        echo json_encode( array( "status" => TRUE ) );
      } else {
        $upload_data = $this->upload->data();
        $data = array(
          'tanggal' => $tanggal,
          'uraian' => $uraian,
          'kredit' => $kredit,
          'id_pekerjaan' => $id_pekerjaan,
          'id_kategori_pengeluaran' => $id_kategori_pengeluaran,
          'bukti' => 'upload/bukti/' . $upload_data[ 'file_name' ]
        );
        $this->m_kas->update( array( 'id_kas' => $id ), $data );
        echo json_encode( array( "status" => TRUE ) );
      }

    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }


  function cetak() {
    $start_date = $this->libku->tgl_mysql( $this->input->get( 'awal' ) );
    $end_date = $this->libku->tgl_mysql( $this->input->get( 'akhir' ) );

    $tanggal_awal = $this->libku->tglindo( $start_date );
    $tanggal_akhir = $this->libku->tglindo( $end_date );
    $excel = new PHPExcel();
    $excel->getProperties()->setCreator( 'PT. PRADNYA PARAMITA' )->setLastModifiedBy( 'PT. PRADNYA PARAMITA' )->setTitle( "LAPORAN KAS" )->setSubject( "LAPORAN KAS" )->setDescription( "LAPORAN KAS" )->setKeywords( "LAPORAN KAS" );


    $style_col = array(
      'font' => array( 'bold' => true, ),
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
      ),
      'borders' => array(
        'top' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ),
        'right' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ),
        'bottom' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ),
        'left' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN )
      ),
      'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array(
          'rgb' => 'aed6f1',
        )
      )
    );
    $style_row = array(
      'alignment' => array(
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
      ),
      'borders' => array(
        'top' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ),
        'right' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ),
        'bottom' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ),
        'left' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN )
      )
    );
    $style_row1 = array(
      'alignment' => array(
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
      ),
      'borders' => array(
        'top' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ),
        'right' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ),
        'bottom' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ),
        'left' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN )
      )
    );

    $style_row2 = array(
      'alignment' => array(
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
      ),
      'borders' => array(
        'top' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ),
        'right' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ),
        'bottom' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ),
        'left' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN )
      )
    );
    $style_row_total = array(
      'font' => array(
        'bold' => true,

      ),
      'alignment' => array(
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
      ),
      'borders' => array(
        'top' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ),
        'right' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ),
        'bottom' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ),
        'left' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN )
      ),
      'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array(
          'rgb' => 'ebf5fb',
        )
      )
    );
    $style_row_total_isi = array(
      'font' => array(
        'bold' => true,

      ),
      'alignment' => array(
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
      ),
      'borders' => array(
        'top' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ),
        'right' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ),
        'bottom' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ),
        'left' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN )
      ),
    );

    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName( 'logo_pradnya_paramita' );
    $objDrawing->setDescription( 'ogo_pradnya_paramita' );
    $objDrawing->setPath( './aset/img/ic_logo.png' );
    $objDrawing->setCoordinates( 'A1' );
    $objDrawing->setOffsetX( 5 );
    $objDrawing->setOffsetY( 5 );
    $objDrawing->setWidth( 100 );
    $objDrawing->setHeight( 35 );
    $objDrawing->setWorksheet( $excel->getActiveSheet() );

    $excel->setActiveSheetIndex( 0 )->setCellValue( 'B1', "PT.PRADNYA PARAMITA KONSULTAN" );
    $excel->getActiveSheet()->getStyle( 'B1' )->getFont()->setBold( TRUE );
    $excel->getActiveSheet()->getStyle( 'B1' )->getFont()->setSize( 14 );
    $excel->setActiveSheetIndex( 0 )->setCellValue( 'B2', "Perum Kebalenan Baru II Blok F.13 RT. 02 RW. 04 Ling. Brawijaya Kel. Kebalenan Banyuwangi - Jawa Timur" );
    $excel->getActiveSheet()->getStyle( 'B2' )->getFont()->setSize( 12 );

    $excel->setActiveSheetIndex( 0 )->setCellValue( 'A5', "LAPORAN KAS" );
    $excel->getActiveSheet()->mergeCells( 'A5:E5' );
    $excel->getActiveSheet()->getStyle( 'A5' )->getFont()->setBold( TRUE );
    $excel->getActiveSheet()->getStyle( 'A5' )->getFont()->setSize( 20 );
    $excel->getActiveSheet()->getStyle( 'A5' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );


    $excel->setActiveSheetIndex( 0 )->setCellValue( 'A7', "Periode" );
    $excel->setActiveSheetIndex( 0 )->setCellValue( 'B7', ': ' . $tanggal_awal . ' s/d ' . $tanggal_akhir );

    $excel->setActiveSheetIndex( 0 )->setCellValue( 'A8', "NO" );
    $excel->setActiveSheetIndex( 0 )->setCellValue( 'B8', "TANGGAL" );
    $excel->setActiveSheetIndex( 0 )->setCellValue( 'C8', "URAIAN" );
    $excel->setActiveSheetIndex( 0 )->setCellValue( 'D8', "DEBET" );
    $excel->setActiveSheetIndex( 0 )->setCellValue( 'E8', "KREDIT" );
    $excel->getActiveSheet()->getRowDimension( '8' )->setRowHeight( 25 );
    $excel->getActiveSheet()->getStyle( 'A8' )->applyFromArray( $style_col );
    $excel->getActiveSheet()->getStyle( 'B8' )->applyFromArray( $style_col );
    $excel->getActiveSheet()->getStyle( 'C8' )->applyFromArray( $style_col );
    $excel->getActiveSheet()->getStyle( 'D8' )->applyFromArray( $style_col );
    $excel->getActiveSheet()->getStyle( 'E8' )->applyFromArray( $style_col );
    $nw = 9;
    $isi = $this->m_kas->cetak( $start_date, $end_date );
    $debet = $this->m_kas->saldo()->ttld;
    $kredit = $this->m_kas->saldo()->ttlk;
    $saldo = intval( $debet ) - intval( $kredit );
    $no = 0;
    foreach ( $isi as $p ) {
      $tanggal = date( 'd/m/Y', strtotime( $p->tanggal ) );
      $no++;
      $excel->setActiveSheetIndex( 0 )->setCellValue( 'A' . $nw, $no );
      $excel->setActiveSheetIndex( 0 )->setCellValue( 'B' . $nw, $tanggal );
      $excel->setActiveSheetIndex( 0 )->setCellValue( 'C' . $nw, $p->uraian );
      $excel->setActiveSheetIndex( 0 )->setCellValue( 'D' . $nw, $p->debet );
      $excel->setActiveSheetIndex( 0 )->setCellValue( 'E' . $nw, $p->kredit );
      $excel->getActiveSheet()->getStyle( 'D' . $nw )->getNumberFormat()->setFormatCode( '[>=3000]#,##0;[Red][<0]#,##0;#,##0' );
      $excel->getActiveSheet()->getStyle( 'E' . $nw )->getNumberFormat()->setFormatCode( '[>=3000]#,##0;[Red][<0]#,##0;#,##0' );
      $excel->getActiveSheet()->getStyle( 'A' . $nw )->applyFromArray( $style_row1 );
      $excel->getActiveSheet()->getStyle( 'B' . $nw )->applyFromArray( $style_row1 );
      $excel->getActiveSheet()->getStyle( 'C' . $nw )->applyFromArray( $style_row );
      $excel->getActiveSheet()->getStyle( 'D' . $nw )->applyFromArray( $style_row );
      $excel->getActiveSheet()->getStyle( 'E' . $nw )->applyFromArray( $style_row2 );
      $excel->getActiveSheet()->getRowDimension( $nw )->setRowHeight( 20 );
      $nw++;
    }
    $excel->getActiveSheet()->getColumnDimension( 'A' )->setWidth( 10 );
    $excel->getActiveSheet()->getColumnDimension( 'B' )->setWidth( 15 );
    $excel->getActiveSheet()->getColumnDimension( 'C' )->setWidth( 70 );
    $excel->getActiveSheet()->getColumnDimension( 'D' )->setWidth( 20 );
    $excel->getActiveSheet()->getColumnDimension( 'E' )->setWidth( 20 );

    $excel->setActiveSheetIndex( 0 )->setCellValue( 'A' . $nw, "SALDO" );
    $excel->getActiveSheet()->mergeCells( 'A' . $nw . ':C' . $nw );
    $excel->getActiveSheet()->getStyle( 'A' . $nw . ':C' . $nw )->applyFromArray( $style_row_total );

    $excel->setActiveSheetIndex( 0 )->setCellValue( 'D' . $nw, $saldo );
    $excel->getActiveSheet()->mergeCells( 'D' . $nw . ':E' . $nw );
    $excel->getActiveSheet()->getStyle( 'D' . $nw . ':E' . $nw )->getNumberFormat()->setFormatCode( '[>=3000]#,##0;[Red][<0]#,##0;#,##0' );
    $excel->getActiveSheet()->getStyle( 'D' . $nw . ':E' . $nw )->applyFromArray( $style_row_total_isi );
    $excel->getActiveSheet()->getRowDimension( $nw )->setRowHeight( 25 );


    $excel->getActiveSheet()->getPageSetup()->setOrientation( PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE );
    $excel->getActiveSheet( 0 )->setTitle( "KAS" );
    $excel->setActiveSheetIndex( 0 );
    header( 'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' );
    header( 'Content-Disposition: attachment; filename="Laporan Kas Periode ' . $tanggal_awal . ' s/d ' . $tanggal_akhir . '.xlsx"' ); // Set nama file excel nya
    header( 'Cache-Control: max-age=0' );
    $write = PHPExcel_IOFactory::createWriter( $excel, 'Excel2007' );
    $write->save( 'php://output' );
  }


  function cetak_pdf() {
    $start_date = $this->libku->tgl_mysql( $this->input->get( 'awal' ) );
    $end_date = $this->libku->tgl_mysql( $this->input->get( 'akhir' ) );
    $tanggal_awal = $this->libku->tglindo( $start_date );
    $tanggal_akhir = $this->libku->tglindo( $end_date );
    $debet = $this->m_kas->saldo()->ttld;
    $kredit = $this->m_kas->saldo()->ttlk;
    $saldo = intval( $debet ) - intval( $kredit );
    $data[ 'isi' ] = $this->m_kas->cetak( $start_date, $end_date );
    $data[ 'saldo' ] = $saldo;
    $data[ 'periode' ] = $tanggal_awal . ' s/d ' . $tanggal_akhir;
    $this->load->view( 'print/kas', $data );
  }

  function ajax_list_pekerjaan() {
    $list = $this->m_pekerjaan->get_datatables();
    $data = array();
    $no = $this->input->post( 'start' );
    foreach ( $list as $d ) {
      $id = $d->id_pekerjaan;
      $pengeluaran_kas = $this->m_pengeluaran->total_kas( $id );
      $pengeluaran_bank = $this->m_pengeluaran->total_bank( $id );
      $pengeluaran = intval( $pengeluaran_kas->total ) + intval( $pengeluaran_bank->total );
      $total_rap = $this->m_rap->sum_jumlah( $id )->total;
      $selisih = intval( $total_rap ) - intval( $pengeluaran );
      $persen = ( intval( $pengeluaran ) / intval( $total_rap ) ) * 100;


      $no++;
      $row = array();
      $row[] = $no;
      $row[] = '<div class="btn-group">
			<button class="btn btn-sm btn-primary btn-ft" onclick="isi_pekerjaan(' . "'" . encrypt_url( $d->id_pekerjaan ) . "','" . $d->nama_pekerjaan . "'" . ')" title="pilih"><i class="fa fa-check-square"></i></button>
			</div>';
      $row[] = $d->tahun;
      $row[] = $d->nama_pekerjaan;
      $row[] = number_format( $total_rap, 0, ',', '.' );
      $row[] = number_format( $pengeluaran, 0, ',', '.' );
      $row[] = number_format( $selisih, 0, ',', '.' );
      $row[] = number_format( $persen, 2, ',', '.' ) . ' %';
      $row[] = intval( $persen );
      $data[] = $row;
    }
    $output = array(
      "draw" => $_POST[ 'draw' ],
      "recordsTotal" => $this->m_pekerjaan->count_all(),
      "recordsFiltered" => $this->m_pekerjaan->count_filtered(),
      "data" => $data,
    );
    echo json_encode( $output );
  }

  function cek_pengeluaran() {
    $id = decrypt_url( $this->input->post( 'q' ) );
    $pengeluaran_kas = $this->m_pengeluaran->total_kas( $id );
    $pengeluaran_bank = $this->m_pengeluaran->total_bank( $id );
    $pengeluaran = intval( $pengeluaran_kas->total ) + intval( $pengeluaran_bank->total );
    $total_rap = $this->m_rap->sum_jumlah( $id )->total;
    $selisih = intval( $total_rap ) - intval( $pengeluaran );
    $p = ( intval( $pengeluaran ) / intval( $total_rap ) ) * 100;
    echo json_encode( array( 'persen' => intval( $p ), 'persen_nominal' => number_format( $p, 2, ',', '.' ) . '%' ) );
  }


  function ajax_list_kasir() {
    $list = $this->m_user->get_all_account();
    $data = array();
    $no = $this->input->post( 'start' );
    foreach ( $list as $d ) {

      $deb = $this->m_kas->saldo_kasir( $d->id_account )->ttld;
      $kre = $this->m_kas->saldo_kasir( $d->id_account )->ttlk;
      $sal = intval( $deb ) - intval( $kre );

      $debet = number_format( $deb, 0, ',', '.' );
      $kredit = number_format( $kre, 0, ',', '.' );
      $saldo = number_format( $sal, 0, ',', '.' );

      if ( $deb == 0 ) {
        $debet = "-";
      }
      if ( $kre == 0 ) {
        $kredit = "-";
      }
      $no++;
      $row = array();
      $row[] = $no;
      $row[] = '<div class="btn-group">
			<a href="' . base_url() . 'kas/transaksi_kasir?q=' . encrypt_url( $d->id_account ) . '" class="btn btn-danger btn-ft" title="transaksi"><i class="fa fa-google-wallet"></i></a>
			</div>';
      $row[] = $d->nama;
      $row[] = $debet;
      $row[] = $kredit;
      $row[] = $saldo;
      $data[] = $row;
    }
    $debet = $this->m_kas->saldo()->ttld;
    $kredit = $this->m_kas->saldo()->ttlk;
    $saldo = intval( $debet ) - intval( $kredit );
    $output = array(
      "draw" => $_POST[ 'draw' ],
      "recordsTotal" => $this->m_kas->count_all(),
      "recordsFiltered" => $this->m_kas->count_filtered(),
      "saldo" => number_format( $saldo, 0, ',', '.' ),
      "data" => $data,
    );
    echo json_encode( $output );
  }

  function transaksi_kasir() {
    $id = $this->input->get( 'q' );
	  $user = $this->m_user->edit(decrypt_url($id));
    $data[ 'title' ] = "Transaksi Kasir";
    $data[ 'id' ] = $id;
    $data[ 'bank' ] = $this->m_bank->get_all();
	  $data['nama'] = $user->nama;
    $this->template->display( 'content/transaksi_kasir', $data );
  }


  function ajax_list_transaksi_kasir() {
    $hak = $this->session->userdata( 'hak' );
    $list = $this->m_kasir->get_datatables();
    $data = array();
    $no = $this->input->post( 'start' );
    foreach ( $list as $d ) {
      $debet = number_format( $d->debet, 0, ',', '.' );
      $kredit = number_format( $d->kredit, 0, ',', '.' );

      if ( $debet == 0 ) {
        $debet = "-";
      }
      if ( $kredit == 0 ) {
        $kredit = "-";
      }
      $no++;
      $row = array();
      $row[] = $no;

      $row[] = '<div class="btn-group">
			<a href="javascript:void(0)" class="btn btn-danger btn-ft" onclick="delete_data(' . "'" . encrypt_url( $d->id_kas ) . "'" . ')" title="delete"><i class="fa fa-trash"></i></a>
			<a href="javascript:void(0)" class="btn btn-warning btn-ft" onclick="edit_data(' . "'" . encrypt_url( $d->id_kas ) . "'" . ')" title="edit"><i class="fa fa-pencil-square"></i></a>
			</div>';

      $row[] = date( 'd/m/Y', strtotime( $d->tanggal ) );
      $row[] = $d->uraian;
      $row[] = $debet;
      $row[] = $kredit;
      $row[] = '<div class="btn-group">
			<a href="javascript:void(0)" class="btn btn-primary btn-ft w-100" onclick="lihat_bukti(' . "'" . base_url() . $d->bukti . "'" . ')" title="lihat bukti"><i class="fa fa-file-image-o"></i></a>
			</div>';

      $row[] = $d->admin;


      $data[] = $row;
    }
    $debet = $this->m_kasir->saldo()->ttld;
    $kredit = $this->m_kasir->saldo()->ttlk;
    $saldo = intval( $debet ) - intval( $kredit );
    $output = array(
      "draw" => $_POST[ 'draw' ],
      "recordsTotal" => $this->m_kasir->count_all(),
      "recordsFiltered" => $this->m_kasir->count_filtered(),
      "saldo" => number_format( $saldo, 0, ',', '.' ),
      "data" => $data,
    );
    echo json_encode( $output );
  }

  function save_penambahan_kas() {
    $admin = $this->session->userdata( 'nama' );

    $this->form_validation->set_rules( 'tanggal', 'tanggal', 'required' );
    $this->form_validation->set_rules( 'uraian', 'uraian', 'required' );
    $this->form_validation->set_rules( 'debet', 'debet', 'required' );
    if ( $this->form_validation->run() != false ) {
      $tanggal = $this->libku->tgl_mysql( $this->input->post( 'tanggal', TRUE ) );
      $uraian = $this->input->post( 'uraian', TRUE );
      $debet = $this->libku->ribuansql( $this->input->post( 'debet', TRUE ) );

      $id_user = decrypt_url( $this->input->post( 'id_user' ) );
      date_default_timezone_set( 'Asia/Jakarta' );
      $code = date( "HdmiYs" );
      $upload_conf = array(
        'upload_path' => realpath( './upload/bukti/' ),
        'allowed_types' => 'jpg|jpeg|png',
        'file_name' => $code
      );
      $this->upload->initialize( $upload_conf );
      if ( !$this->upload->do_upload( 'userfile' ) ) {
        $e = $this->upload->display_errors();
        echo json_encode( array( "status" => FALSE, "pesan" => "Mohon Upload Bukti Transaksi Terlebih Dahulu!" ) );
      } else {
        $upload_data = $this->upload->data();
        $data = array(
          'tanggal' => $tanggal,
          'uraian' => $uraian,
          'debet' => $debet,
          'bukti' => 'upload/bukti/' . $upload_data[ 'file_name' ],
          'jenis' => 0,
          'admin' => $admin,
          'id_user' => $id_user
        );
        $id = $this->m_kas->save( $data );
        echo json_encode( array( "status" => TRUE ) );
      }
    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }


}