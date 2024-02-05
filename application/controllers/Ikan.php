<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Ikan extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->load->model( array( 'm_ikan' ) );
    $this->load->library( array( 'form_validation', 'libku' ) );
    if ( !$this->auth->cek() ) {
      $this->session->sess_destroy();
      redirect( base_url() );
      exit();
    }
  }

  function index() {
    $data[ 'title' ] = "Nama Ikan";
    $data[ 'judul' ] = "Nama Ikan";
    $this->template->display( 'content/ikan', $data );
  }

  function ajax_list() {
    $list = $this->m_ikan->get_datatables();
    $data = array();
    $no = $this->input->post( 'start' );
    foreach ( $list as $d ) {
      $no++;
      $row = array();
      $row[] = ' <div class="btn-group"><a href="javascript:;" class="btn btn-sm btn-warning btn-rounded" data-toggle="tooltip" data-original-title="Delete" onClick="edit_data(' . "'" . encrypt_url( $d->id_ikan ) . "'" . ')"> Edit </a> <a href="javascript:;" class="btn btn-sm btn-danger btn-rounded" data-toggle="tooltip" data-original-title="Logo" onClick="delete_data(' . "'" . encrypt_url( $d->id_ikan ) . "'" . ')">Delete</a></div>';
      $row[] = $no;
      $row[] = $d->ikan;
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

  function edit() {
    $k = $this->m_ikan->edit( decrypt_url( $this->input->post( 'q', TRUE ) ) );
    $data[ 'ikan' ] = $k->ikan;
    echo json_encode( $data );
  }

  function delete() {
    $id = decrypt_url( $this->input->post( "q" ) );
    if ( $id != "" || $id != NULL ) {
      $this->m_ikan->delete_by_id( $id );
      echo json_encode( array( "status" => TRUE ) );
    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }

  function save() {
    $this->form_validation->set_rules( 'ikan', 'nama_ikan', 'required' );
    if ( $this->form_validation->run() != false ) {
      $data = array(
        'ikan' => $this->input->post( 'ikan', TRUE )
      );
      $id = $this->m_ikan->save( $data );
      echo json_encode( array( "status" => TRUE ) );
    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }

  function update() {
    $id = decrypt_url( $this->input->get( "q" ) );
    $this->form_validation->set_rules( 'ikan', 'ikan', 'required' );
    if ( $this->form_validation->run() != false ) {
      $data = array(
        'ikan' => $this->input->post( 'ikan', TRUE )
      );
      $this->m_ikan->update( array( 'id_ikan' => $id ), $data );
      echo json_encode( array( "status" => TRUE ) );
    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }
}