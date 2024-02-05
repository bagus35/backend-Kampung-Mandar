<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Coba extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->load->model( array( 'm_coba', 'm_kelompok' ) );
    $this->load->library( array( 'form_validation', 'libku' ) );
    if ( !$this->auth->cek() ) {
      $this->session->sess_destroy();
      redirect( base_url() );
      exit();
    }
  }
// ini vina
  function index() {
    $data[ 'title' ] = "Data Perahu";
    $data[ 'judul' ] = "Data Perahu";
    $data[ 'kelompok' ] = $this->m_kelompok->get_all();
    $this->template->display( 'content/coba', $data );
  }

  function berkas() {
    $id = decrypt_url( $this->input->get( "q" ) );
    $data[ 'title' ] = "Data Perahu";
    $data[ 'judul' ] = "Data Perahu";
    $data[ 'isi' ] = $this->m_coba->detail( $id );
    $this->template->display( 'content/berkas_coba', $data );
  }

  function ajax_list() {
    $list = $this->m_coba->get_datatables();
    $data = array();
    $no = $this->input->post( 'start' );
    foreach ( $list as $d ) {
      $no++;
      $row = array();
      $row[] = ' <div class="btn-group">
      <a href="javascript:;" class="btn btn-sm btn-warning btn-rounded" data-toggle="tooltip" data-original-title="Delete" onClick="edit_data(' . "'" . encrypt_url( $d->id_coba ) . "'" . ')"> Edit </a> 
      <a href="javascript:;" class="btn btn-sm btn-danger btn-rounded" data-toggle="tooltip" data-original-title="Logo" onClick="delete_data(' . "'" . encrypt_url( $d->id_coba ) . "'" . ')">Delete</a>
      <a href="' . base_url() . 'coba/berkas?q=' . encrypt_url( $d->id_coba ) . '" class="btn btn-sm btn-success btn-rounded" data-toggle="tooltip" data-original-title="lihat berkas" > Lihat Berkas </a>
	    </div>';
      $row[] = $no;
      
      $row[] = $d->nama_coba;
      $row[] = $d->nama_kelompok;
      $row[] = number_format( $d->lebar_perahu_coba, 0, ',', '.' );
      $row[] = number_format( $d->panjang_perahu_coba, 0, ',', '.' );
      $data[] = $row;
    }
    $output = array(
      "draw" => $_POST[ 'draw' ],
      "recordsTotal" => $this->m_coba->count_all(),
      "recordsFiltered" => $this->m_coba->count_filtered(),
      "data" => $data
    );
    echo json_encode( $output );
  }

  function edit() {
    $k = $this->m_coba->edit( decrypt_url( $this->input->post( 'q', TRUE ) ) );
    $data[ 'nama_coba' ] = $k->nama_coba;
    $data[ 'id_kelompok' ] = encrypt_url( $k->id_kelompok );
    $data[ 'lebar_perahu_coba' ] = number_format( $k->lebar_perahu_coba, 0, ',', '.' );
    $data[ 'panjang_perahu_coba' ] = number_format( $k->panjang_perahu_coba, 0, ',', '.' );
    echo json_encode( $data );
  }

  function delete() {
    $id = decrypt_url( $this->input->post( "q" ) );
    if ( $id != "" || $id != NULL ) {
      $i = $this->m_coba->edit( $id );
      $l = $i->foto_depan_coba;
      if ( $l != NULL ) {
        unlink( $l );
      }
      $this->m_coba->delete_by_id( $id );
      echo json_encode( array( "status" => TRUE ) );
    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }

  function save() {
    $this->form_validation->set_rules( 'nama_coba', 'nama_coba', 'required' );
    $this->form_validation->set_rules( 'id_kelompok', 'id_kelompok', 'required' );
    $this->form_validation->set_rules( 'lebar_perahu_coba', 'lebar_perahu_coba', 'required' );
    $this->form_validation->set_rules( 'panjang_perahu_coba', 'panjang_perahu_coba', 'required' );

    if ( $this->form_validation->run() != false ) {
      // $nama_coba = $this->input->post( 'nama_coba' );
      $id_kelompok = $this->input->post( 'id_kelompok', TRUE );
      $nama_coba = $this->input->post( 'nama_coba', TRUE );
      // $id_kelompok = decrypt_url( $this->input->post( 'id_kelompok', TRUE ) );
      $lebar_perahu_coba = $this->libku->ribuansql( $this->input->post( 'lebar_perahu_coba', TRUE ) );
      $panjang_perahu_coba = $this->libku->ribuansql( $this->input->post( 'panjang_perahu_coba', TRUE ) );

      date_default_timezone_set( 'Asia/Jakarta' );
      $code = date( "HdmiYs" );

      $upload_conf = array(
        'upload_path' => realpath( './upload/foto_perahu_baru/' ),
        'allowed_types' => 'jpg|jpeg|png',
        'file_name' => $code
      );

      $this->upload->initialize( $upload_conf );
      if ( !$this->upload->do_upload( 'userfile' ) ) {
        $data = array(
          'nama_coba' => $nama_coba,
          'id_kelompok' => decrypt_url( $id_kelompok ),
          'lebar_perahu_coba' => $lebar_perahu_coba,
          'panjang_perahu_coba' => $panjang_perahu_coba
          // 'nama_coba' => decrypt_url( $nama_coba ),
          // 'id_kelompok' => decrypt_url( $id_kelompok ),
          // 'lebar_perahu_coba' => decrypt_url( $lebar_perahu_coba ),
          // 'panjang_perahu_coba' => decrypt_url( $panjang_perahu_coba )
          // percobaan ketika lebar dan panjang bernilai 0, id_kelompok dan gambar muncul

          // 'nama_coba' => $nama_coba ,
          // 'id_kelompok' => $id_kelompok,
          // 'lebar_perahu_coba' => $lebar_perahu_coba,
          // 'panjang_perahu_coba' => $panjang_perahu_coba
          // percobaan ketika id_kelompok bernilai 0, lebar dan panjang muncul namun tidak muncul di tabel
        );
        $this->m_coba->save( $data );
        echo json_encode( array( "status" => TRUE ) );
      } else {
        $upload_data = $this->upload->data();
        $data = array(
          'nama_coba' => $nama_coba,
          'id_kelompok' => decrypt_url( $id_kelompok ),
          'lebar_perahu_coba' => $lebar_perahu_coba,
          'panjang_perahu_coba' => $panjang_perahu_coba,
          // 'nama_coba' => decrypt_url($nama_coba),
          // 'id_kelompok' => decrypt_url( $id_kelompok ),
          // 'lebar_perahu_coba' => decrypt_url( $lebar_perahu_coba ),
          // 'panjang_perahu_coba' => decrypt_url( $panjang_perahu_coba )
          'foto_depan_coba' => 'upload/foto_perahu_baru/' . $upload_data[ 'file_name' ]
        );
        $this->m_coba->save( $data );
        echo json_encode( array( "status" => TRUE ) );
      }
    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }

  function update() {
    $id = decrypt_url( $this->input->get( "q" ) );

    $this->form_validation->set_rules( 'nama_coba', 'nama_coba', 'required' );
    $this->form_validation->set_rules( 'id_kelompok', 'id_kelompok', 'required' );
    $this->form_validation->set_rules( 'lebar_perahu_coba', 'lebar_perahu_coba', 'required' );
    $this->form_validation->set_rules( 'panjang_perahu_coba', 'panjang_perahu_coba', 'required' );

    if ( $this->form_validation->run() != false ) {
      $nama_coba = $this->input->post( 'nama_coba', TRUE );
      $id_kelompok = $this->input->post( 'id_kelompok', TRUE );
      $lebar_perahu_coba = $this->libku->ribuansql( $this->input->post( 'lebar_perahu_coba', TRUE ) );
      $panjang_perahu_coba = $this->libku->ribuansql( $this->input->post( 'panjang_perahu_coba', TRUE ) );

      date_default_timezone_set( 'Asia/Jakarta' );
      $code = date( "HdmiYs" );

      $upload_conf = array(
        'upload_path' => realpath( './upload/foto_perahu_baru/' ),
        'allowed_types' => 'jpg|jpeg|png',
        'file_name' => $code
      );
      $this->upload->initialize( $upload_conf );
      if ( !$this->upload->do_upload( 'userfile' ) ) {
        $data = array(
          'nama_coba' => $nama_coba,
          'id_kelompok' => decrypt_url( $id_kelompok ),
          'lebar_perahu_coba' => $lebar_perahu_coba,
          'panjang_perahu_coba' => $panjang_perahu_coba
        );
        $this->m_coba->update( array( 'id_coba' => $id ), $data );
        echo json_encode( array( "status" => TRUE ) );
      } else {
        $upload_data = $this->upload->data();
        $data = array(
          'nama_coba' => $nama_coba,
          'id_kelompok' => decrypt_url( $id_kelompok ),
          'lebar_perahu_coba' => $lebar_perahu_coba,
          'panjang_perahu_coba' => $panjang_perahu_coba,
          'foto_depan_coba' => 'upload/foto_perahu_baru/' . $upload_data[ 'file_name' ]
        );
        $this->m_coba->update( array( 'id_coba' => $id ), $data );
        echo json_encode( array( "status" => TRUE ) );
      }
    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }

  function get_berkas() {
    $id = decrypt_url( $this->input->post( "q" ) );
    $isi = $this->m_coba->edit( $id );
    $foto_samping_coba = $isi->foto_samping_coba ? : 'aset/img/no_berkas.jpg';
    $sim = $isi->sim ? : 'aset/img/no_berkas.jpg';
    $data[ 'foto_samping_coba' ] = base_url() . $foto_samping_coba;
    $data[ 'sim' ] = base_url() . $sim;
    echo json_encode( $data );
  }

  function upload_foto_samping_coba() {
    $id_coba = decrypt_url( $this->input->post( 'id_coba' ) );
    date_default_timezone_set( 'Asia/Jakarta' );
    $code = date( "HdmiYs" );
    $upload_conf = array(
      'upload_path' => realpath( './upload/foto_perahu_baru/' ),
      'allowed_types' => 'jpg|jpeg|png',
      'file_name' => $code
    );
    $this->upload->initialize( $upload_conf );
    if ( !$this->upload->do_upload( 'foto_samping_coba' ) ) {
      echo json_encode( array( "status" => FALSE, 'pesan' => "Pilih Foto Samping Perahu Terlebih Dahulu!" ) );
    } else {
      $upload_data = $this->upload->data();
      $data = array(
        'foto_samping_coba' => 'upload/foto_perahu_baru/' . $upload_data[ 'file_name' ]
      );
      $this->m_coba->update( array( 'id_coba' => $id_coba ), $data );
      echo json_encode( array( "status" => TRUE ) );
    }

  }

  function upload_sim() {
    $id_coba = decrypt_url( $this->input->post( 'id_coba' ) );
    date_default_timezone_set( 'Asia/Jakarta' );
    $code = date( "HdmiYs" );
    $upload_conf = array(
      'upload_path' => realpath( './upload/foto_perahu_baru/' ),
      'allowed_types' => 'jpg|jpeg|png',
      'file_name' => $code
    );
    $this->upload->initialize( $upload_conf );
    if ( !$this->upload->do_upload( 'sim' ) ) {
      echo json_encode( array( "status" => FALSE, 'pesan' => "Pilih Foto Pas Kecil/Besar Terlebih Dahulu!" ) );
    } else {
      $upload_data = $this->upload->data();
      $data = array(
        'sim' => 'upload/foto_perahu_baru/' . $upload_data[ 'file_name' ]
      );
      $this->m_coba->update( array( 'id_coba' => $id_coba ), $data );
      echo json_encode( array( "status" => TRUE ) );
    }

  }

}