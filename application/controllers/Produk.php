<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Produk extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    // $this->load->model('mSatuan');
    // $this->load->model('mKategori');
    $this->load->model('mProduk');
  }

  function index()
  {
    $data['page'] = "Barang";
    $data['judul'] = "Data Barang";
    $data['deskripsi'] = "Manage Data Barang";
    $data['data'] = $this->mProduk->getData();
    $data['satuan'] = $this->mProduk->getSatuan();
    $data['kategori'] = $this->mProduk->getKategori();
    $this->template->view('view_produk', $data);
  }

  function tampilkanData()
  {
    $data = $this->mProduk->getData();
    echo json_encode($data);
  }

  //Create Data
  function tambahData()
  {
    $this->form_validation->set_rules('nama_produk', 'Nama Barang', 'trim|required');
    $this->form_validation->set_rules('id_kategori', 'Kategori Barang', 'required');
    $this->form_validation->set_rules('id_satuan', 'Satuan Barang', 'trim|required');
    $this->form_validation->set_rules('harga_beli', 'Harga Beli', 'numeric');
    $this->form_validation->set_rules('harga_pokok', 'Harga Pokok', 'numeric');
    $this->form_validation->set_rules('harga_jual', 'Harga Jual', 'numeric');
    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
    if ($this->form_validation->run() == FALSE) {
      $response = array('response' => 'error', 'message' => validation_errors());
    } else {
      $nama_produk = $this->input->post('nama_produk');
      $validData = $this->mProduk->cekDuplicate($nama_produk);
      if ($validData >= 1) {
        $response = array('response' => 'error', 'message' => 'Nama Kategori Barang Sudah Terdaftar..');
      } else {
        $id_kategori = $this->input->post('id_kategori');
        $data = array(
          'id_produk' => $this->mProduk->getKode($id_kategori),
          'nama_produk' => $nama_produk,
          'id_kategori' => $id_kategori,
          'id_satuan' => $this->input->post('id_satuan'),
          'barcode' => $this->input->post('barcode'),
          'harga_beli' => $this->input->post('harga_beli'),
          'harga_pokok' => $this->input->post('harga_pokok'),
          'harga_jual' => $this->input->post('harga_jual'),
        );
        $data = $this->security->xss_clean($data);
        if ($this->mProduk->insertData($data)) {
          $response = array('response' => 'success', 'message' => 'Record added Successfully');
        } else {
          $response = array('response' => 'error', 'message' => 'Terjadi Kesalahan, Data Gagal di Simpan');
        }
      }
    }
    echo json_encode($response);
  }

  //Updata Data
  function perbaruiData()
  {
    $this->form_validation->set_rules('nama_produk', 'Nama Barang', 'trim|required');
    $this->form_validation->set_rules('id_kategori', 'Kategori Barang', 'required');
    $this->form_validation->set_rules('id_satuan', 'Satuan Barang', 'trim|required');
    $this->form_validation->set_rules('harga_beli', 'Harga Beli', 'numeric');
    $this->form_validation->set_rules('harga_pokok', 'Harga Pokok', 'numeric');
    $this->form_validation->set_rules('harga_jual', 'Harga Jual', 'numeric');
    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
    if ($this->form_validation->run() == FALSE) {
      $response = array('response' => 'error', 'message' => validation_errors());
    } else {
      $id_produk = $this->input->post('id_produk');
      $data = array(
        'nama_produk' => $this->input->post('nama_produk'),
        'id_kategori' => $this->input->post('id_kategori'),
        'id_satuan' => $this->input->post('id_satuan'),
        'barcode' => $this->input->post('barcode'),
        'harga_beli' => $this->input->post('harga_beli'),
        'harga_pokok' => $this->input->post('harga_pokok'),
        'harga_jual' => $this->input->post('harga_jual'),
      );
      $data = $this->security->xss_clean($data);
      if ($post = $this->mProduk->updateData($id_produk, $data)) {
        $response = array('response' => 'success', 'message' => 'Record update Successfully');
      } else {
        $response = array('response' => 'error', 'message' => 'Terjadi Kesalahan, Data Gagal di Simpan');
      }
    }
    echo json_encode($response);
  }

  //Menampilkan data Berdasarkan ID
  function tampilkanDataByID()
  {
    $id_produk = $this->input->post('id_produk');
    $data = $this->mProduk->getDataById($id_produk);
    echo json_encode($data);
  }

  //Delete Data
  function hapusData()
  {
    if ($this->input->is_ajax_request()) {
      $id = $this->input->post('id_produk');
      if ($this->mProduk->deleteData($id)) {
        $data = array('response' => 'success');
      } else {
        $data = array('response' => 'error');
      }
      echo json_encode($data);
    } else {
      echo "No direct script access allowed";
    }
  }
}
