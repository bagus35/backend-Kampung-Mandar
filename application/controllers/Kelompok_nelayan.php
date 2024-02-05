<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Kelompok_nelayan extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->load->model( array( 'm_kelompok' ) );
    $this->load->library( array( 'form_validation', 'libku' ) );
    if ( !$this->auth->cek() ) {
      $this->session->sess_destroy();
      redirect( base_url() );
      exit();
    }
  }

  function index() {
    $data[ 'title' ] = "kelompok";
    $data[ 'judul' ] = "Kelompok Nelayan";
    $this->template->display( 'content/kelompok', $data );
  }

  function berkas() {
    $id = decrypt_url( $this->input->get( "q" ) );
    $data[ 'title' ] = "Berkas Kelompok";
    $data[ 'judul' ] = "Berkas Kelompok";
    $data[ 'isi' ] = $this->m_kelompok->detail( $id );
    $this->template->display( 'content/berkas_kelompok', 
    $data );
  }

  function ajax_list() {
    $list = $this->m_kelompok->get_datatables();
    $data = array();
    $no = $this->input->post( 'start' );
    foreach ( $list as $d ) {
      $no++;
      $row = array();
      $row[] = ' <div class="btn-group">
      <a href="javascript:;" class="btn btn-sm btn-warning 
      btn-rounded" data-toggle="tooltip" 
      data-original-title="Delete" 
      onClick="edit_data(' . "'" . 
      encrypt_url( $d->id_kelompok ) . "'" . ')"> 
      Edit </a> 
      <a href="javascript:;" class="btn btn-sm btn-danger 
      btn-rounded" data-toggle="tooltip" 
      data-original-title="Logo" 
      onClick="delete_data(' . "'" . 
      encrypt_url( $d->id_kelompok ) . "'" . ')">
      Delete</a>
      <a href="' . base_url() . 
      'kelompok_nelayan/berkas?q=' . 
      encrypt_url($d->id_kelompok) . '" 
      class="btn btn-sm btn-success btn-rounded" 
      data-toggle="tooltip" data-original-title="lihat berkas"> 
      Lihat Berkas </a>
      </div>'; 
      $row[] = $no;
      $row[] = $d->nama_kelompok;
      $row[] = $d->nama_ketua?:"-";
      $data[] = $row;
    }
    $output = array(
      "draw" => $_POST[ 'draw' ],
      "recordsTotal" => $this->m_kelompok->count_all(),
      "recordsFiltered" => $this->m_kelompok->count_filtered(),
      "data" => $data
    );
    echo json_encode( $output );
  }

  function edit() {
    $k = $this->m_kelompok->edit( decrypt_url( 
      $this->input->post( 'q', TRUE ) ) );
    $data[ 'nama_kelompok' ] = $k->nama_kelompok;
    $data[ 'nama_ketua' ] = $k->nama_ketua;
    echo json_encode( $data );
  }

  function delete() {
    $id = decrypt_url( $this->input->post( "q" ) );
    if ( $id != "" || $id != NULL ) {
      $this->m_kelompok->delete_by_id( $id );
      echo json_encode( array( "status" => TRUE ) );
    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }

  function save() {
    $this->form_validation->set_rules( 'nama_kelompok', 'nama_kelompok', 'required' );
    if ( $this->form_validation->run() != false ) {
      $data = array(
        'nama_kelompok' => $this->input->post( 'nama_kelompok', TRUE ),
        'nama_ketua' => $this->input->post( 'nama_ketua', TRUE )
      );
      $id = $this->m_kelompok->save( $data );
      echo json_encode( array( "status" => TRUE ) );
    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }

  function update() {
    $id = decrypt_url( $this->input->get( "q" ) );
    $this->form_validation->set_rules( 'nama_kelompok', 'nama_kelompok', 'required' );
    if ( $this->form_validation->run() != false ) {
      $data = array(
        'nama_kelompok' => $this->input->post( 'nama_kelompok', TRUE ),
        'nama_ketua' => $this->input->post( 'nama_ketua', TRUE )
      );
      $this->m_kelompok->update( array( 'id_kelompok' => $id ), $data );
      echo json_encode( array( "status" => TRUE ) );
    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }

  function get_berkas()
  {
    $id = decrypt_url($this->input->post("q"));
    $isi = $this->m_kelompok->edit($id);
    $foto_sk = $isi->foto_sk ?: 'aset/img/no_berkas.jpg';
    $foto_ad_art = $isi->foto_ad_art ?: 'aset/img/no_berkas.jpg';
    $foto_sekertariat = $isi->foto_sekertariat ?: 'aset/img/no_berkas.jpg';
      
    $data['foto_sk'] = base_url() . $foto_sk;
    $data['foto_ad_art'] = base_url() . $foto_ad_art;
    $data['foto_sekertariat'] = base_url() . $foto_sekertariat;

    echo json_encode($data);
  }

  function upload_sk()
  {
    $id_kelompok = decrypt_url($this->input->post('id_kelompok'));
    date_default_timezone_set('Asia/Jakarta');
    $code = date("HdmiYs");
    $upload_conf = array(
      'upload_path' => realpath('./upload/berkas_kelompok/'),
      'allowed_types' => 'jpg|jpeg|png',
      'file_name' => $code
    );

    $this->upload->initialize($upload_conf);
    if (!$this->upload->do_upload('foto_sk')) {
      echo json_encode(array("status" => FALSE, 
      'pesan' => "Pilih Foto SK
   Terlebih Dahulu!"));
    } else {
      $upload_data = $this->upload->data();
      $data = array(
        'foto_sk
    ' => 'upload/berkas_kelompok/' . 
        $upload_data['file_name']
      );
      $this->m_kelompok->update(
        array('id_kelompok' => $id_kelompok), $data);
      echo json_encode(array("status" => TRUE));
    }
  }

    function upload_ad_art()
  {
    $id_kelompok = decrypt_url($this->input->post('id_kelompok'));
    date_default_timezone_set('Asia/Jakarta');
    $code = date("HdmiYs");
    $upload_conf = array(
      'upload_path' => realpath('./upload/berkas_kelompok/'),
      'allowed_types' => 'jpg|jpeg|png',
      'file_name' => $code
    );
    $this->upload->initialize($upload_conf);
    if (!$this->upload->do_upload('foto_ad_art')) {
      echo json_encode(array("status" => FALSE, 
      'pesan' => "Pilih Foto AD/ART Terlebih Dahulu!"));
    } else {
      $upload_data = $this->upload->data();
      $data = array(
        'foto_ad_art' => 'upload/berkas_kelompok/' . 
        $upload_data['file_name']
      );
      $this->m_kelompok->update(
        array('id_kelompok' => $id_kelompok), $data);
      echo json_encode(array("status" => TRUE));
    }
  }

  function upload_sekertariat()
  {
    $id_kelompok = decrypt_url($this->input->post('id_kelompok'));
    date_default_timezone_set('Asia/Jakarta');
    $code = date("HdmiYs");
    $upload_conf = array(
      'upload_path' => realpath('./upload/berkas_kelompok/'),
      'allowed_types' => 'jpg|jpeg|png',
      'file_name' => $code
    );
    $this->upload->initialize($upload_conf);
    if (!$this->upload->do_upload('foto_sekertariat')) {
      echo json_encode(array("status" => FALSE, 
      'pesan' => "Pilih Foto Sekertariat Terlebih Dahulu!"));
    } else {
      $upload_data = $this->upload->data();
      $data = array(
        'foto_sekertariat' => 'upload/berkas_kelompok/' . 
        $upload_data['file_name']
      );
      $this->m_kelompok->update(
        array('id_kelompok' => $id_kelompok), $data);
      echo json_encode(array("status" => TRUE));
    }
  }

  }
