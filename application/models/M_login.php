<?php
if ( !defined( 'BASEPATH' ) )exit( 'No direct script access allowed' );
class M_login extends CI_Model {
  var $table = 'account';
  var $id_key = "id_account";
  var $username = "username";

  function __construct() {
    parent::__construct();
    $this->load->database();
  }

  function cek( $data ) {
    return $this->db->get_where( $this->table, $data )->num_rows();
  }

  function cek_id( $id_user, $username ) {
    $this->db->where( 'nama!=', $id_user );
    $this->db->where( $this->username, $username );
    return $this->db->get( $this->table )->num_rows();
  }

  function ambil_user( $user ) {
    $this->db->where( $this->username, $user );
    return $this->db->get( $this->table )->row();
  }

  function ambil_mail( $mail ) {
    $this->db->where( "email", $mail );
    return $this->db->get( $this->table )->row();
  }

  function tampil() {
    return $this->db->get( $this->table )->result();
  }

  function save( $data ) {
    $this->db->insert( $this->table, $data );
  }


  function delete( $id_user ) {
    $this->db->where( $this->id_key, $id_user );
 	   $this->db->delete( $this->table );
  }
	
function update( $where, $data ) {
    $this->db->update( $this->table, $data, $where );
    return $this->db->affected_rows();
  } 

  function edit( $id_user ) {
    $this->db->where( $this->id_key, $id_user );
    return $this->db->get( $this->table )->row();
  }

  function edit_2( $id_user ) {
    $this->db->where( 'nama', $id_user );
    return $this->db->get( $this->table )->row();
  }

  function update_2( $id_user, $data ) {
    $this->db->where( 'nama', $id_user );
    $this->db->update( $this->table, $data );
  }

  function get_hak() {
    $this->db->select( 'hak_akses,' . $this->id_key );
    return $this->db->get( $this->table )->row();
  }

  function ambil_user_by_hp( $no_hp ) {
    $this->db->where( "no_hp", $no_hp );
    return $this->db->get( $this->table )->row();
  }
	
	  function cek_user( $data ) {
    return $this->db->get_where( $this->table, $data );
  }
}
/* Location: ./application/model/Administrator_model.php */