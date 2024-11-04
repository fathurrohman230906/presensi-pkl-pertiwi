<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KegiatanPkl;
use App\Models\Siswa;
// use App\Models\Perusahaan;

class LaporanKegiatanSiswa extends Controller
{
    public function LaporanKegiatan() 
    {
        $nis = session('nis');
        $Siswa = Siswa::with('kelas', 'perusahaan')->where('nis', $nis)->get();
        return view('siswa.kegiatan.kegiatan-pkl', [
            "titlePage" => "Kegiatan Siswa",
            "siswa" => $Siswa
        ]);    
    }
}
