<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;

class KelolaSiswaAdminControllers extends Controller
{
    public function index() {
        $titlePage = "Kelola Siswa";
        $siswa = Siswa::with('kelas', 'perusahaan')->get();
        return view("page.admin.data-siswa.data-siswa", compact('titlePage', 'siswa'));
    }
    
}
