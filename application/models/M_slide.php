<?php
if ( !defined( 'BASEPATH' ) )exit( 'No direct script access allowed' );
class M_slide extends CI_Model {
  var $table = 'slide';
  var $id_key = "id_slide";
  var $column_order = array( 'id_slide', null );
  var $column_search = array( 'no_urut' );
  var $order = array( 'id_slide' => 'DESC' );

  function __construct() {
    parent::__construct();
    $this->load->database();
  }
  private function _get_datatables_query() {
    $this->db->select( '*' );
    $this->db->from( $this->table );
    $order = $this->order;
    $this->db->order_by( key( $order ), $order[ key( $order ) ] );
  }

  function get_datatables() {
    $this->_get_datatables_query();
    if ( $this->input->post( 'show' ) != -1 )
      $this->db->limit( $this->input->post( 'show' ), $_POST[ 'start' ] );
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
    return $this->db->count_all_results();
  }
  public function save( $data ) {
    $this->db->insert( $this->table, $data );
    return $this->db->insert_id();
  }
  public function edit( $id ) {
    $this->db->where( $this->id_key, $id );
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

  function get_all() {
    $this->db->select( '*' );
    $this->db->from( $this->table );
    $this->db->order_by( 'no_urut', 'ASC' );
    $query = $this->db->get();
    return $query->result();
  }


}
?>
