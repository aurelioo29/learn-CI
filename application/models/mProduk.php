<?php

class mProduk extends CI_Model
{
  function __construct()
  {
    parent::__construct();
    $this->load->database(); // Pastikan database di-load
  }

  function get_kategori()
  {
    $query = $this->db->get('tbl_m_kategori'); // 'kategori' adalah nama tabel di database
    return $query->result(); // Mengembalikan hasil sebagai array objek
  }

  function get_satuan()
  {
    $query = $this->db->get('tbl_m_satuan'); // 'satuan' adalah nama tabel di database
    return $query->result(); // Mengembalikan hasil sebagai array objek
  }

  function getData()
  {
    $this->db->select('p.*, k.nama_kategori, s.nama_satuan');
    $this->db->from('tbl_m_produk p');
    $this->db->join('tbl_m_kategori k', 'p.id_kategori = k.id_kategori');
    $this->db->join('tbl_m_satuan s', 'p.id_satuan = s.id_satuan');
    return $this->db->get()->result();
  }

  function insertData($data)
  {
    $this->db->insert('tbl_m_produk', $data);
  }

  function getDataById($id)
  {
    $this->db->where('id_produk', $id);
    return $this->db->get('tbl_m_produk')->row();
  }

  function updateData($id, $data)
  {
    $this->db->where('id_produk', $id);
    return $this->db->update('tbl_m_produk', $data);
  }

  function deleteData($id)
  {
    $this->db->where('id_produk', $id);
    return $this->db->delete('tbl_m_produk');
  }

  function cekDuplicate($kategori)
  {
    $this->db->where('nama_produk', $kategori);
    return $this->db->get('tbl_m_produk')->num_rows();
  }

  function getKode($id_kategori)
  {
    $query = $this->db->query("SELECT MAX(RIGHT(kode_produk, 6)) AS kd_max FROM tbl_m_produk WHERE id_kategori = '$id_kategori'");
    $isCode = '';
    if ($query->num_rows() > 0) {
      foreach ($query->result() as $k) {
        $tmp = ((int)$k->kd_max) + 1;
        $isCode = sprintf("%06s", $tmp);
      }
    } else {
      $isCode = "000001";
    }
    return $id_kategori . $isCode;
  }
}
