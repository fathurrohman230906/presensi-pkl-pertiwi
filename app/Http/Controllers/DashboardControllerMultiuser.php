<?php

namespace App\Http\Controllers;

use App\Models\KegiatanPkl;
use Illuminate\Http\Request;

class DashboardControllerMultiuser extends Controller
{
    public function DashboardAdmin()
    {
        return view('page.admin.dashboard', [
            "titlePage" => "dashboard"
        ]);
    }

    public function DashboardSiswa()
    {
        $tanggal_hari_ini = \Carbon\Carbon::now()->format('Y-m-d');
        $KegiatanPkl = KegiatanPkl::where('nis', session('nis'))->where('status_kegiatan', 'diterima')->where('tgl_kegiatan', $tanggal_hari_ini)->get();
        return view('siswa.dashboard', [
            "titlePage" => "dashboard",
            "KegiatanPkl" => $KegiatanPkl,
        ]);
    }

    public function DashboardPembimbing()
    {
        return view('pembimbing.dashboard', [
            "titlePage" => "dashboard"
        ]);
    }
    
    public function DashboardWaliKelas()
    {
        return view('waliKelas.dashboard', [
            "titlePage" => "dashboard"
        ]);
    }
}
