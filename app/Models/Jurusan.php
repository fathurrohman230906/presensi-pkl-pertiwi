<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;
    
    protected $fillable = ["nm_jurusan"];
    protected $primaryKey = "jurusanID";
    protected $table = "jurusan";
    
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'jurusanID');
    }

    public function pembimbing()
    {
        return $this->hasMany(Pembimbing::class, 'jurusanID');
    }
    public function perusahaan()
    {
        return $this->hasMany(Perusahaan::class, 'jurusanID');
    }
}
