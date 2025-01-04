<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KegiatanPkl;
use App\Models\Siswa;
use Carbon\Carbon;
use App\Models\PengajuanPkl;

class LaporanKegiatanSiswa extends Controller
{   
public function LaporanKegiatan() 
{
    $KegiatanPkl = KegiatanPkl::all();
        
        $bulanTahun = $KegiatanPkl->pluck('tgl_kegiatan')->map(function ($tgl) {
            return Carbon::parse($tgl)->format('F Y'); // Ubah format menjadi "Bulan Tahun"
        })->unique();
        
        // Cek bulan dan tahun saat ini
        $currentMonthYear = Carbon::now()->format('F Y');
        
        // Jika bulan dan tahun saat ini tidak ada di koleksi, tambahkan secara manual
        if (!$bulanTahun->contains($currentMonthYear)) {
            $bulanTahun->push($currentMonthYear);
        }
    
    // Current date
    $currentDate = Carbon::now();
    $formattedDate = $currentDate->format('d-m-Y');
    $fullDate = $currentDate->locale('id')->isoFormat('dddd, D MMMM YYYY');

    // Get student activities based on NIS
    $nis = session('nis');
    $tgl_kegiatan_sekarang = Carbon::now()->format('Y-m-d'); // Today's date
    // dd($tgl_kegiatan_sekarang);
    $KegiatanPklSiswa = KegiatanPkl::with('siswa')->where('nis', $nis)->get();

    // Group activities by date
    if ($KegiatanPklSiswa->isNotEmpty()) {
        $tglKegiatan = $KegiatanPklSiswa->groupBy('tgl_kegiatan');
    }

    // If no activities for today, initialize empty collection for today's activities
    if (!isset($tglKegiatan[$tgl_kegiatan_sekarang])) {
        $tglKegiatan[$tgl_kegiatan_sekarang] = collect(); 
    }

    $formattedTgl = Carbon::now()->format('m-Y');
    // Fetch the student's internship application data for the entry and exit months
    $PengajuanPkl = PengajuanPkl::with('perusahaan', 'siswa')->where('nis', $nis)->get();

    foreach ($PengajuanPkl as $PengajuanbulanPKL) {
        $bulan_masuk = Carbon::parse($PengajuanbulanPKL->bulan_masuk)->format('m');
        $tahun_masuk = Carbon::parse($PengajuanbulanPKL->bulan_masuk)->format('Y');
        
        $bulan_keluar = Carbon::parse($PengajuanbulanPKL->bulan_keluar)->format('m');
        $tahun_keluar = Carbon::parse($PengajuanbulanPKL->bulan_keluar)->format('Y');
    }

    // Pass data to the view
    return view('siswa.kegiatan.kegiatan-pkl', [
        "titlePage" => "Kegiatan Siswa",
        "KegiatanPkl" => $tglKegiatan,
        "bulanTahun" => $bulanTahun, 
        "fullDate" => $fullDate, 
        "bulan_masuk" => $bulan_masuk, 
        "bulan_keluar" => $bulan_keluar, 
        "tahun_keluar" => $tahun_keluar, 
        "tahun_masuk" => $tahun_masuk, 
        "formattedTgl" => $formattedTgl, 
        "currentDate" => $currentDate->format('Y-m-d'), // Send today's date
    ]);
}

    public function createLaporanKegiatan(Request $request) 
    {
        // Validasi input data
        $DataKegiatan = $request->validate([
            "nis" => "required|max:12|min:12",
            "deskripsi_kegiatan" => "required",
        ]);
    
        // Set tgl_kegiatan ke tanggal sekarang dengan zona waktu 'Asia/Jakarta'
        $DataKegiatan['tgl_kegiatan'] = Carbon::now('Asia/Jakarta')->toDateString(); // Ambil hanya tanggalnya, tanpa waktu
    
        // Buat entri baru di tabel kegiatan_pkl
        $kegiatanPKL = KegiatanPkl::create($DataKegiatan);
    
        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Berhasil')->with('bulanTahun', $request->input('bulanTahun'));
        // return redirect()->back()->with('success', 'Berhasil');
        // return redirect()->route('laporan.kegiatan.siswa')->with('success', 'Berhasil');
    }
    
    
    
    public function checkboxKegiatanSiswa(Request $request) {
        $kegiatanPKL = KegiatanPkl::where('kegiatanID', $request->kegiatanID);
        // Update the status_kegiatan field (you might want to adjust this field and logic as necessary)
        $kegiatanPKL->update([
            "status_kegiatan" => "diterima", // Assuming you're setting the status to true, adjust as needed
        ]);
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Berhasil')->with('bulanTahun', $request->input('bulanTahun'));
        // return redirect()->back()->with('success', 'Data kegiatan siswa telah diperbarui!');
    }

    public function deleteKegiatanSiswa(Request $request)
    {
        $DataKegiatan = $request->validate([
            "kegiatanID" => "required"
        ]);

        $KegiatanPkl = KegiatanPkl::where('kegiatanID', $request->kegiatanID);
        $KegiatanPkl->delete();
        return redirect()->back()->with('success', 'Berhasil')->with('bulanTahun', $request->input('bulanTahun'));
        // return redirect()->back()->with('success', 'Data kegiatan siswa telah diperbarui!');
    }

    public function cariKegiatanSiswa(Request $request)
    {
        // dd($request->all());
        // Ambil input tgl_kegiatan, pastikan dalam format 'MM-YYYY'
        $inputDate = $request->tgl_kegiatan;
        try {
            // Parse input menjadi bulan dan tahun
            $parsedDate = Carbon::createFromFormat('m-Y', $inputDate);
            $bulan = $parsedDate->month; // Contoh: 11
            $tahun = $parsedDate->year;  // Contoh: 2024
        } catch (\Exception $e) {
            // Jika format salah, kembali ke halaman laporan dengan pesan error
            return redirect()->route('laporan.kegiatan.siswa')
                             ->withErrors(['tgl_kegiatan' => 'Format tanggal tidak valid. Gunakan format MM-YYYY.']);
        }
    
        // Filter berdasarkan bulan dan tahun
        $KegiatanPkl = KegiatanPkl::whereMonth('tgl_kegiatan', $bulan)
                                   ->whereYear('tgl_kegiatan', $tahun);
    
        // Ambil tahun-bulan unik dari tgl_kegiatan
        $bulanTahunUnik = $KegiatanPkl->pluck('tgl_kegiatan')
                                      ->map(function ($tgl) {
                                          return Carbon::parse($tgl)->format('Y-m');
                                      })
                                      ->unique();
    
        // Check apakah data untuk bulan-tahun tersebut ada
        $bulanFilterFormat = $parsedDate->format('Y-m'); // Format sebagai 'YYYY-MM'
        if ($bulanTahunUnik->contains($bulanFilterFormat)) {
            return redirect('result-cari-kegiatan-siswa/' . $inputDate);
        } else {
            return redirect()->route('laporan.kegiatan.siswa');
        }
    }
    

    public function resultCariKegiatanSiswa($tgl_kegiatan) 
    {
        // Cek jika $tgl_kegiatan tidak null atau kosong
        if ($tgl_kegiatan) {
            try {
                // Cek apakah input $tgl_kegiatan hanya bulan atau bulan dan tahun
                $carbonDate = Carbon::parse($tgl_kegiatan);
            } catch (\Exception $e) {
                // Jika gagal, anggap $tgl_kegiatan adalah bulan saja dan gunakan tahun saat ini
                $carbonDate = Carbon::parse("01-" . $tgl_kegiatan . "-" . Carbon::now()->year); // Format dd-mm-yyyy
            }
    
            // Format tanggal yang valid sebagai 'Y-m' untuk pencarian di database
            $formattedTgl = $carbonDate->format('Y-m'); // Format untuk pencarian bulan dan tahun
        } else {
            // Jika tidak ada parameter $tgl_kegiatan, gunakan bulan dan tahun sekarang
            $formattedTgl = Carbon::now()->format('Y-m'); // Gunakan bulan dan tahun sekarang
        }
        // Ambil semua data kegiatan PKL sesuai dengan bulan dan tahun yang diformat
        $KegiatanPkl = KegiatanPkl::whereYear('tgl_kegiatan', Carbon::parse($formattedTgl)->year)
                                   ->whereMonth('tgl_kegiatan', Carbon::parse($formattedTgl)->month)
                                   ->get();
    
        // Cek jika data kegiatan kosong, jika iya, ambil data untuk bulan dan tahun saat ini
        if ($KegiatanPkl->isEmpty()) {
            $bulanTahun = [Carbon::now()->format('F Y')]; // Array dengan bulan dan tahun sekarang
        } else {
            // Ambil bulan dan tahun yang unik berdasarkan data kegiatan yang ada
            $bulanTahun = $KegiatanPkl->pluck('tgl_kegiatan')->map(function ($tgl) {
                return Carbon::parse($tgl)->format('F Y');
            })->unique();
        }
        
        // Ambil tanggal saat ini untuk menampilkan di tampilan
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->format('d-m-Y');
        $fullDate = $currentDate->locale('id')->isoFormat('dddd, D MMMM YYYY'); // Tanggal lengkap dalam format Indonesia
    
        // Ambil kegiatan siswa sesuai dengan NIS
        $nis = session('nis');
        $KegiatanPklSiswa = KegiatanPkl::with('siswa')
                                        ->where('nis', $nis)
                                        ->whereYear('tgl_kegiatan', Carbon::parse($formattedTgl)->year)
                                        ->whereMonth('tgl_kegiatan', Carbon::parse($formattedTgl)->month)
                                        ->get();
        
        // Kelompokkan kegiatan berdasarkan tanggal
        if ($KegiatanPklSiswa->isNotEmpty()) {

            $tglKegiatan = $KegiatanPklSiswa->groupBy('tgl_kegiatan');
        } else {
            $tglKegiatan = collect([$formattedDate => collect()]); // Fallback jika tidak ada kegiatan untuk siswa
        }
    
        // Ambil data pengajuan PKL untuk siswa
        $PengajuanPkl = PengajuanPkl::with('perusahaan', 'siswa')
                                   ->where('nis', $nis)
                                   ->get();
        
        // Inisialisasi variabel bulan masuk dan bulan keluar
        $bulan_masuk = null;
        $bulan_keluar = null;
        
        foreach ($PengajuanPkl as $PengajuanbulanPKL) {
            $bulan_masuk = Carbon::parse($PengajuanbulanPKL->bulan_masuk)->format('m');
            $tahun_masuk = Carbon::parse($PengajuanbulanPKL->bulan_masuk)->format('Y');
            
            $bulan_keluar = Carbon::parse($PengajuanbulanPKL->bulan_keluar)->format('m');
            $tahun_keluar = Carbon::parse($PengajuanbulanPKL->bulan_keluar)->format('Y');
        }
        
        // Kirim data ke tampilan (view)
        return view('siswa.kegiatan.result-cari-kegiatan-pkl', [
            "titlePage" => "Kegiatan Siswa",
            "KegiatanPkl" => $tglKegiatan, // Kegiatan yang sudah dikelompokkan berdasarkan tanggal
            "bulanTahun" => $bulanTahun, // Daftar bulan tahun yang ada
            "fullDate" => $fullDate, // Tanggal penuh dalam format Indonesia
            "bulan_masuk" => $bulan_masuk, // Bulan masuk PKL
            "bulan_keluar" => $bulan_keluar, // Bulan keluar PKL
            "tahun_keluar" => $tahun_keluar, 
            "tahun_masuk" => $tahun_masuk, 
            "formattedTgl" => $formattedTgl, 
        ]);
    }
    
    
}
