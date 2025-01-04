<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Pembimbing;
use App\Models\WaliKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class WaliKelasDanSiswaPembimbingControllers extends Controller
{
    public function KelolaWaliKelas() {
        $titlePage = "Kelola Wali Kelas";
        // Mengambil data pembimbing berdasarkan ID yang tersimpan di sesi
        $pembimbing = Pembimbing::where('pembimbingID', session('pembimbingID'))->first();
    
        // Pastikan pembimbing ditemukan
        if (!$pembimbing) {
            return response()->json(['message' => 'Pembimbing tidak ditemukan'], 404);
        }
    
        // Ambil ID jurusan yang terkait dengan pembimbing
        $jurusanID = $pembimbing->jurusanID;
    
        // Ambil daftar kelas berdasarkan jurusan
        $kelasIDs = Kelas::where('jurusanID', $jurusanID)->pluck('kelasID');
        // Ambil wali kelas yang sesuai dengan daftar kelas
        $waliKelas = WaliKelas::with('kelas')->whereIn('kelasID', $kelasIDs)->get();

        // foreach ($waliKelas as $key => $DatawaliKelas) {
        //     # code...
        //     return response()->json($DatawaliKelas);
        // }
        // dd($kelasIDs);
        return view("pembimbing.Wali-kelas&Kelas.kelola-waliKelas", compact('titlePage', 'waliKelas'));
    }
    
    public function KelolaKelas() {
        $titlePage = "Kelola Kelas";
        // Mengambil data pembimbing berdasarkan ID yang tersimpan di sesi
        $pembimbing = Pembimbing::where('pembimbingID', session('pembimbingID'))->first();
    
        // Pastikan pembimbing ditemukan
        if (!$pembimbing) {
            return response()->json(['message' => 'Pembimbing tidak ditemukan'], 404);
        }
    
        // Ambil ID jurusan yang terkait dengan pembimbing
        $jurusanID = $pembimbing->jurusanID;
    
        // Ambil daftar kelas berdasarkan jurusan
        $kelas = Kelas::where('jurusanID', $jurusanID)->get();
        return view("pembimbing.Wali-kelas&Kelas.kelola-kelas", compact('titlePage', 'kelas', 'jurusanID'));
    }
    
    public function KelolaKelasCreate(Request $request) {
        // dd($request->all());

        $DataStore = $request->validate([
            "nm_kelas" => "required",
            "jurusanID" => "required",
        ]);

        Kelas::create($DataStore);
        return redirect()->back()->with('success', 'Data berhasil di tambahkan');
    }
}
