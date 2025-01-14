<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication\AuthenticationMultiuserControllers;

// controller multiuser
use App\Http\Controllers\DashboardControllerMultiuser;
use App\Http\Controllers\ProfileUser\ProfileUserController;

// controller admin
use App\Http\Controllers\Admin\PerusahaanControllers;
use App\Http\Controllers\Admin\KelolaSiswaAdminControllers;
use App\Http\Controllers\Admin\PresensiControllerAdmin;
use App\Http\Controllers\Admin\SiswaImportController;
use App\Http\Controllers\Admin\KelasSiswaAdminControllers;
use App\Http\Controllers\Admin\WaliKelasSiswaAdminControllers;
// controller Pembimbing
use App\Http\Controllers\Pembimbing\KelolaSiswaPembimbingControllers;
use App\Http\Controllers\Pembimbing\PersetujuanPKLPembimbingControllers;
use App\Http\Controllers\Pembimbing\PerusahaanPembimbingController;
use App\Http\Controllers\Pembimbing\PresensiPembimbingControllers;
use App\Http\Controllers\Pembimbing\WaliKelasDanSiswaPembimbingControllers;
// controller wali kelas
use App\Http\Controllers\Wali_Kelas\PerusahaanWaliKelasController;
use App\Http\Controllers\Wali_Kelas\PresensiWaliKelasController;
use App\Http\Controllers\Wali_Kelas\LaporanKegiatanWaliKelas;

// controller siswa
use App\Http\Controllers\Siswa\ProfileControllers;
use App\Http\Controllers\Siswa\LaporanKegiatanSiswa;
use App\Http\Controllers\Siswa\PermintaanPklController;
use App\Http\Controllers\Siswa\PresensiController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Routes untuk login
Route::middleware(['guest:admin,pembimbing,wali_kelas,siswa'])->group(function () {
    Route::get('/', [AuthenticationMultiuserControllers::class, 'LoginUsers'])->name('login.user');
    Route::post('/Authentication-login', [AuthenticationMultiuserControllers::class, 'AuthenticationLogin'])->name('Authentication.login');
});

Route::middleware(['auth:admin,pembimbing,wali_kelas,siswa'])->group(function () {
    Route::get('/profile', [ProfileUserController::class, 'ProfileUser'])->name('profile.user');
    Route::post('/profile-user', [ProfileUserController::class, 'EditProfileUser'])->name('edit.profile.user');
    Route::post('/reset-password', [ProfileUserController::class, 'EditPasswordUser'])->name('edit.password.user');
    Route::post('/logout', [AuthenticationMultiuserControllers::class, 'logout'])->name('logout.user');
    
});

// Route untuk dashboard
Route::middleware('auth:admin')->group(function () {
    Route::get('/admin-dashboard', [DashboardControllerMultiuser::class, 'DashboardAdmin'])->name('admin.dashboard');

    Route::get('/data-perusahaan', [PerusahaanControllers::class, 'index'])->name('admin.perusahaan');
    Route::get('/create-perusahaan', [PerusahaanControllers::class, 'create'])->name('create.perusahaan.admin');
    Route::post('/add-perusahaan', [PerusahaanControllers::class, 'store'])->name('add.perusahaan.admin');
    Route::post('/edit-perusahaan', [PerusahaanControllers::class, 'edit'])->name('edit.perusahaan.admin');
    Route::post('/update-perusahaan/{perusahaanID}', [PerusahaanControllers::class, 'update'])->name('update.perusahaan.admin');
    Route::delete('/delete-perusahaan', [PerusahaanControllers::class, 'destroy'])->name('delete.perusahaan.admin');
    
    Route::get('/data-siswa', [KelolaSiswaAdminControllers::class, 'index'])->name('admin.siswa');
    Route::post('/edit-siswa', [KelolaSiswaAdminControllers::class, 'edit'])->name('edit.admin.siswa');
    Route::put('/update-siswa', [KelolaSiswaAdminControllers::class, 'update'])->name('update.admin.siswa');
    Route::delete('/delete-siswa', [KelolaSiswaAdminControllers::class, 'destroy'])->name('delete.admin.siswa');
    Route::post('import', [SiswaImportController::class, 'importDataSiswa'])->name('siswa.import');
    
    Route::get('/data-kelas', [KelasSiswaAdminControllers::class, 'index'])->name('admin.kelas');
    Route::get('/create-kelas', [KelasSiswaAdminControllers::class, 'create'])->name('create.kelas.admin');
    Route::post('/add-kelas', [KelasSiswaAdminControllers::class, 'store'])->name('add.kelas.admin');
    Route::post('/edit-kelas', [KelasSiswaAdminControllers::class, 'edit'])->name('edit.kelas.admin');
    Route::post('/update-kelas', [KelasSiswaAdminControllers::class, 'update'])->name('update.kelas.admin');
    Route::delete('/delete-kelas', [KelasSiswaAdminControllers::class, 'destroy'])->name('delete.kelas.admin');

    Route::get('/data-wali-kelas', [WaliKelasSiswaAdminControllers::class, 'index'])->name('admin.kelas');
});

Route::middleware('auth:pembimbing')->group(function () {
    Route::get('/pembimbing-dashboard', [DashboardControllerMultiuser::class, 'DashboardPembimbing'])->name('pembimbing.dashboard');

    // page data perusahaan
    Route::get('/kelola-perusahaan', [PerusahaanPembimbingController::class, 'perusahaan'])->name('pembimbing.perusahaan');
    Route::get('/kelola-perusahaan/create', [PerusahaanPembimbingController::class, 'Createperusahaan'])->name('pembimbing.perusahaan.create');
    Route::post('/kelola-perusahaan/store', [PerusahaanPembimbingController::class, 'Storeperusahaan'])->name('pembimbing.perusahaan.store');
    Route::post('/kelola-perusahaan/edit', [PerusahaanPembimbingController::class, 'EditPerusahaan'])->name('pembimbing.perusahaan.edit');
    Route::post('/kelola-perusahaan/update', [PerusahaanPembimbingController::class, 'UpdatePerusahaan'])->name('pembimbing.perusahaan.update');
    Route::post('/kelola-perusahaan/destroy', [PerusahaanPembimbingController::class, 'Deleteperusahaan'])->name('pembimbing.perusahaan.delete');
    // page data siswa
    Route::get('/kelola-siswa', [KelolaSiswaPembimbingControllers::class, 'KelolaSiswa'])->name('pembimbing.kelola.siswa');
    Route::post('/kelola-siswa/search', [KelolaSiswaPembimbingControllers::class, 'SearchkelolaSiswa'])->name('search.pembimbing.kelola.siswa');
    
    // page persetujuan pkl
    Route::get('/internship-persetujuan', [PersetujuanPKLPembimbingControllers::class, 'PersetujuanPKL'])->name('persetujuan.pkl');
    Route::post('/internship-persetujuan/persetujuan', [PersetujuanPKLPembimbingControllers::class, 'ProsesPersetujuanPKL'])->name('proses.persetujuan.pkl');
    Route::get('/wali-kelas', [WaliKelasDanSiswaPembimbingControllers::class, 'KelolaWaliKelas'])->name('kelola.wali.kelas');
    Route::get('/kelola-kelas', [WaliKelasDanSiswaPembimbingControllers::class, 'KelolaKelas'])->name('kelola.kelas');
    Route::post('/kelola-kelas/create', [WaliKelasDanSiswaPembimbingControllers::class, 'KelolaKelasCreate'])->name('kelola.kelas.create');
    Route::post('/kelola-kelas/delete/{kelasID}', [WaliKelasDanSiswaPembimbingControllers::class, 'KelolaKelasCreate'])->name('hapus.kelas.pembimbing');

    Route::get('/presensi-internship', [PresensiPembimbingControllers::class, 'internshipKelolaPresensi'])->name('internship.kelola.presensi');
    Route::post('/presensi-internship/search', [PresensiPembimbingControllers::class, 'internshipKelolaPresensiSearch'])->name('internship.kelola.presensi.search');
    Route::get('/internship-view/lokasi/siswa/{nis}', [PresensiPembimbingControllers::class, 'internshipViewLokasiSiswa'])->name('internship.view.lokasi.siswa');

});

Route::middleware('auth:wali_kelas')->group(function () {
    Route::get('/wali-kelas-dashboard', [DashboardControllerMultiuser::class, 'DashboardWaliKelas'])->name('wali-kelas.dashboard');

    // page kelola siswa dan perusahaan
    Route::get('/perusahaan', [PerusahaanWaliKelasController::class, 'perusahaan'])->name('perusahaan');
    Route::post('/perusahaan/search', [PerusahaanWaliKelasController::class, 'PerusahaanSearch'])->name('perusahaan.search');   
    Route::post('/perusahaan/delete', [PerusahaanWaliKelasController::class, 'DeleteSiswa'])->name('delete.siswa');
    
    // page kelola presensi siswa
    Route::get('/kelola-presensi', [PresensiWaliKelasController::class, 'kelolaPresensi'])->name('kelola.presensi');
    Route::post('/kelola-presensi/search', [PresensiWaliKelasController::class, 'kelolaPresensiSearch'])->name('kelola.presensi.search');
    Route::get('/view/lokasi/siswa/{nis}', [PresensiWaliKelasController::class, 'ViewLokasiSiswa'])->name('kelola.presensi');
    
    // page laporan kegiatan siswa
    Route::get('/laporan', [LaporanKegiatanWaliKelas::class, 'LaporanKegiatanSiswa'])->name('data.laporan.kegiatan.siswa');
    Route::post('/laporan/search', [LaporanKegiatanWaliKelas::class, 'LaporanKegiatanSiswaSearch'])->name('data.laporan.search');

});

Route::middleware('auth:siswa')->group(function () {
    Route::get('/data-presensi', [PresensiControllerAdmin::class, 'DataPresensi'])->name('data.presensi.admin');

    Route::get('/siswa-dashboard', [DashboardControllerMultiuser::class, 'DashboardSiswa'])->name('siswa.dashboard');
    Route::get('/profile-siswa', [ProfileControllers::class, 'profileSiswa'])->name('profile.siswa');
    Route::post('/edit-profile-siswa', [ProfileControllers::class, 'EditprofileSiswa'])->name('edit.profile.siswa');
    Route::post('/edit-password-siswa', [ProfileControllers::class, 'EditPasswordSiswa'])->name('edit.password.siswa');

    Route::post('/edit-pengajuan-pkl-siswa', [ProfileControllers::class, 'EditPengajuanPklSiswa'])->name('edit.pengajuan.pkl.siswa');
    
    Route::get('/laporan-kegiatan', [LaporanKegiatanSiswa::class, 'LaporanKegiatan'])->name('laporan.kegiatan.siswa');
    Route::post('/create-laporan-kegiatan', [LaporanKegiatanSiswa::class, 'createLaporanKegiatan'])->name('create.kegiatan.siswa');
    Route::post('/checkbox-kegiatan-siswa', [LaporanKegiatanSiswa::class, 'checkboxKegiatanSiswa'])->name('checkbox.kegiatan.siswa');
    Route::post('/delete-kegiatan-siswa', [LaporanKegiatanSiswa::class, 'deleteKegiatanSiswa'])->name('hapus.kegiatan.siswa');
    Route::post('/cari-kegiatan-siswa', [LaporanKegiatanSiswa::class, 'cariKegiatanSiswa'])->name('cari.kegiatan.siswa');
    Route::get('/result-cari-kegiatan-siswa/{tgl_kegiatan}', [LaporanKegiatanSiswa::class, 'resultCariKegiatanSiswa'])->name('result.cari.kegiatan.siswa');
    
    Route::get('/permintaan-pkl', [PermintaanPklController::class, 'permintaanPkl'])->name('permintaan.pkl');
    Route::get('/permintaan-pkl/create', [PermintaanPklController::class, 'CreatepermintaanPkl'])->name('create.permintaan.pkl');
    Route::post('/permintaan-pkl/create-pkl', [PermintaanPklController::class, 'StorepermintaanPkl'])->name('proses.create.permintaan.pkl');
    Route::get('/permintaan-pkl/cetak', [PermintaanPklController::class, 'CetakPermintaanPKL'])->name('proses.cetak.permintaan.pkl');
    
    Route::get('/internship-presensi', [PresensiController::class, 'Presensi'])->name('presensi.siswa');
    Route::get('/internship-presensi/pkl', [PresensiController::class, 'PresensiPulang'])->name('pulang.presensi.siswa');
    Route::post('/internship-presensi/presensi', [PresensiController::class, 'ProsesPresensi'])->name('proses.presensi.siswa');
    Route::post('/internship-presensi/presensi-pulang', [PresensiController::class, 'ProsesPresensiPulang'])->name('proses.pulang.presensi.siswa');
    Route::post('/internship-presensi/store-presensi', [PresensiController::class, 'SakitDanIzin'])->name('sakit.izin.presensi.siswa');
    Route::post('/internship-presensi/pulang-cepat', [PresensiController::class, 'PulangCepat'])->name('pulang.cepat.presensi.siswa');

    Route::get('/internship-presensi/history', [PresensiController::class, 'PresensiHistory'])->name('history.presensi.siswa');
    Route::post('/internship-presensi/history', [PresensiController::class, 'CariHistory'])->name('cari.history.presensi.siswa');
});