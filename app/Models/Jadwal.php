<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $fillable = ["perusahaanID", "jam_masuk", "jam_keluar", "hari"];
    protected $primaryKey = "jadwalID";
    
    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'perusahaanID');
    }
}
