?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Kontrol_user_android extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->load->model( array( 'm_kontrol', 'm_komplain', 'm_kecamatan' ) );
    $this->load->library( array( 'form_validation', 'libku', 'phpexcel', 'pdf' ) );
    if ( !$this->auth->cek() ) {
      $this->session->sess_destroy();
      redirect( base_url() );
      exit();
    }
  }

  function index() {
    $data[ 'title' ] = "Kontrol User";
    $data[ 'kecamatan' ] = $this->m_kecamatan->get_all();
    $this->template->display( 'content/kontrol', $data );
  }


  function ajax_list() {
    if ( !$this->auth->cek() ) {
      $this->session->sess_destroy();
      redirect( base_url() );
      exit();
    } else {
      $list = $this->m_kontrol->get_datatables();
      $data = array();
      $no = $this->input->post( 'start' );
      foreach ( $list as $d ) {
        $status = $d->status;
        $switch = '<input id="' . encrypt_url( $d->id_user ) . '" data-on="Active" data-off="Suspended" class="onoff" type="checkbox" checked data-toggle="toggle" data-onstyle="success" data-offstyle="danger" onChange="update_status(' . "'" . encrypt_url( $d->id_user ) . "'" . ')">';

        if ( $status == 2 ) {
          $switch = '<input id="' . encrypt_url( $d->id_user ) . '" data-on="Active" data-off="Suspended" class="onoff" type="checkbox" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" onChange="update_status(' . "'" . encrypt_url( $d->id_user ) . "'" . ')">';
        }


        $lapor = $this->m_komplain->lapor_per_user( $d->id_user );

        $foto = $d->foto_profil;

        if ( $foto == NULL ) {
          $foto = 'aset/img/ic_user.png';
        }

        $st = $d->status;
        $sta = "Aktive";
        if ( $st == 2 ) {
          $sta = "Suspend";
        }

        $no++;
        $row = array();
        $row[] = $switch;
        $row[] = $no;
        $row[] = '<div style="background: url(' . base_url() . $foto . ') no-repeat center center; background-size:80px 80px;height:80px;width:80px; "> </div>';
        $row[] = strtoupper($d->nama);

        $row[] = $d->no_hp;
        $row[] = '<div class="rumah"><p class="alamat">' . $d->alamat . '</p><i class="desa">Desa/Kel. ' . $d->desa . ' Kecamatan ' . $d->kecamatan . '</i></div>';
        $row[] = $status;
        $row[] = number_format( $lapor, 0, ',', '.' );
        $data[] = $row;
      }
      $output = array(
        "draw" => $_POST[ 'draw' ],
        "recordsTotal" => $this->m_kontrol->count_all(),
        "recordsFiltered" => $this->m_kontrol->count_filtered(),
        "data" => $data,
        'pos' => $this->input->post( 'start' )
      );
      echo json_encode( $output );
    }
  }


  function get_desa() {
    $id_kecamatan = decrypt_url( $this->input->post( 'q' ) );
    $list = $this->m_desa->get_by_kecamatan( $id_kecamatan );
    $isine = array();
    foreach ( $list as $i ) {
      $row = array();
      $row[ 'id_desa' ] = encrypt_url( $i->id_desa );
      $row[ 'desa' ] = $i->desa;
      $isine[] = $row;
    }
    $data[ 'isi' ] = $isine;
    echo json_encode( $data );
  }


  function update_status() {
    $id = decrypt_url( $this->input->post( "key" ) );
    $this->form_validation->set_rules( 'st', 'st', 'required' );
    $this->form_validation->set_rules( 'key', 'key', 'required' );
    if ( $this->form_validation->run() != false ) {

      $data = array(
        'status' => $this->input->post( 'st', TRUE ),
      );
      $this->m_kontrol->update( array( 'id_user' => $id ), $data );
      echo json_encode( array( "status" => TRUE, "pesan" => "Status Berhasil Diperbaharui" ) );

    } else {
      echo json_encode( array( "status" => FALSE, 'pesan' => 'Pastikan inputan anda sudah terisi dengan benar!' ) );
    }
  }


}