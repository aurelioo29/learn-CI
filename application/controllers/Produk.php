<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('mProduk');
  }

  function index()
  {
    $data['page'] = "Produk";
    $data['judul'] = "Data Produk";
    $data['deskripsi'] = "Manage Data Produk";
    $data['data'] = $this->mProduk->getData();
    $this->template->view('view_produk', $data);
  }
}
