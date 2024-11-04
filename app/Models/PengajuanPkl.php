<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanPkl extends Model
{
    use HasFactory;
    protected $fillable = 
    [
      "nis", "perusahaanID", "bulan_masuk", "bulan_keluar", "status_pengajuan"
    ];
    
    protected $primaryKey = "pengajuanID";

    public function perusahaan()
    {
        return $this->hasMany(Perusahaan::class, 'perusahaanID');
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'nis');
    }
}
