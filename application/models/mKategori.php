<?php

class mKategori extends CI_Model
{
  function getData()
  {
    $result = $this->db->get('tbl_m_kategori');
    return $result;
  }
}
