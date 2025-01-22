<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembimbing;
use App\Models\Jurusan;

class KelolaPembimbingAdminControllers extends Controller
{
    public function index() {
        $titlePage = "Kelola Pembimbing";
    
        $pembimbing = Pembimbing::with('jurusan')->get();
    
        return view("page.admin.data-pembimbing.data-pembimbing", compact('titlePage', 'pembimbing'));
    }

    public function edit(Request $request) {
        $titlePage = "Kelola Pembimbing";
        $title = "Edit Pembimbing";
        $DaftarJurusan = Jurusan::get();
        $Pembimbing = Pembimbing::with('jurusan')->where('pembimbingID', $request->pembimbingID)->first();
    
        return view("page.admin.data-pembimbing.edit-pembimbing", compact('titlePage', 'title', 'DaftarJurusan', 'Pembimbing'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'pembimbingID' => 'required|string|max:12',
            'nm_lengkap' => 'required|string|max:255',
            'jurusanID' => 'required|integer',
            'jk' => 'required|in:L,P',
            'alamat' => 'nullable|string|max:500',
            'agama' => 'nullable|string|max:100',
            'level' => 'nullable|string|max:100',
        ]);

        $Pembimbing = Pembimbing::with('jurusan')->where('pembimbingID', $request->pembimbingID)->firstOrFail();
        $Pembimbing->update($validatedData);
    

        return redirect()->route('admin.pembimbing')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy(Request $request)
    {
        try {
            $Pembimbing = Pembimbing::with('jurusan')->where('pembimbingID', $request->pembimbingID)->first();

            if (!$Pembimbing) {
            return redirect()->route('admin.pembimbing')->with('error', 'Data Wali Kelas tidak ditemukan!');
            }

            $Pembimbing->delete();

            return redirect()->route('admin.pembimbing')->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('admin.pembimbing')->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
