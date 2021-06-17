<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class PegawaiSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');

        $data = array();
        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                'nama'          => $faker->name,
                'alamat'        => $faker->address,
                'create_at'     => Time::createFromTimestamp($faker->unixTime()),
                'updated_at'    => Time::now()
            ];
        }

        // $data = [
        //     [
        //         'nama'          => 'Andriyanto Pajiri',
        //         'alamat'        => 'Jl. Bendungan Hunggaluwa, Desa Payu, Kec. Mootilango, Kab. Gorontalo',
        //         'create_at'    => Time::now(),
        //         'updated_at'    => Time::now()
        //     ],
        //     [
        //         'nama'          => 'Harioyono Jainahu',
        //         'alamat'        => 'Desa Paris, Kec. Mootilango, Kab. Gorontalo',
        //         'create_at'    => Time::now(),
        //         'updated_at'    => Time::now()
        //     ],
        //     [
        //         'nama'          => 'Idris Male',
        //         'alamat'        => 'Kec. Mootilango, Kab. Gorontalo',
        //         'create_at'    => Time::now(),
        //         'updated_at'    => Time::now()
        //     ]
        // ];

        // Simple Queries
        // $this->db->query("INSERT INTO pegawai (nama, alamat, create_at, updated_at) VALUES(:nama:, :alamat:, :create_at:, :updated_at:)", $data);

        // Using Query Builder
        // $this->db->table('pegawai')->insert($data);
        $this->db->table('pegawai')->insertBatch($data);
    }
}
