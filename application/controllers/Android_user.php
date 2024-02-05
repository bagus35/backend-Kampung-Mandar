<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Android_user extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->load->model( array( 'm_login', 'm_kelompok', 'm_banner', 'm_produksi', 'm_sampah', 'm_nelayan_android', 'm_user' ) );
    //    $this->load->library( array( 'upload', 'form_validation', 'image_lib', 'libku', 'phpexcel', 'pdf' ) );
  }

  function cek_user() {
    $this->form_validation->set_rules( 'paket', 'paket', 'required' );
    $this->form_validation->set_rules( 'key', 'key', 'required' );
    $this->form_validation->set_rules( 'id_user', 'id_user', 'required' );
    if ( $this->form_validation->run() != false ) {
      $paket = $this->input->post( 'paket', TRUE );
      $key = $this->input->post( 'key', TRUE );
      $id_user = decrypt_url( $this->input->post( 'id_user', TRUE ) );
      if ( $paket == paket() & $key == key_id() ) {
        $data = array(
          'id_account' => $id_user,
          'status' => 1
        );
        $cek = $this->m_login->cek_user( $data );
        if ( $cek->num_rows() == 1 ) {

          $banner = $this->m_banner->get_all();
          $data = array();
          foreach ( $banner as $b ) {
            $row = array();
            $row[ 'banner' ] = base_url() . $b->banner;
            $data[] = $row;
          }

          echo json_encode( array( "status" => "ok", 'banner' => $data ) );
        } else {
          echo json_encode( array( "status" => "block" ) );
        }
      } else {
        echo json_encode( array( "status" => "ilegal" ) );
      }
    } else {
      echo json_encode( array( "status" => "no param" ) );
    }
  }

  function validasi() {
    $this->form_validation->set_rules( 'paket', 'paket', 'required' );
    $this->form_validation->set_rules( 'key', 'key', 'required' );
    $this->form_validation->set_rules( 'username', 'username', 'required' );
    $this->form_validation->set_rules( 'password', 'password', 'required' );
    if ( $this->form_validation->run() != false ) {
      $paket = $this->input->post( 'paket', TRUE );
      $key = $this->input->post( 'key', TRUE );
      $username = $this->input->post( 'username', TRUE );
      $password = $this->input->post( 'password', TRUE );
      if ( $paket == paket() & $key == key_id() ) {
        $data = array(
          'username' => $username,
          'password' => encrypt_url( $password ),
        );
        $user = $this->m_login->cek_user( $data );
        if ( $user->num_rows() == 1 ) {
          $x = $user->row();
          $status = $x->status;

          if ( $status == 1 ) {
            $hak = $x->hak_akses;
            $nama_kelompok = $hak > 2 ? $this->m_kelompok->edit( $x->id_kelompok )->nama_kelompok : "-";

            $banner = $this->m_banner->get_all();
            $databanner = array();
            foreach ( $banner as $b ) {
              $row = array();
              $row[ 'banner' ] = base_url() . $b->banner;
              $databanner[] = $row;
            }


            $newdata = array(
              'status' => 'ok',
              'no_hp' => $x->no_hp,
              'nama' => $x->nama,
              'hak_akses' => $x->hak_akses,
              'email' => $x->email,
              'username' => $x->username,
              'password' => decrypt_url( $x->password ),
              'id_user' => encrypt_url( $x->id_account ),
              'foto' => $x->foto_profil ? base_url() . $x->foto_profil : "",
              'nama_kelompok' => $nama_kelompok,
              'banner' => $databanner
            );
            echo json_encode( $newdata );
          } else {
            echo json_encode( array( "status" => "expired" ) );
          }
        } else {
          echo json_encode( array( "status" => "no" ) );
        }
      } else {
        echo json_encode( array( "status" => "expired" ) );
      }
    } else {
      echo json_encode( array( "status" => "expired" ) );
    }
  }

  function get_home() {
    $this->form_validation->set_rules( 'paket', 'paket', 'required' );
    $this->form_validation->set_rules( 'key', 'key', 'required' );
    $this->form_validation->set_rules( 'id_user', 'id_user', 'required' );
    if ( $this->form_validation->run() != false ) {
      $paket = $this->input->post( 'paket', TRUE );
      $key = $this->input->post( 'key', TRUE );
      $hak_akses = $this->input->post( 'hak', TRUE );
      $id_user = decrypt_url( $this->input->post( 'id_user', TRUE ) );
      if ( $paket == paket() & $key == key_id() ) {
        $data = array(
          'id_account' => $id_user,
          'status' => 1
        );
        $cek = $this->m_login->cek_user( $data );
        if ( $cek->num_rows() == 1 ) {
          $user = $cek->row();
          $id_kelompok = "-1";
          $id_nelayan = "-1";
          $id_perahu = "-1";
          if ( $hak_akses == 4 ) {
            $id_nelayan = $user->id_nelayan;
            $nelayan = $this->m_nelayan->edit( $id_nelayan );
            $id_perahu = $nelayan->id_perahu;
          }
          if ( $hak_akses == 3 ) {
            $id_kelompok = $user->id_kelompok;
          }
          $produksi = $this->m_produksi->total_berat_bulanan( $id_kelompok, $id_perahu );
          $sampah = $this->m_sampah->total_sampah_bulanan( $id_kelompok, $id_nelayan );
          $daur_ulang = $sampah->daur_ulang ? $sampah->daur_ulang . ' kg': "-";
          $non_daur_ulang = $sampah->non_daur_ulang ? $sampah->non_daur_ulang . ' kg': "-";
          echo json_encode( array( "status" => "ok", 'produksi' => $produksi->total ? $produksi->total . 'kg' : '-', 'daur_ulang' => $daur_ulang, 'non_daur_ulang' => $non_daur_ulang,'id_kelompok'=>$id_kelompok) );
        } else {
          echo json_encode( array( "status" => "block" ) );
        }
      } else {
        echo json_encode( array( "status" => "ilegal" ) );
      }
    } else {
      echo json_encode( array( "status" => "no param" ) );
    }
  }


  function ajax_list_sampah() {
    $this->form_validation->set_rules( 'paket', 'paket', 'required' );
    $this->form_validation->set_rules( 'key', 'key', 'required' );
    $this->form_validation->set_rules( 'page_number', 'page_number', 'required' );
    $this->form_validation->set_rules( 'id_user', 'id_user', 'required' );
    if ( $this->form_validation->run() != false ) {
      $paket = $this->input->post( 'paket' );
      $key = $this->input->post( 'key' );
      $hak = $this->input->post( 'hak' );
      if ( $paket == paket() & $key == key_id() ) {
        $page_no = $this->input->post( "page_number" );
        $id_user = decrypt_url( $this->input->post( 'id_user' ) );
        $user = $this->m_user->edit( $id_user );
        $id_kelompok = "-1";
        $id_nelayan = "-1";
        if ( $hak == 3 ) {
          $id_kelompok = $user->id_kelompok;
        }
        if ( $hak == 4 ) {
          $id_nelayan = $user->id_nelayan;
        }

        $all = $this->m_sampah->count_all( $id_kelompok, $id_nelayan );
        $per_page = 20;
        $start = ( $page_no > 1 ) ? ( $page_no * $per_page ) - $per_page : 0;
        $max_page = ceil( intval( $all ) / intval( $per_page ) );
        $list = $this->m_sampah->get_datatables( $start, $per_page, $id_kelompok, $id_nelayan );
        $data = array();
        foreach ( $list as $d ) {
          $row = array();
          $row[ 'id_sampah' ] = encrypt_url( $d->id_sampah );
          $row[ 'tanggal' ] = date( 'd/m/Y', strtotime( $d->tanggal ) );
          $row[ 'berat_daur_ulang' ] = number_format( $d->berat_daur_ulang, 0, ',', '.' );
          $row[ 'nominal_daur_ulang' ] = number_format( $d->nominal_daur_ulang, 0, ',', '.' );
          $row[ 'berat_non_daur_ulang' ] = number_format( $d->berat_non_daur_ulang, 0, ',', '.' );
          $row[ 'nama_nelayan' ] = $d->nama_nelayan;
          $data[] = $row;
        }
        echo json_encode( array( "status" => "ok", "isi" => $data, 'total_page' => $max_page ) );

      } else {
        echo json_encode( array( "status" => "ilegal", "isi" => "" ) );
      }
    } else {
      echo json_encode( array( "status" => "ilegal", "isi" => "" ) );
    }
  }


  function ajax_list_nelayan() {
    $this->form_validation->set_rules( 'paket', 'paket', 'required' );
    $this->form_validation->set_rules( 'key', 'key', 'required' );
    $this->form_validation->set_rules( 'page_number', 'page_number', 'required' );
    $this->form_validation->set_rules( 'id_user', 'id_user', 'required' );
    if ( $this->form_validation->run() != false ) {
      $paket = $this->input->post( 'paket' );
      $key = $this->input->post( 'key' );
      if ( $paket == paket() & $key == key_id() ) {
        $page_no = $this->input->post( "page_number" );
        $hak = $this->input->post( "hak" );
        $id_user = decrypt_url( $this->input->post( 'id_user' ) );
        $user = $this->m_user->edit( $id_user );
        $id_kelompok = "-1";
        $id_nelayan = "-1";
        if ( $hak == 3 ) {
          $id_kelompok = $user->id_kelompok;
        }
        if ( $hak == 4 ) {
          $id_nelayan = $user->id_nelayan;
        }
        $all = $this->m_nelayan_android->count_all( $id_kelompok, $id_nelayan );
        $per_page = 20;
        $start = ( $page_no > 1 ) ? ( $page_no * $per_page ) - $per_page : 0;
        $max_page = ceil( intval( $all ) / intval( $per_page ) );
        $list = $this->m_nelayan_android->get_datatables( $per_page, $start, $id_kelompok, $id_nelayan );
        $data = array();
        foreach ( $list as $d ) {
          $foto = $d->foto;
          $row = array();
          $row[ 'id_nelayan' ] = encrypt_url( $d->id_nelayan );
          $row[ 'nama_nelayan' ] = $d->nama_nelayan;
          $data[] = $row;
        }
        echo json_encode( array( "status" => "ok", "isi" => $data, 'total_page' => $max_page ) );

      } else {
        echo json_encode( array( "status" => "ilegal", "isi" => "" ) );
      }
    } else {
      echo json_encode( array( "status" => "ilegal", "isi" => "" ) );
    }
  }

  function save_sampah() {
    $this->form_validation->set_rules( 'paket', 'paket', 'required' );
    $this->form_validation->set_rules( 'key', 'key', 'required' );
    $this->form_validation->set_rules( 'id_user', 'id_user', 'required' );
    $this->form_validation->set_rules( 'id_nelayan', 'id_nelayan', 'required' );
    $this->form_validation->set_rules( 'berat_daur_ulang', 'berat_daur_ulang', 'required' );
    $this->form_validation->set_rules( 'nominal_daur_ulang', 'nominal_daur_ulang', 'required' );
    $this->form_validation->set_rules( 'berat_non_daur_ulang', 'berat_non_daur_ulang', 'required' );
    if ( $this->form_validation->run() != false ) {
      $paket = $this->input->post( 'paket' );
      $key = $this->input->post( 'key' );
      $id_nelayan = decrypt_url( $this->input->post( 'id_nelayan' ) );
      $berat_daur_ulang = $this->libku->ribuansql( $this->input->post( 'berat_daur_ulang' ) );
      $nominal_daur_ulang = $this->libku->ribuansql( $this->input->post( 'nominal_daur_ulang' ) );
      $berat_non_daur_ulang = $this->libku->ribuansql( $this->input->post( 'berat_non_daur_ulang' ) );
      if ( $paket == paket() & $key == key_id() ) {
        date_default_timezone_set( 'Asia/Jakarta' );
        $tanggal = date( 'Y-m-d H:i:s' );
        $data = array(
          'tanggal' => $tanggal,
          'berat_daur_ulang' => $berat_daur_ulang,
          'nominal_daur_ulang' => $nominal_daur_ulang,
          'berat_non_daur_ulang' => $berat_non_daur_ulang,
          'id_nelayan' => $id_nelayan
        );

        $this->m_sampah->save( $data );
        echo json_encode( array( "status" => "ok" ) );

      } else {
        echo json_encode( array( "status" => "ilegal", "isi" => "" ) );
      }
    } else {
      echo json_encode( array( "status" => "ilegal", "isi" => "" ) );
    }
  }
}