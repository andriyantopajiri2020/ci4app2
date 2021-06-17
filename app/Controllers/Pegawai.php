<?php

namespace App\Controllers;

use App\Models\PegawaiModel;

class Pegawai extends BaseController
{
    protected $komikModel;
    function __construct()
    {
        $this->PegawaiModel = new PegawaiModel();
    }

    public function index()
    {
        $keyword = $this->request->getVar('keyword');

        if ($keyword) {
            $pegawai = $this->PegawaiModel->search($keyword);
        } else {
            $pegawai = $this->PegawaiModel;
        }


        $curentPage = $this->request->getVar('page_pegawai') ? $this->request->getVar('page_pegawai') : 1;

        $data = [
            'title'     => 'Daftar Pegawai',
            'pegawai'   => $pegawai->paginate(6, 'pegawai'),
            'pager'     => $this->PegawaiModel->pager,
            'curentPage' => $curentPage
        ];
        return view('pegawai/index', $data);
    }
}
