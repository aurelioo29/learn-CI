<?php

class mSatuan extends CI_Model
{
  function getData()
  {
    $result = $this->db->get('tbl_m_satuan');
    return $result;
  }
}
