<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Pembimbing;
use App\Models\PengajuanPkl;
use App\Models\Perusahaan;
use App\Models\Presensi;
use App\Models\Siswa;
use App\Models\WaliKelas;
use Illuminate\Http\Request;

class PresensiPembimbingControllers extends Controller
{
    public function internshipKelolaPresensi()
    {
        $titlePage = "Kelola Presensi";
    
        // Ambil data pembimbing berdasarkan session
        $pembimbing = Pembimbing::where('pembimbingID', session('pembimbingID'))->first();
    
        // Pastikan pembimbing ditemukan
        if (!$pembimbing) {
            return response()->json(['message' => 'Pembimbing tidak ditemukan'], 404);
        }
    
        // Ambil ID jurusan terkait pembimbing
        $jurusanID = $pembimbing->jurusanID;
    
        // Ambil daftar kelas berdasarkan jurusan
        $kelasIDs = Kelas::where('jurusanID', $jurusanID)->pluck('kelasID')->toArray();
    
        // Ambil data siswa berdasarkan kelas
        $siswa = Siswa::with('kelas')->whereIn('kelasID', $kelasIDs)->get();
    
        // Jika tidak ada siswa, kembalikan pesan error
        if ($siswa->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada siswa dalam kelas ini.');
        }
    
        // Ambil NIS siswa untuk presensi
        $nisArray = $siswa->pluck('nis')->toArray();
    
        // Ambil data presensi dan perusahaan terkait siswa
        $Presensi = Presensi::with(['siswa', 'perusahaan'])->whereIn('nis', $nisArray)->get();
        $perusahaan = Perusahaan::with('siswa')->where('jurusanID', $jurusanID)->get();

        $PengajuanPkl = PengajuanPkl::with('siswa', 'perusahaan')->whereIn('nis', $nisArray)->where('status_pengajuan', 'diterima')->get();

        // Kembalikan ke view dengan data yang diperlukan
        return view('Pembimbing.kelola-presensi.kelola-presensi', compact('titlePage', 'Presensi', 'siswa', 'perusahaan', 'PengajuanPkl'));
    }    

    public function internshipKelolaPresensiSearch(Request $request) {
        $titlePage = "Kelola Presensi";
    
        // Ambil data pembimbing berdasarkan sesi
        $pembimbing = Pembimbing::where('pembimbingID', session('pembimbingID'))->firstOrFail();
        
        // Ambil ID jurusan dan kelas terkait
        $jurusanID = $pembimbing->jurusanID;
        $kelasID = Kelas::where('jurusanID', $jurusanID)->pluck('kelasID')->toArray();
        
        // Data siswa dan perusahaan
        $siswa = Siswa::with('kelas')->whereIn('kelasID', $kelasID)->get();
        $perusahaan = Perusahaan::with('siswa')->get();
        
        // Validasi input
        $request->validate([
            'nis' => 'nullable|exists:siswa,nis',
            'perusahaanID' => 'nullable|exists:perusahaan,perusahaanID',
        ]);
        
        // Query presensi
        $Presensi = Presensi::with('siswa', 'perusahaan');
        if ($request->nis) {
            $Presensi->where('nis', $request->nis);
            $PengajuanPkl = PengajuanPkl::with('siswa', 'perusahaan')->where('nis', $request->nis)->where('status_pengajuan', 'diterima')->get();
        }
        if ($request->perusahaanID) {
            $Presensi->where('perusahaanID', $request->perusahaanID);
            $PengajuanPkl = PengajuanPkl::with('siswa', 'perusahaan')->where('perusahaanID', $request->perusahaanID)->where('status_pengajuan', 'diterima')->get();
        }
    
        $Presensi = $Presensi->whereIn('nis', $siswa->pluck('nis')->toArray())->get();
        $perusahaanID = $request->perusahaanID;


        $nis = $request->nis;
        return view("Pembimbing.kelola-presensi.kelola-presensi", compact('titlePage', 'Presensi', 'siswa', 'perusahaan', 'perusahaanID', 'nis', 'PengajuanPkl'));
    }
    
    
    public function internshipViewLokasiSiswa($nis) {
        $titlePage = "Kelola Presensi";
        $siswa = Siswa::with('kelas')->where('nis', $nis)->first();
        $Presensi = Presensi::with('siswa', 'perusahaan')->where('nis', $nis)->first();

        $latitude = $Presensi->latitude;
        $longitude = $Presensi->longitude;

        // return view('waliKelas.view-lokasi', compact('titlePage', 'latitude', 'longitude', 'siswa'));
        return view('Pembimbing.kelola-presensi.view-lokasi', compact('titlePage', 'latitude', 'longitude', 'siswa'));
    }
}
