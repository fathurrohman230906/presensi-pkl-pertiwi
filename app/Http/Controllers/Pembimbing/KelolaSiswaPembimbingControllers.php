<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Pembimbing;
use App\Models\PengajuanPkl;
use App\Models\Perusahaan;
use App\Models\Siswa;
use Illuminate\Http\Request;

class KelolaSiswaPembimbingControllers extends Controller
{
    public function kelolaSiswa()
    {
        $titlePage = "Kelola Siswa";

        $pembimbing = Pembimbing::with('jurusan')->find(session('pembimbingID'));
        if (!$pembimbing || !$pembimbing->jurusan) {
            return response()->json(['error' => 'Pembimbing atau Jurusan tidak ditemukan'], 404);
        }

        $kelasIDs = Kelas::where('jurusanID', $pembimbing->jurusan->jurusanID)->pluck('kelasID');
        $siswa = Siswa::whereIn('kelasID', $kelasIDs)->get();
        if ($siswa->isEmpty()) {
            return response()->json(['error' => 'Tidak ada siswa yang ditemukan'], 404);
        }

        $pengajuanPkl = PengajuanPkl::with(['siswa', 'perusahaan'])->whereIn('nis', $siswa->pluck('nis'))->get();
        $Perusahaan = Perusahaan::where('jurusanID', $pembimbing->jurusan->jurusanID)->get();

        return view('pembimbing.Kelola-Siswa.kelola-siswa', compact('titlePage', 'Perusahaan', 'pembimbing', 'kelasIDs', 'siswa', 'pengajuanPkl'));
    }

    // public function kelolaSiswa()
    // {
    //     $titlePage = "Kelola Siswa";
    //     // Ambil data pembimbing berdasarkan ID dari session
    //     $pembimbing = Pembimbing::with('jurusan')->where('pembimbingID', session('pembimbingID'))->first();
    
    //     // Pastikan pembimbing ditemukan
    //     if (!$pembimbing) {
    //         return response()->json(['error' => 'Pembimbing tidak ditemukan'], 404);
    //     }
    
    //     // Ambil ID jurusan dari pembimbing
    //     $jurusanID = $pembimbing->jurusan->jurusanID ?? null;
    
    //     // Periksa apakah jurusanID valid
    //     if (!$jurusanID) {
    //         return response()->json(['error' => 'Jurusan tidak ditemukan'], 404);
    //     }
    
    //     // Ambil semua kelas berdasarkan jurusan
    //     $kelasIDs = Kelas::where('jurusanID', $jurusanID)->pluck('kelasID');
    
    //     // Ambil data siswa berdasarkan kelasID
    //     $siswa = Siswa::whereIn('kelasID', $kelasIDs)->get();
    
    //     // Jika siswa tidak ditemukan
    //     if ($siswa->isEmpty()) {
    //         return response()->json(['error' => 'Tidak ada siswa yang ditemukan'], 404);
    //     }
    
    //     // Ambil daftar NIS siswa
    //     $nisList = $siswa->pluck('nis');
    
    //     // Ambil data pengajuan PKL berdasarkan NIS siswa
    //     $pengajuanPkl = PengajuanPkl::with('siswa')
    //         ->whereIn('nis', $nisList)
    //         ->get();

    //     $Perusahaan = Perusahaan::where('jurusanID', $jurusanID)->get();
    
    //     // Kirim data ke view

    //     return view('pembimbing.Kelola-Siswa.kelola-siswa', compact('titlePage', 'Perusahaan', 'pembimbing', 'kelasIDs', 'siswa', 'pengajuanPkl'));
    //     // return view('pembimbing.Kelola-Siswa.kelola-siswa', [
    //     //     'pembimbing' => $pembimbing,
    //     //     'kelas' => $kelasIDs,
    //     //     'siswa' => $siswa,
    //     //     'pengajuanPkl' => $pengajuanPkl,
    //     // ]);
    // }   

    public function SearchkelolaSiswa(Request $request)
    {
        $titlePage = "Kelola Siswa";
    
        // Ambil data pembimbing berdasarkan ID dari session
        $pembimbing = Pembimbing::with('jurusan')->where('pembimbingID', session('pembimbingID'))->first();
    
        // Pastikan pembimbing ditemukan
        if (!$pembimbing) {
            return response()->json(['error' => 'Pembimbing tidak ditemukan'], 404);
        }
    
        // Ambil ID jurusan dari pembimbing
        $jurusanID = $pembimbing->jurusan->jurusanID ?? null;
    
        // Periksa apakah jurusanID valid
        if (!$jurusanID) {
            return response()->json(['error' => 'Jurusan tidak ditemukan'], 404);
        }
    
        // Ambil semua kelas berdasarkan jurusan
        $kelasIDs = Kelas::where('jurusanID', $jurusanID)->pluck('kelasID');
    
        // Ambil data siswa berdasarkan kelasID
        $siswa = Siswa::whereIn('kelasID', $kelasIDs)->get();
    
        // Jika siswa tidak ditemukan
        if ($siswa->isEmpty()) {
            return response()->json(['error' => 'Tidak ada siswa yang ditemukan'], 404);
        }
    
        // Ambil daftar NIS siswa
        $nisList = $siswa->pluck('nis');
    
        // Ambil data pengajuan PKL berdasarkan NIS siswa
        $pengajuanPkl = PengajuanPkl::with(['siswa', 'perusahaan'])
            ->whereIn('nis', $nisList);
    
        if (isset($request->perusahaanID)) {
            $pengajuanPkl = $pengajuanPkl->where('perusahaanID', $request->perusahaanID);
        }
    
        $pengajuanPkl = $pengajuanPkl->get();
    
        // Filter siswa berdasarkan pengajuan PKL
        $filteredSiswa = $siswa->filter(function ($item) use ($pengajuanPkl) {
            return $pengajuanPkl->contains('nis', $item->nis);
        });
    
        $Perusahaan = Perusahaan::where('jurusanID', $jurusanID)->get();
        $perusahaanID = $request->perusahaanID;
    
        // Kirim data ke view
        return view('pembimbing.Kelola-Siswa.kelola-siswa', compact('titlePage', 'perusahaanID', 'Perusahaan', 'pembimbing', 'kelasIDs', 'filteredSiswa', 'pengajuanPkl'));
    }
    

    // public function SearchkelolaSiswa(Request $request)
    // {
    //     // dd($request->all());
    //     $titlePage = "Kelola Siswa";
    //     // Ambil data pembimbing berdasarkan ID dari session
    //     $pembimbing = Pembimbing::with('jurusan')->where('pembimbingID', session('pembimbingID'))->first();
    
    //     // Pastikan pembimbing ditemukan
    //     if (!$pembimbing) {
    //         return response()->json(['error' => 'Pembimbing tidak ditemukan'], 404);
    //     }
    
    //     // Ambil ID jurusan dari pembimbing
    //     $jurusanID = $pembimbing->jurusan->jurusanID ?? null;
    
    //     // Periksa apakah jurusanID valid
    //     if (!$jurusanID) {
    //         return response()->json(['error' => 'Jurusan tidak ditemukan'], 404);
    //     }
    
    //     // Ambil semua kelas berdasarkan jurusan
    //     $kelasIDs = Kelas::where('jurusanID', $jurusanID)->pluck('kelasID');
    
    //     // Ambil data siswa berdasarkan kelasID
    //     $siswa = Siswa::whereIn('kelasID', $kelasIDs)->get();
    
    //     // Jika siswa tidak ditemukan
    //     if ($siswa->isEmpty()) {
    //         return response()->json(['error' => 'Tidak ada siswa yang ditemukan'], 404);
    //     }
    
    //     // Ambil daftar NIS siswa
    //     $nisList = $siswa->pluck('nis');
    
    //     // Ambil data pengajuan PKL berdasarkan NIS siswa
    //     if (isset($request->perusahaanID)) {
    //         # code...
    //         $pengajuanPkl = PengajuanPkl::with('siswa')
    //             ->whereIn('nis', $nisList)
    //             ->where('perusahaanID', $request->perusahaanID)
    //             ->get();
    //     } else {
    //         $pengajuanPkl = PengajuanPkl::with('siswa')
    //             ->whereIn('nis', $nisList)
    //             ->get();
    //     }

    //     // dd($pengajuanPkl);

    //     $Perusahaan = Perusahaan::where('jurusanID', $jurusanID)->get();
    //     $perusahaanID = $request->perusahaanID;
    //     // Kirim data ke view

    //     return view('pembimbing.Kelola-Siswa.kelola-siswa', compact('titlePage', 'perusahaanID', 'Perusahaan', 'pembimbing', 'kelasIDs', 'siswa', 'pengajuanPkl'));
    // }    
}
