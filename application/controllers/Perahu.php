<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Perahu extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->load->model( array( 'm_perahu', 'm_kelompok' ) );
    $this->load->library( array( 'form_validation', 'libku' ) );
    if ( !$this->auth->cek() ) {
      $this->session->sess_destroy();
      redirect( base_url() );
      exit();
    }
  }

  function index() {
    $data[ 'title' ] = "Data Perahu";
    $data[ 'judul' ] = "Data Perahu";
    $data[ 'kelompok' ] = $this->m_kelompok->get_all();
    $this->template->display( 'content/perahu', $data );
  }

  function berkas() {
    $id = decrypt_url( $this->input->get( "q" ) );
    $data[ 'title' ] = "Berkas Perahu";
    $data[ 'judul' ] = "Berkas Perahu";
    $data[ 'isi' ] = $this->m_perahu->detail( $id );
    $this->template->display( 'content/berkas_perahu', $data );
  }

  function ajax_list() {
    $list = $this->m_perahu->get_datatables();
    $data = array();
    $no = $this->input->post( 'start' );
    foreach ( $list as $d ) {
      $no++;
      $row = array();
      $row[] = ' <div class="btn-group">
      <a href="javascript:;" class="btn btn-sm btn-warning btn-rounded" data-toggle="tooltip" data-original-title="Delete" onClick="edit_data(' . "'" . encrypt_url( $d->id_perahu ) . "'" . ')"> Edit </a> 
      <a href="javascript:;" class="btn btn-sm btn-danger btn-rounded" data-toggle="tooltip" data-original-title="Logo" onClick="delete_data(' . "'" . encrypt_url( $d->id_perahu ) . "'" . ')">Delete</a>
      <a href="' . base_url() . 'perahu/berkas?q=' . encrypt_url( $d->id_perahu ) . '" class="btn btn-sm btn-success btn-rounded" data-toggle="tooltip" data-original-title="lihat berkas" > Lihat Berkas </a>
      </div>';
      $row[] = $no;
      $row[] = $d->nama_perahu;
		  $row[] = $d->nama_kelompok;
      $row[] = number_format( $d->lebar_perahu, 0, ',', '.' );
      $row[] = number_format( $d->panjang_perahu, 0, ',', '.' );
      $data[] = $row;
    }
    $output = array(
      "draw" => $_POST[ 'draw' ],
      "recordsTotal" => $this->m_perahu->count_all(),
      "recordsFiltered" => $this->m_perahu->count_filtered(),
      "data" => $data
    );
    echo json_encode( $output );
  }

  function edit() {
    $k = $this->m_perahu->edit( decrypt_url( $this->input->post( 'q', TRUE ) ) );
    $data[ 'nama_perahu' ] = $k->nama_perahu;
	  $data['id_kelompok'] = encrypt_url($k->id_kelompok);
    $data[ 'lebar_perahu' ] = number_format( $k->lebar_perahu, 0, ',', '.' );
    $data[ 'panjang_perahu' ] = number_format( $k->panjang_perahu, 0, ',', '.' );
    echo json_encode( $data );
  }


  function delete() {
    $id = decrypt_url( $this->input->post( "q" ) );
    if ( $id != "" || $id != NULL ) {
      $i = $this->m_perahu->edit( $id );
      $l = $i->foto_depan_perahu;
      if ( $l != NULL ) {
        unlink( $l );
      }
      $this->m_perahu->delete_by_id( $id );
      echo json_encode( array( "status" => TRUE ) );
    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }

  function save() {
    $this->form_validation->set_rules( 'nama_perahu', 'nama_perahu', 'required' );
    $this->form_validation->set_rules( 'id_kelompok', 'id_kelompok', 'required' );
    $this->form_validation->set_rules( 'lebar_perahu', 'lebar_perahu', 'required' );
    $this->form_validation->set_rules( 'panjang_perahu', 'panjang_perahu', 'required' );

    if ( $this->form_validation->run() != false ) {
      $nama_perahu = $this->input->post( 'nama_perahu', TRUE );
		  $id_kelompok = $this->input->post( 'id_kelompok', TRUE );
      $lebar_perahu = $this->libku->ribuansql( $this->input->post( 'lebar_perahu', TRUE ) );
      $panjang_perahu = $this->libku->ribuansql( $this->input->post( 'panjang_perahu', TRUE ) );

      date_default_timezone_set( 'Asia/Jakarta' );
      $code = date( "HdmiYs" );

      $upload_conf = array(
        'upload_path' => realpath( './upload/foto_perahu/' ),
        'allowed_types' => 'jpg|jpeg|png',
        'file_name' => $code
      );

      $this->upload->initialize( $upload_conf );
      if ( !$this->upload->do_upload( 'userfile' ) ) {
		  
		   $data = array(
          'nama_perahu' => $nama_perahu,
          'id_kelompok' => decrypt_url( $id_kelompok ),
          'lebar_perahu' => $lebar_perahu,
          'panjang_perahu' => $panjang_perahu
        );
        $this->m_perahu->save( $data );
        echo json_encode( array( "status" => TRUE ) );
      } else {
        $upload_data = $this->upload->data();
		  
		   $data = array(
          'nama_perahu' => $nama_perahu,
          'id_kelompok' => decrypt_url( $id_kelompok ),
          'lebar_perahu' => $lebar_perahu,
          'panjang_perahu' => $panjang_perahu,
          'foto_depan_perahu' => 'upload/foto_perahu/' . $upload_data[ 'file_name' ]
        );

        $this->m_perahu->save( $data );
        echo json_encode( array( "status" => TRUE ) );
      }
    } else {
      echo json_encode( array( "status" => FALSE, "pesan" => "Input tidak valid. Silahkan periksa kembali inputan anda!" ) );
    }
  }

  function update() {
    $id = decrypt_url( $this->input->get( "q" ) );
    
    $this->form_validation->set_rules( 'nama_perahu', 'nama_perahu', 'required' );
    $this->form_validation->set_rules( 'id_kelompok', 'id_kelompok', 'required' );
    $this->form_validation->set_rules( 'lebar_perahu', 'lebar_perahu', 'required' );
    $this->form_validation->set_rules( 'panjang_perahu', 'panjang_perahu', 'required' );
    
    if ( $this->form_validation->run() != false ) {
      $nama_perahu = $this->input->post( 'nama_perahu', TRUE );
      $id_kelompok = $this->input->post( 'id_kelompok', TRUE );
      $lebar_perahu = $this->libku->ribuansql( $this->input->post( 'lebar_perahu', TRUE ) );
      $panjang_perahu = $this->libku->ribuansql( $this->input->post( 'panjang_perahu', TRUE ) );

      date_default_timezone_set( 'Asia/Jakarta' );
      $code = date( "HdmiYs" );
      $upload_conf = array(
        'upload_path' => realpath( './upload/foto_perahu/' ),
        'allowed_types' => 'jpg|jpeg|png',
        'file_name' => $code
      );

      $this->upload->initialize( $upload_conf );
      if ( !$this->upload->do_upload( 'userfile' ) ) {
        $data = array(
          'nama_perahu' => $nama_perahu,
			    'id_kelompok' => decrypt_url( $id_kelompok ),
          'lebar_perahu' => $lebar_perahu,
          'panjang_perahu' => $panjang_perahu
        );
        $this->m_perahu->update( array( 'id_perahu' => $id ), $data );
        echo json_encode( array( "status" => TRUE ) );
      } else {
        $upload_data = $this->upload->data();
        $data = array(
          'nama_perahu' => $nama_perahu,
			    'id_kelompok' => decrypt_url( $id_kelompok ),
          'lebar_perahu' => $lebar_perahu,
          'panjang_perahu' => $panjang_perahu,
          'foto_depan_perahu' => 'upload/foto_perahu/' . $upload_data[ 'file_name' ]
        );
        $this->m_perahu->update( array( 'id_perahu' => $id ), $data );
        echo json_encode( array( "status" => TRUE ) );
      }
    } else {
      echo json_encode( array( "status" => FALSE, "pesan" => "Input tidak valid. Silahkan periksa kembali inputan anda!" ) );
    }
  }
	
  function get_berkas() {
    $id = decrypt_url( $this->input->post( "q" ) );
    $isi = $this->m_perahu->edit( $id );
    $foto_samping_perahu = $isi->foto_samping_perahu ? : 'aset/img/no_berkas.jpg';
    $foto_sim = $isi->foto_sim ? : 'aset/img/no_berkas.jpg';
    $data[ 'foto_samping_perahu' ] = base_url() . $foto_samping_perahu;
    $data[ 'foto_sim' ] = base_url() . $foto_sim;
    echo json_encode( $data );
  }

  function upload_foto_samping_perahu() {
    $id_perahu = decrypt_url( $this->input->post( 'id_perahu' ) );
    date_default_timezone_set( 'Asia/Jakarta' );
    $code = date( "HdmiYs" );
    $upload_conf = array(
      'upload_path' => realpath( './upload/foto_perahu/' ),
      'allowed_types' => 'jpg|jpeg|png',
      'file_name' => $code
    );
    $this->upload->initialize( $upload_conf );
    if ( !$this->upload->do_upload( 'foto_samping_perahu' ) ) {
      echo json_encode( array( "status" => FALSE, 'pesan' => "Pilih Foto Samping Perahu Terlebih Dahulu!" ) );
    } else {
      $upload_data = $this->upload->data();
      $data = array(
        'foto_samping_perahu' => 'upload/foto_perahu/' . $upload_data[ 'file_name' ]
      );
      $this->m_perahu->update( array( 'id_perahu' => $id_perahu ), $data );
      echo json_encode( array( "status" => TRUE ) );
    }

  }

  function upload_foto_sim() {
    $id_perahu = decrypt_url( $this->input->post( 'id_perahu' ) );
    date_default_timezone_set( 'Asia/Jakarta' );
    $code = date( "HdmiYs" );
    $upload_conf = array(
      'upload_path' => realpath( './upload/foto_perahu/' ),
      'allowed_types' => 'jpg|jpeg|png',
      'file_name' => $code
    );
    $this->upload->initialize( $upload_conf );
    if ( !$this->upload->do_upload( 'foto_sim' ) ) {
      echo json_encode( array( "status" => FALSE, 'pesan' => "Pilih Foto Pas Kecil/Besar Terlebih Dahulu!" ) );
    } else {
      $upload_data = $this->upload->data();
      $data = array(
        'foto_sim' => 'upload/foto_perahu/' . $upload_data[ 'file_name' ]
      );
      $this->m_perahu->update( array( 'id_perahu' => $id_perahu ), $data );
      echo json_encode( array( "status" => TRUE ) );
    }

  }

}