<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Slide extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->load->model( array( 'm_slide' ) );
    $this->load->library( array( 'upload', 'form_validation', 'image_lib', 'libku', 'phpexcel', 'pdf' ) );
    if ( !$this->auth->cek() ) {
      $this->session->sess_destroy();
      redirect( base_url() );
      exit();
    }
  }

  function index() {
    $data[ 'title' ] = "SLIDE";
    $this->template->display( 'content/slide', $data );
  }



  function ajax_list() {
    if ( !$this->auth->cek() ) {
      $this->session->sess_destroy();
      redirect( base_url() );
      exit();
    } else {
      $list = $this->m_slide->get_datatables();
      $data = array();
      $no = $this->input->post( 'start' );
      foreach ( $list as $d ) {
        $foto = $d->slide;
        $no++;
        $row = array();
        $row[] = '<div class="btn-group">
  					<a href="javascript:;" class="btn btn-warning btn-sm" title="Edit" onClick="edit_data(' . "'" . encrypt_url( $d->id_slide ) . "'" . ')">Edit</a>
  					<a href="javascript:;" class="btn btn-danger btn-sm"  title="Delete" onClick="delete_data(' . "'" . encrypt_url( $d->id_slide ) . "'" . ')">Delete</a>
				</div>';
        $row[] = $no;
        $row[] = $d->no_urut;
        $row[] = '<img src="' . base_url() . $foto . '" class="img-fluid"/>';
        $data[] = $row;
      }
      $output = array(
        "draw" => $_POST[ 'draw' ],
        "recordsTotal" => $this->m_slide->count_all(),
        "recordsFiltered" => $this->m_slide->count_filtered(),
        "data" => $data,
        'pos' => $this->input->post( 'start' )
      );
      echo json_encode( $output );
    }
  }

  function edit() {
    $k = $this->m_slide->edit( decrypt_url( $this->input->post( 'q', TRUE ) ) );
    $data[ 'no_urut' ] = $k->no_urut;
    echo json_encode( $data );
  }


  function delete() {
    $id = decrypt_url( $this->input->post( "q" ) );
    if ( $id != "" || $id != NULL ) {
      $i = $this->m_slide->edit( $id );
      $l = $i->slide;
      if ( $l != NULL ) {
        unlink( $l );
      }
      $this->m_slide->delete_by_id( $id );
      echo json_encode( array( "status" => TRUE ) );
    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }

  function save() {
    $this->form_validation->set_rules( 'no_urut', 'no_urut', 'required' );
    if ( $this->form_validation->run() != false ) {
      date_default_timezone_set( 'Asia/Jakarta' );
      $code = date( "HdmiYs" );
      $upload_conf = array(
        'upload_path' => realpath( './upload/slide/' ),
        'allowed_types' => 'jpg|jpeg|png',
        'file_name' => $code
      );
      $this->upload->initialize( $upload_conf );
      if ( !$this->upload->do_upload( 'userfile' ) ) {
        $e = $this->upload->display_errors();
        echo json_encode( array( "status" => FALSE, "pesan" => "Mohon Upload Foto Jalan Terlebih Dahulu!" ) );
      } else {
        $no_urut = $this->input->post( 'no_urut', TRUE );
        $upload_data = $this->upload->data();
        $data = array(
          'no_urut' => $no_urut,
          'slide' => 'upload/slide/' . $upload_data[ 'file_name' ]
        );
        $id = $this->m_slide->save( $data );
        echo json_encode( array( "status" => TRUE ) );
      }
    } else {
      echo json_encode( array( "status" => FALSE, "pesan" => "Input tidak valid. Silahkan periksa kembali inputan anda!" ) );
    }
  }


  function update() {
    $this->form_validation->set_rules( 'no_urut', 'no_urut', 'required' );
    if ( $this->form_validation->run() != false ) {
      $id = decrypt_url( $this->input->get( "q" ) );
      $no_urut = $this->input->post( 'no_urut', TRUE );
     
      date_default_timezone_set( 'Asia/Jakarta' );
      $code = date( "HdmiYs" );
      $upload_conf = array(
        'upload_path' => realpath( './upload/slide/' ),
        'allowed_types' => 'jpg|jpeg|png',
        'file_name' => $code
      );
      $this->upload->initialize( $upload_conf );
      if ( !$this->upload->do_upload( 'userfile' ) ) {
        $upload_data = $this->upload->data();
        $data = array(
          'no_urut' => $no_urut,
        );
        $this->m_slide->update( array( 'id_slide' => $id ), $data );
        echo json_encode( array( "status" => TRUE ) );
      } else {
        $upload_data = $this->upload->data();
        $i = $this->m_slide->edit( $id );
        $l = $i->slide;
        if ( $l != NULL ) {
          unlink( $l );
        }
        $data = array(
          'no_urut' => $no_urut,
          'slide' => 'upload/slide/' . $upload_data[ 'file_name' ]
        );
        $this->m_slide->update( array( 'id_slide' => $id ), $data );
        echo json_encode( array( "status" => TRUE ) );
      }
    } else {
      echo json_encode( array( "status" => FALSE, "pesan" => "Input tidak valid. Silahkan periksa kembali inputan anda!" ) );
    }
  }


}