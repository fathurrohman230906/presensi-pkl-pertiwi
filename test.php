public function LaporanKegiatan() 
{
    $KegiatanPkl = KegiatanPkl::all();
    
    // Check if the database has data, if not, use the current date
    if ($KegiatanPkl->isEmpty() || $KegiatanPkl->groupBy('tgl_kegiatan') == null) {
        $bulanTahun = [Carbon::now()->format('F Y')]; // Array of current month-year if no data
    } else {
        // Extract unique 'tgl_kegiatan' formatted as 'F Y' (e.g., "October 2024")
        $bulanTahun = $KegiatanPkl->pluck('tgl_kegiatan')->map(function ($tgl) {
            return Carbon::parse($tgl)->format('F Y');
        })->unique(); 
    }

    // Get the current date for fallback
    $currentDate = Carbon::now();
    $formattedDate = $currentDate->format('d-m-Y');
    $fullDate = $currentDate->locale('id')->isoFormat('dddd, D MMMM YYYY');  // Full date format in Indonesian

    // Retrieve the student's activities grouped by date
    $nis = session('nis');
    $KegiatanPklSiswa = KegiatanPkl::with('siswa')->where('nis', $nis)->get();

    // Group the activities by 'tgl_kegiatan' (date)
    if ($KegiatanPklSiswa->isNotEmpty()) {
        $tglKegiatan = $KegiatanPklSiswa->groupBy('tgl_kegiatan');
    } else {
        $tglKegiatan = collect([$formattedDate => collect()]);
    }
    
    // Retrieve the student's PKL application data
    $PengajuanPkl = PengajuanPkl::with('perusahaan', 'siswa')->where('nis', $nis)->get();
    
    foreach ($PengajuanPkl as $PengajuanbulanPKL) {
        $bulan_masuk = Carbon::parse($PengajuanbulanPKL->bulan_masuk)->format('m');
        $bulan_keluar = Carbon::parse($PengajuanbulanPKL->bulan_keluar)->format('m');
    }

    // Pass the filtered KegiatanPkl and other data to the view
    return view('siswa.kegiatan.kegiatan-pkl', [
        "titlePage" => "Kegiatan Siswa",
        "KegiatanPkl" => $tglKegiatan, // Filtered kegiatan by nis
        "bulanTahun" => $bulanTahun, 
        "fullDate" => $fullDate, 
        "bulan_masuk" => $bulan_masuk, 
        "bulan_keluar" => $bulan_keluar, 
    ]);
}