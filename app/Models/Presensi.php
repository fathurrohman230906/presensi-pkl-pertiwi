<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $fillable = 
    [
      "nis", "perusahaanID", "tgl_presensi", "masuk", "pulang", "status_presensi", "keterangan", "foto", "latitude", "longitude"
    ];
    protected $primaryKey = "presensiID";

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'perusahaanID');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis');
    }
}
