<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use App\Models\Perusahaan;
use App\Models\PengajuanPkl;
use App\Models\Kelas;
use App\Models\Sekolah;
use App\Models\Siswa;
use Directory;

class PermintaanPklController extends Controller
{
    public function permintaanPkl() {
        if (empty(session('nis'))) {
            return redirect()->back()->with('error', 'NIS tidak ditemukan');
        }
    
        // Retrieve PengajuanPkl with relationships
        $PengajuanPkl = PengajuanPkl::with('perusahaan', 'siswa')->where('nis', session('nis'))->get();

        // ambil jurusan
        $siswa = Siswa::with('kelas')->where('nis', session('nis'));

        $kelasID = $siswa->first()->kelasID;
        
        $kelas = Kelas::with('jurusan')->where('kelasID', $kelasID);
        $jurusanID = $kelas->first()->jurusanID;

        $Jurusan = Jurusan::with('kelas')->where('jurusanID', $jurusanID);
        $nm_jurusan = $Jurusan->first()->nm_jurusan;
        // dd($jurusanID);

    
        return view('siswa.PermintaanPkl.permintaan-pkl', [
            'titlePage' => 'Permintaan PKL',
            'PengajuanPkl' => $PengajuanPkl,
            'nm_jurusan' => $nm_jurusan,
            // 'nm_perusahaan' => $nm_perusahaan,
        ]);
    }
    
    
    

    public function CreatepermintaanPkl() {
        $nis = session('nis');
        $siswa = Siswa::with('kelas')->where('nis', session('nis'));

        $kelasID = $siswa->first()->kelasID;
        
        $kelas = Kelas::with('jurusan')->where('kelasID', $kelasID);
        $jurusanID = $kelas->first()->jurusanID;

        $perusahaan = Perusahaan::with('siswa', 'pengajuan_pkl')->where('jurusanID', $jurusanID)->get();
        return view('siswa.PermintaanPkl.create-permintaan', [
            "titlePage" => "Permintaan PKL",
            "dataPerusahaan" => $perusahaan,
        ]);
    }

    public function storePermintaanPkl(Request $request) {
        // Custom validation messages
        $customMessages = [
            'perusahaanID.required' => 'Kolom Dunia Industri / Dinas wajib diisi.',
            'bulan_masuk.required' => 'Kolom Mulai Tanggal wajib diisi.',
            'bulan_keluar.required' => 'Kolom Sampai Tanggal wajib diisi.',
        ];
    
        // Validate the request data
        $validatedData = $request->validate([
            'nis' => 'required',
            'perusahaanID' => 'required',
            'bulan_masuk' => 'required|date',
            'bulan_keluar' => 'required|date|after_or_equal:bulan_masuk',
        ], $customMessages);
    
        // Cek apakah sudah ada pengajuan PKL untuk nis yang sama
        $hitungPengajuanPKL = PengajuanPkl::where('nis', $request->nis)->count();
    
        if ($hitungPengajuanPKL > 0) {
            // Jika sudah ada pengajuan PKL, tampilkan pesan
            return redirect('permintaan-pkl')->with('peringatan', 'Maaf, Anda sudah mengajukan PKL sebelumnya.');
        }
    
        // Add default status to the request data
        $validatedData['status_pengajuan'] = 'ditunggu';
    
        try {
            // Store the validated data into the database
            $store = PengajuanPkl::create($validatedData);
    
            // Check if the record was successfully created
            if ($store) {
                return redirect('permintaan-pkl')->with('success', 'Berhasil Mengajukan PKL. Silakan tunggu!');
            }
            
            // If not stored successfully, show failure message
            return redirect('permintaan-pkl')->with('peringatan', 'Maaf, gagal mengajukan PKL!');
        } catch (\Exception $e) {
            // Handle any exceptions (e.g., database issues)
            return redirect('permintaan-pkl')->with('peringatan', 'Terjadi kesalahan. Coba lagi nanti.');
        }
    }

    public function CetakPermintaanPKL() {
        // kota siswa
        // Desa Muncangela Kuningan Kec. Cipicung Kab. Kuningan
        $PengajuanPkl = PengajuanPkl::with('perusahaan', 'siswa')->where('nis', session('nis'))->where('status_pengajuan', 'diterima')->get();
        $dataSekolah = Sekolah::all();
        $nm_sekolah = $dataSekolah->first()->nm_sekolah;

        $siswa = Siswa::with('kelas')->where('nis', session('nis'));

        foreach ($PengajuanPkl as $dataPengajuan) {
            $nm_perusahaan = $dataPengajuan->perusahaan->nm_perusahaan;
        }
        $alamat = $siswa->first()->alamat;

        // Pisahkan string berdasarkan spasi
        $alamat_parts = explode(' ', $alamat);
        
        // Ambil bagian terakhir yang dianggap sebagai kota (berdasarkan format alamat)
        $Kota = end($alamat_parts);

        $kelasID = $siswa->first()->kelasID;
        $nm_lengkap = $siswa->first()->nm_lengkap;
        
        $kelas = Kelas::with('jurusan')->where('kelasID', $kelasID);
        $jurusanID = $kelas->first()->jurusanID;

        $Jurusan = Jurusan::with('kelas')->where('jurusanID', $jurusanID);
        $nm_jurusan = $Jurusan->first()->nm_jurusan;
        
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML(view('siswa.PermintaanPkl.cetak-pdf', [
            "pengajuan" => $PengajuanPkl, 
            "nm_jurusan" => $nm_jurusan, 
            "nm_lengkap" => $nm_lengkap,
            "nm_sekolah" => $nm_sekolah,
            "kota" => $Kota
        ]));
        $mpdf->Output($nm_perusahaan . '_' . $nm_lengkap . '.pdf', 'D');
        // $mpdf->Output();
    }
    
}
