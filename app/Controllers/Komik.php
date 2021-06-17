<?php

namespace App\Controllers;

use App\Models\KomikModel;

class Komik extends BaseController
{
    protected $komikModel;
    function __construct()
    {
        $this->komikModel = new KomikModel();
    }

    public function index()
    {
        // $komik = $this->komikModel->findAll();

        $data = [
            'title' => 'Daftar Komik',
            'komik' => $this->komikModel->getKomik()
        ];


        return view('komik/index', $data);
    }

    public function detail($slug = '')
    {
        $data = [
            'title' => 'Detail Komik',
            'komik' => $this->komikModel->getKomik($slug)
        ];

        // jika komik tidak ditemukan
        if (empty($data['komik'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul komik ' . $slug . ' tidak ditemukan!');
        }

        return view('komik/detail', $data);
    }

    public function create()
    {
        // session();
        $data = [
            'title'         => 'Tambah Data Komik',
            'validation'    => \Config\Services::validation()
        ];

        return view('komik/create', $data);
    }

    public function save()
    {

        // validasi input
        if (!$this->validate([
            'judul' => [
                'rules'     => 'required|is_unique[komik.judul]',
                'errors'    => [
                    'required'  => '{field} harus diisi!',
                    'is_unique' => '{field} sudah terdaftar!'
                ]
            ],

            'penulis'   => [
                'rules'     => 'required',
                'errors'    => [
                    'required'  => '{field} harus diisi!'
                ]
            ],

            'penerbit'  => [
                'rules' => 'required',
                'errors' => [
                    'required'  => '{field} harus diisi!'
                ]
            ],

            'sampul'    => [
                'rules' => 'max_size[sampul, 1024]|max_dims[sampul,1000,1000]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size'  => 'Ukuran gambar terlalu besar!',
                    'max_dims'  => 'Dimensi gambar tidak didukung!',
                    'is_image'  => 'Yang anda pilih bukan gambar',
                    'mime_in'   => 'Yang anda pilih bukan gambar'
                ]
            ]

        ])) {
            // $validation = \Config\Services::validation();
            return redirect()->to('/komik/create/')->withInput();
        }

        // ambil gambar
        $fileSampul = $this->request->getFile('sampul');
        // apakah tidak ada gambar yang diupload
        if ($fileSampul->getError() == 4) {
            $namaSampul = 'default.jpg';
        } else {
            // generate nama sampul random
            $namaSampul = $fileSampul->getRandomName();
            // pindahkan file ke folder img
            $fileSampul->move('img', $namaSampul);
        }



        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'judul'     => $this->request->getVar('judul'),
            'slug'      => $slug,
            'penulis'   => $this->request->getVar('penulis'),
            'penerbit'  => $this->request->getVar('penerbit'),
            'sampul'    => $namaSampul
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan!');

        return redirect()->to('/komik');
    }

    public function delete($id)
    {
        // cari gambar berdasarkan id
        $komik = $this->komikModel->find($id);

        // cek jika file gambarnya default.jpg
        if ($komik['sampul'] != 'default.jpg') {
            // hapus file gambar di dalam folder
            unlink('img/' . $komik['sampul']);
        }


        $this->komikModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus!');
        return redirect()->to('/komik');
    }

    public function edit($slug)
    {
        $data = [
            'title'         => 'Ubah Data Komik',
            'validation'    => \Config\Services::validation(),
            'komik'         => $this->komikModel->getKomik($slug)
        ];

        return view('komik/edit', $data);
    }

    public function update($id)
    {
        // cek judul
        $komikLama = $this->komikModel->getKomik($this->request->getVar('slug'));
        if ($komikLama['judul'] == $this->request->getVar('judul')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[komik.judul]';
        }

        if (!$this->validate([
            'judul' => [
                'rules'     => $rule_judul,
                'errors'    => [
                    'required'  => '{field} harus diisi!',
                    'is_unique' => '{field} sudah terdaftar!'
                ]
            ],

            'penulis'   => [
                'rules'     => 'required',
                'errors'    => [
                    'required'  => '{field} harus diisi!'
                ]
            ],

            'penerbit'  => [
                'rules' => 'required',
                'errors' => [
                    'required'  => '{field} harus diisi!'
                ]
            ],

            'sampul'    => [
                'rules' => 'max_size[sampul, 1024]|max_dims[sampul,1000,1000]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size'  => 'Ukuran gambar terlalu besar!',
                    'max_dims'  => 'Dimensi gambar tidak didukung!',
                    'is_image'  => 'Yang anda pilih bukan gambar',
                    'mime_in'   => 'Yang anda pilih bukan gambar'
                ]
            ]

        ])) {
            return redirect()->to('/komik/edit/' . $this->request->getVar('slug'))->withInput();
        }


        $filesSampul = $this->request->getFile('sampul');

        // cek gambar, apakah gambar lama
        if ($filesSampul->getError() == 4) {
            $namaSampul = $this->request->getVar('sampulLama');
        } else {
            // generate nama file random
            $namaSampul = $filesSampul->getRandomName();
            // pindahkan gambar
            $filesSampul->move('img', $namaSampul);
            // hapus file lama
            unlink('img/' . $this->request->getVar('sampulLama'));
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'id'        => $id,
            'judul'     => $this->request->getVar('judul'),
            'slug'      => $slug,
            'penulis'   => $this->request->getVar('penulis'),
            'penerbit'  => $this->request->getVar('penerbit'),
            'sampul'    => $namaSampul
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah!');

        return redirect()->to('/komik');
    }
}
