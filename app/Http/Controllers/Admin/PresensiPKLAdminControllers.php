<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PresensiPKLAdminControllers extends Controller
{
    public function index() {
        $titlePage = "Kelola Presensi";
    
        // Ambil semua siswa
        $presensi = Presensi::get();
        // Kirim data ke view
        return view("page.admin.data-kelas.data-kelas", compact('titlePage', 'presensi'));
    }
}
