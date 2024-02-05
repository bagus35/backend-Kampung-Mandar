<?php
if ( !defined( 'BASEPATH' ) )exit( 'No direct script access allowed' );
class M_komplain extends CI_Model {
  var $table = 'komplain';
  var $id_key = "id_komplain";
  var $column_order = array( 'id_komplain', null );
  var $column_search = array( 'c.nama_ruas', 'b.nama' );
  var $order = array( 'a.id_komplain' => 'DESC' );

  function __construct() {
    parent::__construct();
    $this->load->database();
  }
  private function _get_datatables_query() {
    $this->db->select( '*' );
    $this->db->from( $this->table . ' a' );
    $this->db->join( 'user b', 'a.id_user = b.id_user' );
    $this->db->join( 'ruas_jalan c', 'a.id_ruas_jalan = c.id_ruas_jalan' );
    $this->db->join( 'kecamatan d', 'c.id_kecamatan = d.id_kecamatan' );
    $this->db->join( 'desa e', 'c.id_desa = e.id_desa' );
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
    $id_desa = $this->input->post( 'id_desa', TRUE );
    if ( $id_desa != "-1" ) {
      $this->db->where( 'c.id_desa', decrypt_url( $id_desa ) );
    }
    $id_kecamatan = $this->input->post( 'id_kecamatan', TRUE );
    if ( $id_kecamatan != "-1" ) {
      $this->db->where( 'c.id_kecamatan', decrypt_url( $id_kecamatan ) );
    }

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
    $this->db->from( $this->table . ' a' );
    $this->db->join( 'ruas_jalan c', 'a.id_ruas_jalan = c.id_ruas_jalan' );
    $this->db->join( 'kecamatan d', 'c.id_kecamatan = d.id_kecamatan' );
    $this->db->join( 'desa e', 'c.id_desa = e.id_desa' );
    $id_desa = $this->input->post( 'id_desa', TRUE );
    if ( $id_desa != "-1" ) {
      $this->db->where( 'c.id_desa', decrypt_url( $id_desa ) );
    }
    $id_kecamatan = $this->input->post( 'id_kecamatan', TRUE );
    if ( $id_kecamatan != "-1" ) {
      $this->db->where( 'c.id_kecamatan', decrypt_url( $id_kecamatan ) );
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
    $this->db->join( 'user b', 'a.id_user = b.id_user' );
    $this->db->join( 'ruas_jalan c', 'a.id_ruas_jalan = c.id_ruas_jalan' );
    $this->db->join( 'kecamatan d', 'b.id_kecamatan = d.id_kecamatan' );
    $this->db->join( 'desa e', 'b.id_desa = e.id_desa' );
    $this->db->where( $this->id_key, $id );
    return $this->db->get()->row();
  }


  public function cetak( $id_kecamatan, $id_desa ) {
    $this->db->select( '*' );
    $this->db->from( $this->table . ' a' );
    $this->db->join( 'user b', 'a.id_user = b.id_user' );
    $this->db->join( 'ruas_jalan c', 'a.id_ruas_jalan = c.id_ruas_jalan' );
    $this->db->join( 'kecamatan d', 'b.id_kecamatan = d.id_kecamatan' );
    $this->db->join( 'desa e', 'b.id_desa = e.id_desa' );
    if ( $id_desa != "-1" ) {
      $this->db->where( 'c.id_desa', decrypt_url( $id_desa ) );
    }
    if ( $id_kecamatan != "-1" ) {
      $this->db->where( 'c.id_kecamatan', decrypt_url( $id_kecamatan ) );
    }
    $this->db->order_by( 'nama_ruas', 'ASC' );
    return $this->db->get()->result();
  }

  function lapor_per_user( $id_user ) {
    $this->db->from( $this->table );
    $this->db->where( 'id_user', $id_user );
    $query = $this->db->get();
    return $query->num_rows();
  }


  function get_lapor_per_user( $id_user ) {
    $this->db->select( 'a.*,c.nama_ruas,d.kecamatan,e.desa' );
    $this->db->from( $this->table . ' a' );
    $this->db->join( 'ruas_jalan c', 'a.id_ruas_jalan = c.id_ruas_jalan' );
    $this->db->join( 'kecamatan d', 'c.id_kecamatan = d.id_kecamatan' );
    $this->db->join( 'desa e', 'c.id_desa = e.id_desa' );
    $this->db->where( 'a.id_user', $id_user );
    $this->db->order_by( 'a.id_komplain', 'DESC' );
    $query = $this->db->get();
    return $query->result();
  }

  function all_foto( $id_komplain ) {
    $this->db->from( 'foto_komplain' );
    $this->db->where( 'id_komplain', $id_komplain );
    $query = $this->db->get();
    return $query->num_rows();
  }

  function all_tanggapan( $id_komplain ) {
    $this->db->from( 'tanggapan' );
    $this->db->where( 'id_komplain', $id_komplain );
    $query = $this->db->get();
    return $query->result();
  }


  function get_by_id( $id ) {
    $this->db->select( 'a.id_komplain,a.tanggal,a.status,a.keterangan,b.nama,b.alamat,e.desa,d.kecamatan,b.no_hp,a.foto_komplain,a.id_ruas_jalan,a.koordinat' );
    $this->db->from( $this->table . ' a' );
    $this->db->join( 'user b', 'a.id_user = b.id_user' );
    $this->db->join( 'kecamatan d', 'b.id_kecamatan = d.id_kecamatan' );
    $this->db->join( 'desa e', 'b.id_desa = e.id_desa' );
	  $this->db->where('id_komplain',$id);
	     $query = $this->db->get();
    return $query->row();
  }
	
	function get_all_foto($id){
		 $this->db->where( 'id_komplain', $id);
    $query = $this->db->get('foto_komplain');
    return $query->result();
	}


}
?>
