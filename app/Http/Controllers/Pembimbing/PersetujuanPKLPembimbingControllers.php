<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use App\Models\Pembimbing;
use App\Models\PengajuanPkl;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class PersetujuanPKLPembimbingControllers extends Controller
{
    public function PersetujuanPKL() {
        $titlePage = "Persetujuan PKL";

        $Pembimbing = Pembimbing::where('pembimbingID', session('pembimbingID'))->first();

        if ($Pembimbing) {
            $jurusanID = $Pembimbing->jurusanID;
        
            // Mengambil semua perusahaan yang terkait dengan jurusan
            $Perusahaan = Perusahaan::where('jurusanID', $jurusanID)->get();
        
            // Mengambil ID perusahaan dari hasil query di atas
            $perusahaanIDs = $Perusahaan->pluck('perusahaanID');
        
            // Mendapatkan pengajuan PKL yang sesuai
            if($Pembimbing->level === "pembimbing") {
                $total_Setuju = "total_setuju_pembimbing";
            } elseif ($Pembimbing->level === "kepala program") {
                $total_Setuju = "total_setuju_kaprog";
            } else {
                return redirect()->route('persetujuan.pkl')->with('peringatan', 'Maaf terjadi kesalahan.');
            }
            
            $PengajuanPKL = PengajuanPkl::with('perusahaan', 'siswa')
                ->whereIn('perusahaanID', $perusahaanIDs)
                ->where('status_pengajuan', 'ditunggu')
                ->where($total_Setuju, 0)
                ->get();

        } else {
            // Logika jika pembimbing tidak ditemukan
            $PengajuanPKL = collect(); // Mengembalikan koleksi kosong
        }
        

        return view("pembimbing.Persetujuan-PKL.persetujuan-pkl", compact('titlePage', 'PengajuanPKL'));
    }

    public function ProsesPersetujuanPKL(Request $request)
    {
        // Validasi input
        $request->validate([
            'pengajuanID' => 'required|exists:pengajuan_pkls,pengajuanID', // Pastikan ID valid
            'level' => 'required|in:pembimbing,kepala program', // Validasi level
            'status_pengajuan' => 'required|in:diterima,ditolak' // Validasi status pengajuan
        ]);
    
        // Temukan pengajuan berdasarkan ID
        $pengajuanPKL = PengajuanPkl::where('pengajuanID', $request->pengajuanID)->firstOrFail();
    
        // Tentukan kolom yang akan diubah berdasarkan level
        $fieldToUpdate = match ($request->level) {
            'pembimbing' => 'total_setuju_pembimbing',
            'kepala program' => 'total_setuju_kaprog',
            default => null
        };
    
        if (!$fieldToUpdate) {
            return redirect()->route('persetujuan.pkl')->with('peringatan', 'Maaf terjadi kesalahan.');
        }
    
        // Perbarui nilai berdasarkan status pengajuan
        $adjustment = $request->status_pengajuan === 'diterima' ? 1 : -1;
    
        $pengajuanPKL->increment($fieldToUpdate, $adjustment);
    
        // Tentukan pesan sukses
        $message = $request->status_pengajuan === 'diterima' ? 'Anda Setuju.' : 'Anda Menolak.';
    
        // Redirect dengan pesan sukses
        return redirect()->route('persetujuan.pkl')->with('success', $message);
    }
}