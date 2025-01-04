<?php

namespace App\Http\Controllers\Wali_Kelas;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\PengajuanPkl;
use App\Models\Perusahaan;
use App\Models\Siswa;
use App\Models\WaliKelas;
use Illuminate\Http\Request;

class PerusahaanWaliKelasController extends Controller
{
    public function perusahaan() {
// Ambil data wali kelas yang sedang login beserta data kelasnya
$wali_kelas = WaliKelas::with('kelas')->where('wali_kelasID', session('wali_kelasID'))->first();

// Pastikan wali kelas ditemukan
if (!$wali_kelas) {
    return response()->json(['error' => 'Wali kelas tidak ditemukan'], 404);
}

// Ambil ID kelas dari wali kelas
$kelasID = $wali_kelas->kelas->kelasID;

// $jurusan = Jurusan::where('')
// Ambil semua siswa yang ada di kelas tersebut
$siswa = Siswa::where('kelasID', $kelasID)->get();
// dd($siswa);
// Ambil daftar NIS dari siswa
// $nisList = $siswa->pluck('nis')->toArray();

// Ambil data pengajuan PKL berdasarkan NIS dan status pengajuan diterima
$PengajuanPkl = PengajuanPkl::with('siswa')
    // ->whereIn('nis', $nisList)
    // ->where('status_pengajuan', 'ditunggu')
    ->get();

    // dd($PengajuanPkl);
        $Perusahaan = Perusahaan::with('siswa')->get();

        return view("waliKelas.data-perusahaan", [
            'titlePage' => 'Data Perusahaan',
            'Perusahaan' => $Perusahaan,
            'siswa' => $siswa,
            'PengajuanPkl' => $PengajuanPkl,
        ]);
    }

    public function PerusahaanSearch(Request $request) {
        $wali_kelas = WaliKelas::with('kelas')->where('wali_kelasID', session('wali_kelasID'))->first();
        $kelasID = $wali_kelas->kelas->kelasID;
        
        $siswa = Siswa::with('kelas')->where('kelasID', $kelasID)->get();
        $Perusahaan = Perusahaan::with('siswa')->get();
        
        $PengajuanPkl = PengajuanPkl::with('siswa')->where('perusahaanID', $request->perusahaanID)
        ->where('status_pengajuan', 'diterima')
        ->get();

        if($request->perusahaanID === "semua") {
            return redirect()->route('perusahaan')->with('wkwk', 'Siswa berhasil di hapus');
        }
        
        return view("waliKelas.data-perusahaan", [
            'titlePage' => 'Data Perusahaan',
            'Perusahaan' => $Perusahaan,
            'siswa' => $siswa,
            'PengajuanPkl' => $PengajuanPkl,
            'perusahaanID' => $request->perusahaanID,
        ]);
    }
    public function DeleteSiswa(Request $request) {
        $siswa = Siswa::where('nis', $request->nis)->delete();
        return redirect()->back()->with('success', 'Siswa berhasil di hapus');
    }
}
