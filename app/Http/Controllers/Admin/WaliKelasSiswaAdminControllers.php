<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WaliKelas;

class WaliKelasSiswaAdminControllers extends Controller
{
    public function index() {
        $titlePage = "Kelola Wali Kelas";
    
        // Ambil semua siswa
        $WaliKelas = WaliKelas::with('kelas')->get();
    
        // Ambil NIS yang memiliki pengajuan PKL
        // Kirim data ke view
        return view("page.admin.data-wali-kelas.data-wali-kelas", compact('titlePage', 'WaliKelas'));
    }
}
