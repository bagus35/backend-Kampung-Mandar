<?php
if ( !defined( 'BASEPATH' ) )exit( 'No direct script access allowed' );
class M_produksi_timbang extends CI_Model {
  var $table = 'produksi';
  var $id_key = "id_produksi";
  var $column_order = array( 'id_produksi', null );
  var $column_search = array( 'b.nama_perahu' );
  var $order = array( 'id_produksi' => 'DESC' );

  function __construct() {
    parent::__construct();
    $this->load->database();
  }
  private function _get_datatables_query() {
    $this->db->from( $this->table . ' a' );
    $this->db->join( 'perahu b', 'a.id_perahu = b.id_perahu' );
    $this->db->join( 'tempat_lelang c', 'a.id_tempat_lelang = c.id_tempat_lelang' );
    $this->db->join( 'ikan d', 'a.id_ikan = d.id_ikan' );
    $this->db->join( 'pembeli e', 'a.id_pembeli = e.id_pembeli', 'LEFT' );
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

    $start_date = $this->libku->tgl_mysql( $this->input->post( 'tanggal_awal' ) );
    $end_date = $this->libku->tgl_mysql( $this->input->post( 'tanggal_akhir' ) );
    $id = decrypt_url( $this->input->post( 'id' ) );

    $this->db->where( 'a.id_perahu', $id );
    if ( $start_date == $end_date ) {
      $this->db->where( 'a.tanggal', $start_date );
    } else {
      $this->db->where( 'a.tanggal >=', $start_date );
      $this->db->where( 'a.tanggal <=', $end_date );
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
    $start_date = $this->libku->tgl_mysql( $this->input->post( 'tanggal_awal' ) );
    $end_date = $this->libku->tgl_mysql( $this->input->post( 'tanggal_akhir' ) );
    $id = decrypt_url($this->input->post( 'id' ) );

    $this->db->where( 'id_perahu', $id );
    if ( $start_date == $end_date ) {
      $this->db->where( 'tanggal', $start_date );
    } else {
      $this->db->where( 'tanggal >=', $start_date );
      $this->db->where( 'tanggal <=', $end_date );
    }
    return $this->db->count_all_results();
  }
  

}
?>
