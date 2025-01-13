<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Perusahaan;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class PerusahaanControllers extends Controller
{
    public function index() {
      $titlePage = "Data Perusahaan";
      $perusahaan = Perusahaan::with('jurusan')->get();
      return view("page.admin.perusahaan.data-perusahaan", compact('titlePage', 'perusahaan'));
    }

    public function create() {
      $titlePage = "Data Perusahaan";
      $title = "Create Perusahaan";
      $jurusan = Jurusan::get();
      return view("page.admin.perusahaan.add-perusahaan", compact('titlePage', 'title', 'jurusan'));
    }

    public function edit(Request $request) {
      $perusahaanID = $request->perusahaanID;
      $titlePage = "Data Perusahaan";
      $title = "Edit Perusahaan";
      $perusahaan = Perusahaan::where('perusahaanID', $perusahaanID)->first();
      $jurusanID = $perusahaan->jurusanID;
      $jurusan = Jurusan::get();
      return view("page.admin.perusahaan.edit-perusahaan", compact('titlePage', 'title', 'perusahaan', 'jurusan', 'jurusanID'));
   }
   

    public function store(Request $request) {
      // Validate input data
      $message = [
        "no_tlp.digits" => "Nomer Telepon harus lebih dari 11",
        "pendiri.required" => "Pendiri wajib di isi",
        "alamat.required" => "Alamat wajib di isi",
        "deskripsi.required" => "Deskripsi wajib di isi",
        "email.required" => "Email wajib di isi",
        "jurusanID.required" => "Jurusan wajib di isi",
        "jurusanID.integer" => "Jurusan wajib di isi",
        "no_tlp.required" => "Nomer Telepon wajib di isi",
        "nm_perusahaan.required" => "Nama Perusahaan wajib di isi"
      ];
      $DataPerusahaan = $request->validate([
          'pendiri' => 'required|max:30',
          'nm_perusahaan' => 'required|max:30',
          'alamat' => 'required|string|max:255', // Changed to string
          'email' => 'required|email',
          'deskripsi' => 'required|string|max:500', // Changed to string
          'no_tlp' => 'required|digits:11', // Fixed validation for phone number
          'jurusanID' => 'required|integer' // Changed to integer
      ], $message);
  
      try {
          // Create a new Perusahaan instance
          $perusahaan = Perusahaan::create($DataPerusahaan);
          
          // Redirect with a success message
          return redirect()->route('admin.perusahaan')->with('success', 'Data berhasil tambah');
      } catch (\Exception $e) {
          // Return with an error message
          return redirect()->back()->with('peringatan', 'Gagal menambah data, silakan coba lagi');
      }
  }

    public function update(Request $request, $perusahaanID) {
      // Validate input data
      $message = [
        "no_tlp.digits" => "Nomer Telepon harus lebih dari 11",
        "pendiri.required" => "Pendiri wajib di isi",
        "alamat.required" => "Alamat wajib di isi",
        "deskripsi.required" => "Deskripsi wajib di isi",
        "email.required" => "Email wajib di isi",
        "jurusanID.required" => "Jurusan wajib di isi",
        "jurusanID.integer" => "Jurusan wajib di isi",
        "no_tlp.required" => "Nomer Telepon wajib di isi",
        "nm_perusahaan.required" => "Nama Perusahaan wajib di isi"
      ];
      $DataPerusahaan = $request->validate([
          'pendiri' => 'required|max:30',
          'nm_perusahaan' => 'required|max:30',
          'alamat' => 'required|string|max:255', // Changed to string
          'email' => 'required|email',
          'deskripsi' => 'required|string|max:500', // Changed to string
          'no_tlp' => 'required|digits:11', // Fixed validation for phone number
          'jurusanID' => 'required|integer' // Changed to integer
      ], $message);
  
      try {
          // Create a new Perusahaan instance
          $perusahaan = Perusahaan::where('perusahaanID', $perusahaanID)->first();

          $perusahaan->update($DataPerusahaan);
          
          // Redirect with a success message
          return redirect()->route('admin.perusahaan')->with('success', 'Data berhasil diubah');
      } catch (\Exception $e) {
          // Return with an error message
          return redirect()->back()->with('peringatan', 'Gagal di ubah data, silakan coba lagi');
      }
  }
  
  public function destroy(Request $request) {
    try {
      $perusahaanID = $request->perusahaanID;
      $perusahaan = Perusahaan::where('perusahaanID', $perusahaanID)->first();

      $perusahaan->delete();
      return redirect()->route('admin.perusahaan')->with('success', 'Data berhasil dihapus');
  } catch (\Exception $e) {
      // Return with an error message
      return redirect()->back()->with('peringatan', 'Gagal di hapus data, silakan coba lagi');
  }
  }
}
