<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class User_management extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->load->model( array( 'm_user', 'm_kelompok', 'm_nelayan' ) );
    if ( !$this->auth->cek() ) {
      $this->session->sess_destroy();
      redirect( base_url() );
      exit();
    }
  }

  function index() {
    $data[ 'title' ] = 'User Management';
    $data[ 'judul' ] = 'User Management';
    $data[ 'kelompok' ] = $this->m_kelompok->get_all();
    $this->template->display( 'content/user', $data );
  }

  function ajax_list() {
    $list = $this->m_user->get_datatables();
    $data = array();
    $no = 0;
    foreach ( $list as $d ) {
      $no++;
      $row = array();
      $row[] = '<div class="btn-group d-flex btn-group-sm">
			<a href="javascript:void(0)" class="btn btn-danger w-100" onclick="delete_data(' . "'" . encrypt_url( $d->id_account ) . "'" . ')" title="delete"><i class="fa fa-trash"></i></a>
			<a href="javascript:void(0)" class="btn btn-warning w-100" onclick="edit_data(' . "'" . encrypt_url( $d->id_account ) . "'" . ')" title="edit"><i class="fa fa-pencil-square"></i></a>
			</div>';
      $hak = $d->hak_akses;
      if ( $hak == "1" ) {
        $hak = "Super User";
      } elseif ( $hak == "2" ) {
        $hak = "Admin";
      } elseif ($hak == "3") {
        $hak = "Ketua Kelompok";
      }else{
		  $hak = "Nelayan";
	  }
      $row[] = $no;
      $row[] = $d->nama;
      $row[] = '+62' . $d->no_hp;
      $row[] = $d->email;
      $row[] = $d->username;
      $row[] = decrypt_url($d->password);
      $row[] = $hak;
      $data[] = $row;
    }
    $output = array(
      "draw" => $_POST[ 'draw' ],
      "recordsTotal" => $this->m_user->count_all(),
      "recordsFiltered" => $this->m_user->count_filtered(),
      "data" => $data,
    );
    echo json_encode( $output );
  }


  function edit() {
    $id = decrypt_url( $this->input->post( "q" ) );
    $k = $this->m_user->edit( $id );
    $row = array();
    $row[ 'nama' ] = $k->nama;
    $row[ 'email' ] = $k->email;
    $row[ 'no_hp' ] = $k->no_hp;
    $row[ 'email' ] = $k->email;
    $row[ 'hak_akses' ] = $k->hak_akses;
    $row[ 'id_nelayan' ] = encrypt_url($k->id_nelayan);
    $row[ 'id_kelompok' ] = encrypt_url($k->id_kelompok);
    echo json_encode( $row );
  }

  function delete() {
    $this->form_validation->set_rules( 'q', 'q', 'required' );
    if ( $this->form_validation->run() != false ) {
      $id = decrypt_url( $this->input->post( "q" ) );
      $this->m_user->delete_by_id( $id );
      echo json_encode( array( "status" => TRUE ) );
    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }

  function save() {
    $this->form_validation->set_rules( 'nama', 'nama', 'required' );
    $this->form_validation->set_rules( 'username', 'username', 'required' );
    $this->form_validation->set_rules( 'password', 'password', 'required' );
    $this->form_validation->set_rules( 'hak_akses', 'hak_akses', 'required' );
    $this->form_validation->set_rules( 'no_hp', 'no_hp', 'required' );
    $this->form_validation->set_rules( 'email', 'email', 'required' );
    $this->form_validation->set_rules( 'hak_akses', 'hak_akses', 'required' );
    if ( $this->form_validation->run() != false ) {
      $nama = $this->input->post( 'nama', TRUE );
      $id_kelompok = decrypt_url( $this->input->post( 'id_kelompok', TRUE ) );
      $id_nelayan = decrypt_url( $this->input->post( 'id_nelayan', TRUE ) );
      $data = array(
        'nama' => $nama,
        'username' => $this->input->post( 'username' ),
        'password' => encrypt_url( $this->input->post( 'password', TRUE ) ),
        'email' => $this->input->post( 'email', TRUE ),
        'no_hp' => $this->input->post( 'no_hp', TRUE ),
        'hak_akses' => $this->input->post( 'hak_akses', TRUE ),
        'id_nelayan' => $id_nelayan,
        'id_kelompok' => $id_kelompok
      );
      $id = $this->m_user->save( $data );
      echo json_encode( array( "status" => TRUE ) );
    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }

  function update() {
    $id = decrypt_url( $this->input->get( "q" ) );
    $this->form_validation->set_rules( 'nama', 'nama', 'required' );
    $this->form_validation->set_rules( 'hak_akses', 'hak_akses', 'required' );
    $this->form_validation->set_rules( 'no_hp', 'no_hp', 'required' );
    $this->form_validation->set_rules( 'email', 'email', 'required' );
    if ( $this->form_validation->run() != false ) {
      $nama = $this->input->post( 'nama', TRUE );
      $username = $this->input->post( 'username', TRUE );
			$id_kelompok = decrypt_url( $this->input->post( 'id_kelompok', TRUE ) );
      $id_nelayan = decrypt_url( $this->input->post( 'id_nelayan', TRUE ) );
      $data = array(
        'nama' => $nama,
        'hak_akses' => $this->input->post( 'hak_akses', TRUE ),
        'email' => $this->input->post( 'email', TRUE ),
        'no_hp' => $this->input->post( 'no_hp', TRUE ),
		     'id_nelayan' => $id_nelayan,
        'id_kelompok' => $id_kelompok
      );

      $this->m_user->update( array( "id_account" => $id ), $data );
      echo json_encode( array( "status" => TRUE ) );
    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }

  function cek_username() {
    $username = $this->input->post( 'username', TRUE );
    $cek_u = array(
      'username' => $username
    );
    $cek_username = $this->m_user->cek( $cek_u );
    if ( $cek_username == 0 ) {
      echo json_encode( array( "status" => TRUE ) );
    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }


  function get_nelayan() {
    $id_kelompok = encrypt_url( $this->input->post( 'q' ) );
    $nelayan = $this->m_nelayan->get_nelayan( $id_kelompok );
    echo json_encode( array( 'status' => TRUE, 'isi' => $nelayan ) );
  }
} // END