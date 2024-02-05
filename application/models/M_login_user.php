<?php
if ( !defined( 'BASEPATH' ) )exit( 'No direct script access allowed' );
class M_login_user extends CI_Model {
  var $table = 'user';
  var $id_key = "id_user";
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

  function ambil_user( $no_hp ) {
    $this->db->select( 'a.id_user,a.no_hp,a.nama,a.alamat,a.foto_profil,b.kecamatan,c.desa,a.id_kecamatan,a.id_desa' );
    $this->db->from( 'user a' );
    $this->db->join( 'kecamatan b', 'a.id_kecamatan = b.id_kecamatan' );
    $this->db->join( 'desa c', 'a.id_desa = c.id_desa' );
    $this->db->where( 'a.no_hp', $no_hp );
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
}
/* Location: ./application/model/Administrator_model.php */