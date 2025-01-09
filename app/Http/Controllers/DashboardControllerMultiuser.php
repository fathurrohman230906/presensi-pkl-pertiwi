<?php

namespace App\Http\Controllers;

use App\Models\KegiatanPkl;
use App\Models\Kelas;
use App\Models\Pembimbing;
use App\Models\PengajuanPkl;
use App\Models\Perusahaan;
use App\Models\Presensi;
use App\Models\Siswa;
use App\Models\WaliKelas;
use Illuminate\Http\Request;

class DashboardControllerMultiuser extends Controller
{
    public function DashboardAdmin()
    {
        $titlePage = "Dashboard";
        // Check if 'adminID' is present in the session
        $adminID = session('adminID');
        if (!$adminID) {
            return redirect()->back()->with('error', 'Wali Kelas ID not found in session.');
        } 
        // Get the number of students in the class (siswa count)
        $PerusahaanCount = Perusahaan::count();
        
        // Get the number of accepted PengajuanPkl for the class's students
        $perusahaanCount = PengajuanPkl::where('status_pengajuan', 'diterima')
                                         ->count();
    
        // Return the view with the necessary data
        return view('page.admin.dashboard', compact('titlePage', 'PerusahaanCount', 'perusahaanCount'));
    }

    public function DashboardSiswa()
    {
        $PengajuanPkl = PengajuanPkl::with('perusahaan')->where('nis', session('nis'))->get();
        
        foreach ($PengajuanPkl as $PengajuanPklSiswa) {
            $perusahaanID = $PengajuanPklSiswa->perusahaan->perusahaanID;
        }

        $tanggal_hari_ini = \Carbon\Carbon::now()->format('Y-m-d');
        $tgl_presensi = $tanggal_hari_ini; // Can be the same as $tanggal_hari_ini
        
        // Get Kegiatan Pkl
        $KegiatanPkl = KegiatanPkl::where('nis', session('nis'))
            ->where('status_kegiatan', 'diterima')
            ->where('tgl_kegiatan', $tanggal_hari_ini)
            ->get();
    
        // Get attendance records for today
        $absen_masuk = Presensi::where('nis', session('nis'))
            ->where('tgl_presensi', $tgl_presensi)
            ->where('status_presensi', 'hadir')
            ->count();
    
        $absen_pulang = Presensi::where('nis', session('nis'))
            ->where('status_absen', 'selesai')
            ->where('tgl_presensi', $tgl_presensi)
            ->where('status_presensi', 'hadir')
            ->count();
    
        $status_absen = Presensi::where('nis', session('nis'))
            ->where('tgl_presensi', $tgl_presensi)
            ->whereIn('status_presensi', ['sakit', 'izin'])
            ->count(); // Mengecek apakah absen sakit atau izin ada hari ini
        
        // Get Pengajuan Pkl data
        $PengajuanPkl = PengajuanPkl::with('perusahaan')
            ->where('nis', session('nis'))
            ->first(); // Use first() to get a single record
    
        // Check if Pengajuan Pkl is available
        $jam_masuk = $PengajuanPkl ? $PengajuanPkl->jam_masuk : null;
        $jam_keluar = $PengajuanPkl ? $PengajuanPkl->jam_keluar : null;
    
        // Return to the view with the required data
        return view('siswa.dashboard', [
            "titlePage" => "Dashboard",
            "KegiatanPkl" => $KegiatanPkl,
            "absen_masuk" => $absen_masuk,
            "absen_pulang" => $absen_pulang,
            "status_absen" => $status_absen,
            "jam_masuk" => $jam_masuk,
            "perusahaanID" => $perusahaanID,
            "jam_keluar" => $jam_keluar
        ]);
    }
    
    

    public function DashboardPembimbing()
    {
        $titlePage = "Dashboard";
    
        // Cek apakah sesi `pembimbingID` tersedia
        $pembimbingID = session('pembimbingID');
        if (!$pembimbingID) {
            return redirect()->back()->with('error', 'Pembimbing ID tidak ditemukan dalam sesi.');
        }
    
        // Ambil data pembimbing dengan relasi jurusan
        $pembimbing = Pembimbing::with('jurusan')->where('pembimbingID', $pembimbingID)->first();
        if (!$pembimbing) {
            return redirect()->back()->with('error', 'Data pembimbing tidak ditemukan.');
        }
    
        // Ambil jurusanID dari pembimbing
        $jurusanID = $pembimbing->jurusan->jurusanID ?? null;
        if (!$jurusanID) {
            return redirect()->back()->with('error', 'Jurusan terkait pembimbing tidak ditemukan.');
        }
    
        // Ambil data kelas berdasarkan jurusanID dan siswa yang terkait
        $kelas = Kelas::with('siswa')->where('jurusanID', $jurusanID)->get();
    
        // Hitung jumlah siswa di semua kelas dalam jurusan
        $siswaCount = Siswa::whereIn('kelasID', $kelas->pluck('kelasID'))->count();
    
        // Hitung jumlah pengajuan PKL yang diterima untuk siswa di kelas terkait
        $perusahaanCount = Perusahaan::where('jurusanID', $pembimbing->jurusanID)->count();
    
        // Render view dengan data yang sudah dihitung
        return view('pembimbing.dashboard', compact('titlePage', 'siswaCount', 'perusahaanCount'));
    }
    
    
    public function DashboardWaliKelas()
    {
        $titlePage = "Dashboard";
        // Check if 'wali_kelasID' is present in the session
        $waliKelasID = session('wali_kelasID');
        if (!$waliKelasID) {
            return redirect()->back()->with('error', 'Wali Kelas ID not found in session.');
        }
    
        // Get the WaliKelas record with its related Kelas
        $waliKelas = WaliKelas::with('kelas')->where('wali_kelasID', $waliKelasID)->first();
        
        // Check if WaliKelas exists, to avoid errors if not found
        if (!$waliKelas) {
            return redirect()->back()->with('error', 'Wali Kelas not found.');
        }
    
        // Get the Kelas ID from the WaliKelas
        $kelasID = $waliKelas->kelas->kelasID;
    
        // Get the number of students in the class (siswa count)
        $siswaCount = Siswa::where('kelasID', $kelasID)->count();
        
        // Get the number of accepted PengajuanPkl for the class's students
        $perusahaanCount = PengajuanPkl::whereIn('nis', Siswa::where('kelasID', $kelasID)->pluck('nis'))
                                         ->where('status_pengajuan', 'diterima')
                                         ->count();
    
        // Return the view with the necessary data

        return view('waliKelas.dashboard', compact('titlePage', 'siswaCount', 'perusahaanCount'));
    }
    
    
}
