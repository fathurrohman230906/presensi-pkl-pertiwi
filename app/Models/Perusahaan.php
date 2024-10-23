<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    use HasFactory;
    protected $fillable = 
    [
      "pendiri", "nm_perusahaan", "deskripsi", "alamat"
    ];
    protected $primaryKey = "perusahaanID";
    
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'perusahaanID');
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'perusahaanID');
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class, 'perusahaanID');
    }

    public function pengajuan_pkl()
    {
        return $this->hasMany(PengajuanPkl::class, 'perusahaanID');
    }
}
