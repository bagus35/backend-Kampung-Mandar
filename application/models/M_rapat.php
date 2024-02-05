<?php
if ( !defined( 'BASEPATH' ) )exit( 'No direct script access allowed' );
class M_rapat extends CI_Model {
  var $table = 'rapat_bulanan';
  var $id_key = "id_rapat";
  var $column_order = array( 'id_rapat', null );
  var $column_search = array( 'b.nama_kelompok' );
  var $order = array( 'id_rapat' => 'DESC' );

  function __construct() {
    parent::__construct();
    $this->load->database();
  }
  private function _get_datatables_query() {
    $this->db->from( $this->table . ' a' );
    $this->db->join( 'kelompok b', 'a.id_kelompok = b.id_kelompok' );
    $i = 0;

    foreach ( $this->column_search as $item ) {
      if ( $_POST[ 'search' ][ 'value' ] ) {
        if ( $i === 0 ) {
          $this->db->group_start();
          $this->db->like( $item, $_POST[ 'search' ][ 'value' ] );
        } else {
          $this->db->or_like( $item, $_POST[ 'search' ][ 'value' ] );
        }
        if ( count( $this->column_search ) - 1 == $i )
          $this->db->group_end();
      }
      $i++;
    }

    if ( isset( $_POST[ 'order' ] ) ) {
      $this->db->order_by( 
        $this->column_order[ $_POST[ 'order' ][ '0' ][ 'column' ] ], 
        $_POST[ 'order' ][ '0' ][ 'dir' ] );
    } else if ( isset( $this->order ) ) {
      $order = $this->order;
      $this->db->order_by( key( $order ), 
      $order[ key( $order ) ] );
    }

  }

  function get_datatables() {
    $this->_get_datatables_query();
    if ( $_POST[ 'length' ] != -1 )
      $this->db->limit( $_POST[ 'length' ], $_POST[ 'start' ] );
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
    $this->db->from( $this->table );
    $this->db->order_by( 'id_rapat', 'ASC' );
    return $this->db->get()->result();
  }

  public function detail( $id ) {
    $this->db->from( $this->table . ' a' );
    $this->db->join( 'kelompok b', 'a.id_kelompok = b.id_kelompok' );
    $this->db->where( $this->id_key, $id );
    return $this->db->get()->row();
  }

}
