<?php
if ( !defined( 'BASEPATH' ) )exit( 'No direct script access allowed' );
class M_produksi_rekap extends CI_Model {
  var $table = 'perahu';
  var $id_key = "id_perahu";
  var $column_order = array( 'id_perahu', null );
  var $column_search = array( 'nama_perahu' );
  var $order = array( 'nama_perahu' => 'DESC' );

  function __construct() {
    parent::__construct();
    $this->load->database();
  }
  private function _get_datatables_query() {
    $this->db->from( $this->table );
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
      $this->db->order_by( $this->column_order[ $_POST[ 'order' ][ '0' ][ 'column' ] ], $_POST[ 'order' ][ '0' ][ 'dir' ] );
    } else if ( isset( $this->order ) ) {
      $order = $this->order;
      $this->db->order_by( key( $order ), $order[ key( $order ) ] );
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

  function total_ikan( $id, $start_date, $end_date ) {
    $this->db->select( 'SUM(berat) as total_ikan' );
    $this->db->from( 'produksi' );
    $this->db->where( 'id_perahu', $id );
    if ( $start_date == $end_date ) {
      $this->db->where( 'tanggal', $start_date );
    } else {
      $this->db->where( 'tanggal >=', $start_date );
      $this->db->where( 'tanggal <=', $end_date );
    }

    $query = $this->db->get();
    return $query->row();
  }

  function total_pendapatan( $id, $start_date, $end_date ) {
    $this->db->select( 'SUM(total) as total_pendapatan' );
    $this->db->from( 'produksi' );
    $this->db->where( 'id_perahu', $id );

    if ( $start_date == $end_date ) {
      $this->db->where( 'tanggal', $start_date );
    } else {
      $this->db->where( 'tanggal >=', $start_date );
      $this->db->where( 'tanggal <=', $end_date );
    }
    $query = $this->db->get();
    return $query->row();
  }

  function get_nelayan( $id_perahu ) {
    $this->db->select( 'nama_nelayan' );
    $this->db->from( 'nelayan' );
    $this->db->where( 'id_perahu', $id_perahu );
    $query = $this->db->get();
    return $query;
  }

  function total_bensin( $id, $start_date, $end_date ) {
    $this->db->select( 'SUM(jumlah) as total_bensin,SUM(total_bbm) as total' );
    $this->db->from( 'bbm' );
    $this->db->where( 'id_perahu', $id );
    $this->db->where( 'jenis', 1 );

    if ( $start_date == $end_date ) {
      $this->db->where( 'tanggal', $start_date );
    } else {
      $this->db->where( 'tanggal >=', $start_date );
      $this->db->where( 'tanggal <=', $end_date );
    }
    $query = $this->db->get();
    return $query->row();
  }

  function total_solar( $id, $start_date, $end_date ) {
    $this->db->select( 'SUM(jumlah) as total_solar,SUM(total_bbm) as total' );
    $this->db->from( 'bbm' );
    $this->db->where( 'id_perahu', $id );
    $this->db->where( 'jenis', 2 );

    if ( $start_date == $end_date ) {
      $this->db->where( 'tanggal', $start_date );
    } else {
      $this->db->where( 'tanggal >=', $start_date );
      $this->db->where( 'tanggal <=', $end_date );
    }
    $query = $this->db->get();
    return $query->row();
  }

  function get_ikan( $id_ikan, $id, $start_date, $end_date ) {
    $this->db->select( 'SUM(berat) as total_ikan,SUM(total) as total' );
    $this->db->from( 'produksi' );
    $this->db->where( 'id_ikan', $id_ikan );
    $this->db->where( 'id_perahu', $id );
    if ( $start_date == $end_date ) {
      $this->db->where( 'tanggal', $start_date );
    } else {
      $this->db->where( 'tanggal >=', $start_date );
      $this->db->where( 'tanggal <=', $end_date );
    }

    $query = $this->db->get();
    return $query->row();
  }


}
?>
