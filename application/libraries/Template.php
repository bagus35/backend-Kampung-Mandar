<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template {	
	protected $_ci;
	function __construct(){
		$this->_ci = &get_instance();
	}
	function display($template, $data = null) {	
		$data['content'] 	= $this->_ci->load->view($template, $data,true);
		$data['sidebar'] 	= $this->_ci->load->view('main/sidebar', $data,true);
		$data['header'] 	= $this->_ci->load->view('main/header', $data,true);
		$data['judul'] 	= $this->_ci->load->view('main/judul', $data,true);
		$data['loading'] 	= $this->_ci->load->view('main/loading', $data,true);
		$this->_ci->load->view('/template.php', $data);
	}
}