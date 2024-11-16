<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication\AuthenticationMultiuserControllers;
use App\Http\Controllers\DashboardControllerMultiuser;

use App\Http\Controllers\Admin\PerusahaanControllers;
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

// Route::get('/dashboard', function () {
//     return view('page.admin.dashboard');
// });

// Routes untuk login
Route::middleware(['guest:admin,pembimbing,wali_kelas,siswa'])->group(function () {
    Route::get('/', [AuthenticationMultiuserControllers::class, 'LoginUsers'])->name('login.user');
    Route::post('/Authentication-login', [AuthenticationMultiuserControllers::class, 'AuthenticationLogin'])->name('Authentication.login');
});

Route::middleware(['auth:admin,pembimbing,wali_kelas,siswa'])->group(function () {
    Route::post('/logout', [AuthenticationMultiuserControllers::class, 'logout'])->name('logout.user');
    
});

// Route untuk dashboard
Route::middleware('auth:admin')->group(function () {
    Route::get('/admin-dashboard', [DashboardControllerMultiuser::class, 'DashboardAdmin'])->name('admin.perusahaan');
    Route::get('/data-perusahaan', [PerusahaanControllers::class, 'index'])->name('admin.perusahaan');
});

Route::middleware('auth:wali_kelas')->group(function () {
    Route::get('/wali-kelas-dashboard', [DashboardControllerMultiuser::class, 'DashboardWaliKelas'])->name('wali-kelas.dashboard');
});

Route::middleware('auth:siswa')->group(function () {
    Route::get('/siswa-dashboard', [DashboardControllerMultiuser::class, 'DashboardSiswa'])->name('siswa.dashboard');
    Route::get('/profile-siswa', [ProfileControllers::class, 'profileSiswa'])->name('profile.siswa');
    Route::post('/edit-profile-siswa', [ProfileControllers::class, 'EditprofileSiswa'])->name('edit.profile.siswa');
    Route::post('/edit-password-siswa', [ProfileControllers::class, 'EditPasswordSiswa'])->name('edit.password.siswa');
    
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
    Route::post('/internship-presensi/presensi', [PresensiController::class, 'ProsesPresensi'])->name('proses.presensi.siswa');
});

Route::middleware('auth:pembimbing')->group(function () {
    Route::get('/pembimbing-dashboard', [DashboardControllerMultiuser::class, 'DashboardPembimbing'])->name('pembimbing.dashboard');
});






// Route::middleware(['guest:admin,pembimbing,wali_kelas'])->group(function () {
//     Route::get('/login', [AuthenticationMultiuserControllers::class, 'AuthenticationUsers'])->name('login.user');
// });

// Route::middleware(['guest:siswa'])->group(function () {
//     Route::get('/login/siswa', [AuthenticationMultiuserControllers::class, 'AuthenticationSiswa'])->name('login.siswa');
// });


// Route::middleware(['auth:admin'])->group(function () {
//     Route::get('/admin', function () {
//         return view('admin.dashboard');
//     });
// });
// Route::middleware(['auth:siswa'])->group(function () {
//     Route::get('/siswa', function () {
//         return view('admin.dashboard');
//     });
// });

// Route::middleware(['auth:admin,siswa,pembimbing,wali_kelas'])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('siswa.dashboard');
//     });
// });
