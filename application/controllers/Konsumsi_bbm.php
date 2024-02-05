<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Konsumsi_bbm extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->load->model( array( 'm_bbm', 'm_perahu' ) );
    $this->load->library( array( 'upload', 'form_validation', 'image_lib', 'libku' ) );
    if ( !$this->auth->cek() ) {
      $this->session->sess_destroy();
      redirect( base_url() );
      exit();
    }
  }

  function index() {
    $data[ 'title' ] = "Konsumsi BBM";
    $data[ 'judul' ] = "Konsumsi BBM";
    $data[ 'perahu' ] = $this->m_perahu->get_all();
    $this->template->display( 'content/bbm', $data );
  }


  function ajax_list() {
    $list = $this->m_bbm->get_datatables();
    $data = array();
    $no = $this->input->post( 'start' );
    foreach ( $list as $d ) {
      $foto = $d->nota ? : 'aset/img/belum_diupload.jpg';
      $no++;
      $row = array();
      $row[] = ' <div class="btn-group"><a href="javascript:;" class="btn btn-sm btn-warning btn-rounded" data-toggle="tooltip" data-original-title="Delete" onClick="edit_data(' . "'" . encrypt_url( $d->id_bbm ) . "'" . ')"> Edit </a> <a href="javascript:;" class="btn btn-sm btn-danger btn-rounded" data-toggle="tooltip" data-original-title="Logo" onClick="delete_data(' . "'" . encrypt_url( $d->id_bbm ) . "'" . ')">Delete</a></div>';
      $row[] = $no;
      $row[] = '<a href="javascript:void(0)" onclick="lihat_foto
      (' . "'" . base_url() . $foto . "'" . ')" >
      <img src="' . base_url() . $foto . '" class="img-fluid">
      </a>';
      $row[] = date( 'd/m/Y', strtotime( $d->tanggal ) );
      $row[] = $d->nama_perahu;
      $row[] = $d->jenis == 1 ? 'Bensin' : 'Solar';
      $row[] = number_format( $d->harga_per_liter, 0, ',', '.' );
      $row[] = number_format( $d->jumlah, 0, ',', '.' );
      $row[] = number_format( $d->total_bbm, 0, ',', '.' );
      $data[] = $row;
    }
    $output = array(
      "draw" => $_POST[ 'draw' ],
      "recordsTotal" => $this->m_bbm->count_all(),
      "recordsFiltered" => $this->m_bbm->count_filtered(),
      "data" => $data
    );
    echo json_encode( $output );
  }

  function edit() {
    $k = $this->m_bbm->edit( decrypt_url( $this->input->post( 'q', TRUE ) ) );
    $data[ 'tanggal' ] = date( 'd/m/Y', strtotime( $k->tanggal ) );
    $data[ 'id_perahu' ] = encrypt_url( $k->id_perahu );
    $data[ 'jumlah' ] = number_format( $k->jumlah, 0, ',', '.' );
    $data[ 'harga_per_liter' ] = number_format( $k->harga_per_liter, 0, ',', '.' );
    $data[ 'jenis' ] = $k->jenis;
    echo json_encode( $data );
  }


  function delete() {
    $id = decrypt_url( $this->input->post( "q" ) );
    if ( $id != "" || $id != NULL ) {
      $i = $this->m_bbm->edit( $id );
      $l = $i->nota;
      if ( $l != NULL ) {
        unlink( $l );
      }
      $this->m_bbm->delete_by_id( $id );
      echo json_encode( array( "status" => TRUE ) );
    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }

  function save() {
    $this->form_validation->set_rules( 'tanggal', 'tanggal', 'required' );
    $this->form_validation->set_rules( 'id_perahu', 'id_perahu', 'required' );
    $this->form_validation->set_rules( 'jenis', 'jenis', 'required' );
    $this->form_validation->set_rules( 'jumlah', 'jumlah', 'required' );
    $this->form_validation->set_rules( 'harga_per_liter', 'harga_per_liter', 'required' );
    if ( $this->form_validation->run() != false ) {
      $tanggal = $this->libku->tgl_mysql( $this->input->post( 'tanggal', TRUE ) );
      $id_perahu = decrypt_url( $this->input->post( 'id_perahu', TRUE ) );
      $jenis = $this->input->post( 'jenis', TRUE );
      $jumlah = $this->libku->ribuansql( $this->input->post( 'jumlah', TRUE ) );
      $harga_per_liter = $this->libku->ribuansql( $this->input->post( 'harga_per_liter', TRUE ) );
      $total_bbm = intval( $jumlah ) * intval( $harga_per_liter );

      date_default_timezone_set( 'Asia/Jakarta' );
      $code = date( "HdmiYs" );
      $upload_conf = array(
        'upload_path' => realpath( './upload/nota/' ),
        'allowed_types' => 'jpg|jpeg|png',
        'file_name' => $code
      );
      $this->upload->initialize( $upload_conf );
      if ( !$this->upload->do_upload( 'userfile' ) ) {
        $data = array(
          'tanggal' => $tanggal,
          'id_perahu' => $id_perahu,
          'jenis' => $jenis,
          'jumlah' => $jumlah,
          'harga_per_liter' => $harga_per_liter,
          'total_bbm' => $total_bbm,
        );
        $this->m_bbm->save( $data );
        echo json_encode( array( "status" => TRUE ) );
      } else {
        $upload_data = $this->upload->data();
        $data = array(
          'tanggal' => $tanggal,
          'id_perahu' => $id_perahu,
          'jenis' => $jenis,
          'jumlah' => $jumlah,
          'harga_per_liter' => $harga_per_liter,
          'total_bbm' => $total_bbm,
          'nota' => 'upload/nota/' . $upload_data[ 'file_name' ]
        );
        $this->m_bbm->save( $data );
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
    $this->form_validation->set_rules( 'jenis', 'jenis', 'required' );
    $this->form_validation->set_rules( 'jumlah', 'jumlah', 'required' );
    $this->form_validation->set_rules( 'harga_per_liter', 'harga_per_liter', 'required' );
    if ( $this->form_validation->run() != false ) {
      $tanggal = $this->libku->tgl_mysql( $this->input->post( 'tanggal', TRUE ) );
      $id_perahu = decrypt_url( $this->input->post( 'id_perahu', TRUE ) );
      $jenis = $this->input->post( 'jenis', TRUE );
      $jumlah = $this->libku->ribuansql( $this->input->post( 'jumlah', TRUE ) );
      $harga_per_liter = $this->libku->ribuansql( $this->input->post( 'harga_per_liter', TRUE ) );
      $total_bbm = intval( $jumlah ) * intval( $harga_per_liter );

      date_default_timezone_set( 'Asia/Jakarta' );
      $code = date( "HdmiYs" );
      $upload_conf = array(
        'upload_path' => realpath( './upload/nota/' ),
        'allowed_types' => 'jpg|jpeg|png',
        'file_name' => $code
      );
      $this->upload->initialize( $upload_conf );
      if ( !$this->upload->do_upload( 'userfile' ) ) {
        $data = array(
          'tanggal' => $tanggal,
          'id_perahu' => $id_perahu,
          'jenis' => $jenis,
          'jumlah' => $jumlah,
          'harga_per_liter' => $harga_per_liter,
          'total_bbm' => $total_bbm,
        );
        $this->m_bbm->update( array( 'id_bbm' => $id ), $data );
        echo json_encode( array( "status" => TRUE ) );
      } else {
        $upload_data = $this->upload->data();
        $data = array(
          'tanggal' => $tanggal,
          'id_perahu' => $id_perahu,
          'jenis' => $jenis,
          'jumlah' => $jumlah,
          'harga_per_liter' => $harga_per_liter,
          'total_bbm' => $total_bbm,
          'nota' => 'upload/nota/' . $upload_data[ 'file_name' ]
        );
        $this->m_bbm->update( array( 'id_bbm' => $id ), $data );
        echo json_encode( array( "status" => TRUE ) );
      }
    } else {
      echo json_encode( array( "status" => FALSE, "pesan" => "Input tidak valid. Silahkan periksa kembali inputan anda!" ) );
    }
  }

}