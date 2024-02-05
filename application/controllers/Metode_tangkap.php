<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Metode_tangkap extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->load->model( array( 'm_metode_tangkap' ) );
    $this->load->library( array( 'form_validation', 'libku' ) );
    if ( !$this->auth->cek() ) {
      $this->session->sess_destroy();
      redirect( base_url() );
      exit();
    }
  }

  function index() {
    $data[ 'title' ] = "Metode Tangkap";
    $data[ 'judul' ] = "Metode Tangkap";
    $this->template->display( 'content/metode_tangkap', $data );
  }

  function ajax_list() {
    $list = $this->m_metode_tangkap->get_datatables();
    $data = array();
    $no = $this->input->post( 'start' );
    foreach ( $list as $d ) {
      $no++;
      $row = array();
      $row[] = '<div class="btn-group"> <a href="javascript:;" class="btn btn-sm btn-warning btn-rounded" data-toggle="tooltip" data-original-title="Delete" onClick="edit_data(' . "'" . encrypt_url( $d->id_metode_tangkap ) . "'" . ')"> Edit </a> <a href="javascript:;" class="btn btn-sm btn-danger btn-rounded" data-toggle="tooltip" data-original-title="Logo" onClick="delete_data(' . "'" . encrypt_url( $d->id_metode_tangkap ) . "'" . ')">Delete</a></div>';
      $row[] = $no;
      $row[] = $d->metode_tangkap;
      $data[] = $row;
    }
    $output = array(
      "draw" => $_POST[ 'draw' ],
      "recordsTotal" => $this->m_metode_tangkap->count_all(),
      "recordsFiltered" => $this->m_metode_tangkap->count_filtered(),
      "data" => $data
    );
    echo json_encode( $output );
  }

  function edit() {
    $k = $this->m_metode_tangkap->edit( decrypt_url( $this->input->post( 'q', TRUE ) ) );
    $data[ 'metode_tangkap' ] = $k->metode_tangkap;
    echo json_encode( $data );
  }

  function delete() {
    $id = decrypt_url( $this->input->post( "q" ) );
    if ( $id != "" || $id != NULL ) {
      $this->m_metode_tangkap->delete_by_id( $id );
      echo json_encode( array( "status" => TRUE ) );
    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }

  function save() {
    $this->form_validation->set_rules( 'metode_tangkap', 'metode_tangkap', 'required' );
    if ( $this->form_validation->run() != false ) {
      $id_kecamatan = $this->input->post( 'id_kecamatan', TRUE );
      $data = array(
        'metode_tangkap' => $this->input->post( 'metode_tangkap', TRUE ),
      );
      $id = $this->m_metode_tangkap->save( $data );
      echo json_encode( array( "status" => TRUE, 'k' => $id_kecamatan ) );
    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }

  function update() {
    $id = decrypt_url( $this->input->get( "q" ) );
    $this->form_validation->set_rules( 'metode_tangkap', 'metode_tangkap', 'required' );
    if ( $this->form_validation->run() != false ) {
      $id_kecamatan = $this->input->post( 'id_kecamatan', TRUE );
      $data = array(
        'metode_tangkap' => $this->input->post( 'metode_tangkap', TRUE ),
      );
      $this->m_metode_tangkap->update( array( 'id_metode_tangkap' => $id ), $data );
      echo json_encode( array( "status" => TRUE ) );
    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }
}