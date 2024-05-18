<?php

class Home extends CI_Controller
{
  public function index()
  {
    $data['page'] = "home";
    $data['judul'] = "beranda";
    $data['deskripsi'] = "FULL STACK WEB DEVELOPMENT SYSTEM";
    $this->template->view('home', $data);
  }
}
