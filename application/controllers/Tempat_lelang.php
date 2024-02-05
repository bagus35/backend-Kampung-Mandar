<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Tempat_lelang extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->load->model( array( 'm_tempat_lelang' ) );
    $this->load->library( array( 'form_validation', 'libku' ) );
    if ( !$this->auth->cek() ) {
      $this->session->sess_destroy();
      redirect( base_url() );
      exit();
    }
  }

  function index() {
    $data[ 'title' ] = "Tempat Lelang";
    $data[ 'judul' ] = "Tempat Lelang";
    $this->template->display( 'content/tempat_lelang', $data );
  }

  function ajax_list() {
    $list = $this->m_tempat_lelang->get_datatables();
    $data = array();
    $no = $this->input->post( 'start' );
    foreach ( $list as $d ) {
      $no++;
      $row = array();
      $row[] = ' <div class="btn-group"><a href="javascript:;" class="btn btn-sm btn-warning btn-rounded" data-toggle="tooltip" data-original-title="Delete" onClick="edit_data(' . "'" . encrypt_url( $d->id_tempat_lelang ) . "'" . ')"> Edit </a> <a href="javascript:;" class="btn btn-sm btn-danger btn-rounded" data-toggle="tooltip" data-original-title="Logo" onClick="delete_data(' . "'" . encrypt_url( $d->id_tempat_lelang ) . "'" . ')">Delete</a></div>';
      $row[] = $no;
      $row[] = $d->tempat_lelang;
      $data[] = $row;
    }
    $output = array(
      "draw" => $_POST[ 'draw' ],
      "recordsTotal" => $this->m_tempat_lelang->count_all(),
      "recordsFiltered" => $this->m_tempat_lelang->count_filtered(),
      "data" => $data
    );
    echo json_encode( $output );
  }

  function edit() {
    $k = $this->m_tempat_lelang->edit( decrypt_url( $this->input->post( 'q', TRUE ) ) );
    $data[ 'tempat_lelang' ] = $k->tempat_lelang;
    echo json_encode( $data );
  }

  function delete() {
    $id = decrypt_url( $this->input->post( "q" ) );
    if ( $id != "" || $id != NULL ) {
      $this->m_tempat_lelang->delete_by_id( $id );
      echo json_encode( array( "status" => TRUE ) );
    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }

  function save() {
    $this->form_validation->set_rules( 'tempat_lelang', 'nama_tempat_lelang', 'required' );
    if ( $this->form_validation->run() != false ) {
      $data = array(
        'tempat_lelang' => $this->input->post( 'tempat_lelang', TRUE )
      );
      $id = $this->m_tempat_lelang->save( $data );
      echo json_encode( array( "status" => TRUE ) );
    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }

  function update() {
    $id = decrypt_url( $this->input->get( "q" ) );
    $this->form_validation->set_rules( 'tempat_lelang', 'tempat_lelang', 'required' );
    if ( $this->form_validation->run() != false ) {
      $data = array(
        'tempat_lelang' => $this->input->post( 'tempat_lelang', TRUE )
      );
      $this->m_tempat_lelang->update( array( 'id_tempat_lelang' => $id ), $data );
      echo json_encode( array( "status" => TRUE ) );
    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }
}