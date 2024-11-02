<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class WaliKelas extends Authenticatable
{
    use HasFactory;

    protected $fillable = 
    [
      "email", "password", "nm_lengkap", "jk", "agama", "kelasID", "no_tlp", "foto", "alamat"
    ];

    protected $primaryKey = "wali_kelasID";
    protected $table = 'wali_kelas';
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelasID');
    }
}
