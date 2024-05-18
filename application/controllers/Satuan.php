<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Satuan extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('mSatuan');
  }
  function index()
  {
    $data['page'] = "Satuan";
    $data['judul'] = "Data Satuan";
    $data['deskripsi'] = "Manage Data Satuan";
    $data['data'] = $this->mSatuan->getData();
    $this->template->view('view_satuan', $data);
  }
}
