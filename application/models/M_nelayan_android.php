<?php
if ( !defined( 'BASEPATH' ) )exit( 'No direct script access allowed' );
class M_nelayan_android extends CI_Model {
  var $table = 'nelayan';
  var $id_key = "id_nelayan";
  var $column_order = array( 'id_nelayan', null );
  var $column_search = array( 'nama_nelayan' );
  var $order = array( 'id_nelayan' => 'DESC' );

  function __construct() {
    parent::__construct();
    $this->load->database();
  }
  private function _get_datatables_query() {
    $this->db->from( $this->table );
    $i = 0;
    foreach ( $this->column_search as $item ) {
      $cari = $this->input->post( 'cari', TRUE );
      if ( $cari ) {
        if ( $i === 0 ) {
          $this->db->group_start();
          $this->db->like( $item, $cari );
        } else {
          $this->db->or_like( $item, $cari );
        }
        if ( count( $this->column_search ) - 1 == $i )
          $this->db->group_end();
      }
      $i++;
    }
    $this->db->order_by( 'nama_nelayan', 'ASC' );

  }

  function get_datatables( $limit, $start, $id_kelompok, $id_nelayan ) {
    $this->_get_datatables_query();
    $this->db->limit( $limit, $start );
    if ( $id_kelompok != "-1" ) {
      $this->db->where( 'id_kelompok', $id_kelompok );
    }
    if ( $id_nelayan != "-1" ) {
      $this->db->where( 'id_nelayan', $id_nelayan );
    }
    $query = $this->db->get();
    return $query->result();
  }

  function count_filtered() {
    $this->_get_datatables_query();
    $query = $this->db->get();
    return $query->num_rows();
  }
  public function count_all( $id_kelompok, $id_nelayan ) {
    $this->db->from( $this->table );
    if ( $id_kelompok != "-1" ) {
      $this->db->where( 'id_kelompok', $id_kelompok );
    }
    if ( $id_nelayan != "-1" ) {
      $this->db->where( 'id_nelayan', $id_nelayan );
    }
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
    $this->db->order_by( 'nama_nelayan', 'ASC' );
    return $this->db->get()->result();
  }

  public function detail( $id ) {
    $this->db->from( $this->table . ' a' );
    $this->db->join( 'kelompok b', 'a.id_kelompok = b.id_kelompok' );
    $this->db->join( 'metode_tangkap c', 'a.id_metode_tangkap = c.id_metode_tangkap' );
    $this->db->join( 'perahu d', 'a.id_perahu = d.id_perahu', 'LEFT' );
    $this->db->where( $this->id_key, $id );
    return $this->db->get()->row();
  }

  function get_nelayan( $id ) {
    $this->db->select( 'id_nelayan,nama_nelayan' );
    $this->db->from( 'nelayan' );
    $this->db->order_by( 'nama_nelayan', 'ASC' );
    return $this->db->get()->result();
  }


  public function get_perahu( $id ) {
    $this->db->where( $this->id_key, $id );
    return $this->db->get( $this->table );
  }


}
?>
