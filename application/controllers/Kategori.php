<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('mKategori');
    }

    function tampilkanData()
    {
        $data = $this->mKategori->getData();
        echo json_encode($data);
    }

    function index()
    {
        $data['page'] = "Kategori";
        $data['judul'] = "Data Kategori";
        $data['deskripsi'] = "Manage Data Kategori";
        $data['data'] = $this->mKategori->getData();
        $this->template->view('view_kategori', $data);
    }

    function tambahData()
    {
        $this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'required');
        if ($this->form_validation->run() == false) {
            $response = array('responce' => 'error', 'message' => 'Nama Kategori Barang Sudah Terdaftar');
        } else {
            $data = ['nama_kategori' => $this->input->post('nama_kategori')];
            if ($this->mKategori->inserData($data)) {
                $response = array('responce' => 'success', 'message' => 'Data Kategori Barang Berhasil Ditambahkan');
            } else {
                $response = array('responce' => 'error', 'message' => 'Data Kategori Barang Gagal Ditambahkan');
            }
        }
        echo json_encode($response);
    }

    function perbaruiData()
    {
        $this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'required');
        $this->form_validation->set_rules('id_kategori', 'ID Kategori', 'required');
        if ($this->form_validation->run() == false) {
            $response = array('responce' => 'error', 'message' => 'Nama Kategori Barang Sudah Terdaftar');
        } else {
            $nama_kategori = $this->input->post('nama_kategori');
            $id_kategori = $this->input->post('id_kategori');
            $validData = $this->mKategori->cekDuplicate($nama_kategori);
            if ($validData >= 1) {
                $response = array('responce' => 'error', 'message' => 'Nama Kategori Barang Sudah Terdaftar');
            } else {
                $data = ['nama_kategori' => $nama_kategori];
                if ($post = $this->mKategori->updateData($id_kategori, $data)) {
                    $response = array('responce' => 'success', 'message' => 'Data Kategori Barang Berhasil Diperbarui');
                } else {
                    $response = array('responce' => 'error', 'message' => 'Data Kategori Barang Gagal Diperbarui');
                }
            }
        }
        echo json_encode($response);
    }

    function tampilkanDataById()
    {
        $id_kategori = $this->input->post('id_kategori');
        $data = $this->mKategori->getDataById($id_kategori);
        echo json_encode($data);
    }

    function hapusData()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id_kategori');
            if ($this->mKategori->deleteData($id)) {
                $data = array('responce' => 'success');
            } else {
                $data = array('responce' => 'error');
            }
            echo json_encode($data);
        } else {
            echo "No direct script access allowed";
        }
    }
}
