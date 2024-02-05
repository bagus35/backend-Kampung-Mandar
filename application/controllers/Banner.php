<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Banner extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->load->model( array( 'm_banner' ) );
    $this->load->library( array( 'form_validation', 'libku' ) );
    if ( !$this->auth->cek() ) {
      $this->session->sess_destroy();
      redirect( base_url() );
      exit();
    }
  }

  function index() {
    $data[ 'title' ] = "Banner";
    $data[ 'judul' ] = "Banner";
    $this->template->display( 'content/banner', $data );
  }


  function ajax_list() {
    $list = $this->m_banner->get_datatables();
    $data = array();
    $no = $this->input->post( 'start' );
    foreach ( $list as $d ) {
      $status = $d->status;
      $switch = '<input id="' .encrypt_url( $d->id_banner ) . '"  class="uji"  data-off="Off" data-on="On" type="checkbox" onChange="update_status(' . "'" .encrypt_url( $d->id_banner ) . "'" . ')" checked>';
      if ( $d->status == 0 ) {
        $switch = '<input id="' .encrypt_url( $d->id_banner ) . '" class="uji" data-off="Off" data-on="On" type="checkbox" onChange="update_status(' . "'" .encrypt_url( $d->id_banner ) . "'" . ')">';
      }
      $no++;
      $row = array();
      $row[] = ' <div class="btn-group"><a href="javascript:;" class="btn btn-sm btn-warning btn-rounded" data-toggle="tooltip" data-original-title="Delete" onClick="edit_data(' . "'" . encrypt_url( $d->id_banner ) . "'" . ')"> Edit </a> <a href="javascript:;" class="btn btn-sm btn-danger btn-rounded" data-toggle="tooltip" data-original-title="Logo" onClick="delete_data(' . "'" . encrypt_url( $d->id_banner ) . "'" . ')">Delete</a>
	  </div>';
      $row[] = $no;
      $row[] = $switch;
      $row[] = $d->judul;
      $row[] = '<a href="javascript:void(0)" onclick="lihat_foto(' . "'" . base_url() . $d->banner . "'" . ')" ><div style="background: url(' . base_url() . $d->banner . ') no-repeat center center; background-size:100px 100px;height:100px;width:100px; "> </div></a>';
		$row[] =$d->status;
      $data[] = $row;
    }
    $output = array(
      "draw" => $_POST[ 'draw' ],
      "recordsTotal" => $this->m_banner->count_all(),
      "recordsFiltered" => $this->m_banner->count_filtered(),
      "data" => $data
    );
    echo json_encode( $output );
  }

  function edit() {
    $k = $this->m_banner->edit( decrypt_url( $this->input->post( 'q', TRUE ) ) );
    $data[ 'judul' ] = $k->judul;
    echo json_encode( $data );
  }

  function delete() {
    $id = decrypt_url( $this->input->post( "q" ) );
    if ( $id != "" || $id != NULL ) {
      $i = $this->m_banner->edit( $id );
      $l = $i->banner;
      if ( $l != NULL ) {
        unlink( $l );
      }
      $this->m_banner->delete_by_id( $id );
      echo json_encode( array( "status" => TRUE ) );
    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }

  function save() {
    $this->form_validation->set_rules( 'judul', 'judul', 'required' );
    if ( $this->form_validation->run() != false ) {
      $judul = $this->input->post( 'judul', TRUE );
      date_default_timezone_set( 'Asia/Jakarta' );
      $code = date( "HdmiYs" );
      $upload_conf = array(
        'upload_path' => realpath( './upload/banner/' ),
        'allowed_types' => 'jpg|jpeg|png',
        'file_name' => $code
      );
      $this->upload->initialize( $upload_conf );
      if ( !$this->upload->do_upload( 'userfile' ) ) {

        echo json_encode( array( "status" => FALSE, 'pesan' => 'Banner tidak boleh kosong' ) );
      } else {
        $upload_data = $this->upload->data();
        $data = array(
          'judul' => $judul,
          'banner' => 'upload/banner/' . $upload_data[ 'file_name' ]
        );
        $this->m_banner->save( $data );
        echo json_encode( array( "status" => TRUE ) );
      }
    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }

  function update() {
    $id = decrypt_url( $this->input->get( "q" ) );
    $this->form_validation->set_rules( 'judul', 'judul', 'required' );
    if ( $this->form_validation->run() != false ) {
      $judul = $this->input->post( 'judul', TRUE );
      date_default_timezone_set( 'Asia/Jakarta' );
      $code = date( "HdmiYs" );
      $upload_conf = array(
        'upload_path' => realpath( './upload/banner/' ),
        'allowed_types' => 'jpg|jpeg|png',
        'file_name' => $code
      );
      $this->upload->initialize( $upload_conf );
      if ( !$this->upload->do_upload( 'userfile' ) ) {
        $data = array(
          'judul' => $judul
        );
        $this->m_banner->update( array( 'id_banner' => $id ), $data );
        echo json_encode( array( "status" => TRUE ) );
      } else {
        $upload_data = $this->upload->data();
        $data = array(
          'judul' => $judul,
          'banner' => 'upload/banner/' . $upload_data[ 'file_name' ]
        );
        $this->m_banner->update( array( 'id_banner' => $id ), $data );
        echo json_encode( array( "status" => TRUE ) );
      }
    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }


  function update_status() {
    $id = decrypt_url( $this->input->post( "key" ) );
    $this->form_validation->set_rules( 'st', 'st', 'required' );
    if ( $this->form_validation->run() != false ) {
      $status = $this->input->post( 'st', TRUE );
      $data = array(
        'status' => $status,
      );
      $this->m_banner->update( array( 'id_banner' => $id ), $data );
      echo json_encode( array( "status" => TRUE, "pesan" => "Status Berhasil Diperbaharui" ) );

    } else {
      echo json_encode( array( "status" => FALSE, 'pesan' => 'Pastikan Pilihan anda dengan benar!' ) );
    }
  }

}