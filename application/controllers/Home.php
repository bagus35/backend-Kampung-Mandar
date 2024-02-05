<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Home extends CI_Controller {
  public function __construct() {
    parent::__construct();
    if ( !$this->auth->cek() ) {
      $this->session->sess_destroy();
      redirect( base_url() );
      exit();
    }
  }
  public function index() {
    $data[ 'title' ] = 'KUD MANDAR BERKAH BAHARI - HOME';
    $data[ 'judul' ] = 'KUD MANDAR BERKAH BAHARI';
    $this->template->display( 'content/home', $data );
  }



}