<?php
if ( !defined( 'BASEPATH' ) )exit( 'No direct script access allowed' );
class M_ruas_jalan extends CI_Model {
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

  public function detail( $id ) {
    $this->db->select( '*' );
    $this->db->from( $this->table . ' a' );
    $this->db->join( 'kecamatan b', 'a.id_kecamatan = b.id_kecamatan' );
    $this->db->join( 'desa c', 'a.id_desa = c.id_desa' );
    $this->db->where( $this->id_key, $id );
    return $this->db->get()->row();
  }


  public function cetak( $id_kecamatan, $id_desa ) {
    $this->db->select( '*' );
    $this->db->from( $this->table . ' a' );
    $this->db->join( 'kecamatan b', 'a.id_kecamatan = b.id_kecamatan' );
    $this->db->join( 'desa c', 'a.id_desa = c.id_desa' );
    if ( $id_desa != "-1" ) {
      $this->db->where( 'a.id_desa', decrypt_url( $id_desa ) );
    }
    if ( $id_kecamatan != "-1" ) {
      $this->db->where( 'a.id_kecamatan', decrypt_url( $id_kecamatan ) );
    }
    $this->db->order_by( 'nama_ruas', 'ASC' );
    return $this->db->get()->result();
  }

  public function total_pajang() {
    $this->db->select_sum( 'panjang', 'total' );
    $id_kecamatan = $this->input->post( 'q' );
    if ( $id_kecamatan != '-1' ) {
      $this->db->where( 'id_kecamatan', decrypt_url( $id_kecamatan ) );
    }
    $this->db->from( $this->table );
    return $this->db->get()->row();
  }

  public function total_ruas() {
    $id_kecamatan = $this->input->post( 'q' );
    if ( $id_kecamatan != '-1' ) {
      $this->db->where( 'id_kecamatan', decrypt_url( $id_kecamatan ) );
    }
    return $this->db->get( $this->table )->num_rows();
  }

  public function total_nasional() {
    $this->db->where( 'status_jalan', 1 );
    $id_kecamatan = $this->input->post( 'q' );
    if ( $id_kecamatan != '-1' ) {
      $this->db->where( 'id_kecamatan', decrypt_url( $id_kecamatan ) );
    }
    return $this->db->get( $this->table )->num_rows();
  }

  public function total_provinsi() {
    $id_kecamatan = $this->input->post( 'q' );
    if ( $id_kecamatan != '-1' ) {
      $this->db->where( 'id_kecamatan', decrypt_url( $id_kecamatan ) );
    }
    $this->db->where( 'status_jalan', 2 );
    return $this->db->get( $this->table )->num_rows();
  }

  public function total_kabupaten() {
    $id_kecamatan = $this->input->post( 'q' );
    if ( $id_kecamatan != '-1' ) {
      $this->db->where( 'id_kecamatan', decrypt_url( $id_kecamatan ) );
    }
    $this->db->where( 'status_jalan', 3 );
    return $this->db->get( $this->table )->num_rows();
  }

  public function total_kota() {
    $id_kecamatan = $this->input->post( 'q' );
    if ( $id_kecamatan != '-1' ) {
      $this->db->where( 'id_kecamatan', decrypt_url( $id_kecamatan ) );
    }
    $this->db->where( 'status_jalan', 4 );
    return $this->db->get( $this->table )->num_rows();
  }

  public function total_desa() {
    $id_kecamatan = $this->input->post( 'q' );
    if ( $id_kecamatan != '-1' ) {
      $this->db->where( 'id_kecamatan', decrypt_url( $id_kecamatan ) );
    }
    $this->db->where( 'status_jalan', 5 );
    return $this->db->get( $this->table )->num_rows();
  }


  public function panjang_nasional() {
    $this->db->select_sum( 'panjang', 'total' );
    $this->db->where( 'status_jalan', 1 );
    $id_kecamatan = $this->input->post( 'q' );
    if ( $id_kecamatan != '-1' ) {
      $this->db->where( 'id_kecamatan', decrypt_url( $id_kecamatan ) );
    }
    return $this->db->get( $this->table )->row();
  }

  public function panjang_provinsi() {
    $this->db->select_sum( 'panjang', 'total' );
    $id_kecamatan = $this->input->post( 'q' );
    if ( $id_kecamatan != '-1' ) {
      $this->db->where( 'id_kecamatan', decrypt_url( $id_kecamatan ) );
    }
    $this->db->where( 'status_jalan', 2 );
    return $this->db->get( $this->table )->row();
  }

  public function panjang_kabupaten() {
    $this->db->select_sum( 'panjang', 'total' );
    $id_kecamatan = $this->input->post( 'q' );
    if ( $id_kecamatan != '-1' ) {
      $this->db->where( 'id_kecamatan', decrypt_url( $id_kecamatan ) );
    }
    $this->db->where( 'status_jalan', 3 );
    return $this->db->get( $this->table )->row();
  }

  public function panjang_kota() {
    $this->db->select_sum( 'panjang', 'total' );
    $id_kecamatan = $this->input->post( 'q' );
    if ( $id_kecamatan != '-1' ) {
      $this->db->where( 'id_kecamatan', decrypt_url( $id_kecamatan ) );
    }
    $this->db->where( 'status_jalan', 4 );
    return $this->db->get( $this->table )->row();
  }

  public function panjang_desa() {
    $this->db->select_sum( 'panjang', 'total' );
    $id_kecamatan = $this->input->post( 'q' );
    if ( $id_kecamatan != '-1' ) {
      $this->db->where( 'id_kecamatan', decrypt_url( $id_kecamatan ) );
    }
    $this->db->where( 'status_jalan', 5 );
    return $this->db->get( $this->table )->row();
  }


  public function kondisi_baik() {
    $this->db->select_sum( 'kondisi_baik', 'total' );
    $id_kecamatan = $this->input->post( 'q' );
    if ( $id_kecamatan != '-1' ) {
      $this->db->where( 'id_kecamatan', decrypt_url( $id_kecamatan ) );
    }
    $this->db->from( $this->table );
    return $this->db->get()->row();
  }

  public function kondisi_sedang() {
    $this->db->select_sum( 'kondisi_sedang', 'total' );
    $id_kecamatan = $this->input->post( 'q' );
    if ( $id_kecamatan != '-1' ) {
      $this->db->where( 'id_kecamatan', decrypt_url( $id_kecamatan ) );
    }
    $this->db->from( $this->table );
    return $this->db->get()->row();
  }

  public function kondisi_rusak_ringan() {
    $this->db->select_sum( 'kondisi_rusak_ringan', 'total' );
    $id_kecamatan = $this->input->post( 'q' );
    if ( $id_kecamatan != '-1' ) {
      $this->db->where( 'id_kecamatan', decrypt_url( $id_kecamatan ) );
    }
    $this->db->from( $this->table );
    return $this->db->get()->row();
  }

  public function kondisi_rusak_berat() {
    $this->db->select_sum( 'kondisi_rusak_berat', 'total' );
    $id_kecamatan = $this->input->post( 'q' );
    if ( $id_kecamatan != '-1' ) {
      $this->db->where( 'id_kecamatan', decrypt_url( $id_kecamatan ) );
    }
    $this->db->from( $this->table );
    return $this->db->get()->row();
  }

}
?>
