<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;
    
    protected $fillable = ["nm_jurusan"];
    protected $primaryKey = "jurusanID";
    
    public function kelas()
    {
        return $this->belongsTo(Jurusan::class, 'jurusanID');
    }
}
