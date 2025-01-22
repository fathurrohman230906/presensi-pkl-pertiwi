<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\PengajuanPkl;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\Log;
use Psy\Readline\Hoa\Console;

class PresensiController extends Controller
{
    public function Presensi() {

        $PengajuanPkl = PengajuanPkl::with('perusahaan')->where('nis', session('nis'))->get();
        
        foreach ($PengajuanPkl as $PengajuanPklSiswa) {
            $perusahaanID = $PengajuanPklSiswa->perusahaan->perusahaanID;
            $jam_masuk = $PengajuanPklSiswa->jam_masuk;
            $jam_keluar = $PengajuanPklSiswa->jam_keluar;
        
            $jamMasuk = \Carbon\Carbon::parse($jam_masuk)->format('H:i:s');
            $jamKeluar = \Carbon\Carbon::parse($jam_keluar)->format('H:i:s');
            
            // Set current time to Asia/Jakarta timezone
            $currentTime = Carbon::now('Asia/Jakarta')->format('H:i:s');
            
            // Cek jika jam masuk belum tercapai
            if ($currentTime < $jamMasuk) {
                return redirect('/siswa-dashboard')->with('peringatan', 'Maaf belum waktunya absen');
            }
        
            // Jika waktu sudah lewat (telat), lakukan pengecekan apakah sudah lewat jam keluar atau belum
            if ($currentTime >= $jamMasuk && $currentTime < $jamKeluar) {
                // Jika masih dalam jam kerja, Anda bisa menampilkan peringatan atau melakukan apa yang perlu dilakukan
            } else {
                // Jika sudah lewat jam keluar, mungkin perlu menunjukkan bahwa siswa sudah tidak bisa absen atau ada tindakan lainnya
            }
        }
        
        
        

        $Presensi = Presensi::where('nis', session('nis'))->get();



        return view('siswa.Presensi.internship-presensi', [
            'titlePage' => 'Pengajuan PKL',
            'perusahaanID' => $perusahaanID,
            'Presensi' => $Presensi,
        ]);
        
    }

    public function PresensiPulang() {
        $Presensi = Presensi::where('nis', session('nis'))->first();
        $PengajuanPkl = PengajuanPkl::where('nis', session('nis'))->get();
    
        // Pastikan ada data pengajuan PKL dan presensi
        if (!$PengajuanPkl || !$Presensi) {
            return redirect()->back()->with('peringatan', 'Data tidak ditemukan');
        }
    
        // Loop melalui data Pengajuan PKL
        foreach ($PengajuanPkl as $DataPengajuan) {
            // Ambil waktu sekarang
            $now = Carbon::now('Asia/Jakarta');
            $jam_sekarang = $now->format('H:i:s');

            // dd($jam_sekarang);
            // Ambil jam keluar dari Pengajuan PKL
            $jamKeluar = $DataPengajuan->jam_keluar;
            // Periksa apakah waktu sekarang sebelum jam keluar
            if ($jamKeluar > $jam_sekarang || $jamKeluar == $jam_sekarang) {
                // Jika waktu sekarang sebelum jam keluar, tampilkan pesan peringatan
                return redirect()->back()->with('pulang_awal', 'Waktu keluar belum tiba.');
            }
        }
    
        // Jika waktu sudah tepat atau lebih, tampilkan halaman presensi
        return view('siswa.Presensi.internship-presensi-pulang', [
            'titlePage' => 'Pengajuan PKL',
            'Presensi' => $Presensi,
        ]);
    }

    // public function ProsesPresensi(Request $request) {
    //     dd($request->all());
    //     $lokasi = json_decode($request['lokasi'], true); // true to return an associative array
    //     // Now you can access the latitude like this:
    //     $latitude = $lokasi['latitude'];
    //     $longitude = $lokasi['longitude'];
    //     // dd($longitude);
    // }
    public function ProsesPresensi(Request $request)
    {
      dd($request->all());
        try {
            // Validate the incoming request
            $request->validate([
                'lokasi' => 'required|json',
                'nis' => 'required|string',
                'perusahaanID' => 'required|integer',
                'foto' => 'nullable|string',
            ]);
    
            // Decode the JSON location data
            $lokasi = json_decode($request->lokasi, true);
        
            $latitude = $lokasi['latitude'] ?? null;
            $longitude = $lokasi['longitude'] ?? null;
        
            // If no location data was received, handle it appropriately
            if (!$latitude || !$longitude) {
                throw new \Exception('Location data is missing or invalid.');
            }
        
            // Get the current time for 'masuk' and 'tgl_presensi' fields
            $now = Carbon::now('Asia/Jakarta');
            $tgl_presensi = $now->format('Y-m-d');
            $masuk = $now->format('H:i:s');
        
            // Get other form data
            $nis = $request->nis;
            $perusahaanID = $request->perusahaanID;
            $foto = $request->foto;
        
            // Process the photo (base64 encoded image from webcam)
            $imageName = null;
            if ($foto) {
                $imageData = base64_decode(str_replace('data:image/jpeg;base64,', '', $foto));
                $imageName = 'presensi_' . time() . '.jpg';
        
                // Ensure the directory exists
                $directory = public_path('storage/FotoPresensi/Masuk');
                if (!file_exists($directory)) {
                    mkdir($directory, 0777, true);  // Create the directory if it doesn't exist
                }
        
                // Save the image
                $path = $directory . '/' . $imageName;
                if (!file_put_contents($path, $imageData)) {
                    throw new \Exception('Failed to save the photo.');
                }
            }
        
            // Save the presensi data to the database
            Presensi::create([
                'nis' => $nis,
                'perusahaanID' => $perusahaanID,
                'tgl_presensi' => $tgl_presensi,
                'masuk' => $masuk,
                'status_presensi' => 'hadir',
                'foto' => $imageName ?? null,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'status_absen' => "true",
            ]);
        
            // Return a success response
            return redirect()->route('siswa.dashboard')->with('success', 'Anda Berhasil Absen dan semangat beraktivitas!');
        
        } catch (\Exception $e) {
            // Log the error
            Log::error('ProsesPresensi failed: ' . $e->getMessage(), [
                'request' => $request->all(),
                'error' => $e->getTraceAsString(),
            ]);
        
            // Return a meaningful error response
            return redirect()->back()->with([
                'peringatan' => 'Terjadi kesalahan saat memproses absen',
                'errorDetails' => $e->getMessage()
            ]);
        }
    }
    
    public function ProsesPresensiPulang(Request $request)
    {
        try {
            // Validate the incoming request
            $request->validate([
                'lokasi' => 'required|json',
                'foto_pulang' => 'nullable|string',
            ]);
    
            // Decode the JSON location data
            $lokasi = json_decode($request->lokasi, true);
            $latitude_pulang = $lokasi['latitude'] ?? null;
            $longitude_pulang = $lokasi['longitude'] ?? null;
    
            // If no location data was received, handle it appropriately
            if (!$latitude_pulang || !$longitude_pulang) {
                throw new \Exception('Lokasi anda tidak di tempat PKL!');
            }
    
            // Get current time for "pulang"
            $now = Carbon::now('Asia/Jakarta');
            $pulang = $now->format('H:i:s');
            $tgl_pulang = $now->format('Y-m-d');
    
            // Check if there's an existing entry for today
            $dataMasuk = Presensi::where('tgl_presensi', $tgl_pulang)
                                 ->where('nis', session('nis'))
                                 ->first();
    
            if (!$dataMasuk) {
                throw new \Exception('Tidak ada presensi masuk untuk hari ini.');
            }
    
            // Retrieve the entry and update it
            $presensiID = $dataMasuk->presensiID;
            $presensi = Presensi::where('presensiID', $presensiID);
            
            $imageName = null;
            if ($request->foto_pulang) {
                $imageData = base64_decode(str_replace('data:image/jpeg;base64,', '', $request->foto_pulang));
                $imageName = 'presensi_pulang_' . time() . '.jpg';
    
                // Ensure the directory exists
                $directory = public_path('storage/FotoPresensi/Pulang');
                if (!file_exists($directory)) {
                    mkdir($directory, 0777, true);  // Create the directory if it doesn't exist
                }
    
                // Save the image
                $path = $directory . '/' . $imageName;
                if (!file_put_contents($path, $imageData)) {
                    throw new \Exception('Failed to save the photo.');
                }
            }
    
            // Update the presensi record with "pulang" time and status
            $presensi->update([
                'status_absen' => "selesai",
                'pulang' => $pulang,
                'foto_pulang' => $imageName ?? null,
            ]);
    
            // Return a success response
            return redirect()->route('siswa.dashboard')->with('success', 'Anda Sudah pulang, terima kasih sudah berkontribusi di tempat PKL!');
        
        } catch (\Exception $e) {
            // Log the error
            Log::error('ProsesPresensiPulang failed: ' . $e->getMessage(), [
                'request' => $request->all(),
                'error' => $e->getTraceAsString(),
            ]);
        
            // Return a meaningful error response
            return redirect()->back()->with([
                'peringatan'=> 'Terjadi kesalahan saat memproses absen pulang',
                'errorDetails' => $e->getMessage()
            ]);
        }
    }
    

    public function SakitDanIzin(Request $request)
    {
        try {
            // Validate the input
            $request->validate([
                'keterangan' => 'required|string|max:255',
                'foto' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048', // Foto bisa berupa file gambar atau PDF
            ]);
    
            // Decode location data
            $lokasi = json_decode($request->lokasi, true);
            $latitude = $lokasi['latitude'] ?? null;
            $longitude = $lokasi['longitude'] ?? null;
    
            // Save the sick/izin record
            $presensi = new Presensi();
            $presensi->nis = $request->nis;
            $presensi->perusahaanID = $request->perusahaanID;
            $presensi->status_presensi = $request->status_presensi;
            $presensi->tgl_presensi = $request->tgl_presensi;
            $presensi->latitude = $latitude;
            $presensi->longitude = $longitude;
            $presensi->keterangan = $request->keterangan;
    
            // Save the supporting document (if any)
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $path = $file->store('bukti_surat', 'public'); // Save in 'public/uploads/foto_surat'
                $presensi->foto = $path;
            }
    
            // Save to the database
            $presensi->save();
    
            // Return a success response
            return redirect()->route('siswa.dashboard')->with('success', 'Bukti surat presensi berhasil diproses.');
        
        } catch (\Exception $e) {
            // Log the error
            Log::error('SakitDanIzin failed: ' . $e->getMessage(), [
                'request' => $request->all(),
                'error' => $e->getTraceAsString(),
            ]);

            // Return a meaningful error response
            return redirect()->back()->with([
                'peringatan' => 'Terjadi kesalahan saat memproses izin atau sakit',
                'errorDetails' => $e->getMessage() // Pass the error message to frontend
            ]);
        }
    }

    public function PulangCepat(Request $request)
    {
        try {
            // Validate the input
            $request->validate([
                'keterangan' => 'required|string|max:255',
                'status_absen' => 'required',
                'foto' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048', // Foto bisa berupa file gambar atau PDF
            ]);
    
            // Decode location data
            $lokasi = json_decode($request->lokasi, true);
            $latitude = $lokasi['latitude'] ?? null;
            $longitude = $lokasi['longitude'] ?? null;
    
            // Save the sick/izin record
            $presensi = new Presensi();
            $presensi->nis = $request->nis;
            $presensi->perusahaanID = $request->perusahaanID;
            $presensi->status_presensi = $request->status_presensi;
            $presensi->status_absen = $request->status_absen;
            $presensi->tgl_presensi = $request->tgl_presensi;
            $presensi->latitude = $latitude;
            $presensi->longitude = $longitude;
            $presensi->keterangan = $request->keterangan;
    
            // Save the supporting document (if any)
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $path = $file->store('bukti_surat', 'public'); // Save in 'public/uploads/foto_surat'
                $presensi->foto = $path;
            }
    
            // Save to the database
            $presensi->save();
    
            // Return a success response
            return redirect()->route('siswa.dashboard')->with('success', 'Bukti surat presensi berhasil diproses.');
        
        } catch (\Exception $e) {
            // Log the error
            Log::error('SakitDanIzin failed: ' . $e->getMessage(), [
                'request' => $request->all(),
                'error' => $e->getTraceAsString(),
            ]);

            // Return a meaningful error response
            return redirect()->back()->with([
                'peringatan' => 'Terjadi kesalahan saat memproses izin atau sakit',
                'errorDetails' => $e->getMessage() // Pass the error message to frontend
            ]);
        }
    }

    public function PresensiHistory() {
        $bulan = Carbon::now()->format('m');
        $tahun = Carbon::now()->format('Y');
    
        // Ambil data presensi sesuai dengan nis, tahun, dan bulan
        $Presensi = Presensi::where('nis', session('nis'))
                            ->whereYear('tgl_presensi', $tahun)  // Filter berdasarkan tahun
                            ->whereMonth('tgl_presensi', $bulan) // Filter berdasarkan bulan
                            ->get();
    
        return view('siswa.Presensi.internship-presensi-history', [
            'titlePage' => 'Pengajuan PKL',
            'Presensi' => $Presensi,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);
    }
    

    public function CariHistory(Request $request)
    {
        // dd($request->all());
        // Get the selected month and year from the form
            $bulan = $request->input('bulan');
            $tahun = $request->input('tahun');

        // Get the presensi data for the selected month and year
        $Presensi = Presensi::whereMonth('tgl_presensi', $bulan)
                            ->whereYear('tgl_presensi', $tahun)
                            ->get();

        // Return the view with the filtered data
        return view('siswa.Presensi.internship-presensi-history', compact('Presensi', 'bulan', 'tahun'));
    }
}
