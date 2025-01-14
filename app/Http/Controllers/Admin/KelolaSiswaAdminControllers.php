<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\PengajuanPkl;
use App\Models\Kelas;
use App\Models\Perusahaan;

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

    if ($request->has('pengajuanID')) {
        $pengajuanID = $request->pengajuanID;
        $DaftarKelas = Kelas::get();
        
        $dataSiswa = Siswa::with(['kelas', 'pengajuan_pkl.perusahaan'])
            ->whereHas('pengajuan_pkl', function ($query) use ($pengajuanID) {
                $query->where('pengajuanID', $pengajuanID);
            })
            ->get();
    } elseif ($request->has('nis')) {
        $nis = $request->nis;
        $DaftarKelas = Kelas::get();
        
        $dataSiswa = Siswa::with('kelas')
            ->where('nis', $nis)
            ->get();
    } else {
        return redirect()->back()->withErrors('Parameter pengajuanID atau nis diperlukan.');
    }

    return view('page.admin.data-siswa.edit-siswa', compact('titlePage', 'title', 'dataSiswa', 'DaftarKelas'));
}

public function update(Request $request)
{
    // Validasi input
    $validatedData = $request->validate([
        'nis' => 'required|string|max:12',
        'nm_lengkap' => 'required|string|max:255',
        'kelasID' => 'required|integer',
        'jk' => 'required|in:L,P',
        'alamat' => 'nullable|string|max:500',
        'agama' => 'nullable|string|max:100',
    ]);

    // Ambil data siswa berdasarkan NIS
    $Siswa = Siswa::where('nis', $request->nis)->firstOrFail();

        // Update data siswa tanpa perusahaanID
        $Siswa->update($validatedData);
  

    return redirect()->route('admin.siswa')->with('success', 'Data berhasil diperbarui!');
}

public function destroy(Request $request)
{
    try {
        // Cari data siswa berdasarkan NIS
        $siswa = Siswa::where('nis', $request->nis)->first();

        if (!$siswa) {
           return redirect()->route('admin.siswa')->with('error', 'Data siswa tidak ditemukan!');
        }

        // Cek apakah ada pengajuan PKL yang diterima
        $pengajuanPKL = PengajuanPkl::where('nis', $request->nis)
        ->where('pengajuanID', $request->pengajuanID)
            ->where('status_pengajuan', 'diterima')
            ->first();

        // Hapus data siswa
        $siswa->delete();

        // Hapus data pengajuan PKL jika ditemukan
        if ($pengajuanPKL) {
            $pengajuanPKL->delete();
        }

        // Redirect dengan pesan sukses
        return redirect()->route('admin.siswa')->with('success', 'Data berhasil dihapus!');
    } catch (\Exception $e) {
        // Tangani error dan tampilkan pesan
        return redirect()->route('admin.siswa')->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
    }
}
}
