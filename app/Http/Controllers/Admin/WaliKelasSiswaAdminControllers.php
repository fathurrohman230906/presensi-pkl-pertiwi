<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WaliKelas;
use App\Models\Kelas;

class WaliKelasSiswaAdminControllers extends Controller
{
    public function index() {
        $titlePage = "Kelola Wali Kelas";
    
        // Ambil semua siswa
        $WaliKelas = WaliKelas::with('kelas')->get();
    
        // Ambil NIS yang memiliki pengajuan PKL
        // Kirim data ke view
        return view("page.admin.data-wali-kelas.data-wali-kelas", compact('titlePage', 'WaliKelas'));
    }
    public function edit(Request $request) {
        $titlePage = "Kelola Wali Kelas";
        $title = "Edit Wali Kelas";
        $DaftarKelas = Kelas::get();
        // Ambil semua siswa
        $WaliKelas = WaliKelas::with('kelas')->where('wali_kelasID', $request->wali_kelasID)->first();
    
        // Ambil NIS yang memiliki pengajuan PKL
        // Kirim data ke view
        return view("page.admin.data-wali-kelas.edit-wali-kelas", compact('titlePage', 'title', 'DaftarKelas', 'WaliKelas'));
    }
    
    public function update(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'wali_kelasID' => 'required|string|max:12',
            'nm_lengkap' => 'required|string|max:255',
            'kelasID' => 'required|integer',
            'jk' => 'required|in:L,P',
            'alamat' => 'nullable|string|max:500',
            'agama' => 'nullable|string|max:100',
        ]);

        // Ambil data WaliKelas berdasarkan wali_kelasID
        $WaliKelas = WaliKelas::with('kelas')->where('wali_kelasID', $request->wali_kelasID)->firstOrFail();

            // Update data siswa tanpa perusahaanID
            $WaliKelas->update($validatedData);
    

        return redirect()->route('admin.wali.kelas')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy(Request $request)
    {
        try {
            // Cari data siswa berdasarkan NIS
            $WaliKelas = WaliKelas::with('kelas')->where('wali_kelasID', $request->wali_kelasID)->first();

            if (!$WaliKelas) {
            return redirect()->route('admin.wali.kelas')->with('error', 'Data Wali Kelas tidak ditemukan!');
            }

            // Hapus data siswa
            $WaliKelas->delete();

            // Redirect dengan pesan sukses
            return redirect()->route('admin.wali.kelas')->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            // Tangani error dan tampilkan pesan
            return redirect()->route('admin.wali.kelas')->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
