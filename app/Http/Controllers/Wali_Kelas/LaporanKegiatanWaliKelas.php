<?php

namespace App\Http\Controllers\Wali_Kelas;

use App\Http\Controllers\Controller;
use App\Models\KegiatanPkl;
use App\Models\PengajuanPkl;
use App\Models\Perusahaan;
use App\Models\Siswa;
use App\Models\WaliKelas;
use Illuminate\Http\Request;

class LaporanKegiatanWaliKelas extends Controller
{
    public function LaporanKegiatanSiswa() {
        $titlePage = "Laporan Kegiatan Siswa";
    
        // Get the class info of the teacher
        $wali_kelas = WaliKelas::with('kelas')->where('wali_kelasID', session('wali_kelasID'))->first();
        $kelasID = $wali_kelas->kelas->kelasID;
        
        // Get students in the class
        $siswa = Siswa::with('kelas')->where('kelasID', $kelasID)->get();
        
        if ($siswa->isEmpty()) {
            return redirect()->back()->with('error', 'No students found in this class.');
        }
        
        // Extract NIS numbers for related data
        $nisArray = $siswa->pluck('nis')->toArray();
        
        // Get PKL activities and related submission data
        $PengajuanPkl = PengajuanPkl::with('perusahaan')->whereIn('nis', $nisArray)->where('status_pengajuan', 'diterima')->get();

        $KegiatanPKL = KegiatanPkl::with('siswa')->whereIn('nis', $nisArray)->where('status_kegiatan', 'diterima')->get();

        
        // Map PengajuanPkl by NIS to avoid unnecessary iterations
        $pengajuanPklByNis = $PengajuanPkl->keyBy('nis');

        $perusahaan = Perusahaan::all();
        
        return view('waliKelas.laporan-kegiatan', compact('titlePage', 'KegiatanPKL', 'siswa', 'pengajuanPklByNis', 'perusahaan'));
    }

    public function LaporanKegiatanSiswaSearch(Request $request) {
        $titlePage = "Laporan Kegiatan Siswa";

        $wali_kelas = WaliKelas::with('kelas')->where('wali_kelasID', session('wali_kelasID'))->first();
        $kelasID = $wali_kelas->kelas->kelasID;

        // Get all students in the class
        $siswa = Siswa::with('kelas')->where('kelasID', $kelasID)->get();
        $perusahaan = Perusahaan::all();

        // Get the filtered NIS and Perusahaan ID from the request
        $nis = $request->nis;
        $perusahaanID = $request->perusahaanID;

        // dd($request->all());

        // Initialize base query
        $query = KegiatanPkl::with('siswa')->whereIn('nis', $siswa->pluck('nis'))->where('status_kegiatan', 'diterima');

        // Apply filters if present
        if ($nis) {
            $query->where('nis', $nis);
        }
        if ($perusahaanID) {
            // Filter PengajuanPkl by PerusahaanID and NIS
            $query->whereHas('siswa', function($q) use ($perusahaanID) {
                $q->whereHas('pengajuan_pkl', function($q) use ($perusahaanID) {
                    $q->where('perusahaanID', $perusahaanID);
                });
            });
        }

        // Fetch the filtered data
        $KegiatanPKL = $query->get();

        // Get the PengajuanPkl based on filters
        $PengajuanPkl = PengajuanPkl::with('perusahaan')->whereIn('nis', $siswa->pluck('nis'))->where('status_pengajuan', 'diterima');
        if ($perusahaanID) {
            $PengajuanPkl->where('perusahaanID', $perusahaanID);
        }
        if ($nis) {
            $PengajuanPkl->where('nis', $nis);
        }

        $pengajuanPklByNis = $PengajuanPkl->get()->keyBy('nis');

        return view("waliKelas.laporan-kegiatan", compact('titlePage', 'KegiatanPKL', 'siswa', 'pengajuanPklByNis', 'perusahaan', 'perusahaanID', 'nis'));
    }
}