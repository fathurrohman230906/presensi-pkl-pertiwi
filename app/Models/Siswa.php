<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Authenticatable // Change this line
{
    use HasFactory;

    protected $fillable = [
        "email", "password", "nm_lengkap", "jk", "agama", "kelasID", "no_tlp", "foto", "alamat"
        // "email", "password", "nm_lengkap", "jk", "agama", "kelasID", "perusahaanID", "no_tlp", "foto", "alamat"
    ];
    protected $table = 'siswa';
    protected $primaryKey = "nis";
    
    // If you want to use the 'password' field for authentication, ensure it's hashed.
    protected $hidden = [
        'password',
    ];
    
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
