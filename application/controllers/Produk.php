<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('mProduk');
  }

  function index()
  {
    $data['page'] = "Barang";
    $data['judul'] = "Data Barang";
    $data['deskripsi'] = "Manage Data Barang";
    $data['data'] = $this->mProduk->getData();
    $data['kategori'] = $this->mProduk->get_kategori();
    $data['satuan'] = $this->mProduk->get_satuan();
    $this->template->view('view_produk', $data);
  }

  function tampilkanData()
  {
    $data = $this->mProduk->getData();
    echo json_encode($data);
  }

  function tambahData()
  {
    $this->form_validation->set_rules('nama_produk', 'Nama Produk', 'trim|required');
    $this->form_validation->set_rules('id_kategori', 'Kategori Produk', 'required');
    $this->form_validation->set_rules('id_satuan', 'Satuan Produk', 'trim|required');
    $this->form_validation->set_rules('harga_beli', 'Harga Beli', 'required');
    $this->form_validation->set_rules('harga_pokok', 'Harga Pokok', 'required');
    $this->form_validation->set_rules('harga_jual', 'Harga Jual', 'required');
    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

    if ($this->form_validation->run() == false) {
      $response = array('responce' => 'error', 'message' => validation_errors());
    } else {
      $nama_produk = $this->input->post('nama_produk');
      $validData = $this->mProduk->cekDuplicate($nama_produk);
      if ($validData > 1) {
        $response = array('responce' => 'error', 'message' => 'Nama Produk Sudah Terdaftar');
      } else {
        $id_kategori = $this->input->post('id_kategori');
        $data = [
          'id_produk' => $this->input->post('id_produk'),
          'nama_produk' => $nama_produk,
          'id_kategori' => $id_kategori,
          'id_satuan' => $this->input->post('id_satuan'),
          'barcode' => $this->input->post('barcode'),
          'harga_beli' => $this->input->post('harga_beli'),
          'harga_pokok' => $this->input->post('harga_pokok'),
          'harga_jual' => $this->input->post('harga_jual')
        ];
        $data = $this->security->xss_clean($data);
        if ($this->mProduk->insertData($data)) {
          $response = array('responce' => 'success', 'message' => 'Data Produk Berhasil Ditambahkan');
        } else {
          $response = array('responce' => 'error', 'message' => 'Data Produk Gagal Ditambahkan');
        }
      }
    }
    echo json_encode($response);
  }

  function perbaruiData()
  {
    $this->form_validation->set_rules('nama_produk', 'Nama Produk', 'trim|required');
    $this->form_validation->set_rules('id_kategori', 'Kategori Produk', 'required');
    $this->form_validation->set_rules('id_satuan', 'Satuan Produk', 'trim|required');
    $this->form_validation->set_rules('harga_beli', 'Harga Beli', 'numeric');
    $this->form_validation->set_rules('harga_pokok', 'Harga Pokok', 'numeric');
    $this->form_validation->set_rules('harga_jual', 'Harga Jual', 'numeric');
    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

    if ($this->form_validation->run() == false) {
      $response = array('responce' => 'error', 'message' => validation_errors());
    } else {

      $id_produk = $this->input->post('id_produk');
      $data = array(
        'nama_produk' => $this->input->post('nama_produk'),
        'id_kategori' => $this->input->post('id_kategori'),
        'id_satuan'   => $this->input->post('id_satuan'),
        'barcode'     => $this->input->post('barcode'),
        'harga_beli'  => $this->input->post('harga_beli'),
        'harga_pokok' => $this->input->post('harga_pokok'),
        'harga_jual'  => $this->input->post('harga_jual')
      );
      $data = $this->security->xss_clean($data);
      if ($this->mProduk->insertData($data)) {
        $response = array('responce' => 'success', 'message' => 'Data Produk Berhasil Diubah');
      } else {
        $response = array('responce' => 'error', 'message' => 'Data Produk Gagal Diubah');
      }
    }
    echo json_encode($response);
  }

  function tampilkanDataById()
  {
    $id_produk = $this->input->post('id_produk');
    $data = $this->mProduk->getDataById($id_produk);
    echo json_encode($data);
  }

  function hapusData()
  {
    if ($this->input->is_ajax_request()) {
      $id = $this->input->post('id_produk');
      if ($this->mProduk->deleteData($id)) {
        $data = array('responce' => 'success');
      } else {
        $data = array('responce' => 'error');
      }
    } else {
      echo "No direct script access allowed";
    }
  }
}
