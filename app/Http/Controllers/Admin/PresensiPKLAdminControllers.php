<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presensi;
use App\Models\Siswa;
use App\Models\PengajuanPkl;
use App\Models\Perusahaan;
use App\Models\Kelas;

class PresensiPKLAdminControllers extends Controller
{
    public function d() {
        $titlePage = "Kelola Presensi";
    
        // Ambil semua siswa
        $presensi = Presensi::get();
        // Kirim data ke view
        return view("page.admin.presensi.kelola-presensi", compact('titlePage', 'presensi'));
    }
    
    public function index() {
        $titlePage = "Kelola Presensi";
        $siswa = Siswa::with('kelas')->get();
        if ($siswa->isEmpty()) {
            return redirect()->back()->with('error', 'No students found in this class.');
        }

        $kelas = Kelas::all();
        $Presensi = Presensi::with('siswa', 'perusahaan')->get();
        
        $PengajuanPkl = PengajuanPkl::with('siswa', 'perusahaan')->where('status_pengajuan', 'diterima')->get();

        // if (!$PengajuanPkl) {
        //     return redirect()->route('wali-kelas.dashboard')->with('peringatan', 'Maaf tidak ada.');
        // }

        $perusahaan = Perusahaan::with('siswa')->get();
        return view('page.admin.presensi.kelola-presensi', compact('titlePage', 'Presensi', 'siswa', 'perusahaan', 'PengajuanPkl', 'kelas'));
    }

    public function cari(Request $request) {
        // dd($request->all());   
        $titlePage = "Kelola Presensi";
        // $siswa = Siswa::with('kelas')->where('kelasID', $request->kelasID)->get();
        // dd($siswa);
        $kelasID = $request->kelasID;   
        // dd($kelasID);
        // if ($siswa->isEmpty()) {
        //     return redirect()->route('admin.presensi')->with('error', 'No students found in this class.');
        // }

        $kelas = Kelas::all();
        $Presensi = Presensi::with('siswa', 'perusahaan')->get();
        
        $PengajuanPkl = PengajuanPkl::with('siswa', 'perusahaan')->where('status_pengajuan', 'diterima')->get();

        // if (!$PengajuanPkl) {
        //     return redirect()->route('wali-kelas.dashboard')->with('peringatan', 'Maaf tidak ada.');
        // }

        $perusahaan = Perusahaan::with('siswa')->get();
        return view('page.admin.presensi.kelola-presensi', compact('titlePage', 'Presensi', 'perusahaan', 'PengajuanPkl', 'kelas', 'kelasID'));
    }
    // public function index(Request $request) {
    //     $titlePage = "Kelola Presensi";
        
    //     // Fetch all kelas for dropdown
    //     $kelas = Kelas::all();
        
    //     // Fetch all students with their class and perusahaan
    //     $siswa = Siswa::with('kelas')->get();
        
    //     // Fetch all perusahaan for dropdown
    //     $perusahaan = Perusahaan::all();
        
    //     // Fetch Presensi data
    //     $Presensi = Presensi::with('siswa', 'perusahaan')->get();
        
    //     // Fetch Pengajuan Pkl data
    //     $PengajuanPkl = PengajuanPkl::with('siswa', 'perusahaan')->where('status_pengajuan', 'diterima')->get();
        
    //     if ($request->ajax()) {
    //         // If the request is an AJAX request, return students based on selected class
    //         $class_id = $request->class_id;
    //         $students = Siswa::where('kelas_id', $class_id)->get();
    //         return response()->json($students);
    //     }
    
    //     return view('page.admin.presensi.kelola-presensi', compact('titlePage', 'Presensi', 'siswa', 'perusahaan', 'PengajuanPkl', 'kelas'));
    // }
    
}
