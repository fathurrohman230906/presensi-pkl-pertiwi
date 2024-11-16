<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;

    protected $table = "sekolah";
    protected $primaryKey = "sekolahID";

    protected $fillable = ["nm_sekolah", "pendiri", "no_tlp", "alamat"];
}
