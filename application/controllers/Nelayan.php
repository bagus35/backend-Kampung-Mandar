<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Nelayan extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model(array(
      'm_nelayan', 'm_kelompok',
      'm_metode_tangkap', 'm_perahu'
    ));
    $this->load->library(array('form_validation', 'libku'));
    if (!$this->auth->cek()) {
      $this->session->sess_destroy();
      redirect(base_url());
      exit();
    }
  }

  function index()
  {
    $data['title'] = "Data Nelayan";
    $data['judul'] = "Data Nelayan";
    $data['kelompok'] = $this->m_kelompok->get_all();
    $data['metode'] = $this->m_metode_tangkap->get_all();
    $data['perahu'] = $this->m_perahu->get_all();
    $this->template->display('content/nelayan', $data);
  }

  function berkas()
  {
    $id = decrypt_url($this->input->get("q"));
    $data['title'] = "Berkas Nelayan";
    $data['judul'] = "Berkas Nelayan";
    $data['isi'] = $this->m_nelayan->detail($id);
    $this->template->display('content/berkas_nelayan', $data);
  }

  function ajax_list()
  {
    $list = $this->m_nelayan->get_datatables();
    $data = array();
    $no = $this->input->post('start');

    foreach ($list as $d) {
      $foto = $d->foto ?: 'aset/img/belum_diupload.jpg';
      $no++;
      $row = array();

      $row[] = ' <div class="btn-group">
      <a href="javascript:;" class="btn btn-sm btn-warning 
      btn-rounded" data-toggle="tooltip" 
      data-original-title="Delete" 
      onClick="edit_data(' . "'" . encrypt_url($d->id_nelayan) . "'" . ')"> 
      Edit </a> 
      
      <a href="javascript:;" 
      class="btn btn-sm btn-danger btn-rounded" 
      data-toggle="tooltip" data-original-title="Logo" 
      onClick="delete_data(' . "'" . encrypt_url($d->id_nelayan) . "'" . ')">Delete</a>
	  
	  <a href="' . base_url() . 'nelayan/berkas?q=' . encrypt_url($d->id_nelayan) . '" class="btn btn-sm btn-success btn-rounded" data-toggle="tooltip" data-original-title="lihat berkas" > Lihat Berkas </a>
	  </div>';

      $row[] = $no;
      $row[] = '<a href="javascript:void(0)" 
      onclick="lihat_foto(' . "'" . base_url() . 
      $foto . "'" . ')" ><img src="' . base_url() . 
      $foto . '" class="img-fluid"></a>';
      $row[] = $d->nama_nelayan;
      $row[] = $d->nama_perahu ?: '-';
      $row[] = $d->kepemilikkan_perahu == 1 ? 'Milik Sendiri' : 'Orang Lain';
      $row[] = $d->nama_kelompok;
      $row[] = $d->metode_tangkap;
      $data[] = $row;
    }
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->m_nelayan->count_all(),
      "recordsFiltered" => $this->m_nelayan->count_filtered(),
      "data" => $data
    );
    echo json_encode($output);
  }

  function edit()
  {
    $k = $this->m_nelayan->edit(
      decrypt_url($this->input->post('q', TRUE)));

    $data['nama_nelayan'] = $k->nama_nelayan;
    $data['id_perahu'] = encrypt_url($k->id_perahu);
    $data['id_kelompok'] = encrypt_url($k->id_kelompok);
    $data['kepemilikkan_perahu'] = $k->kepemilikkan_perahu;
    $data['id_metode_tangkap'] = encrypt_url($k->id_metode_tangkap);
    echo json_encode($data);
  }

  function delete()
  {
    $id = decrypt_url($this->input->post("q"));
    if ($id != "" || $id != NULL) {
      $i = $this->m_nelayan->edit($id);
      $l = $i->foto;
      if ($l != NULL) {
        unlink($l);
      }
      $this->m_nelayan->delete_by_id($id);
      echo json_encode(array("status" => TRUE));
    } else {
      echo json_encode(array("status" => FALSE));
    }
  }

  function save()
  {
    $this->form_validation->set_rules('nama_nelayan', 'nama_nelayan', 'required');
    $this->form_validation->set_rules('id_perahu', 'id_perahu', 'required');
    $this->form_validation->set_rules('kepemilikkan_perahu', 'kepemilikan_perahu', 'required');
    $this->form_validation->set_rules('id_kelompok', 'id_kelompok', 'required');
    $this->form_validation->set_rules('id_metode_tangkap', 'id_metode_tangkap', 'required');
    
    if ($this->form_validation->run() != false) {
      $nama_nelayan = $this->input->post('nama_nelayan');
      $id_perahu = $this->input->post('id_perahu');
      $kepemilikkan_perahu = $this->input->post('kepemilikkan_perahu');
      $id_kelompok = $this->input->post('id_kelompok');
      $id_metode_tangkap = $this->input->post('id_metode_tangkap');
      date_default_timezone_set('Asia/Jakarta');
      $code = date("HdmiYs");
      $upload_conf = array(
        'upload_path' => realpath('./upload/foto/'),
        'allowed_types' => 'jpg|jpeg|png',
        'file_name' => $code
      );
      $this->upload->initialize($upload_conf);
      if (!$this->upload->do_upload('userfile')) {
        $data = array(
          'nama_nelayan' => $nama_nelayan,
          'id_perahu' => decrypt_url($id_perahu),
          'kepemilikkan_perahu' => $kepemilikkan_perahu,
          'id_kelompok' => decrypt_url($id_kelompok),
          'id_metode_tangkap' => decrypt_url($id_metode_tangkap),
        );
        $this->m_nelayan->save($data);
        echo json_encode(array("status" => TRUE));
      } else {
        $upload_data = $this->upload->data();
        $data = array(
          'nama_nelayan' => $nama_nelayan,
          'id_perahu' => decrypt_url($id_perahu),
          'kepemilikkan_perahu' => $kepemilikkan_perahu,
          'id_kelompok' => decrypt_url($id_kelompok),
          'id_metode_tangkap' => decrypt_url($id_metode_tangkap),
          'foto' => 'upload/foto/' . $upload_data['file_name']
        );
        $this->m_nelayan->save($data);
        echo json_encode(array("status" => TRUE));
      }
    } else {
      echo json_encode(array("status" => FALSE));
    }
  }

  function update()
  {
    $id = decrypt_url($this->input->get("q"));
    $this->form_validation->set_rules('nama_nelayan', 'nama_nelayan', 'required');
    $this->form_validation->set_rules('id_perahu', 'id_perahu', 'required');
    $this->form_validation->set_rules('kepemilikkan_perahu', 'kepemilikan_perahu', 'required');
    $this->form_validation->set_rules('id_kelompok', 'id_kelompok', 'required');
    $this->form_validation->set_rules('id_metode_tangkap', 'id_metode_tangkap', 'required');
    if ($this->form_validation->run() != false) {
      $nama_nelayan = $this->input->post('nama_nelayan');
      $id_perahu = $this->input->post('id_perahu');
      $kepemilikkan_perahu = $this->input->post('kepemilikkan_perahu');
      $id_kelompok = $this->input->post('id_kelompok');
      $id_metode_tangkap = $this->input->post('id_metode_tangkap');
      date_default_timezone_set('Asia/Jakarta');
      $code = date("HdmiYs");
      $upload_conf = array(
        'upload_path' => realpath('./upload/foto/'),
        'allowed_types' => 'jpg|jpeg|png',
        'file_name' => $code
      );
      $this->upload->initialize($upload_conf);
      if (!$this->upload->do_upload('userfile')) {
        $data = array(
          'nama_nelayan' => $nama_nelayan,
          'id_perahu' => decrypt_url($id_perahu),
          'kepemilikkan_perahu' => $kepemilikkan_perahu,
          'id_kelompok' => decrypt_url($id_kelompok),
          'id_metode_tangkap' => decrypt_url($id_metode_tangkap),
        );
        $this->m_nelayan->update(array('id_nelayan' => $id), $data);
        echo json_encode(array("status" => TRUE));
      } else {
        $upload_data = $this->upload->data();
        $data = array(
          'nama_nelayan' => $nama_nelayan,
          'id_perahu' => decrypt_url($id_perahu),
          'kepemilikkan_perahu' => $kepemilikkan_perahu,
          'id_kelompok' => decrypt_url($id_kelompok),
          'id_metode_tangkap' => decrypt_url($id_metode_tangkap),
          'foto' => 'upload/foto/' . $upload_data['file_name']
        );
        $this->m_nelayan->update(array('id_nelayan' => $id), $data);
        echo json_encode(array("status" => TRUE));
      }
    } else {
      echo json_encode(array("status" => FALSE));
    }
  }

  function get_berkas()
  {
    $id = decrypt_url($this->input->post("q"));
    $isi = $this->m_nelayan->edit($id);
    $ktp = $isi->ktp ?: 'aset/img/no_berkas.jpg';
    $npwp = $isi->npwp ?: 'aset/img/no_berkas.jpg';
    $kusuka = $isi->kusuka ?: 'aset/img/no_berkas.jpg';
    $nib = $isi->nib ?: 'aset/img/no_berkas.jpg';
    $data['ktp'] = base_url() . $ktp;
    $data['npwp'] = base_url() . $npwp;
    $data['kusuka'] = base_url() . $kusuka;
    $data['nib'] = base_url() . $nib;
    echo json_encode($data);
  }

  function upload_ktp()
  {
    $id_nelayan = decrypt_url($this->input->post('id_nelayan'));
    date_default_timezone_set('Asia/Jakarta');
    $code = date("HdmiYs");
    $upload_conf = array(
      'upload_path' => realpath('./upload/foto_berkas/'),
      'allowed_types' => 'jpg|jpeg|png',
      'file_name' => $code
    );
    $this->upload->initialize($upload_conf);
    if (!$this->upload->do_upload('ktp')) {
      echo json_encode(array("status" => FALSE, 'pesan' => "Pilih Foto KTP Terlebih Dahulu!"));
    } else {
      $upload_data = $this->upload->data();
      $data = array(
        'ktp' => 'upload/foto_berkas/' . $upload_data['file_name']
      );
      $this->m_nelayan->update(array('id_nelayan' => $id_nelayan), $data);
      echo json_encode(array("status" => TRUE));
    }
  }

  function upload_npwp()
  {
    $id_nelayan = decrypt_url($this->input->post('id_nelayan'));
    date_default_timezone_set('Asia/Jakarta');
    $code = date("HdmiYs");
    $upload_conf = array(
      'upload_path' => realpath('./upload/foto_berkas/'),
      'allowed_types' => 'jpg|jpeg|png',
      'file_name' => $code
    );
    $this->upload->initialize($upload_conf);
    if (!$this->upload->do_upload('npwp')) {
      echo json_encode(array("status" => FALSE, 'pesan' => "Pilih Foto NPWP Terlebih Dahulu!"));
    } else {
      $upload_data = $this->upload->data();
      $data = array(
        'npwp' => 'upload/foto_berkas/' . $upload_data['file_name']
      );
      $this->m_nelayan->update(array('id_nelayan' => $id_nelayan), $data);
      echo json_encode(array("status" => TRUE));
    }
  }


  function upload_kusuka()
  {
    $id_nelayan = decrypt_url($this->input->post('id_nelayan'));
    date_default_timezone_set('Asia/Jakarta');
    $code = date("HdmiYs");
    $upload_conf = array(
      'upload_path' => realpath('./upload/foto_berkas/'),
      'allowed_types' => 'jpg|jpeg|png',
      'file_name' => $code
    );
    $this->upload->initialize($upload_conf);
    if (!$this->upload->do_upload('kusuka')) {
      echo json_encode(array("status" => FALSE, 'pesan' => "Pilih Foto Kusuka Terlebih Dahulu!"));
    } else {
      $upload_data = $this->upload->data();
      $data = array(
        'kusuka' => 'upload/foto_berkas/' . $upload_data['file_name']
      );
      $this->m_nelayan->update(array('id_nelayan' => $id_nelayan), $data);
      echo json_encode(array("status" => TRUE));
    }
  }

  function upload_nib()
  {
    $id_nelayan = decrypt_url($this->input->post('id_nelayan'));
    date_default_timezone_set('Asia/Jakarta');
    $code = date("HdmiYs");
    $upload_conf = array(
      'upload_path' => realpath('./upload/foto_berkas/'),
      'allowed_types' => 'jpg|jpeg|png',
      'file_name' => $code
    );
    $this->upload->initialize($upload_conf);
    if (!$this->upload->do_upload('nib')) {
      echo json_encode(array("status" => FALSE, 'pesan' => "Pilih Foto NIB Terlebih Dahulu!"));
    } else {
      $upload_data = $this->upload->data();
      $data = array(
        'nib' => 'upload/foto_berkas/' . $upload_data['file_name']
      );
      $this->m_nelayan->update(
        array('id_nelayan' => $id_nelayan), $data);
      echo json_encode(array("status" => TRUE));
    }
  }
}
