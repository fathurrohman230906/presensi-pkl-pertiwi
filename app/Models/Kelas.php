<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $fillable = ["nm_kelas", "jurusanID"];
    protected $primaryKey = "kelasID";
    
    public function jurusan()
    {
        return $this->hasMany(Jurusan::class, 'jurusanID');
    }
    
    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'kelasID');
    }
}
