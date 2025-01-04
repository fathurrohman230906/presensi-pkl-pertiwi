<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use App\Models\Pembimbing;
use App\Models\Perusahaan;
use Illuminate\Http\Request;

class PerusahaanPembimbingController extends Controller
{
    public function perusahaan() {
        // Ambil data wali kelas yang sedang login beserta data kelasnya
        $pembimbing = Pembimbing::with('jurusan')->where('pembimbingID', session('pembimbingID'))->first();
        // Pastikan wali jurusan ditemukan
        if (!$pembimbing) {
            return response()->json(['error' => 'Pembimbing tidak ditemukan'], 404);
        }
        // Ambil ID jurusan dari wali jurusan
        $jurusanID = $pembimbing->jurusan->jurusanID;
        // Ambil semua siswa yang ada di jurusan tersebut
        $Perusahaan = Perusahaan::where('jurusanID', $jurusanID)->get();
        return view("pembimbing.Perusahaan.data-perusahaan", [
            'titlePage' => 'Data Perusahaan',
            'Perusahaan' => $Perusahaan,
        ]);
    }

    public function Createperusahaan() {
        return view("pembimbing.Perusahaan.create-perusahaan", [
            'titlePage' => 'Data Perusahaan',
        ]);
    }

    public function EditPerusahaan(Request $request) {
        $titlePage = "Data Perusahaan";
        $perusahaanID = $request->input('perusahaanID');
        // dd($id);
        $Perusahaan = Perusahaan::where('perusahaanID', $perusahaanID)->first();
        return view("pembimbing.Perusahaan.edit-perusahaan", compact('titlePage', 'Perusahaan'));
    }

    public function Storeperusahaan(Request $request) {
        // dd($request->all());
        
        $DataPerusahaan = $request->validate([
            "pendiri" => 'required',
            "nm_perusahaan" => 'required',
            "email" => 'required',
            "no_tlp" => 'required',
            "deskripsi" => 'nullable',
            "alamat" => 'required',
        ]);

        $pembimbing = Pembimbing::with('jurusan')->where('pembimbingID', session('pembimbingID'))->first();
        // Pastikan wali jurusan ditemukan
        if (!$pembimbing) {
            return redirect()->route('pembimbing.perusahaan')->with('peringatan', 'Ada kesalahan ketika ubah data');
        }
        // Ambil ID jurusan dari wali jurusan
        $jurusanID = $pembimbing->jurusan->jurusanID;
        $DataPerusahaan["jurusanID"] = $jurusanID;
        $Perusahaan = Perusahaan::create($DataPerusahaan);

        return redirect()->route('pembimbing.perusahaan')->with('success', 'Data Berhasil Di tambahkan');
    }

    public function UpdatePerusahaan(Request $request) {
        // dd($request->all());
        $DataPerusahaan = $request->validate([
            "perusahaanID" => 'required',
            "pendiri" => 'required',
            "nm_perusahaan" => 'required',
            "email" => 'required',
            "no_tlp" => 'required',
            "deskripsi" => 'nullable',
            "alamat" => 'required',
        ]);

        $perusahaan = Perusahaan::where('perusahaanID', $request->perusahaanID)->first();
        // Pastikan wali jurusan ditemukan
        if (!$perusahaan || !$request->perusahaanID) {
            return redirect()->route('pembimbing.perusahaan')->with('peringatan', 'Ada kesalahan ketika ubah data');
        }
        $perusahaan->update($DataPerusahaan);

        return redirect()->route('pembimbing.perusahaan')->with('success', 'Data Berhasil Di Ubah');
    }

    public function Deleteperusahaan(Request $request) {
        // dd($request->all());
        $DataPerusahaan = $request->validate([
            "perusahaanID" => 'required',
        ]);

        $perusahaan = Perusahaan::where('perusahaanID', $request->perusahaanID)->first();
        // Pastikan wali jurusan ditemukan
        if (!$perusahaan || !$request->perusahaanID) {
            return redirect()->route('pembimbing.perusahaan')->with('peringatan', 'Ada kesalahan ketika ubah data');
        }

        $perusahaan->delete();

        return redirect()->route('pembimbing.perusahaan')->with('success', 'Data Berhasil Di Ubah');
    }
}
