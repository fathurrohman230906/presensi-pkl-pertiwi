<?php

namespace App\Http\Controllers\Wali_Kelas;

use App\Http\Controllers\Controller;
use App\Models\PengajuanPkl;
use App\Models\Perusahaan;
use App\Models\Presensi;
use App\Models\Siswa;
use App\Models\WaliKelas;
use Illuminate\Http\Request;

class PresensiWaliKelasController extends Controller
{
    public function kelolaPresensi() {
        $titlePage = "Kelola Presensi";
        $wali_kelas = WaliKelas::with('kelas')->where('wali_kelasID', session('wali_kelasID'))->first();
        $kelasID = $wali_kelas->kelas->kelasID;
    
        // Fetch all students (siswa) for the current class
        $siswa = Siswa::with('kelas')->where('kelasID', $kelasID)->get();
    
        // Ensure there are students in the class
        if ($siswa->isEmpty()) {
            // Handle the case where no students are found
            // You might want to return a specific view or show an error message
            return redirect()->back()->with('error', 'No students found in this class.');
        }

        // Fetch presensi details for the students along with their perusahaan
        $nisArray = $siswa->pluck('nis')->toArray(); // Ensure pluck returns an array
        $Presensi = Presensi::with('siswa', 'perusahaan')->whereIn('nis', $nisArray)->get();
        
        $PengajuanPkl = PengajuanPkl::with('siswa', 'perusahaan')->whereIn('nis', $nisArray)->where('status_pengajuan', 'diterima')->get();

        // if (!$PengajuanPkl) {
        //     return redirect()->route('wali-kelas.dashboard')->with('peringatan', 'Maaf tidak ada.');
        // }

        $perusahaan = Perusahaan::with('siswa')->get();
    
        // If a perusahaanID is already selected, pass it to the view
        return view('waliKelas.kelola-presensi', compact('titlePage', 'Presensi', 'siswa', 'perusahaan', 'PengajuanPkl'));
    }
    
    public function kelolaPresensiSearch(Request $request) {
        $titlePage = "Kelola Presensi";

        $wali_kelas = WaliKelas::with('kelas')->where('wali_kelasID', session('wali_kelasID'))->first();
        $kelasID = $wali_kelas->kelas->kelasID;

        $siswa = Siswa::with('kelas')->where('kelasID', $kelasID)->get();
        $perusahaan = Perusahaan::with('siswa')->get();

        // $PengajuanPkl = PengajuanPkl::with('siswa')->where('perusahaanID', $request->perusahaanID)->get();
        
        if ($request->nis && $request->perusahaanID) {
            // Both nis and perusahaanID are present
            $Presensi = Presensi::with('siswa', 'perusahaan')
                                ->where('perusahaanID', $request->perusahaanID)
                                ->where('nis', $request->nis)
                                ->get();
        } elseif ($request->nis) {
            $Presensi = Presensi::with('siswa', 'perusahaan')
                                ->where('nis', $request->nis)
                                ->get();
        } elseif ($request->perusahaanID) {
            $Presensi = Presensi::with('siswa', 'perusahaan')
                                ->where('perusahaanID', $request->perusahaanID)
                                ->get();
        } else {
            $nisArray = $siswa->pluck('nis')->toArray(); // Ensure pluck returns an array
            $Presensi = Presensi::with('siswa', 'perusahaan')->whereIn('nis', $nisArray)->get();
        }
        
        if (empty($request->nis) && empty($request->perusahaanID)) {
            $nisArray = $siswa->pluck('nis')->toArray(); // Ensure pluck returns an array
            $Presensi = Presensi::with('siswa', 'perusahaan')->whereIn('nis', $nisArray)->get();
        }
        

        $perusahaanID = $request->perusahaanID;
        $nis = $request->nis;

        return view("waliKelas.kelola-presensi", compact('titlePage', 'Presensi', 'siswa', 'perusahaan', 'perusahaanID', 'nis'));
    }  
    
    public function ViewLokasiSiswa($nis) {
        $titlePage = "Kelola Presensi";
        $siswa = Siswa::with('kelas')->where('nis', $nis)->first();
        $Presensi = Presensi::with('siswa', 'perusahaan')->where('nis', $nis)->first();

        $latitude = $Presensi->latitude;
        $longitude = $Presensi->longitude;

        return view('waliKelas.view-lokasi', compact('titlePage', 'latitude', 'longitude', 'siswa'));
    }

}
