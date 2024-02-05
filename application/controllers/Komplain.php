<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Komplain extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->load->model( array( 'm_komplain', 'm_kecamatan', 'm_desa', 'm_tanggapan', 'm_ruas_jalan', 'm_user_android' ) );
    $this->load->library( array( 'form_validation', 'libku', 'phpexcel', 'pdf' ) );
    if ( !$this->auth->cek() ) {
      $this->session->sess_destroy();
      redirect( base_url() );
      exit();
    }
  }

  function index() {
    $data[ 'title' ] = "Komplain";
    $data[ 'kecamatan' ] = $this->m_kecamatan->get_all();
    $this->template->display( 'content/komplain', $data );
  }


  function detail() {
    $id = decrypt_url( $this->input->get( 'q' ) );
    $data[ 'title' ] = "DETAIL - KOMPLAIN";
    $isi = $this->m_komplain->get_by_id( $id );
    $data[ 'isi' ] = $isi;
    $data[ 'ruas' ] = $this->m_ruas_jalan->detail( $isi->id_ruas_jalan );
    $data[ 'foto' ] = $this->m_komplain->get_all_foto( $id );
    $this->template->display( 'content/detail_komplain', $data );
  }


  function ajax_list() {
    if ( !$this->auth->cek() ) {
      $this->session->sess_destroy();
      redirect( base_url() );
      exit();
    } else {
      $list = $this->m_komplain->get_datatables();
      $data = array();
      $no = $this->input->post( 'start' );
      foreach ( $list as $d ) {
        $foto = $d->foto_komplain;

        if ( $foto == NULL ) {
          $foto = 'aset/img/k_no_logo.png';
        }

        $no++;
        $row = array();
        $row[] = '<div class="btn-group">
  					<a href="javascript:;" class="btn btn-danger btn-sm"  title="Delete" onClick="delete_data(' . "'" . encrypt_url( $d->id_komplain ) . "'" . ')">Delete</a>
  					<a href="' . base_url() . 'komplain/detail?q=' . encrypt_url( $d->id_komplain ) . '" class="btn btn-primary btn-sm"  title="Detail">Detail</a>
				</div>';
        $row[] = $no;
        $row[] = $d->nama_ruas;
        $row[] = $d->desa . '<br><i>' . $d->kecamatan . '</i>';
        $row[] = $d->nama;
        $row[] = $d->koordinat;
        $row[] = '<a href="javascript:void(0)" onclick="lihat_foto(' . "'" . base_url() . $foto . "'" . ')" ><div style="background: url(' . base_url() . $foto . ') no-repeat center center; background-size:80px 60px;height:60px;width:80px; "> </div></a>';
        $row[] = $d->keterangan;

        $data[] = $row;
      }
      $output = array(
        "draw" => $_POST[ 'draw' ],
        "recordsTotal" => $this->m_komplain->count_all(),
        "recordsFiltered" => $this->m_komplain->count_filtered(),
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


  function ajax_list_tanggapan() {
    if ( !$this->auth->cek() ) {
      $this->session->sess_destroy();
      redirect( base_url() );
      exit();
    } else {
      $list = $this->m_tanggapan->get_datatables();
      $data = array();
      $no = $this->input->post( 'start' );
      foreach ( $list as $d ) {
        $no++;
        $row = array();
        $row[] = '<div class="btn-group">
					<a href="javascript:;" class="btn btn-success btn-sm"  title="edit" onClick="edit_data(' . "'" . encrypt_url( $d->id_tanggapan ) . "'" . ')">edit</a>
  					<a href="javascript:;" class="btn btn-danger btn-sm"  title="Delete" onClick="delete_data(' . "'" . encrypt_url( $d->id_tanggapan ) . "'" . ')">Delete</a>		
				</div>';
        $row[] = date( 'd/m/Y | H:i:s', strtotime( $d->tanggal ) );
        $row[] = $d->tanggapan ? : '-';
        $data[] = $row;
      }
      $output = array(
        "draw" => $_POST[ 'draw' ],
        "recordsTotal" => $this->m_tanggapan->count_all(),
        "recordsFiltered" => $this->m_tanggapan->count_filtered(),
        "data" => $data
      );
      echo json_encode( $output );
    }
  }

  function save_tanggapan() {
    $this->form_validation->set_rules( 'status', 'status', 'required' );
    $this->form_validation->set_rules( 'komentar', 'komentar', 'required' );
    $this->form_validation->set_rules( 'id_komplain', 'id_komplain', 'required' );
    if ( $this->form_validation->run() != false ) {
      date_default_timezone_set( 'Asia/Jakarta' );
      $tanggal = date( "Y-m-d H:i:s" );
      $status = $this->input->post( 'status', TRUE );
      $komentar = $this->input->post( 'komentar', TRUE );
      $id_komplain = decrypt_url( $this->input->post( 'id_komplain', TRUE ) );
      $data = array(
        'tanggapan' => $komentar,
        'id_komplain' => $id_komplain,
        'tanggal' => $tanggal
      );
      $id = $this->m_tanggapan->save( $data );
      $data2 = array(
        'status' => $status
      );
      $this->m_komplain->update( array( 'id_komplain' => $id_komplain ), $data2 );
      $k = $this->m_komplain->edit($id_komplain);
      $id_user = $k->id_user;
      $u = $this->m_user_android->edit( $id_user );
      $token = $u->token;
		$judul="LAPORAN KAMI TERIMA";
		switch($status){
			case 2:
				$judul = "LAPORAN SEDANG DITINJAU";
				break;
			case 3:
				$judul = "LAPORAN DALAM PERENCANAAN";
					break;
			case 4:
				$judul ="LAPORAN SEDANG DIKERJAKAN";
				break;
			case 5:
				$judul ="LAPORAN TELAH DISELESAIKAN";
				break;
			default:
				$judul ="LAPORAN DIBATALKAN";
				break;
		}

		$this->send($token,$judul,$komentar);
      echo json_encode( array( "status" => TRUE ) );

    } else {
      echo json_encode( array( "status" => FALSE, "pesan" => "Input tidak valid. Silahkan periksa kembali inputan anda!" ) );
    }
  }


  function update_tanggapan() {
    $this->form_validation->set_rules( 'status', 'status', 'required' );
    $this->form_validation->set_rules( 'komentar', 'komentar', 'required' );
    $this->form_validation->set_rules( 'id_komplain', 'id_komplain', 'required' );
    if ( $this->form_validation->run() != false ) {
      $id = decrypt_url( $this->input->get( "q" ) );
      $status = $this->input->post( 'status', TRUE );
      $komentar = $this->input->post( 'komentar', TRUE );
      $id_komplain = decrypt_url( $this->input->post( 'id_komplain', TRUE ) );
      $data = array(
        'tanggapan' => $komentar
      );

      $data2 = array(
        'status' => $status
      );
      $this->m_tanggapan->update( array( 'id_tanggapan' => $id ), $data );
      $this->m_komplain->update( array( 'id_komplain' => $id_komplain ), $data2 );
      echo json_encode( array( "status" => TRUE ) );

    } else {
      echo json_encode( array( "status" => FALSE, "pesan" => "Input tidak valid. Silahkan periksa kembali inputan anda!" ) );
    }
  }

  function delete_tanggapan() {
    $id = decrypt_url( $this->input->post( "q" ) );
    if ( $id != "" || $id != NULL ) {
      $this->m_tanggapan->delete_by_id( $id );
      echo json_encode( array( "status" => TRUE ) );
    } else {
      echo json_encode( array( "status" => FALSE ) );
    }
  }

  function edit_tanggapan() {
    $k = $this->m_tanggapan->edit( decrypt_url( $this->input->post( 'q', TRUE ) ) );
    $data[ 'komentar' ] = $k->tanggapan;
    $data[ 'status' ] = $k->status;
    echo json_encode( $data );
  }

  function send( $token, $pesan, $judul ) {
    $response = array();
    $msg = array(
      'body' => $pesan,
      'title' => $judul,
      'sound' => 'default',
		

    );
    $fields = array(
      'to' => $token,
      'notification' => $msg,
      "priority" => 10
    );
    $headers = array( 'Authorization:key=AAAAPLgHw4M:APA91bHrIR62vGmGhgOLUOwBAu7yE5CXneC4XvnPUw2TPq62BvH6WrM_eC5g-D138l5CHjCJjVqXZzBZwKGUqLDbtC9hpogJ5_uDRH8Ds5-sa_IY8QAxGO4tNHasPqz4K1zQr1yyZuuP ',
      'Content-Type: application/json'
    );
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    curl_setopt( $ch, CURLOPT_POST, true );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );
    $result = curl_exec( $ch );
    curl_close( $ch );
    // echo $result;
  }
}