<?php

namespace App\Models;

use CodeIgniter\Model;

class PegawaiModel extends Model
{
    protected $table = 'pegawai';

    protected $useTimestamps = true;

    protected $allowedFields = ['nama', 'alamat'];


    public function search($keyword = false)
    {
        return $this->like('nama', $keyword)->orLike('alamat', $keyword);
    }
}
