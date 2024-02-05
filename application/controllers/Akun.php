<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Akun extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->load->model( array( 'm_user' ) );
    if ( !$this->auth->cek() ) {
      $this->session->sess_destroy();
      redirect( base_url() );
      exit();
    }
  }
  function index() {
    $id_user = decrypt_url( $this->session->userdata( "id_user" ) );
    $data[ 'title' ] = 'Pengaturan Akun';
	  $data['judul'] = "Pengaturan Akun";
    $data[ 'd' ] = $this->m_user->edit( $id_user );
    $this->template->display( 'content/akun', $data );
  }
  function cek_username() {
    $username = $this->input->post( 'username', TRUE );
    $cek_u = array(
      'username' => $username
    );
    $cek_username = $this->m_user->cek( $cek_u );
    if ( $cek_username == 0 ) {
      return TRUE;
    } else {
      return FALSE;
    }
  }
  function upload_foto() {
    date_default_timezone_set( 'Asia/Jakarta' );
    $code = date( "HdmiYs" );
    $data = $_POST[ 'image' ];
    list( $type, $data ) = explode( ';', $data );
    list( , $data ) = explode( ',', $data );
    $data = base64_decode( $data );
    $imageName = $code . '.png';
    file_put_contents( 'upload/foto/' . $imageName, $data );
    $data = array(
      'foto_profil' => 'upload/foto/' . $imageName,
    );
    $id_user = decrypt_url( $this->session->userdata( "id_user" ) );
    $user = $this->m_user->edit( $id_user );
    $ft = $user->foto;
    if ( $ft != NULL ) {
      $ft1 = $ft;
      unlink( $ft1 );
    }
    $this->m_user->update( array( 'id_account' => $id_user ), $data );
    $this->session->set_userdata( 'foto', 'upload/foto/' . $imageName );
    echo json_encode( array( "status" => TRUE ) );
  }
  function ganti_nama() {
    $id = decrypt_url( $this->session->userdata( 'id_user' ) );
    $this->form_validation->set_rules( 'nama', 'nama', 'required' );
    $this->form_validation->set_rules( 'password_nama', 'password_nama', 'required' );
    if ( $this->form_validation->run() != false ) {
      $p = $this->session->userdata( 'pw' );
      $pw = $this->input->post( 'password_nama' );
      if ( $p == encrypt_url( $pw ) ) {
        $nama = $this->input->post( 'nama', TRUE );
        $data = array(
          'nama' => $nama
        );
        $this->m_user->update( array( "id_account" => $id ), $data );
        $this->session->set_userdata( 'nama', $nama );
        echo json_encode( array( "status" => TRUE, "pesan" => "Nama Berhasil Diganti", "judul_pesan" => "Berhasil Diganti" ) );
      } else {
        echo json_encode( array( "status" => FALSE, "pesan" => "Password yang anda masukkan salah!", "judul_pesan" => "Password Salah!" ) );
      }
    } else {
      echo json_encode( array( "status" => FALSE, "pesan" => "Mohon periksa inputan anda!", "judul_pesan" => "Input tidak Valid!" ) );
    }
  }
  function ganti_email() {
    $id = decrypt_url( $this->session->userdata( 'id_user' ) );
    $this->form_validation->set_rules( 'email', 'email', 'required' );
    $this->form_validation->set_rules( 'password_email', 'password_email', 'required' );
    if ( $this->form_validation->run() != false ) {
      $p = $this->session->userdata( 'pw' );
      $pw = $this->input->post( 'password_email' );
      if ( $p == encrypt_url( $pw ) ) {
        $nama = $this->input->post( 'email', TRUE );
        $data = array(
          'email' => $nama
        );
        $this->m_user->update( array( "id_account" => $id ), $data );
        $this->session->set_userdata( 'email', $nama );
        echo json_encode( array( "status" => TRUE, "pesan" => "Email Berhasil Diganti", "judul_pesan" => "Berhasil Diganti" ) );
      } else {
        echo json_encode( array( "status" => FALSE, "pesan" => "Password yang anda masukkan salah!", "judul_pesan" => "Password Salah!" ) );
      }
    } else {
      echo json_encode( array( "status" => FALSE, "pesan" => "Mohon periksa inputan anda!", "judul_pesan" => "Input tidak Valid!" ) );
    }
  }
  function ganti_username() {
    $id = decrypt_url( $this->session->userdata( 'id_user' ) );
    $this->form_validation->set_rules( 'username', 'username', 'required' );
    $this->form_validation->set_rules( 'password_username', 'password_username', 'required' );
    if ( $this->form_validation->run() != false ) {
      $p = $this->session->userdata( 'pw' );
      $pw = $this->input->post( 'password_username' );
      if ( $p == encrypt_url( $pw ) ) {
        $user = $this->session->userdata( "username" );
        $nama = $this->input->post( 'username', TRUE );
        if ( $nama == $user ) {
          echo json_encode( array( "status" => FALSE, "pesan" => "Anda tidak melakukan Pengubahan Username!", "judul_pesan" => "Username tidak diganti!" ) );
        } else {
          if ( $this->cek_username( $nama ) ) {
            $data = array(
              'username' => $nama
            );
            $this->m_user->update( array( "id_account" => $id ), $data );
            $this->session->set_userdata( 'username', $nama );
            echo json_encode( array( "status" => TRUE, "pesan" => "Username Berhasil Diganti", "judul_pesan" => "Berhasil Diganti" ) );
          } else {
            echo json_encode( array( "status" => FALSE, "pesan" => "Mohon gunakan username yang lain!", "judul_pesan" => "Username Telah Digunakan!" ) );
          }
        }
      } else {
        echo json_encode( array( "status" => FALSE, "pesan" => "Password yang anda masukkan salah!", "judul_pesan" => "Password Salah!" ) );
      }
    } else {
      echo json_encode( array( "status" => FALSE, "pesan" => "Mohon periksa inputan anda!", "judul_pesan" => "Input tidak Valid!" ) );
    }
  }
  function ganti_password() {
    $id = decrypt_url( $this->session->userdata( 'id_user' ) );
    $this->form_validation->set_rules( 'password', 'password', 'required' );
    $this->form_validation->set_rules( 'password_lama', 'password_lama', 'required' );
    $this->form_validation->set_rules( 'ulangi_password', 'ulangi_password', 'required' );
    if ( $this->form_validation->run() != false ) {
      $p = $this->session->userdata( 'pw' );
      $pw = $this->input->post( 'password_lama' );
      if ( $p == encrypt_url( $pw ) ) {
        $nama = encrypt_url( $this->input->post( 'password', TRUE ) );
        $ulangi = encrypt_url( $this->input->post( 'ulangi_password', TRUE ) );
        if ( $ulangi == $nama ) {
          $data = array(
            'password' => $nama
          );
          $this->m_user->update( array( "id_account" => $id ), $data );
          $this->session->set_userdata( 'pw', $nama );
          echo json_encode( array( "status" => TRUE, "pesan" => "Password Berhasil Diganti", "judul_pesan" => "Berhasil Diganti" ) );
        } else {
          echo json_encode( array( "status" => FALSE, "pesan" => "Mohon ketikan dengan benar!", "judul_pesan" => "Password Tidak Sama!" ) );
        }
      } else {
        echo json_encode( array( "status" => FALSE, "pesan" => "Password lama yang anda masukkan salah!", "judul_pesan" => "Password Lama Salah!" ) );
      }
    } else {
      echo json_encode( array( "status" => FALSE, "pesan" => "Mohon periksa inputan anda!", "judul_pesan" => "Input tidak Valid!" ) );
    }
  }
} // END