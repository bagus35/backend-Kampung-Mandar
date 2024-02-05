<?php
if ( !defined( 'BASEPATH' ) )exit( 'No direct script access allowed' );
class M_tanggapan extends CI_Model {
  var $table = 'tanggapan';
  var $id_key = "id_tanggapan";
  var $column_order = array( 'id_tanggapan', null );
  var $column_search = array( 'tanggapan' );
  var $order = array( 'id_tanggapan' => 'DESC' );

  function __construct() {
    parent::__construct();
    $this->load->database();
  }
  private function _get_datatables_query() {
    $this->db->select( '*' );
    $this->db->from( $this->table );
    $i = 0;
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
    $id_komplain = $this->input->post( 'id_komplain' );
    $this->db->where( 'id_komplain', decrypt_url( $id_komplain ) );

  }

  function get_datatables() {
    $this->_get_datatables_query();
    if ( $this->input->post( 'show' ) != -1 )
      $this->db->limit( $this->input->post( 'show' ), $this->input->post( 'start' ) );
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
    $id_komplain = $this->input->post( 'id_komplain' );
    $this->db->where( 'id_komplain', decrypt_url( $id_komplain ) );
    return $this->db->count_all_results();
  }
  public function save( $data ) {
    $this->db->insert( $this->table, $data );
    return $this->db->insert_id();
  }
  public function edit( $id ) {
    $this->db->select( 'a.tanggapan,b.status' );
    $this->db->from( $this->table . ' a' );
    $this->db->join( 'komplain b', 'a.id_komplain = b.id_komplain' );
    $this->db->where( 'a.id_tanggapan', $id );
    return $this->db->get( $this->table )->row();
  }
  public function update( $where, $data ) {
    $this->db->update( $this->table, $data, $where );
    return $this->db->affected_rows();
  }
  public function delete_by_id( $id ) {
    $this->db->where( $this->id_key, $id );
    $this->db->delete( $this->table );
  }

}
?>
