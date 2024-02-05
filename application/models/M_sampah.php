<?php
if ( !defined( 'BASEPATH' ) )exit( 'No direct script access allowed' );
class M_sampah extends CI_Model {
  var $table = 'sampah';
  var $id_key = "id_sampah";
  var $column_order = array( 'id_sampah', null );
  var $column_search = array( 'b.nama_nelayan' );
  var $order = array( 'id_sampah' => 'DESC' );

  function __construct() {
    parent::__construct();
    $this->load->database();
  }
  private function _get_datatables_query() {
    $this->db->from( $this->table . ' a' );
    $this->db->join( 'nelayan b', 'a.id_nelayan = b.id_nelayan' );
    $this->db->join( 'kelompok c', 'b.id_kelompok = c.id_kelompok' );
    $i = 0;
    foreach ( $this->column_search as $item ) {
      $cari = $this->input->post( 'cari' );
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

    $this->db->order_by( 'id_sampah', 'DESC' );

  }

  function get_datatables( $start, $limit, $id_kelompok, $id_nelayan ) {
    $this->_get_datatables_query();
    $this->db->limit( $limit, $start );
    if ( $id_kelompok != "-1" ) {
      $this->db->where( 'c.id_kelompok', $id_kelompok );
    }
    if ( $id_nelayan != "-1" ) {
      $this->db->where( 'b.id_nelayan', $id_nelayan );
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
    $this->db->from( $this->table . ' a' );
    $this->db->join( 'nelayan b', 'a.id_nelayan = b.id_nelayan' );
    $this->db->join( 'kelompok c', 'b.id_kelompok = c.id_kelompok' );
    if ( $id_kelompok != "-1" ) {
      $this->db->where( 'c.id_kelompok', $id_kelompok );
    }
    if ( $id_nelayan != "-1" ) {
      $this->db->where( 'b.id_nelayan', $id_nelayan );
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
    $this->db->order_by( 'id_sampah', 'DESC' );
    return $this->db->get()->result();
  }

  public function detail( $id ) {
    $this->db->from( $this->table . ' a' );
    $this->db->join( 'perahu b', 'a.id_perahu = b.id_perahu' );
    $this->db->join( 'tempat_lelang c', 'a.id_tempat_lelang = c.id_tempat_lelang' );
    $this->db->join( 'ikan d', 'a.id_ikan = d.id_ikan' );
    $this->db->where( $this->id_key, $id );
    return $this->db->get()->row();
  }

  function total_sampah_bulanan( $id_kelompok, $id_nelayan ) {
    date_default_timezone_set( 'Asia/Jakarta' );
    $this->db->select( 'SUM(berat_daur_ulang) as daur_ulang,SUM(berat_non_daur_ulang) as non_daur_ulang' );
    $this->db->from( $this->table . ' a' );
    $this->db->from( 'nelayan b', 'a.id_nelayan = b.id_nelayan','LEFT' );
    $this->db->from( 'kelompok c', 'b.id_kelompok = c.id_kelompok','LEFT' );
    $this->db->where( 'a.tanggal >=', date( 'Y-m-d' ) );
    $this->db->where( 'a.tanggal <=', date( 'Y-m-t' ) );
    $hak_akses = $this->input->post( 'hak' );
    if ( $id_kelompok != '-1' ) {
      $this->db->where( 'c.id_kelompok', $id_kelompok );
    }
	  
	if ( $id_nelayan != '-1' ) {
      $this->db->where( 'b.id_nelayan', $id_nelayan );
    }
    return $this->db->get()->row();
  }


}
?>
