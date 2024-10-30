<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;
    protected $fillable = 
    [
      "email", "password", "nm_lengkap", "jk", "agama", "foto", "alamat"
    ];
    protected $primaryKey = "adminID";
    protected $table = 'admin';
}
