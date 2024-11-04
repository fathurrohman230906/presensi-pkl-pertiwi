<aside class="left-sidebar sidebar-dark" id="left-sidebar">
  <div id="sidebar" class="sidebar sidebar-with-footer">
    <!-- Application Brand -->
    @php
$isSiswa = Auth::guard('siswa')->check();
$isAdmin = Auth::guard('admin')->check();
$isPembimbing = Auth::guard('pembimbing')->check();
$isWaliKelas = Auth::guard('wali_kelas')->check();

$isAdminPembimbingWaliKelas = $isAdmin || $isPembimbing || $isWaliKelas;

if ($isAdmin) {
  $dashboard = '/admin-dashboard';
  $DataPerusahaan = '/data-perusahaan';
} elseif ($isPembimbing) {
  // Handle Pembimbing specific logic if needed
} elseif ($isSiswa) {
  // $nis = session('nis'); // Uncomment if needed
} elseif ($isWaliKelas) {
  // Handle Wali Kelas specific logic if needed
}

$PerusahaanPage = ($titlePage === "Data Perusahaan");
$DashboardPage = ($titlePage === "dashboard");
@endphp

    <div class="app-brand">
      <a href="/index.html">
        <img src="{{ asset('assets/images/logo.png') }}" alt="Logo website" class="me">
        <span class="brand-name">Presensi PKL</span>
      </a>
    </div>
    <!-- begin sidebar scrollbar -->
    <div class="sidebar-left" data-simplebar style="height: 100%;">
      <!-- sidebar menu -->
      <ul class="nav sidebar-inner" id="sidebar-menu">
          <li class="{{ $DashboardPage ? 'active' : '' }}">
            <a class="sidenav-item-link" href="{{ $dashboard }}">
              <i class="mdi mdi-view-dashboard"></i>
              <span class="nav-text">Dashboard</span>
            </a>
          </li>
          
          <li class="section-title text-capitalize">
            menu utama
          </li>
      
          <li class="{{ $PerusahaanPage ? 'active' : '' }} {{ $isSiswa ? 'd-none' : 'd-block' }}">
            <a class="sidenav-item-link" href="{{ $isAdminPembimbingWaliKelas ? $DataPerusahaan : '' }}">
              <i class="mdi mdi-office-building"></i>
              <span class="nav-text">Data Perusahaan</span>
            </a>
          </li>
          
          <li>
            <a class="sidenav-item-link" href="data-siswa.html">
              <i class="mdi mdi-account-multiple"></i>
              <span class="nav-text">Data Siswa</span>
            </a>
          </li>
          
          <li>
            <a class="sidenav-item-link" href="data-pembimbing.html">
              <i class="mdi mdi-account-tie"></i>
              <span class="nav-text">Data Pembimbing</span>
            </a>
          </li>
          
          <li>
            <a class="sidenav-item-link" href="data-wali-kelas.html">
              <i class="mdi mdi-account-supervisor"></i>
              <span class="nav-text">Data Wali Kelas</span>
            </a>
          </li>
          
          <li>
            <a class="sidenav-item-link" href="data-kelas.html">
              <i class="mdi mdi-school"></i>
              <span class="nav-text">Data Kelas</span>
            </a>
          </li>
          
          <li>
            <a class="sidenav-item-link" href="data-permintaan-pkl.html">
              <i class="mdi mdi-file-send"></i>
              <span class="nav-text">Data Permintaan PKL</span>
            </a>
          </li>
          
          <li>
            <a class="sidenav-item-link" href="data-persetujuan-pkl.html">
              <i class="mdi mdi-check-circle"></i>
              <span class="nav-text">Data Persetujuan PKL</span>
            </a>
          </li>
          
          <li>
            <a class="sidenav-item-link" href="data-presensi.html">
              <i class="mdi mdi-calendar-check"></i>
              <span class="nav-text">Data Presensi</span>
            </a>
          </li>
          
          <li>
            <a class="sidenav-item-link" href="laporan-kegiatan.html">
              <i class="mdi mdi-file-document"></i>
              <span class="nav-text">Laporan Kegiatan</span>
            </a>
          </li>
      </ul>
    </div>
  </div>
</aside>
