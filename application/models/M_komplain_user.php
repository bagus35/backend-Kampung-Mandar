<?php
if ( !defined( 'BASEPATH' ) )exit( 'No direct script access allowed' );
class M_komplain_user extends CI_Model {
  var $table = 'komplain';
  var $id_key = "id_komplain";
  var $column_order = array( 'id_komplain', null );
  var $column_search = array( 'c.nama_ruas' );
  var $order = array( 'a.id_komplain' => 'DESC' );

  function __construct() {
    parent::__construct();
    $this->load->database();
  }
  private function _get_datatables_query() {
    $this->db->select( 'a.id_komplain,a.tanggal,a.foto_komplain,a.koordinat,a.status,a.keterangan,a.status,a.alasan,c.nama_ruas,d.kecamatan,e.desa' );
    $this->db->from( $this->table . ' a' );
    $this->db->join( 'ruas_jalan c', 'a.id_ruas_jalan = c.id_ruas_jalan' );
    $this->db->join( 'kecamatan d', 'c.id_kecamatan = d.id_kecamatan' );
    $this->db->join( 'desa e', 'c.id_desa = e.id_desa' );
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
    $id_user = $this->input->post( 'user', TRUE );
    $this->db->where( 'a.id_user', decrypt_url( $id_user ) );


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
    $id_user = $this->input->post( 'user', TRUE );
    $this->db->where( 'id_user', decrypt_url( $id_user ) );
    return $this->db->count_all_results();
  }

}
?>
