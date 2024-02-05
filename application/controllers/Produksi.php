<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Produksi extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->load->model( array( 'm_produksi', 'm_tempat_lelang', 'm_perahu', 'm_ikan', 'm_pembeli', 'm_produksi_rekap', 'm_produksi_timbang' ) );
    $this->load->library( array( 'upload', 'form_validation', 'image_lib', 'libku' ) );
    if ( !$this->auth->cek() ) {
      $this->session->sess_destroy();
      redirect( base_url() );
      exit();
    }
  }

  function index() {
    $data[ 'title' ] = "Produksi";
    $data[ 'judul' ] = "Produksi";
    $data[ 'tempat_lelang' ] = $this->m_tempat_lelang->get_all();
    $data[ 'ikan' ] = $this->m_ikan->get_all();
    $data[ 'perahu' ] = $this->m_perahu->get_all();
    $data[ 'pembeli' ] = $this->m_pembeli->get_all();
    $data[ 'no_hp' ] = $this->m_pembeli->get_all();
    // yoshe ubah ini td yg atas yg no hp
    $this->template->display( 'content/produksi', $data );
  }

  function rekapitulasi() {
    $data[ 'title' ] = "Rekapitulasi Produksi";
    $data[ 'judul' ] = "Rekapitulasi Produksi";
    $this->template->display( 'content/rekapitulasi_produksi', $data );
  }

  function detail_rekap() {
    $id = decrypt_url( $this->input->get( 'q', TRUE ) );
    $start_date = $this->input->get( 'start_date', TRUE );
    $end_date = $this->input->get( 'end_date', TRUE );
    $perahu = $this->m_perahu->edit( $id );
    $periode = $start_date . ' s/d ' . $end_date;
    if ( $start_date == $end_date ) {
      $periode = $start_date;
    }
    $start = $this->libku->tgl_mysql( $start_date );
    $end = $this->libku->tgl_mysql( $end_date );
    $total_ikan = $this->m_produksi_rekap->total_ikan( $id, $start, $end )->total_ikan;
    $total_pendapatan = $this->m_produksi_rekap->total_pendapatan( $id, $start, $end )->total_pendapatan;
    $total_bensin = $this->m_produksi_rekap->total_bensin( $id, $start, $end );
    $total_solar = $this->m_produksi_rekap->total_solar( $id, $start, $end );


    $data[ 'title' ] = "Detail Rekapitulasi";
    $data[ 'judul' ] = "Detail Rekapitulasi";
    $data[ 'periode' ] = $periode;
    $data[ 'total_ikan' ] = number_format( $total_ikan, 0, ',', '.' );
    $data[ 'total_pendapatan' ] = number_format( $total_pendapatan, 0, ',', '.' );
    $data[ 'isi' ] = $this->m_perahu->edit( $id );
    $data[ 'nelayan' ] = $this->m_produksi_rekap->get_nelayan( $id );
    $data[ 'total_bensin' ] = 'Rp. ' . number_format( $total_bensin->total, 0, ',', '.' ) . ' ( ' . number_format( $total_bensin->total_bensin, 0, ',', '.' ) . ' liter)';
    $data[ 'total_solar' ] = 'Rp. ' . number_format( $total_solar->total, 0, ',', '.' ) . ' ( ' . number_format( $total_solar->total_solar, 0, ',', '.' ) . ' liter)';
    $data[ 'start' ] = $start_date;
    $data[ 'end' ] = $end_date;
    $this->template->display( 'content/detail_rekap', $data );
  }


  function ajax_list() {
    $list = $this->m_produksi->get_datatables();
    $data = array();
    $no = $this->input->post( 'start' );
    foreach ( $list as $d ) {
		
      $foto = $d->foto_timbang ? : 
      'aset/img/belum_diupload.jpg';
      $no++;
      $row = array();
      $row[] = ' <div class="btn-group">
      <a href="javascript:;" class="btn btn-sm btn-warning btn-rounded" data-toggle="tooltip" data-original-title="Delete" onClick="edit_data(' . "'" . encrypt_url( $d->id_produksi ) . "'" . ')"> Edit </a> <a href="javascript:;" class="btn btn-sm btn-danger btn-rounded" data-toggle="tooltip" data-original-title="Logo" onClick="delete_data(' . "'" . encrypt_url( $d->id_produksi ) . "'" . ')">Delete</a></div>';
      $row[] = $no;
      $row[] = '<a href="javascript:void(0)" onclick="lihat_foto(' . "'" . base_url() . $foto . "'" . ')" ><img src="' . base_url() . $foto . '" class="img-fluid"></a>';
      $row[] = date( 'd/m/Y', strtotime( $d->tanggal ) );
      $row[] = $d->tempat_lelang;
      $row[] = $d->nama_perahu;
      $row[] = $d->ikan;
      $row[] = number_format( $d->berat, 0, ',', '.' );
      $row[] = number_format( $d->harga, 0, ',', '.' );
      $row[] = number_format( $d->total, 0, ',', '.' );
      $row[] = $d->nama_pembeli;
      $row[] = $d->no_hp;
      // yoshe ubah yg no hp
      $data[] = $row;
    }
    $output = array(
      "draw" => $_POST[ 'draw' ],
      "recordsTotal" => $this->m_produksi->count_all(),
      "recordsFiltered" => $this->m_produksi->count_filtered(),
      "data" => $data
    );
    echo json_encode( $output );
  }

  function edit() {
    $k = $this->m_produksi->edit( decrypt_url( $this->input->post( 'q', TRUE ) ) );
    $data[ 'tanggal' ] = date( 'd/m/Y', strtotime( $k->tanggal ) );
    $data[ 'id_perahu' ] = encrypt_url( $k->id_perahu );
    $data[ 'id_tempat_lelang' ] = encrypt_url( $k->id_tempat_lelang );
    $data[ 'id_ikan' ] = encrypt_url( $k->id_ikan );
    $data[ 'berat' ] = number_format( $k->berat, 0, ',', '.' );
    $data[ 'harga' ] = number_format( $k->harga, 0, ',', '.' );
    $data[ 'id_pembeli' ] = encrypt_url( $k->id_pembeli );
    echo json_encode( $data );
  }


  function delete() {
    $id = decrypt_url( $this->input->post( "q" ) );
    if ( $id != "" || $id != NULL ) {
      $i = $this->m_produksi->edit( $id );
      $l = $i->foto_timbang;
      if ( $l != NULL ) {
        unlink( $l );
      }
      $this->m_produksi->delete_by_id( $id );
      echo json_encode( array( "status" => TRUE ) );
    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }

  function save() {
    $this->form_validation->set_rules( 'tanggal', 'tanggal', 'required' );
    $this->form_validation->set_rules( 'id_perahu', 'id_perahu', 'required' );
    $this->form_validation->set_rules( 'id_tempat_lelang', 'id_tempat_lelang', 'required' );
    $this->form_validation->set_rules( 'id_ikan', 'id_ikan', 'required' );
    $this->form_validation->set_rules( 'berat', 'berat', 'required' );
    $this->form_validation->set_rules( 'harga', 'harga', 'required' );
    if ( $this->form_validation->run() != false ) {
      $tanggal = $this->libku->tgl_mysql( $this->input->post( 'tanggal', TRUE ) );
      $id_perahu = decrypt_url( $this->input->post( 'id_perahu', TRUE ) );
      $id_tempat_lelang = decrypt_url( $this->input->post( 'id_tempat_lelang', TRUE ) );
      $id_ikan = decrypt_url( $this->input->post( 'id_ikan', TRUE ) );
      $id_pembeli = decrypt_url( $this->input->post( 'id_pembeli', TRUE ) );
      $berat = $this->libku->ribuansql( $this->input->post( 'berat', TRUE ) );
      $harga = $this->libku->ribuansql( $this->input->post( 'harga', TRUE ) );
      $total = intval( $berat ) * intval( $harga );

      date_default_timezone_set( 'Asia/Jakarta' );
      $code = date( "HdmiYs" );
      $upload_conf = array(
        'upload_path' => realpath( './upload/foto_timbang/' ),
        'allowed_types' => 'jpg|jpeg|png',
        'file_name' => $code
      );
      $this->upload->initialize( $upload_conf );
      if ( !$this->upload->do_upload( 'userfile' ) ) {
        $data = array(
          'tanggal' => $tanggal,
          'id_tempat_lelang' => $id_tempat_lelang,
          'id_perahu' => $id_perahu,
          'id_ikan' => $id_ikan,
          'id_pembeli' => $id_pembeli,
          'berat' => $berat,
          'harga' => $harga,
          'total' => $total
        );
        $this->m_produksi->save( $data );
        echo json_encode( array( "status" => TRUE ) );
      } else {
        $upload_data = $this->upload->data();
        $data = array(
          'tanggal' => $tanggal,
          'id_tempat_lelang' => $id_tempat_lelang,
          'id_perahu' => $id_perahu,
          'id_ikan' => $id_ikan,
          'id_pembeli' => $id_pembeli,
          'berat' => $berat,
          'harga' => $harga,
          'total' => $total,
          'foto_timbang' => 'upload/foto_timbang/' . $upload_data[ 'file_name' ]
        );
        $this->m_produksi->save( $data );
        echo json_encode( array( "status" => TRUE ) );
      }
    } else {
      echo json_encode( array( "status" => FALSE, "pesan" => "Input tidak valid. Silahkan periksa kembali inputan anda!" ) );
    }
  }


  function update() {
    $id = decrypt_url( $this->input->get( "q" ) );
    $this->form_validation->set_rules( 'tanggal', 'tanggal', 'required' );
    $this->form_validation->set_rules( 'id_perahu', 'id_perahu', 'required' );
    $this->form_validation->set_rules( 'id_tempat_lelang', 'id_tempat_lelang', 'required' );
    $this->form_validation->set_rules( 'id_ikan', 'id_ikan', 'required' );
    $this->form_validation->set_rules( 'berat', 'berat', 'required' );
    $this->form_validation->set_rules( 'harga', 'harga', 'required' );
    if ( $this->form_validation->run() != false ) {
      $tanggal = $this->libku->tgl_mysql( $this->input->post( 'tanggal', TRUE ) );
      $id_perahu = decrypt_url( $this->input->post( 'id_perahu', TRUE ) );
      $id_tempat_lelang = decrypt_url( $this->input->post( 'id_tempat_lelang', TRUE ) );
      $id_ikan = decrypt_url( $this->input->post( 'id_ikan', TRUE ) );
      $id_pembeli = decrypt_url( $this->input->post( 'id_pembeli', TRUE ) );
      $berat = $this->libku->ribuansql( $this->input->post( 'berat', TRUE ) );
      $harga = $this->libku->ribuansql( $this->input->post( 'harga', TRUE ) );
      $total = intval( $berat ) * intval( $harga );

      date_default_timezone_set( 'Asia/Jakarta' );
      $code = date( "HdmiYs" );
      $upload_conf = array(
        'upload_path' => realpath( './upload/foto_timbang/' ),
        'allowed_types' => 'jpg|jpeg|png',
        'file_name' => $code
      );
      $this->upload->initialize( $upload_conf );
      if ( !$this->upload->do_upload( 'userfile' ) ) {
        $data = array(
          'tanggal' => $tanggal,
          'id_tempat_lelang' => $id_tempat_lelang,
          'id_perahu' => $id_perahu,
          'id_ikan' => $id_ikan,
          'id_pembeli' => $id_pembeli,
          'berat' => $berat,
          'harga' => $harga,
          'total' => $total
        );
        $this->m_produksi->update( array( 'id_produksi' => $id ), $data );
        echo json_encode( array( "status" => TRUE ) );
      } else {
        $upload_data = $this->upload->data();
        $data = array(
          'tanggal' => $tanggal,
          'id_tempat_lelang' => $id_tempat_lelang,
          'id_perahu' => $id_perahu,
          'id_ikan' => $id_ikan,
          'id_pembeli' => $id_pembeli,
          'berat' => $berat,
          'harga' => $harga,
          'total' => $total,
          'foto_timbang' => 'upload/foto_timbang/' . $upload_data[ 'file_name' ]
        );
        $this->m_produksi->update( array( 'id_produksi' => $id ), $data );
      }
    } else {
      echo json_encode( array( "status" => FALSE, "pesan" => "Input tidak valid. Silahkan periksa kembali inputan anda!" ) );
    }
  }

  function ajax_list_rekapitulasi() {
    $list = $this->m_produksi_rekap->get_datatables();
    $start_date = $this->input->post( 'tanggal_awal' );
    $end_date = $this->input->post( 'tanggal_akhir' );
    $periode = $start_date . ' s/d ' . $end_date;
	  
    if ( $start_date == $end_date ) {
      $periode = $start_date;
    }
	  
    $start = date('Y-m-d',strtotime($start_date)) ;
	  
	  
    $end = date('Y-m-d',strtotime($end_date)) ;
    $data = array();
    $no = $this->input->post( 'start' );
	  
	  
    foreach ( $list as $d ) {
      $total_ikan = $this->m_produksi_rekap->total_ikan( $d->id_perahu, $start, $end )->total_ikan;
      $total_pendapatan = $this->m_produksi_rekap->total_pendapatan( $d->id_perahu, $start, $end )->total_pendapatan;
      $tb = $this->m_produksi_rekap->total_bensin( $d->id_perahu, $start, $end );
      $ts = $this->m_produksi_rekap->total_solar( $d->id_perahu, $start, $end );
      $bensin = $tb->total_bensin;
      $total_bensin = $tb->total;
      $solar = $ts->total_solar;
      $total_solar = $ts->total;
      $total_bbm = intval( $bensin ) + intval( $solar );
      $total = intval( $total_bensin ) + intval( $total_solar );
		
		
		if(intval($total_ikan) < 0){
	
		
      $no++;
      $row = array();
      $row[] = ' <div class="btn-group"><a href="javascript:void(0);" class="btn btn-sm btn-warning btn-rounded" data-toggle="tooltip" data-original-title="Detail" onClick="detail_data(' . "'" . encrypt_url( $d->id_perahu ) . "'" . ')"> Detail </a></div>';
      $row[] = $no;
      $row[] = $periode;
      $row[] = $d->nama_perahu;
      $row[] = number_format( $total_ikan, 0, ',', '.' );
      $row[] = number_format( $total_pendapatan, 0, ',', '.' );
      $row[] = number_format( $bensin, 0, ',', '.' );
      $row[] = number_format( $total_bensin, 0, ',', '.' );
      $row[] = number_format( $solar, 0, ',', '.' );
      $row[] = number_format( $total_solar, 0, ',', '.' );
      $row[] = number_format( $total_bbm, 0, ',', '.' );
      $row[] = number_format( $total, 0, ',', '.' );

      $data[] = $row;
		}
		
    }
    $output = array(
      "draw" => $_POST[ 'draw' ],
      "recordsTotal" => $this->m_produksi_rekap->count_all(),
      "recordsFiltered" => $this->m_produksi_rekap->count_filtered(),
      "data" => $data,
		'tanggal'=>$start_date
    );
    echo json_encode( $output );
  }


  function ajax_list_tangkapan() {
    $list = $this->m_ikan->get_datatables();
    $id = decrypt_url( $this->input->post( 'id' ) );
    $start_date = $this->input->post( 'tanggal_awal' );
    $end_date = $this->input->post( 'tanggal_akhir' );
    $start = $this->libku->tgl_mysql( $start_date );
    $end = $this->libku->tgl_mysql( $end_date );
    $data = array();
    $no = $this->input->post( 'start' );
    foreach ( $list as $d ) {
      $t = $this->m_produksi_rekap->get_ikan( $d->id_ikan, $id, $start, $end );
      $no++;
      $row = array();
      $row[] = $no;
      $row[] = $d->ikan;
      $row[] = number_format( $t->total_ikan, 0, ',', '.' );
      $row[] = number_format( $t->total, 0, ',', '.' );
      $data[] = $row;
    }
    $output = array(
      "draw" => $_POST[ 'draw' ],
      "recordsTotal" => $this->m_ikan->count_all(),
      "recordsFiltered" => $this->m_ikan->count_filtered(),
      "data" => $data
    );
    echo json_encode( $output );
  }

  function ajax_list_timbangan() {
    $list = $this->m_produksi_timbang->get_datatables();
    $data = array();
    $no = $this->input->post( 'start' );
    foreach ( $list as $d ) {
      $foto = $d->foto_timbang ? : 'aset/img/belum_diupload.jpg';
      $no++;
      $row = array();
      $row[] = $no;
      $row[] = '<a href="javascript:void(0)" onclick="lihat_foto(' . "'" . base_url() . $foto . "'" . ')" ><img src="' . base_url() . $foto . '" class="img-fluid"></a>';
      $row[] = $d->tempat_lelang;
      $row[] = $d->ikan;
      $row[] = number_format( $d->berat, 0, ',', '.' );
      $row[] = number_format( $d->harga, 0, ',', '.' );
      $row[] = number_format( $d->total, 0, ',', '.' );
      $row[] = $d->nama_pembeli;
      $data[] = $row;
    }
    $output = array(
      "draw" => $_POST[ 'draw' ],
      "recordsTotal" => $this->m_produksi_timbang->count_all(),
      "recordsFiltered" => $this->m_produksi_timbang->count_filtered(),
      "data" => $data
    );
    echo json_encode( $output );
  }

}