<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $fillable = 
    [
      "email", "password", "nm_lengkap", "jk", "agama", "kelasID", "perusahaanID", "no_tlp", "foto", "alamat"
    ];
    protected $primaryKey = "nis";
    
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelasID');
    }
    
    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'perusahaanID');
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class, 'nis');
    }

    public function kegiatan_pkl()
    {
        return $this->hasMany(KegiatanPkl::class, 'nis');
    }

    public function pengajuan_pkl()
    {
        return $this->hasMany(PengajuanPkl::class, 'nis');
    }
}
