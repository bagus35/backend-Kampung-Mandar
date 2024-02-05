<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Pengepul extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->load->model( array( 'm_pembeli' ) );
    $this->load->library( array( 'form_validation', 'libku' ) );
    if ( !$this->auth->cek() ) {
      $this->session->sess_destroy();
      redirect( base_url() );
      exit();
    }
  }

  function index() {
    $data[ 'title' ] = "Data Pengepul";
    $data[ 'judul' ] = "Data Pengepul";
    $this->template->display( 'content/pengepul', $data );
  }

  function ajax_list() {
    $list = $this->m_pembeli->get_datatables();
    $data = array();
    $no = $this->input->post( 'start' );
    foreach ( $list as $d ) {
      $no++;
      $row = array();
      $row[] = ' <div class="btn-group"><a href="javascript:;" class="btn btn-sm btn-warning btn-rounded" data-toggle="tooltip" data-original-title="Delete" onClick="edit_data(' . "'" . encrypt_url( $d->id_pembeli ) . "'" . ')"> Edit </a> <a href="javascript:;" class="btn btn-sm btn-danger btn-rounded" data-toggle="tooltip" data-original-title="Logo" onClick="delete_data(' . "'" . encrypt_url( $d->id_pembeli ) . "'" . ')">Delete</a></div>';
      $row[] = $no;
      $row[] = $d->nama_pembeli;
      $row[] = $d->alamat;
      $row[] = $d->no_hp;
      $data[] = $row;
    }
    $output = array(
      "draw" => $_POST[ 'draw' ],
      "recordsTotal" => $this->m_pembeli->count_all(),
      "recordsFiltered" => $this->m_pembeli->count_filtered(),
      "data" => $data
    );
    echo json_encode( $output );
  }

  function edit() {
    $k = $this->m_pembeli->edit( decrypt_url( $this->input->post( 'q', TRUE ) ) );
    $data[ 'nama_pembeli' ] = $k->nama_pembeli;
    $data[ 'alamat' ] = $k->alamat;
    echo json_encode( $data );
  }

  function delete() {
    $id = decrypt_url( $this->input->post( "q" ) );
    if ( $id != "" || $id != NULL ) {
      $this->m_pembeli->delete_by_id( $id );
      echo json_encode( array( "status" => TRUE ) );
    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }

  function save() {
    $this->form_validation->set_rules( 'nama_pembeli', 'nama_pembeli', 'required' );
    $this->form_validation->set_rules( 'alamat', 'alamat', 'required' );
    $this->form_validation->set_rules( 'no_hp', 'no_hp', 'required' );
    if ( $this->form_validation->run() != false ) {
      $data = array(
        'nama_pembeli' => $this->input->post( 'nama_pembeli', TRUE ),
        'alamat' => $this->input->post( 'alamat', TRUE ),
        'no_hp' => $this->input->post( 'no_hp', TRUE )
      );
      $id = $this->m_pembeli->save( $data );
      echo json_encode( array( "status" => TRUE ) );
    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }

  function update() {
    $id = decrypt_url( $this->input->get( "q" ) );
    $this->form_validation->set_rules( 'nama_pembeli', 'nama_pembeli', 'required' );
    $this->form_validation->set_rules( 'alamat', 'alamat', 'required' );
    $this->form_validation->set_rules( 'no_hp', 'no_hp', 'required' );
    if ( $this->form_validation->run() != false ) {
      $data = array(
        'nama_pembeli' => $this->input->post( 'nama_pembeli', TRUE ),
        'alamat' => $this->input->post( 'alamat', TRUE ),
        'no_hp' => $this->input->post( 'no_hp', TRUE )
      );
      $this->m_pembeli->update( array( 'id_pembeli' => $id ), $data );
      echo json_encode( array( "status" => TRUE ) );
    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }
}