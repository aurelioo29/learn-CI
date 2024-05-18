<?php 

class mProduk extends CI_Model
{
  function getData()
  {
    $this->db->select('p.*, k.nama_kategori, s.nama_satuan');
    $this->db->from('tbl_m_produk p');
    $this->db->join('tbl_m_kategori k', 'p.id_kategori = k.id_kategori');
    $this->db->join('tbl_m_satuan s', 'p.id_satuan = s.id_satuan');
    return $this->db->get();
  }
}

?>