<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication\AuthenticationMultiuserControllers;
use App\Http\Controllers\DashboardControllerMultiuser;

use App\Http\Controllers\Admin\PerusahaanControllers;
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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('page.admin.dashboard');
// });

// Routes untuk login
Route::middleware(['guest:admin,pembimbing,wali_kelas,siswa'])->group(function () {
    Route::get('/login', [AuthenticationMultiuserControllers::class, 'LoginUsers'])->name('login.user');
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
