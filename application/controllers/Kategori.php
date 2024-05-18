<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('mKategori');
    }

    function index()
    {
        $data['page'] = "Kategori";
        $data['judul'] = "Data Kategori";
        $data['deskripsi'] = "Manage Data Kategori";
        $data['data'] = $this->mKategori->getData();
        $this->template->view('view_kategori', $data);
    }
}
?>