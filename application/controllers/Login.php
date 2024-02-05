<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model(array('m_login'));
		$this->load->library('email');
	}
	public function index(){
		$session = $this->session->userdata('status');
		if ($session == FALSE) {
			$data['title'] = 'KUD MANDAR BERKAH MANDIRI - LOGIN';
			$this->load->view('login',$data);
		} else {
			redirect('home');
		}
	}
	public function validasi() {
		$this->form_validation->set_rules('username', 'username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			redirect('login');
		} else {
			$password = $this->input->post('password');
			$data= array(
				'username' => $this->input->post('username',TRUE),
				'password' => encrypt_url($password),
			);
			$cek = $this->m_login->cek($data);
			if($cek == 1){
				$user = $this->input->post('username');
				$x = $this->m_login->ambil_user($user);
				$newdata = array(
					'username' => $x->username,
					'hak'=>$x->hak_akses,
                    'id_user'=>encrypt_url($x->id_account),
                    'nama'=>$x->nama,
                    'email'=>$x->email,
					'status'=> TRUE,
                    'foto'=>$x->foto_profil,
					'id_kelompok'=>encrypt_url($x->id_kelompok),
					'id_nelayan'=>encrypt_url($x->id_nelayan),
					
                    'pw'=>$x->password,
				);
				$this->session->set_userdata($newdata);
				echo json_encode(array('status'=>TRUE));
			}
			else{
				echo json_encode(array('status'=>FALSE));
			}
		}
	}
	public function logout() {
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . 'GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-chace');
		$this->session->sess_destroy();
		redirect(base_url());
	}
	function cek_status(){
		echo json_encode($this->hak->cek());
	}
	public function send_email(){
			$data= array(
				'email' => trim($this->input->post('email',TRUE)),
			);
			$cek = $this->m_login->cek($data);
			if($cek == 1){
				$this->load->library('email');
				$config['protocol']    = 'mail';
				$config['smtp_host']    = 'smtp.gmail.com';
				$config['smtp_port']    = '465';
				$config['smtp_crypto']    = 'ssl';
				$config['smtp_timeout'] = '7';
				$config['smtp_user']    = 'sisdukhoiruummah@gmail.com';
				$config['smtp_pass']    = 'sh11021980';
				$config['charset']    = 'utf-8';
				$config['newline']    = "\r\n";
				$config['mailtype'] = 'html';
				$config['validation'] = TRUE;
				$this->email->initialize($config);
				$mail = trim($this->input->post('email'));
				$x = $this->m_login->ambil_mail($mail);
				$from_email = "sisdukhoiruummah@gmail.com";
				$to_email = $mail;
				$data = array
				(
					'nama'=> $x->nama,
					'username'=> $x->username,
					'password'=> decrypt_url($x->password),
				);
				$body = $this->load->view('email.php',$data,TRUE);
				$this->email->from($from_email, 'SISDU KHOIRU UMMAH');
				$this->email->to($to_email);
				$this->email->subject('Akun Login');
				$this->email->message($body);
				if($this->email->send())
				echo json_encode(array('status'=>TRUE));
				else
				echo json_encode(array('status'=>FALSE,'pesan'=>"email tidak dikirim"));
			}
			else{
				echo json_encode(array('status'=>FALSE,'pesan'=>"email tidak terdaftar"));
			}
	}
}
