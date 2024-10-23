<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KegiatanPkl extends Model
{
    use HasFactory;

    protected $fillable = 
    [
      "deskripsi_kegiatan", "tgl_kegiatan", "nis"
    ];
    protected $primaryKey = "kegiatanID";

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis');
    }
}
