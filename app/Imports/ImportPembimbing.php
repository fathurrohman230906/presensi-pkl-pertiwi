<?php

namespace App\Imports;

use App\Models\Pembimbing;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportPembimbing implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Pembimbing([
          "email" => $row[0],
          "password" => bcrypt($row[1]),
          "nm_lengkap" => $row[2],
          "jk" => $row[3],
          "agama" => $row[4],
          "jurusanID" => $row[5],
          "no_tlp" => $row[6],
          "foto" => $row[7],
          "alamat" => $row[8],
          "level" => $row[9],
        ]);
    }
}
