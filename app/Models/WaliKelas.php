<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaliKelas extends Model
{
    use HasFactory;

    protected $fillable = 
    [
      "email", "password", "nm_lengkap", "jk", "agama", "kelasID", "no_tlp", "foto", "alamat"
    ];

    protected $primaryKey = "wali_kelasID";

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelasID');
    }
}
