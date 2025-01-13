<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;

class SiswaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Siswa([
            "nis" => $row[0],
            "email" => $row[1],
            "password" => bcrypt($row[2]),
            "nm_lengkap" => $row[3],
            "jk" => $row[4],
            "agama" => $row[5],
            "kelasID" => $row[6],
            "no_tlp" => $row[7],
            "foto" => $row[8],
            "alamat" => $row[9],
        ]);
    }
}
