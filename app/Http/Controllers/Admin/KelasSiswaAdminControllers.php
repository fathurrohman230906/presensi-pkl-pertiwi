<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Jurusan;


class KelasSiswaAdminControllers extends Controller
{
    public function index() {
        $titlePage = "Kelola Kelas";
    
        // Ambil semua siswa
        $Kelas = Kelas::get();
        // Kirim data ke view
        return view("page.admin.data-kelas.data-kelas", compact('titlePage', 'Kelas'));
    }

    public function create() {
        $titlePage = "Kelola Kelas";
        $title = "Create Kelas";
        $jurusan = Jurusan::get();
        return view("page.admin.data-kelas.add-kelas", compact('titlePage', 'title', 'jurusan'));
    }

    public function edit(Request $request) {
        $titlePage = "Kelola Kelas";
        $title = "Edit Kelas";
        $kelas = Kelas::where('kelasID', $request->kelasID)->first();
        $jurusan = Jurusan::get();
        return view("page.admin.data-kelas.edit-kelas", compact('titlePage', 'title', 'jurusan', 'kelas'));
    }

    public function store(Request $request) {
        // Validate input data
        $message = [
          "jurusanID.required" => "Jurusan wajib di isi",
          "jurusanID.integer" => "Jurusan wajib di isi",
          "nm_kelas.required" => "Nama Kelas wajib di isi"
        ];
        $DataKelas = $request->validate([
            'nm_kelas' => 'required|max:30',
            'jurusanID' => 'required|integer'
        ], $message);
    
        try {
            // Create a new Kelas instance
            $kelas = Kelas::create($DataKelas);
            
            // Redirect with a success message
            return redirect()->route('admin.kelas')->with('success', 'Data berhasil tambah');
        } catch (\Exception $e) {
            // Return with an error message
            return redirect()->back()->with('peringatan', 'Gagal menambah data, silakan coba lagi');
        }
    }

    public function update(Request $request) {
        // Validate input data
        $message = [
          "jurusanID.required" => "Jurusan wajib di isi",
          "jurusanID.integer" => "Jurusan wajib di isi",
          "nm_kelas.required" => "Nama Kelas wajib di isi",
          "kelasID.required" => "ID Kelas wajib di isi",
          "kelasID.integer" => "ID Kelas wajib di isi",
        ];
        $DataKelas = $request->validate([
            'nm_kelas' => 'required|max:30',
            'jurusanID' => 'required|integer',
            'kelasID' => 'required|integer'
        ], $message);
    
        try {
            // Create a new Kelas instance
            $kelas = Kelas::where('kelasID', $request->kelasID)->first();

            $kelas->update($DataKelas);
            
            // Redirect with a success message
            return redirect()->route('admin.kelas')->with('success', 'Data berhasil diubah');
        } catch (\Exception $e) {
            // Return with an error message
            return redirect()->back()->with('peringatan', 'Gagal edit data, silakan coba lagi');
        }
    }
    public function destroy(Request $request) {
        // Validate input data
        $message = [
          "kelasID.required" => "ID Kelas wajib di isi",
          "kelasID.integer" => "ID Kelas wajib di isi",
        ];
        $DataKelas = $request->validate([
            'kelasID' => 'required|integer'
        ], $message);
    
        try {
            // Create a new Kelas instance
            $kelas = Kelas::where('kelasID', $request->kelasID)->first();

            $kelas->delete();
            
            // Redirect with a success message
            return redirect()->route('admin.kelas')->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            // Return with an error message
            return redirect()->back()->with('peringatan', 'Gagal edit data, silakan coba lagi');
        }
    }
}
