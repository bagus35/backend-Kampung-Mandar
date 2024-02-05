<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Rapat_bulanan extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model(array('m_kelompok', 'm_rapat'));
    $this->load->library(array('upload', 'form_validation', 'image_lib', 'libku'));
    if (!$this->auth->cek()) {
      $this->session->sess_destroy();
      redirect(base_url());
      exit();
    }
  }

  function index()
  {
    $data['title'] = "Rapat Bulanan";
    $data['judul'] = "Rapat Bulanan";
    $data['kelompok'] = $this->m_kelompok->get_all();
    $this->template->display('content/rapat', $data);
  }

  
  function berkas() {
    $id = decrypt_url( $this->input->get( "q" ) );
    $data[ 'title' ] = "Berkas Rapat Bulanan";
    $data[ 'judul' ] = "Berkas Rapat Bulanan";
    $data[ 'isi' ] = $this->m_rapat->detail( $id );
    $this->template->display( 'content/berkas_rapat', $data );
  }

  function ajax_list()
  {
    $list = $this->m_rapat->get_datatables();
    $data = array();
    $no = $this->input->post('start');

    foreach ($list as $d) {
      $no++;
      $row = array();

      $row[] = ' <div class="btn-group">
      <a href="javascript:;" class="btn btn-sm btn-warning 
      btn-rounded" data-toggle="tooltip" 
      data-original-title="Delete" 
      onClick="edit_data(' . "'" .
        encrypt_url($d->id_rapat) . "'" . ')"> 
      Edit </a> 

      <a href="javascript:;" class="btn 
      btn-sm btn-danger btn-rounded" 
      data-toggle="tooltip" 
      data-original-title="Logo" 
      onClick="delete_data(' . "'" .
        encrypt_url($d->id_rapat) . "'" . ')">
      Delete</a>

      <a href="' . base_url() . 
      'rapat_bulanan/berkas?q=' . encrypt_url($d->id_rapat) . '" 
      class="btn btn-sm btn-success btn-rounded" 
      data-toggle="tooltip" data-original-title="lihat berkas" > Lihat Dokumentasi </a>
	
      </div>'; 

      $row[] = $no;

      $row[] = date('d/m/Y', strtotime($d->tanggal));

      $row[] = $d->nama_kelompok;
      $row[] = $d->notulen;
      $data[] = $row;
    }

    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->m_rapat->count_all(),
      "recordsFiltered" => $this->m_rapat->count_filtered(),
      "data" => $data
    );
    echo json_encode($output);
  }

  function edit()
  {
    $k = $this->m_rapat->edit(
      decrypt_url($this->input->post('q', TRUE))
    );

    $data['tanggal'] = date('d/m/Y', strtotime($k->tanggal));
    $data['id_kelompok'] = encrypt_url($k->id_kelompok);
    $data['notulen'] = $k->notulen;
    echo json_encode($data);
  }


  function delete()
  {
    $id = decrypt_url($this->input->post("q"));
    if ($id != "" || $id != NULL) {
      $i = $this->m_rapat->edit($id);
      $l = $i->foto_rapat;
      if ($l != NULL) {
        unlink($l);
      }
      $this->m_rapat->delete_by_id($id);
      echo json_encode(array("status" => TRUE));
    } else {
      echo json_encode(array("status" => FALSE));
    }
  }

  function save()
  {
    $this->form_validation->set_rules('tanggal', 'tanggal', 'required');
    $this->form_validation->set_rules('id_kelompok', 'id_kelompok', 'required');
    $this->form_validation->set_rules('notulen', 'notulen', 'required');

    if ($this->form_validation->run() != false) {
      $tanggal = $this->libku->tgl_mysql($this->input->post(
        'tanggal',
        TRUE
      ));
      $id_kelompok = decrypt_url(
        $this->input->post('id_kelompok', TRUE)
      );
      $notulen = $this->input->post('notulen', TRUE);

      date_default_timezone_set('Asia/Jakarta');
      $code = date("HdmiYs");

      $upload_conf = array(
        'upload_path' => realpath('./upload/foto_rapat/'),
        'allowed_types' => 'jpg|jpeg|png',
        'file_name' => $code
      );

      $this->upload->initialize($upload_conf);
      if (!$this->upload->do_upload('userfile')) {
        $data = array(
          'tanggal' => $tanggal,
          'id_kelompok' => $id_kelompok,
          'notulen' => $notulen
        );
        $this->m_rapat->save($data);
        echo json_encode(array("status" => TRUE));
      } else {
        $upload_data = $this->upload->data();
        $data = array(
          'tanggal' => $tanggal,
          'id_kelompok' => $id_kelompok,
          'notulen' => $notulen,
          'foto_rapat' => 'upload/foto_rapat/' .
            $upload_data['file_name']
        );
        $this->m_rapat->save($data);
        echo json_encode(array("status" => TRUE));
      }
    } else {
      echo json_encode(array(
        "status" => FALSE,
        "pesan" =>
        "Input tidak valid. Silahkan periksa kembali inputan anda!"
      ));
    }
  }


  function update()
  {
    $id = decrypt_url($this->input->get("q"));
    $this->form_validation->set_rules('tanggal', 'tanggal', 'required');
    $this->form_validation->set_rules('id_kelompok', 'id_kelompok', 'required');
    $this->form_validation->set_rules('notulen', 'notulen', 'required');

    if ($this->form_validation->run() != false) {
      $tanggal = $this->libku->tgl_mysql($this->input->post('tanggal', TRUE));
      $id_kelompok = decrypt_url($this->input->post('id_kelompok', TRUE));
      $notulen = $this->input->post('notulen', TRUE);


      date_default_timezone_set('Asia/Jakarta');
      $code = date("HdmiYs");
      $upload_conf = array(
        'upload_path' => realpath('./upload/foto_rapat/'),
        'allowed_types' => 'jpg|jpeg|png',
        'file_name' => $code
      );
      $this->upload->initialize($upload_conf);
      if (!$this->upload->do_upload('userfile')) {
        $data = array(
          'tanggal' => $tanggal,
          'id_kelompok' => $id_kelompok,
          'notulen' => $notulen,
        );

        $this->m_rapat->update(array(
          'id_rapat' => $id
        ), $data);
        echo json_encode(array("status" => TRUE));
      } else {
        $upload_data = $this->upload->data();
        $data = array(
          'tanggal' => $tanggal,
          'id_kelompok' => $id_kelompok,
          'notulen' => $notulen,
          'foto_rapat' => 'upload/foto_rapat/' .
            $upload_data['file_name']
        );
        $this->m_rapat->update(array(
          'id_rapat' => $id
        ), $data);
        echo json_encode(array("status" => TRUE));
      }
    } else {
      echo json_encode(array(
        "status" => FALSE,
        "pesan" => "Input tidak valid. 
      Silahkan periksa kembali inputan anda!"
      ));
    }
  }

  function get_berkas()
  {
    $id = decrypt_url($this->input->post("q"));
    $isi = $this->m_rapat->edit($id);
    $foto_absensi = $isi->foto_absensi ?: 'aset/img/no_berkas.jpg';
    $dokumentasi1 = $isi->dokumentasi1 ?: 'aset/img/no_berkas.jpg';
    $dokumentasi2 = $isi->dokumentasi2 ?: 'aset/img/no_berkas.jpg';
      
    $data['foto_absensi'] = base_url() . $foto_absensi;
    $data['dokumentasi1'] = base_url() . $dokumentasi1;
    $data['dokumentasi2'] = base_url() . $dokumentasi2;

    echo json_encode($data);
  }

  function upload_absensi()
  {
    $id_rapat = decrypt_url($this->input->post('id_rapat'));
    date_default_timezone_set('Asia/Jakarta');
    $code = date("HdmiYs");
    $upload_conf = array(
      'upload_path' => realpath('./upload/berkas_rapat/'),
      'allowed_types' => 'jpg|jpeg|png',
      'file_name' => $code
    );

    $this->upload->initialize($upload_conf);
    if (!$this->upload->do_upload('foto_absensi')) {
      echo json_encode(array("status" => FALSE, 
      'pesan' => "Pilih Foto Absensi Terlebih Dahulu!"));
    } else {
      $upload_data = $this->upload->data();
      $data = array(
        'foto_absensi' => 'upload/berkas_rapat/' . 
        $upload_data['file_name']
      );
      $this->m_rapat->update(
        array('id_rapat' => $id_rapat), $data);
      echo json_encode(array("status" => TRUE));
    }
  }

  function upload_dokumentasi1()
  {
    $id_rapat = decrypt_url($this->input->post('id_rapat'));
    date_default_timezone_set('Asia/Jakarta');
    $code = date("HdmiYs");
    $upload_conf = array(
      'upload_path' => realpath('./upload/berkas_rapat/'),
      'allowed_types' => 'jpg|jpeg|png',
      'file_name' => $code
    );
    $this->upload->initialize($upload_conf);
    if (!$this->upload->do_upload('dokumentasi1')) {
      echo json_encode(array("status" => FALSE, 
      'pesan' => "Pilih Foto Dokumentasi 1 Terlebih Dahulu!"));
    } else {
      $upload_data = $this->upload->data();
      $data = array(
        'dokumentasi1' => 'upload/berkas_rapat/' . 
        $upload_data['file_name']
      );
      $this->m_rapat->update(
        array('id_rapat' => $id_rapat), $data);
      echo json_encode(array("status" => TRUE));
    }
  }

  function upload_dokumentasi2()
  {
    $id_rapat = decrypt_url($this->input->post('id_rapat'));
    date_default_timezone_set('Asia/Jakarta');
    $code = date("HdmiYs");
    $upload_conf = array(
      'upload_path' => realpath('./upload/berkas_rapat/'),
      'allowed_types' => 'jpg|jpeg|png',
      'file_name' => $code
    );
    $this->upload->initialize($upload_conf);
    if (!$this->upload->do_upload('dokumentasi2')) {
      echo json_encode(array("status" => FALSE, 
      'pesan' => "Pilih Foto Dokumentasi 2 Terlebih Dahulu!"));
    } else {
      $upload_data = $this->upload->data();
      $data = array(
        'dokumentasi2' => 'upload/berkas_rapat/' . 
        $upload_data['file_name']
      );
      $this->m_rapat->update(
        array('id_rapat' => $id_rapat), $data);
      echo json_encode(array("status" => TRUE));
    }
  }

}
