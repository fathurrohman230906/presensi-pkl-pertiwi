<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\PengajuanPkl;

class KelolaSiswaAdminControllers extends Controller
{
  public function index() {
    $titlePage = "Kelola Siswa";

    // Ambil semua siswa
    $siswa = Siswa::with('kelas')->get();

    // Ambil NIS yang memiliki pengajuan PKL
    $nisPengajuan = PengajuanPkl::pluck('nis')->toArray();

    // Siapkan data siswa
    $dataSiswa = $siswa->map(function ($item) use ($nisPengajuan) {
        $pengajuan = PengajuanPkl::with('perusahaan')
            ->where('nis', $item->nis)
            ->first();

        return [
            'nis' => $item->nis,
            'nm_lengkap' => $item->nm_lengkap,
            'jk' => $item->jk,
            'kelas' => $item->kelas->nm_kelas,
            'tempat_pkl' => $pengajuan->perusahaan->nm_perusahaan ?? '-',
            'agama' => $item->agama,
            'alamat' => $item->alamat,
            'pengajuanID' => $pengajuan->pengajuanID ?? null,
        ];
    });

    // Kirim data ke view
    return view("page.admin.data-siswa.data-siswa", compact('titlePage', 'dataSiswa'));
}

  public function edit(Request $request)
{
    $titlePage = "Kelola Siswa";
    $title = "Edit Siswa";
    $pengajuanID = $request->pengajuanID;
    // Ambil data siswa berdasarkan ID
    $dataSiswa = PengajuanPkl::with('perusahaan')
        ->where('pengajuanID', $pengajuanID)
        ->firstOrFail();

    return view('page.admin.data-siswa.edit-siswa', compact('titlePage', 'title', 'dataSiswa', 'pengajuanID'));
}

public function update(Request $request, $pengajuanID)
{
    // Validasi input
    $validatedData = $request->validate([
        'nm_lengkap' => 'required|string|max:255',
        'jk' => 'required|in:L,P',
        'alamat' => 'nullable|string|max:500',
        'agama' => 'nullable|string|max:100',
    ]);

    // Update data siswa
    $dataSiswa = PengajuanPkl::where('pengajuanID', $pengajuanID)->firstOrFail();
    $dataSiswa->update($validatedData);

    return redirect()->route('admin.siswa')->with('success', 'Data siswa berhasil diperbarui!');
}
}
