<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanPkl extends Model
{
    use HasFactory;
    protected $fillable = 
    [
      "nis", "perusahaanID", "bulan_masuk", "bulan_keluar", "status_pengajuan", "total_setuju_pembimbing", "total_setuju_kaprog"
    ];
    
    protected $primaryKey = "pengajuanID";

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'perusahaanID', 'perusahaanID');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis', 'nis');
    }
}
