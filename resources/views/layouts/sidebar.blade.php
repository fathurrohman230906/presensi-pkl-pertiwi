@php
  $isAdmin = Auth::guard('admin')->check();
  $isPembimbing = Auth::guard('pembimbing')->check();
  $isWali_Kelas = Auth::guard('wali_kelas')->check();

  $WaliKelas_Admin = $isAdmin || $isWali_Kelas;
  if($isAdmin) {
  $Dashboard = '/admin-dashboard';
  $DataPerusahaan = '/data-perusahaan';
  $KelolaSiswa = '/data-siswa';
  $KelolaKelas = '/data-kelas';
  $waliKelas = '/data-wali-kelas';
} elseif ($isPembimbing) {
  $Dashboard = '/pembimbing-dashboard';
  $Persetujuan = '/internship-persetujuan';
  $DataPerusahaan = '/kelola-perusahaan';
  $LaporanKegiatan = '/laporan';
  $KelolaSiswa = '/kelola-siswa';
  $KelolaKelas = '/kelola-kelas';
  $KelolaPresensi = '/presensi-internship';
  $waliKelas = '/wali-kelas';
} elseif ($isWali_Kelas) {
  $nis = session('nis');
  $Dashboard = '/wali-kelas-dashboard';
  $DataPerusahaan = '/perusahaan';
  $KelolaPresensi = '/kelola-presensi';
  $LaporanKegiatan = '/laporan';
}

$PageDashboard = ($titlePage === "Dashboard");
$PagePerusahaan = ($titlePage === "Data Perusahaan");
$PageKelolaPresensi = ($titlePage === "Kelola Presensi");
$PageLaporanKegiatanSiswa = ($titlePage === "Laporan Kegiatan Siswa");
$PageKelolaSiswa = ($titlePage === "Kelola Siswa");
$PagePersetujuanPKL = ($titlePage === "Persetujuan PKL");
$PageKelolaWaliKelas = ($titlePage === "Kelola Wali Kelas");
$PageKelolaKelas = ($titlePage === "Kelola Kelas");
@endphp
<aside class="left-sidebar sidebar-dark" id="left-sidebar">
  <div id="sidebar" class="sidebar sidebar-with-footer">
    <!-- Aplication Brand -->
    <div class="app-brand">
      <a href="/index.html">
        <img src="{{ asset('assets/images/logo.png') }}" alt="Mono">
        <span class="brand-name">Presensi PKL</span>
      </a>
    </div>
    <!-- begin sidebar scrollbar -->
    <div class="sidebar-left" data-simplebar style="height: 100%;">
      <!-- sidebar menu -->
      <ul class="nav sidebar-inner" id="sidebar-menu">
        <li class="{{ $PageDashboard ? 'active' : '' }}">
          <a class="sidenav-item-link" href="{{ $Dashboard }}">
            <i class="mdi mdi-view-dashboard"></i> <!-- Changed to a more relevant icon -->
            <span class="nav-text">Dashboard</span>
          </a>
        </li>
        
        <li class="section-title">
          Menu Utama
        </li>

        <li class="{{ $PagePerusahaan ? 'active' : '' }}">
          <a class="sidenav-item-link" href="{{ $DataPerusahaan ?? '' }}">
            <i class="mdi mdi-{{ $isWali_Kelas ? 'account-group' : 'office-building' }}"></i> <!-- Icon for company data -->
            <span class="nav-text">{{ $isWali_Kelas ? 'Kelola Siswa' : 'Data Perusahaan' }}</span>
          </a>
        </li>

        <li class="{{ $isWali_Kelas ? 'd-none' : 'd-block' }} {{ $PageKelolaSiswa ? 'active' : '' }}">
          <a class="sidenav-item-link" href="{{ $KelolaSiswa ?? '' }}">
            <i class="mdi mdi-school"></i> <!-- Icon for student data -->
            <span class="nav-text">Data Siswa</span>
          </a>
        </li>

        <li class="{{ $WaliKelas_Admin ? 'd-none' : 'd-block' }} {{ $PagePersetujuanPKL ? 'active' : '' }}">
          <a class="sidenav-item-link" href="{{ $Persetujuan ?? '' }}">
            <i class="bi bi-journal-check"></i> <!-- Icon for student data -->
            <span class="nav-text">Persetujuan PKL</span>
          </a>
        </li>

        <li class="{{ $isWali_Kelas ? 'd-none' : 'd-block' }} {{ $PageKelolaKelas ? 'active' : '' }}">
          <a class="sidenav-item-link" href="{{ $KelolaKelas ?? '' }}">
            <i class="mdi mdi-domain"></i> <!-- Icon for class data -->
            <span class="nav-text">Data Kelas</span>
          </a>
        </li>

        <li class="{{ $isWali_Kelas ? 'd-none' : 'd-block' }} {{ $PageKelolaWaliKelas ? 'active' : '' }}">
          <a class="sidenav-item-link" href="{{ $waliKelas ?? '' }}">
            <i class="mdi mdi-account-group"></i> <!-- Icon for class supervisor -->
            <span class="nav-text">Data Wali Kelas</span>
          </a>
        </li>

        <li class="{{ $isWali_Kelas ? 'd-none' : 'd-block' }} {{ session('level') === 'pembimbing' ? 'd-none' : 'd-block' }}">
          <a class="sidenav-item-link" href="data-wali-kelas.html">
            <i class="mdi mdi-account-group"></i> <!-- Icon for class supervisor -->
            <span class="nav-text">Data Pembimbing</span>
          </a>
        </li>        

        <li class="{{ $PageKelolaPresensi ? 'active' : '' }}">
          <a class="sidenav-item-link" href="{{ $KelolaPresensi ?? '' }}">
            <i class="mdi mdi-calendar-check"></i>
            <span class="nav-text">Kelola Presensi</span>
          </a>
        </li>

        <li class="{{ $PageLaporanKegiatanSiswa ? 'active' : '' }}">
          <a class="sidenav-item-link" href="{{ $LaporanKegiatan ?? '' }}">
            <i class="mdi mdi-file-document-box"></i> <!-- Icon for activity reports -->
            <span class="nav-text">Laporan Kegiatan</span>
          </a>
        </li>
      </ul>
    </div>

    {{-- <div class="sidebar-footer">
      <div class="sidebar-footer-content">
        <ul class="d-flex">
          <li>
            <a href="user-account-settings.html" data-toggle="tooltip" title="Profile settings">
              <i class="mdi mdi-settings"></i>
            </a>
          </li>
          <li>
            <a href="#" data-toggle="tooltip" title="No chat messages">
              <i class="mdi mdi-chat-processing"></i>
            </a>
          </li>
        </ul>
      </div>
    </div> --}}
  </div>
</aside>
