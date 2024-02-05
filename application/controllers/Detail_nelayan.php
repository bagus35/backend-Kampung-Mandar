<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Nelayan extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->load->model( array( 'm_ruas_jalan', 'm_kecamatan', 'm_desa' ) );
    $this->load->library( array( 'upload', 'form_validation', 'image_lib', 'libku', 'phpexcel', 'pdf' ) );
    if ( !$this->auth->cek() ) {
      $this->session->sess_destroy();
      redirect( base_url() );
      exit();
    }
  }

  function index() {
    $data[ 'title' ] = "RUAS JALAN";
    $data[ 'kecamatan' ] = $this->m_kecamatan->get_all();
    $this->template->display( 'content/ruas_jalan', $data );
  }

  function detail() {
    $id = decrypt_url( $this->input->get( 'q' ) );
    $k = $this->m_ruas_jalan->detail( $id );
    $data[ 'title' ] = "DETAIL - " . $k->nama_ruas;
    $data[ 'isi' ] = $k;
    $this->template->display( 'content/detail_ruas_jalan', $data );
  }

  function ajax_list() {
    if ( !$this->auth->cek() ) {
      $this->session->sess_destroy();
      redirect( base_url() );
      exit();
    } else {
      $list = $this->m_ruas_jalan->get_datatables();
      $data = array();
      $no = $this->input->post( 'start' );
      foreach ( $list as $d ) {
        $foto = $d->foto;

        if ( $foto == NULL ) {
          $foto = 'aset/img/k_no_logo.png';
        }

        $status_jalan = $d->status_jalan;
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

        $no++;
        $row = array();
        $row[] = '<div class="btn-group">
  					<a href="javascript:;" class="btn btn-warning btn-sm" title="Edit" onClick="edit_data(' . "'" . encrypt_url( $d->id_ruas_jalan ) . "'" . ')">Edit</a>
  					<a href="javascript:;" class="btn btn-danger btn-sm"  title="Delete" onClick="delete_data(' . "'" . encrypt_url( $d->id_ruas_jalan ) . "'" . ')">Delete</a>
  					<a href="' . base_url() . 'ruas_jalan/detail?q=' . encrypt_url( $d->id_ruas_jalan ) . '" class="btn btn-primary btn-sm"  title="Detail">Detail</a>
				</div>';
        $row[] = $no;
        $row[] = $d->no_ruas;
        $row[] = $d->nama_ruas;
        $row[] = '<a href="javascript:void(0)" onclick="lihat_foto(' . "'" . base_url() . $foto . "'" . ')" ><div style="background: url(' . base_url() . $foto . ') no-repeat center center; background-size:80px 60px;height:60px;width:80px; "> </div></a>';
        $row[] = $status_jalan;
        $row[] = $d->kecamatan;
        $row[] = $d->desa;
        $row[] = number_format( $d->panjang, 0, ',', '.' );
        $row[] = number_format( $d->lebar, 2, ',', '.' );
        $row[] = number_format( $d->kondisi_baik, 0, ',', '.' );
        $row[] = number_format( $d->persen_baik, 0, ',', '.' );
        $row[] = number_format( $d->kondisi_sedang, 0, ',', '.' );
        $row[] = number_format( $d->persen_sedang, 0, ',', '.' );
        $row[] = number_format( $d->kondisi_rusak_ringan, 0, ',', '.' );
        $row[] = number_format( $d->persen_rusak_ringan, 0, ',', '.' );
        $row[] = number_format( $d->kondisi_rusak_berat, 0, ',', '.' );
        $row[] = number_format( $d->persen_rusak_berat, 0, ',', '.' );
        $row[] = $d->titik_awal;
        $row[] = $d->titik_akhir;
        $row[] = $d->koordinat_titik_awal;
        $row[] = $d->koordinat_titik_tengah;
        $row[] = $d->koordinat_titik_akhir;

        $data[] = $row;
      }
      $output = array(
        "draw" =>  $this->input->post( 'draw' ),
        "recordsTotal" => $this->m_ruas_jalan->count_all(),
        "recordsFiltered" => $this->m_ruas_jalan->count_filtered(),
        "data" => $data
      );
      echo json_encode( $output );
    }
  }

  function edit() {
    $k = $this->m_ruas_jalan->edit( decrypt_url( $this->input->post( 'q', TRUE ) ) );
    $data[ 'no_ruas' ] = $k->no_ruas;
    $data[ 'nama_ruas' ] = $k->nama_ruas;
    $data[ 'id_kecamatan' ] = encrypt_url( $k->id_kecamatan );
    $data[ 'id_desa' ] = encrypt_url( $k->id_desa );
    $data[ 'kondisi_baik' ] = $k->kondisi_baik;
    $data[ 'kondisi_sedang' ] = $k->kondisi_sedang;
    $data[ 'kondisi_rusak_ringan' ] = $k->kondisi_rusak_ringan;
    $data[ 'kondisi_rusak_berat' ] = $k->kondisi_rusak_berat;
    $data[ 'status_jalan' ] = $k->status_jalan;
    $data[ 'titik_awal' ] = $k->titik_awal;
    $data[ 'panjang' ] = number_format( $k->panjang, 0, ',', '.' );
    $data[ 'lebar' ] = number_format( $k->lebar, 2, ',', '.' );
    $data[ 'titik_akhir' ] = $k->titik_akhir;
    $data[ 'koordinat_titik_awal' ] = trim( $k->koordinat_titik_awal );
    $data[ 'koordinat_titik_akhir' ] = trim( $k->koordinat_titik_akhir );
    $data[ 'koordinat_titik_tengah' ] = trim( $k->koordinat_titik_tengah );
    echo json_encode( $data );
  }


  function delete() {
    $id = decrypt_url( $this->input->post( "q" ) );
    if ( $id != "" || $id != NULL ) {
      $i = $this->m_ruas_jalan->edit( $id );
      $l = $i->foto;
      if ( $l != NULL ) {
        unlink( $l );
      }
      $this->m_ruas_jalan->delete_by_id( $id );
      echo json_encode( array( "status" => TRUE ) );
    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }

  function save() {
    $this->form_validation->set_rules( 'no_ruas', 'no_ruas', 'required' );
    $this->form_validation->set_rules( 'nama_ruas', 'nama_ruas', 'required' );
    $this->form_validation->set_rules( 'id_kecamatan', 'id_kecamatan', 'required' );
    $this->form_validation->set_rules( 'id_desa', 'id_desa', 'required' );
    $this->form_validation->set_rules( 'panjang', 'panjang', 'required' );
    $this->form_validation->set_rules( 'lebar', 'lebar', 'required' );
    $this->form_validation->set_rules( 'status_jalan', 'status_jalan', 'required' );
    $this->form_validation->set_rules( 'titik_awal', 'titik_awal', 'required' );
    $this->form_validation->set_rules( 'titik_akhir', 'titik_akhir', 'required' );
    $this->form_validation->set_rules( 'koordinat_titik_awal', 'koordinat_titik_awal', 'required' );
    $this->form_validation->set_rules( 'koordinat_titik_tengah', 'koordinat_titik_tengah', 'required' );
    $this->form_validation->set_rules( 'koordinat_titik_akhir', 'koordinat_titik_akhir', 'required' );
    if ( $this->form_validation->run() != false ) {
      date_default_timezone_set( 'Asia/Jakarta' );
      $code = date( "HdmiYs" );
      $upload_conf = array(
        'upload_path' => realpath( './upload/foto/' ),
        'allowed_types' => 'jpg|jpeg|png',
        'file_name' => $code
      );
      $this->upload->initialize( $upload_conf );
      if ( !$this->upload->do_upload( 'userfile' ) ) {
        $e = $this->upload->display_errors();
        echo json_encode( array( "status" => FALSE, "pesan" => "Mohon Upload Foto Jalan Terlebih Dahulu!" ) );
      } else {
        $no_ruas = $this->input->post( 'no_ruas', TRUE );
        $nama_ruas = $this->input->post( 'nama_ruas', TRUE );
        $id_kecamatan = $this->input->post( 'id_kecamatan', TRUE );
        $id_desa = $this->input->post( 'id_desa', TRUE );
        $status_jalan = $this->input->post( 'status_jalan', TRUE );
        $kondisi_baik = $this->libku->ribuansql( $this->input->post( 'kondisi_baik', TRUE ) );
        $kondisi_sedang = $this->libku->ribuansql( $this->input->post( 'kondisi_sedang', TRUE ) );
        $kondisi_rusak_ringan = $this->libku->ribuansql( $this->input->post( 'kondisi_rusak_ringan', TRUE ) );
        $kondisi_rusak_berat = $this->libku->ribuansql( $this->input->post( 'kondisi_rusak_berat', TRUE ) );
        $titik_awal = $this->input->post( 'titik_awal', TRUE );
        $titik_akhir = $this->input->post( 'titik_akhir', TRUE );
        $panjang = $this->libku->ribuansql( $this->input->post( 'panjang', TRUE ) );
        $lebar = $this->input->post( 'lebar', TRUE );
        $status_jalan = $this->input->post( 'status_jalan', TRUE );
        $koordinat_titik_awal = $this->input->post( 'koordinat_titik_awal', TRUE );
        $koordinat_titik_tengah = $this->input->post( 'koordinat_titik_tengah', TRUE );
        $koordinat_titik_akhir = $this->input->post( 'koordinat_titik_akhir', TRUE );
        $upload_data = $this->upload->data();
        $persen_baik = intval( $kondisi_baik ) / intval( $panjang ) * 100;
        $persen_sedang = intval( $kondisi_sedang ) / intval( $panjang ) * 100;
        $persen_rusak_ringan = intval( $kondisi_rusak_ringan ) / intval( $panjang ) * 100;
        $persen_rusak_berat = intval( $kondisi_rusak_berat ) / intval( $panjang ) * 100;

        $data = array(
          'no_ruas' => $no_ruas,
          'nama_ruas' => $nama_ruas,
          'id_kecamatan' => decrypt_url( $id_kecamatan ),
          'id_desa' => decrypt_url( $id_desa ),
          'status_jalan' => $status_jalan,
          'kondisi_baik' => $kondisi_baik,
          'kondisi_sedang' => $kondisi_sedang,
          'kondisi_rusak_ringan' => $kondisi_rusak_ringan,
          'kondisi_rusak_berat' => $kondisi_rusak_berat,
          'persen_baik' => $persen_baik,
          'persen_sedang' => $persen_sedang,
          'persen_rusak_ringan' => $persen_rusak_ringan,
          'persen_rusak_berat' => $persen_rusak_berat,
          'status_jalan' => $status_jalan,
          'titik_awal' => $titik_awal,
          'titik_akhir' => $titik_akhir,
          'panjang' => $panjang,
          'lebar' => $this->libku->inputAngka( $lebar ),
          'koordinat_titik_awal' =>hapus( $koordinat_titik_awal ),
          'koordinat_titik_tengah' =>hapus( $koordinat_titik_tengah ),
          'koordinat_titik_akhir' =>hapus( $koordinat_titik_akhir ),
          'foto' => 'upload/foto/' . $upload_data[ 'file_name' ]
        );
        $id = $this->m_ruas_jalan->save( $data );
        echo json_encode( array( "status" => TRUE ) );
      }
    } else {
      echo json_encode( array( "status" => FALSE, "pesan" => "Input tidak valid. Silahkan periksa kembali inputan anda!" ) );
    }
  }


  function update() {
    $this->form_validation->set_rules( 'no_ruas', 'no_ruas', 'required' );
    $this->form_validation->set_rules( 'nama_ruas', 'nama_ruas', 'required' );
    $this->form_validation->set_rules( 'id_kecamatan', 'id_kecamatan', 'required' );
    $this->form_validation->set_rules( 'id_desa', 'id_desa', 'required' );
    $this->form_validation->set_rules( 'panjang', 'panjang', 'required' );
    $this->form_validation->set_rules( 'lebar', 'lebar', 'required' );
    $this->form_validation->set_rules( 'status_jalan', 'status_jalan', 'required' );
    $this->form_validation->set_rules( 'titik_awal', 'titik_awal', 'required' );
    $this->form_validation->set_rules( 'titik_akhir', 'titik_akhir', 'required' );
    $this->form_validation->set_rules( 'koordinat_titik_awal', 'koordinat_titik_awal', 'required' );
    $this->form_validation->set_rules( 'koordinat_titik_tengah', 'koordinat_titik_tengah', 'required' );
    $this->form_validation->set_rules( 'koordinat_titik_akhir', 'koordinat_titik_akhir', 'required' );
    if ( $this->form_validation->run() != false ) {
      $id = decrypt_url( $this->input->get( "q" ) );
       $no_ruas = $this->input->post( 'no_ruas', TRUE );
        $nama_ruas = $this->input->post( 'nama_ruas', TRUE );
        $id_kecamatan = $this->input->post( 'id_kecamatan', TRUE );
        $id_desa = $this->input->post( 'id_desa', TRUE );
        $status_jalan = $this->input->post( 'status_jalan', TRUE );
        $kondisi_baik = $this->libku->ribuansql( $this->input->post( 'kondisi_baik', TRUE ) );
        $kondisi_sedang = $this->libku->ribuansql( $this->input->post( 'kondisi_sedang', TRUE ) );
        $kondisi_rusak_ringan = $this->libku->ribuansql( $this->input->post( 'kondisi_rusak_ringan', TRUE ) );
        $kondisi_rusak_berat = $this->libku->ribuansql( $this->input->post( 'kondisi_rusak_berat', TRUE ) );
        $titik_awal = $this->input->post( 'titik_awal', TRUE );
        $titik_akhir = $this->input->post( 'titik_akhir', TRUE );
        $panjang = $this->libku->ribuansql( $this->input->post( 'panjang', TRUE ) );
        $lebar = $this->input->post( 'lebar', TRUE );
        $status_jalan = $this->input->post( 'status_jalan', TRUE );
        $koordinat_titik_awal = $this->input->post( 'koordinat_titik_awal', TRUE );
        $koordinat_titik_tengah = $this->input->post( 'koordinat_titik_tengah', TRUE );
        $koordinat_titik_akhir = $this->input->post( 'koordinat_titik_akhir', TRUE );
        $upload_data = $this->upload->data();
        $persen_baik = intval( $kondisi_baik ) / intval( $panjang ) * 100;
        $persen_sedang = intval( $kondisi_sedang ) / intval( $panjang ) * 100;
        $persen_rusak_ringan = intval( $kondisi_rusak_ringan ) / intval( $panjang ) * 100;
        $persen_rusak_berat = intval( $kondisi_rusak_berat ) / intval( $panjang ) * 100;
      date_default_timezone_set( 'Asia/Jakarta' );
      $code = date( "HdmiYs" );
      $upload_conf = array(
        'upload_path' => realpath( './upload/foto/' ),
        'allowed_types' => 'jpg|jpeg|png',
        'file_name' => $code
      );
      $this->upload->initialize( $upload_conf );
      if ( !$this->upload->do_upload( 'userfile' ) ) {
        $upload_data = $this->upload->data();
          $data = array(
          'no_ruas' => $no_ruas,
          'nama_ruas' => $nama_ruas,
          'id_kecamatan' => decrypt_url( $id_kecamatan ),
          'id_desa' => decrypt_url( $id_desa ),
          'status_jalan' => $status_jalan,
          'kondisi_baik' => $kondisi_baik,
          'kondisi_sedang' => $kondisi_sedang,
          'kondisi_rusak_ringan' => $kondisi_rusak_ringan,
          'kondisi_rusak_berat' => $kondisi_rusak_berat,
          'persen_baik' => $persen_baik,
          'persen_sedang' => $persen_sedang,
          'persen_rusak_ringan' => $persen_rusak_ringan,
          'persen_rusak_berat' => $persen_rusak_berat,
          'status_jalan' => $status_jalan,
          'titik_awal' => $titik_awal,
          'titik_akhir' => $titik_akhir,
          'panjang' => $panjang,
          'lebar' => $this->libku->inputAngka( $lebar ),
          'koordinat_titik_awal' => hapus( $koordinat_titik_awal ),
          'koordinat_titik_tengah' => hapus( $koordinat_titik_tengah ),
          'koordinat_titik_akhir' => hapus( $koordinat_titik_akhir )
        );
        $this->m_ruas_jalan->update( array( 'id_ruas_jalan' => $id ), $data );
        echo json_encode( array( "status" => TRUE ) );
      } else {
        $upload_data = $this->upload->data();
        $i = $this->m_ruas_jalan->edit( $id );
        $l = $i->foto;
        if ( $l != NULL ) {
          unlink( $l );
        }
          $data = array(
          'no_ruas' => $no_ruas,
          'nama_ruas' => $nama_ruas,
          'id_kecamatan' => decrypt_url( $id_kecamatan ),
          'id_desa' => decrypt_url( $id_desa ),
          'status_jalan' => $status_jalan,
          'kondisi_baik' => $kondisi_baik,
          'kondisi_sedang' => $kondisi_sedang,
          'kondisi_rusak_ringan' => $kondisi_rusak_ringan,
          'kondisi_rusak_berat' => $kondisi_rusak_berat,
          'persen_baik' => $persen_baik,
          'persen_sedang' => $persen_sedang,
          'persen_rusak_ringan' => $persen_rusak_ringan,
          'persen_rusak_berat' => $persen_rusak_berat,
          'status_jalan' => $status_jalan,
          'titik_awal' => $titik_awal,
          'titik_akhir' => $titik_akhir,
          'panjang' => $panjang,
          'lebar' => $this->libku->inputAngka( $lebar ),
          'koordinat_titik_awal' => hapus( $koordinat_titik_awal ),
          'koordinat_titik_tengah' => hapus( $koordinat_titik_tengah ),
          'koordinat_titik_akhir' => hapus( $koordinat_titik_akhir ),
          'foto' => 'upload/foto/' . $upload_data[ 'file_name' ]
        );
        $this->m_ruas_jalan->update( array( 'id_ruas_jalan' => $id ), $data );
        echo json_encode( array( "status" => TRUE ) );
      }
    } else {
      echo json_encode( array( "status" => FALSE, "pesan" => "Input tidak valid. Silahkan periksa kembali inputan anda!" ) );
    }
  }


  function get_desa() {
    $id_kecamatan = decrypt_url( $this->input->post( 'q' ) );
    $list = $this->m_desa->get_by_kecamatan( $id_kecamatan );
    $isine = array();
    foreach ( $list as $i ) {
      $row = array();
      $row[ 'id_desa' ] = encrypt_url( $i->id_desa );
      $row[ 'desa' ] = $i->desa;
      $isine[] = $row;
    }
    $data[ 'isi' ] = $isine;
    echo json_encode( $data );
  }

  function cetak() {

    $id_kecamatan = $this->input->get( 'k' );
    $id_desa = $this->input->get( 'd' );
    $excel = new PHPExcel();
    $excel->getProperties()->setCreator( 'DINAS PEKERJAAN UMUM,BINA MARGA DAN PENATAAN RUANG KABUPATEN BOJONEGORO' )->setLastModifiedBy( 'DINAS PEKERJAAN UMUM,BINA MARGA DAN PENATAAN RUANG KABUPATEN BOJONEGORO' )->setTitle( "DATA RUAS JALAN" )->setSubject( "REKAP RUAS JALAN" )->setDescription( "REKAP RUAS JALAN" )->setKeywords( "REKAP RUAS JALAN" );
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
    $objDrawing->setName( 'logo_pu' );
    $objDrawing->setDescription( 'logo_pu' );
    $objDrawing->setPath( './aset/img/logo_bojonegoro.png' );
    $objDrawing->setCoordinates( 'A1' );
    $objDrawing->setOffsetX( 5 );
    $objDrawing->setOffsetY( 5 );
    $objDrawing->setWidth( 150 );
    $objDrawing->setHeight( 70 );
    $objDrawing->setWorksheet( $excel->getActiveSheet() );

    $excel->setActiveSheetIndex( 0 )->setCellValue( 'B1', "PEMERINTAH KABUPATEN BOJONEGORO" );
    $excel->getActiveSheet()->getStyle( 'B1' )->getFont()->setBold( TRUE );
    $excel->getActiveSheet()->getStyle( 'B1' )->getFont()->setSize( 14 );
    $excel->setActiveSheetIndex( 0 )->setCellValue( 'B2', "DINAS PEKERJAAN UMUM, BINA MARGA DAN PENATAAN RUANG" );
    $excel->getActiveSheet()->getStyle( 'B2' )->getFont()->setSize( 13 );

    $excel->setActiveSheetIndex( 0 )->setCellValue( 'B3', "Jl. Lettu Suyitno 39, Bojonegoro - Jawa Timur" );
    $excel->getActiveSheet()->getStyle( 'B3' )->getFont()->setSize( 12 );

    $excel->setActiveSheetIndex( 0 )->setCellValue( 'A5', "REKAPITULASI DATA RUAS JALAN" );
    $excel->getActiveSheet()->mergeCells( 'A5:M5' );
    $excel->getActiveSheet()->getStyle( 'A5' )->getFont()->setBold( TRUE );
    $excel->getActiveSheet()->getStyle( 'A5' )->getFont()->setSize( 20 );
    $excel->getActiveSheet()->getStyle( 'A5' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );

    if ( $id_kecamatan != "-1" ) {
      $k = $this->m_kecamatan->detail( decrypt_url( $id_kecamatan ) );
      if ( $id_desa == "-1" ) {
        $excel->setActiveSheetIndex( 0 )->setCellValue( 'A7', "KECAMATAN " . strtoupper( $k->kecamatan ) );
        $excel->getActiveSheet()->mergeCells( 'A7:M7' );
        $excel->getActiveSheet()->getStyle( 'A7' )->getFont()->setBold( TRUE );
        $excel->getActiveSheet()->getStyle( 'A7' )->getFont()->setSize( 12 );

      } else {
        $d = $this->m_desa->detail( decrypt_url( $id_desa ) );
        $excel->setActiveSheetIndex( 0 )->setCellValue( 'A7', "DESA/KELURAHAN " . strtoupper( $d->desa ) . " KECAMATAN " . strtoupper( $k->kecamatan ) );
        $excel->getActiveSheet()->mergeCells( 'A7:M7' );
        $excel->getActiveSheet()->getStyle( 'A7' )->getFont()->setBold( TRUE );
        $excel->getActiveSheet()->getStyle( 'A7' )->getFont()->setSize( 12 );

      }
    }


    $excel->setActiveSheetIndex( 0 )->setCellValue( 'A8', "NO RUAS" );
    $excel->getActiveSheet()->mergeCells( 'A8:A9' );
    $excel->setActiveSheetIndex( 0 )->setCellValue( 'B8', "NAMA RUAS" );
    $excel->getActiveSheet()->mergeCells( 'B8:B9' );
    $excel->setActiveSheetIndex( 0 )->setCellValue( 'C8', "KECAMATAN" );
    $excel->getActiveSheet()->mergeCells( 'C8:C9' );
    $excel->setActiveSheetIndex( 0 )->setCellValue( 'D8', "DESA" );
    $excel->getActiveSheet()->mergeCells( 'D8:D9' );
    $excel->setActiveSheetIndex( 0 )->setCellValue( 'E8', "STATUS JALAN" );
    $excel->getActiveSheet()->mergeCells( 'E8:E9' );
    $excel->setActiveSheetIndex( 0 )->setCellValue( 'F8', "PANJANG" );
    $excel->getActiveSheet()->mergeCells( 'F8:F9' );
    $excel->setActiveSheetIndex( 0 )->setCellValue( 'G8', "LEBAR" );
    $excel->getActiveSheet()->mergeCells( 'G8:G9' );
    $excel->setActiveSheetIndex( 0 )->setCellValue( 'H8', "KONDISI" );
    $excel->getActiveSheet()->mergeCells( 'H8:K8' );
    $excel->setActiveSheetIndex( 0 )->setCellValue( 'H9', "BAIK" );
    $excel->setActiveSheetIndex( 0 )->setCellValue( 'I9', "SEDANG" );
    $excel->setActiveSheetIndex( 0 )->setCellValue( 'J9', "RUSAK RINGAN" );
    $excel->setActiveSheetIndex( 0 )->setCellValue( 'K9', "RUSAK BERAT" );
    $excel->setActiveSheetIndex( 0 )->setCellValue( 'L8', "TITIK AWAL" );
    $excel->getActiveSheet()->mergeCells( 'L8:L9' );
    $excel->setActiveSheetIndex( 0 )->setCellValue( 'M8', "TITIK AKHIR" );
    $excel->getActiveSheet()->mergeCells( 'M8:M9' );
    $excel->getActiveSheet()->getRowDimension( '8' )->setRowHeight( 25 );
    $excel->getActiveSheet()->getRowDimension( '9' )->setRowHeight( 25 );
    $excel->getActiveSheet()->getStyle( 'A8' )->applyFromArray( $style_col );
    $excel->getActiveSheet()->getStyle( 'B8' )->applyFromArray( $style_col );
    $excel->getActiveSheet()->getStyle( 'C8' )->applyFromArray( $style_col );
    $excel->getActiveSheet()->getStyle( 'D8' )->applyFromArray( $style_col );
    $excel->getActiveSheet()->getStyle( 'E8' )->applyFromArray( $style_col );
    $excel->getActiveSheet()->getStyle( 'F8' )->applyFromArray( $style_col );
    $excel->getActiveSheet()->getStyle( 'G8' )->applyFromArray( $style_col );
    $excel->getActiveSheet()->getStyle( 'H8' )->applyFromArray( $style_col );
    $excel->getActiveSheet()->getStyle( 'I8' )->applyFromArray( $style_col );
    $excel->getActiveSheet()->getStyle( 'J8' )->applyFromArray( $style_col );
    $excel->getActiveSheet()->getStyle( 'K8' )->applyFromArray( $style_col );
    $excel->getActiveSheet()->getStyle( 'L8' )->applyFromArray( $style_col );
    $excel->getActiveSheet()->getStyle( 'M8' )->applyFromArray( $style_col );
    $excel->getActiveSheet()->getStyle( 'A9' )->applyFromArray( $style_col );
    $excel->getActiveSheet()->getStyle( 'B9' )->applyFromArray( $style_col );
    $excel->getActiveSheet()->getStyle( 'C9' )->applyFromArray( $style_col );
    $excel->getActiveSheet()->getStyle( 'D9' )->applyFromArray( $style_col );
    $excel->getActiveSheet()->getStyle( 'E9' )->applyFromArray( $style_col );
    $excel->getActiveSheet()->getStyle( 'F9' )->applyFromArray( $style_col );
    $excel->getActiveSheet()->getStyle( 'G9' )->applyFromArray( $style_col );
    $excel->getActiveSheet()->getStyle( 'H9' )->applyFromArray( $style_col );
    $excel->getActiveSheet()->getStyle( 'I9' )->applyFromArray( $style_col );
    $excel->getActiveSheet()->getStyle( 'J9' )->applyFromArray( $style_col );
    $excel->getActiveSheet()->getStyle( 'K9' )->applyFromArray( $style_col );
    $excel->getActiveSheet()->getStyle( 'L9' )->applyFromArray( $style_col );
    $excel->getActiveSheet()->getStyle( 'M9' )->applyFromArray( $style_col );
    $nw = 10;
    $isi = $this->m_ruas_jalan->cetak( $id_kecamatan, $id_desa );
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
      $kondisi = $p->kondisi;
      switch ( $kondisi ) {
        case '1':
          $kondisi = "Baik";
          break;
        case '2':
          $kondisi = "Sedang";
          break;
        case '3':
          $kondisi = "Rusak";
          break;
        case '4':
          $kondisi = "Rusak Berat";
          break;
        default:
          $kondisi = "-";
          break;
      }


      $excel->setActiveSheetIndex( 0 )->setCellValue( 'A' . $nw, $p->no_ruas );
      $excel->setActiveSheetIndex( 0 )->setCellValue( 'B' . $nw, $p->nama_ruas );
      $excel->setActiveSheetIndex( 0 )->setCellValue( 'C' . $nw, $p->kecamatan );
      $excel->setActiveSheetIndex( 0 )->setCellValue( 'D' . $nw, $p->desa );
      $excel->setActiveSheetIndex( 0 )->setCellValue( 'E' . $nw, $status_jalan );
      $excel->setActiveSheetIndex( 0 )->setCellValue( 'F' . $nw, $p->panjang );
      $excel->setActiveSheetIndex( 0 )->setCellValue( 'G' . $nw, $p->lebar );
      $excel->setActiveSheetIndex( 0 )->setCellValue( 'H' . $nw, $p->kondisi_baik . "%" );
      $excel->setActiveSheetIndex( 0 )->setCellValue( 'I' . $nw, $p->kondisi_sedang . "%" );
      $excel->setActiveSheetIndex( 0 )->setCellValue( 'J' . $nw, $p->kondisi_rusak_ringan . "%" );
      $excel->setActiveSheetIndex( 0 )->setCellValue( 'K' . $nw, $p->kondisi_rusak_berat . "%" );
      $excel->setActiveSheetIndex( 0 )->setCellValue( 'L' . $nw, $p->titik_awal );
      $excel->setActiveSheetIndex( 0 )->setCellValue( 'M' . $nw, $p->titik_akhir );
      $excel->getActiveSheet()->getStyle( 'A' . $nw )->applyFromArray( $style_row1 );
      $excel->getActiveSheet()->getStyle( 'B' . $nw )->applyFromArray( $style_row );
      $excel->getActiveSheet()->getStyle( 'C' . $nw )->applyFromArray( $style_row );
      $excel->getActiveSheet()->getStyle( 'D' . $nw )->applyFromArray( $style_row );
      $excel->getActiveSheet()->getStyle( 'E' . $nw )->applyFromArray( $style_row );
      $excel->getActiveSheet()->getStyle( 'F' . $nw )->applyFromArray( $style_row );
      $excel->getActiveSheet()->getStyle( 'G' . $nw )->applyFromArray( $style_row );
      $excel->getActiveSheet()->getStyle( 'H' . $nw )->applyFromArray( $style_row1 );
      $excel->getActiveSheet()->getStyle( 'I' . $nw )->applyFromArray( $style_row1 );
      $excel->getActiveSheet()->getStyle( 'J' . $nw )->applyFromArray( $style_row1 );
      $excel->getActiveSheet()->getStyle( 'K' . $nw )->applyFromArray( $style_row1 );
      $excel->getActiveSheet()->getStyle( 'L' . $nw )->applyFromArray( $style_row );
      $excel->getActiveSheet()->getStyle( 'M' . $nw )->applyFromArray( $style_row );
      $excel->getActiveSheet()->getRowDimension( $nw )->setRowHeight( 20 );
      $nw++;
    }
    $excel->getActiveSheet()->getColumnDimension( 'A' )->setWidth( 10 );
    $excel->getActiveSheet()->getColumnDimension( 'B' )->setWidth( 45 );
    $excel->getActiveSheet()->getColumnDimension( 'C' )->setWidth( 20 );
    $excel->getActiveSheet()->getColumnDimension( 'D' )->setWidth( 20 );
    $excel->getActiveSheet()->getColumnDimension( 'E' )->setWidth( 20 );
    $excel->getActiveSheet()->getColumnDimension( 'F' )->setWidth( 20 );
    $excel->getActiveSheet()->getColumnDimension( 'G' )->setWidth( 20 );
    $excel->getActiveSheet()->getColumnDimension( 'H' )->setWidth( 20 );
    $excel->getActiveSheet()->getColumnDimension( 'I' )->setWidth( 20 );
    $excel->getActiveSheet()->getColumnDimension( 'J' )->setWidth( 20 );
    $excel->getActiveSheet()->getColumnDimension( 'K' )->setWidth( 20 );
    $excel->getActiveSheet()->getColumnDimension( 'L' )->setWidth( 20 );
    $excel->getActiveSheet()->getColumnDimension( 'M' )->setWidth( 20 );

    $excel->getActiveSheet()->getPageSetup()->setOrientation( PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE );
    $excel->getActiveSheet( 0 )->setTitle( "REKAP DATA RUAS JALAN" );
    $excel->setActiveSheetIndex( 0 );
    header( 'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' );
    header( 'Content-Disposition: attachment; filename="Rekap Data Ruas Jalan.xlsx"' ); // Set nama file excel nya
    header( 'Cache-Control: max-age=0' );
    $write = PHPExcel_IOFactory::createWriter( $excel, 'Excel2007' );
    $write->save( 'php://output' );
  }

  function cetak_pdf() {
    $id_kecamatan = $this->input->get( 'k' );
    $id_desa = $this->input->get( 'd' );
    $k = "";
    $d = "";
    if ( $id_kecamatan != "-1" ) {
      $x = $this->m_kecamatan->detail( decrypt_url( $id_kecamatan ) );
      $k = "KECAMATAN " . strtoupper( $x->kecamatan );
      if ( $id_desa != "-1" ) {
        $y = $this->m_desa->detail( decrypt_url( $id_desa ) );
        $d = "DESA/KELURAHAN " . strtoupper( $y->desa ) . " ";
      }
    }
    $data[ 'isi' ] = $this->m_ruas_jalan->cetak( $id_kecamatan, $id_desa );
    $data[ 'kecamatan' ] = $k;
    $data[ 'desa' ] = $d;
    $this->load->view( 'print/ruas_jalan', $data );
  }


}