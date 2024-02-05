<?php
if ( !defined( 'BASEPATH' ) )exit( 'No direct script access allowed' );
class M_ruas_jalan_user extends CI_Model {
  var $table = 'ruas_jalan';
  var $id_key = "id_ruas_jalan";
  var $column_order = array( 'id_ruas_jalan', null );
  var $column_search = array( 'a.nama_ruas' );
  var $order = array( 'a.id_ruas_jalan' => 'DESC' );

  function __construct() {
    parent::__construct();
    $this->load->database();
  }
  private function _get_datatables_query() {
    $this->db->select( '*' );
    $this->db->from( $this->table . ' a' );
    $this->db->join( 'kecamatan b', 'a.id_kecamatan = b.id_kecamatan' );
    $this->db->join( 'desa c', 'a.id_desa = c.id_desa' );
    $i = 0;
    foreach ( $this->column_search as $item ) {
      if ( $this->input->post( 'cari' ) ) {
        if ( $i === 0 ) {
          $this->db->group_start();
          $this->db->like( $item, $this->input->post( 'cari' ) );
        } else {
          $this->db->or_like( $item, $this->input->post( 'cari' ) );
        }
        if ( count( $this->column_search ) - 1 == $i )
          $this->db->group_end();
      }
      $i++;
    }

    $order = $this->order;
    $this->db->order_by( key( $order ), $order[ key( $order ) ] );
    $id_desa = $this->input->post( 'id_desa', TRUE );
    if ( $id_desa != "-1" ) {
      $this->db->where( 'a.id_desa', decrypt_url( $id_desa ) );
    }
    $id_kecamatan = $this->input->post( 'id_kecamatan', TRUE );
    if ( $id_kecamatan != "-1" ) {
      $this->db->where( 'a.id_kecamatan', decrypt_url( $id_kecamatan ) );
    }

  }

  function get_datatables( $start, $per_page ) {
    $this->_get_datatables_query();
    $this->db->limit( $per_page, $start );
    $query = $this->db->get();
    return $query->result();
  }

  function count_filtered() {
    $this->_get_datatables_query();
    $query = $this->db->get();
    return $query->num_rows();
  }
  public function count_all() {

    $this->db->from( $this->table );
    $id_desa = $this->input->post( 'id_desa', TRUE );
    if ( $id_desa != "-1" ) {
      $this->db->where( 'id_desa', decrypt_url( $id_desa ) );
    }
    $id_kecamatan = $this->input->post( 'id_kecamatan', TRUE );
    if ( $id_kecamatan != "-1" ) {
      $this->db->where( 'id_kecamatan', decrypt_url( $id_kecamatan ) );
    }
    return $this->db->count_all_results();
  }

}
?>
