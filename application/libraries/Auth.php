<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 class Auth
 {
	 public function __construct() {
		$this->CI = & get_instance();
		$this->CI->load->library('session');
    }
	 
	 function cek()
	 {
		 $hak =  $this->CI->session->userdata('status');
		 if(!$hak == FALSE)
		 {
			 return TRUE;
		 }
		 else
		 {
			 return FALSE;
		 } 
	 }
	 function admin()
	 {
		$hak =  $this->CI->session->userdata('hak');
		 $session =  $this->CI->session->userdata('status');
		if($session == TRUE and $hak == "1")
		{
			return TRUE;
		}
		else
		{
			return FALSE; 
		} 
	 }
	 
	 function just_admin()
	 {
		$hak =  $this->CI->session->userdata('hak');
		if($hak == "1")
		{
			return TRUE;
		}
		else
		{
			return FALSE; 
		} 
	 }
	 
 }
?>