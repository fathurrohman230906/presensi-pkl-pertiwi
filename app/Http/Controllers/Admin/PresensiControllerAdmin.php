<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use Illuminate\Http\Request;

class PresensiControllerAdmin extends Controller
{
    public function DataPresensi() {
        // Mengambil data Presensi berdasarkan NIS yang ada di session
        $Presensi = Presensi::where('nis', session('nis'))->get(); // Menambahkan get() untuk mengambil data

        return view('admin.Presensi.data-presensi', [
            "titlePage" => "Data Presensi",
            "Presensi" => $Presensi, // Mengirim data Presensi ke view
        ]);
    }
}