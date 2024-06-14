<?php
class mProduk extends CI_Model
{
  function getKategori()
  {
    $query = $this->db->get('tbl_m_kategori'); 
    return $query->result(); 
  }

  function getSatuan()
  {
    $query = $this->db->get('tbl_m_satuan');
    return $query->result(); 
  }

  function getData()
  {
    $this->db->select('p.*, k.nama_kategori, s.nama_satuan');
    $this->db->from('tbl_m_produk p');
    $this->db->join('tbl_m_kategori k', 'p.id_kategori = k.id_kategori');
    $this->db->join('tbl_m_satuan s', 'p.id_satuan = s.id_satuan');
    return $this->db->get()->result();
  }

  //Menambah Data(Create)
  function insertData($data)
  {
    return $this->db->insert('tbl_m_produk', $data);
  }

  //Untuk Menampilkan Data Berdasarkan ID(Read)
  function getDataById($id)
  {
    $this->db->where('id_produk', $id);
    return $this->db->get('tbl_m_produk')->row();
  }

  //Update Data berdasarkan ID(Update)
  function updateData($id, $data)
  {
    $this->db->where('id_produk', $id);
    return $this->db->update('tbl_m_produk', $data);
  }

  //Menghapus data berdasarkan ID(Delete)
  function deleteData($id)
  {
    $this->db->where('id_produk', $id);
    return $this->db->delete('tbl_m_produk');
  }

  //Validasi Data Duplikat
  function cekDuplicate($produk)
  {
    $this->db->where('nama_produk', $produk);
    $query = $this->db->get('tbl_m_produk');
    return $query->num_rows();
  }

  // Membuat Kode Barang otomatis berdasarkan Kategori
  function getKode($id_kategori)
  {
    $query = $this->db->query("SELECT MAX(RIGHT(id_produk,6)) AS kd_max FROM tbl_m_produk WHERE id_kategori='$id_kategori'");
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
