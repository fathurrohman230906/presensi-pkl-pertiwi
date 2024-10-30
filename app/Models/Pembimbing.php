<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Pembimbing extends Authenticatable
{
    use HasFactory;

    protected $fillable = 
    [
      "email", "password", "nm_lengkap", "jk", "agama", "jurusanID", "no_tlp", "foto", "alamat", "level"
    ];

    protected $table = 'pembimbing';
    
    protected $primaryKey = "pembimbingID";

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusanID');
    }
}
