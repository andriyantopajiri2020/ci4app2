<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Home | Web Programming'
        ];
        return view('pages/home', $data);
    }

    public function about()
    {
        $data = [
            'title' => 'About | Web Programming', 'tes' => ['satu', 'dua', 'tiga']
        ];
        return view('pages/about', $data);
    }

    public function contact()
    {
        $data = [
            'title' => 'Contact | Web Programming',
            'alamat' => [
                [
                    'tipe'      => 'kantor',
                    'alamat'    => 'Jl. Barito, Desa Molsel, Kec. Kwandang',
                    'kota'      => 'Gorontalo Utara'
                ],
                [
                    'tipe'      => 'rumah',
                    'alamat'    => 'Jl. Bendungan Hunggaluwa, Desa Payu, Kec. Mootilango',
                    'kota'      => 'Gorontalo'
                ]
            ]
        ];

        return view('pages/contact', $data);
    }
}
