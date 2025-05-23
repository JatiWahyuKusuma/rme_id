<?php

use App\Http\Controllers\AdminCadanganbbController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OpcoController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\DashboardSuperadminController;
use App\Http\Controllers\DetailHasilRekomendasiAdminController;
use App\Http\Controllers\DetailHasilRekomendasiController;
use App\Http\Controllers\HasilRekomendasiAdminController;
use App\Http\Controllers\HasilRekomendasiController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\NotifikasiAdminController;
use App\Http\Controllers\NotifikasiSuperadminController;
use App\Http\Controllers\SubKriteriaController;
use App\Http\Controllers\SuperadminCadanganbbController;
use App\Http\Controllers\UmurCadanganAdminController;
use App\Http\Controllers\UmurCadanganController;
use App\Http\Controllers\UmurIzinAdminController;
use App\Http\Controllers\UmurIzinController;
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
    return view('login');
});
Route::middleware('guest')->group(function () {
    Route::group(['prefix' => 'login'], function () {
        Route::get('/', [LoginController::class, 'index'])->name('login');
        Route::post('/', [LoginController::class, 'login_process'])->name('login');
    });
});

// Route Login
// Route::group(['middleware' => 'auth:admin'], function () {
//     Route::get('/admincadpot', function () {
//         return view('user.dashboard');
//     });
// });
// Superadmin routes
Route::middleware(['superadmin'])->group(function () {
    Route::get('/dashboardcadbb', function () {
        return view('superadmin.dashboard');
    })->name('superadmin.dashboard');
});

// Admin routes
Route::middleware(['admin'])->group(function () {
    Route::get('/dashboardcad', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});
// Route::group(['middleware' => ['auth:superadmin']], function () {
//     Route::get('/cadpot', [CadangandanPotensiController::class, 'index'])->name('superadmin.cadangan');
// });

//Route Logout
Route::post('/logout', [LogoutController::class, 'index'])->name('logout');




//ROUTE MIDDLEWARE SUPERADMIN
Route::middleware('role:1')->group(function () {
    Route::group(['prefix' => 'cadanganbb'], function () {
        Route::get('cadanganbb/export-pdf', [SuperadminCadanganbbController::class, 'exportPDF'])->name('cadanganbb.exportPDF');
        Route::get('/', [SuperadminCadanganbbController::class, 'index']);
        Route::post('/list', [SuperadminCadanganbbController::class, 'list']);
        Route::get('/create', [SuperadminCadanganbbController::class, 'create']);
        Route::post('/', [SuperadminCadanganbbController::class, 'store']);
        Route::get('/{id}', [SuperadminCadanganbbController::class, 'show']);
        Route::get('/{id}/edit', [SuperadminCadanganbbController::class, 'edit']);
        Route::put('/{id}', [SuperadminCadanganbbController::class, 'update']);
        Route::delete('/{id}', [SuperadminCadanganbbController::class, 'destroy']);
    });

    //Route Superadmin
    Route::group(['prefix' => 'level'], function () {
        Route::get('/', [LevelController::class, 'index']);
        Route::post('/list', [LevelController::class, 'list']);
        Route::get('/create', [LevelController::class, 'create']);
        Route::post('/', [LevelController::class, 'store']);
        Route::get('/{id}', [LevelController::class, 'show']);
        Route::get('/{id}/edit', [LevelController::class, 'edit']);
        Route::put('/{id}', [LevelController::class, 'update']);
        Route::delete('/{id}', [LevelController::class, 'destroy']);
    });

    Route::group(['prefix' => 'admin'], function () {
        Route::get('/', [AdminController::class, 'index']);
        Route::post('/list', [AdminController::class, 'list']);
        Route::get('/create', [AdminController::class, 'create']);
        Route::post('/', [AdminController::class, 'store']);
        Route::get('/{id}', [AdminController::class, 'show']);
        Route::get('/{id}/edit', [AdminController::class, 'edit']);
        Route::put('/{id}', [AdminController::class, 'update']);
        Route::delete('/{id}', [AdminController::class, 'destroy']);
    });
    Route::group(['prefix' => 'opco'], function () {
        Route::get('/', [OpcoController::class, 'index']);
        Route::post('/list', [OpcoController::class, 'list']);
        Route::get('/create', [OpcoController::class, 'create']);
        Route::post('/', [OpcoController::class, 'store']);
        Route::get('/{id}', [OpcoController::class, 'show']);
        Route::get('/{id}/edit', [OpcoController::class, 'edit']);
        Route::put('/{id}', [OpcoController::class, 'update']);
        Route::delete('/{id}', [OpcoController::class, 'destroy']);
    });

    Route::group(['prefix' => 'kriteria'], function () {
        Route::get('/', [KriteriaController::class, 'index']);
        Route::post('/list', [KriteriaController::class, 'list']);
        Route::get('/create', [KriteriaController::class, 'create']);
        Route::post('/', [KriteriaController::class, 'store']);
        Route::get('/{id}', [KriteriaController::class, 'show']);
        Route::get('/{id}/edit', [KriteriaController::class, 'edit']);
        Route::put('/{id}', [KriteriaController::class, 'update']);
        Route::delete('/{id}', [KriteriaController::class, 'destroy']);
    });
    Route::group(['prefix' => 'subkriteria'], function () {
        Route::get('/', [SubKriteriaController::class, 'index']);
        Route::post('/list', [SubKriteriaController::class, 'list']);
        Route::get('/create', [SubKriteriaController::class, 'create']);
        Route::post('/', [SubKriteriaController::class, 'store']);
        Route::get('/{id}', [SubKriteriaController::class, 'show']);
        Route::get('/{id}/edit', [SubKriteriaController::class, 'edit']);
        Route::put('/{id}', [SubKriteriaController::class, 'update']);
        Route::delete('/{id}', [SubKriteriaController::class, 'destroy']);
    });

    Route::group(['prefix' => 'rekomendasi'], function () {
        Route::get('/', [HasilRekomendasiController::class, 'index']);
        Route::post('/list', [HasilRekomendasiController::class, 'list']);
        Route::get('/rekomendasi', [HasilRekomendasiController::class, 'index']);
        Route::get('/cetak-pdf', [HasilRekomendasiController::class, 'cetakPdf'])->name('rekomendasi.cetak');
        Route::post('/rekomendasi/simpan-penilaian', [HasilRekomendasiController::class, 'simpanPenilaian'])->name('rekomendasi.simpan');
    });
    Route::group(['prefix' => 'umurcadangan'], function () {
        Route::get('/', [UmurCadanganController::class, 'index']);
        Route::post('/list', [UmurCadanganController::class, 'list']);
    });
    Route::group(['prefix' => 'umurizin'], function () {
        Route::get('/', [UmurIzinController::class, 'index']);
        Route::post('/list', [UmurIzinController::class, 'list']);
        Route::get('/rekomendasi', [UmurIzinController::class, 'index']);
    });
    Route::group(['prefix' => 'detailrekomendasi'], function () {
        Route::get('/', [DetailHasilRekomendasiController::class, 'index']);
        Route::post('/list', [DetailHasilRekomendasiController::class, 'list']);
        Route::get('/rekomendasi', [DetailHasilRekomendasiController::class, 'index']);
    });
    Route::group(['prefix' => 'history'], function () {
        Route::get('/', [HasilRekomendasiController::class, 'riwayat'])->name('superadmin.history.index');
        Route::post('/list', [HasilRekomendasiController::class, 'list']);
        Route::delete('/hapus/{index}', [HasilRekomendasiController::class, 'hapusRiwayat'])->name('history.hapus');
        Route::get('/history/detail/{index}', [HasilRekomendasiController::class, 'showDetail'])->name('history.detail');
        Route::get('/history/cetak-pdf/{index}', [HasilRekomendasiController::class, 'cetakPdfRiwayat'])->name('history.cetak-pdf');
        Route::post('/history/restore/{index}', [HasilRekomendasiController::class, 'restorePenilaian'])->name('history.restore');
    });
});

Route::middleware('role:2')->group(function () {
    Route::group(['prefix' => 'admincadanganbb'], function () {
        Route::get('/', [AdminCadanganbbController::class, 'index']);
        Route::post('/list', [AdminCadanganbbController::class, 'list']);
        Route::get('/create', [AdminCadanganbbController::class, 'create']);
        Route::post('/', [AdminCadanganbbController::class, 'store']);
        Route::get('/{id}', [AdminCadanganbbController::class, 'show']);
        Route::get('/{id}/edit', [AdminCadanganbbController::class, 'edit']);
        Route::put('/{id}', [AdminCadanganbbController::class, 'update']);
        Route::delete('/{id}', [AdminCadanganbbController::class, 'destroy']);
        Route::get('admincadanganbb/export-pdf', [AdminCadanganbbController::class, 'exportPDF'])->name('admincadanganbb.exportPDF');
    });
    Route::group(['prefix' => 'umurcadanganadmin'], function () {
        Route::get('/', [UmurCadanganAdminController::class, 'index']);
        Route::post('/list', [UmurCadanganAdminController::class, 'list']);
    });
    Route::group(['prefix' => 'umurizinadmin'], function () {
        Route::get('/', [UmurIzinAdminController::class, 'index']);
        Route::post('/list', [UmurIzinAdminController::class, 'list']);
        Route::get('/rekomendasi', [UmurIzinAdminController::class, 'index']);
    });
    //Route Hasil Rekomendasi
    Route::group(['prefix' => 'rekomendasiadmin'], function () {
        Route::get('/', [HasilRekomendasiAdminController::class, 'index']);
        Route::post('/list', [HasilRekomendasiAdminController::class, 'list']);
        Route::get('/rekomendasi', [HasilRekomendasiAdminController::class, 'index']);
        Route::get('/cetak-pdf', [HasilRekomendasiAdminController::class, 'cetakPdf'])->name('rekomendasi.cetak');
    });
    //Route Detail Hasil Rekomendasi
    Route::group(['prefix' => 'detailrekomendasiadmin'], function () {
        Route::get('/', [DetailHasilRekomendasiAdminController::class, 'index']);
        Route::post('/list', [DetailHasilRekomendasiAdminController::class, 'list']);
        Route::get('/rekomendasi', [DetailHasilRekomendasiAdminController::class, 'index']);
    });
    //Route History Admin
    Route::group(['prefix' => 'historyadmin'], function () {
        Route::get('/', [HasilRekomendasiController::class, 'riwayatadmin'])->name('admin.history.index');
        Route::get('/history/cetak-pdf/{index}', [HasilRekomendasiController::class, 'cetakpdfAdmin'])->name('history.cetak-pdf');
        Route::get('/history/detail/{index}', [HasilRekomendasiController::class, 'showDetailAdmin'])->name('history.detail');
    });
});

//Route Notifications Superadmin
Route::get('/notifications', [NotifikasiSuperadminController::class, 'getNotifications'])->name('notifications');






// routes/web.php
Route::get('/get-lokasi-iup/{opco_id}', [App\Http\Controllers\UmurCadanganController::class, 'getLokasiIUP']);
Route::middleware('auth')->group(function () {
    //Routes Dashboard SUPERADMIN
    Route::group(['prefix' => 'dashboardcadbb'], function () {
        Route::get('/', [DashboardSuperadminController::class, 'index']);
        Route::post('/list', [DashboardSuperadminController::class, 'list']);
        Route::get('/dashboard', [DashboardSuperadminController::class, 'index']);
    });
    //Routes Dashboard Admin
    Route::group(['prefix' => 'dashboardcad'], function () {
        Route::get('/', [DashboardAdminController::class, 'index']);
        Route::post('/list', [DashboardAdminController::class, 'list']);
    });

    //route superadmin
    Route::group(['prefix' => 'cadanganbb'], function () {
        Route::get('cadanganbb/export-pdf', [SuperadminCadanganbbController::class, 'exportPDF'])->name('cadanganbb.exportPDF');
        Route::get('/', [SuperadminCadanganbbController::class, 'index']);
        Route::post('/list', [SuperadminCadanganbbController::class, 'list']);
        Route::get('/create', [SuperadminCadanganbbController::class, 'create']);
        Route::post('/', [SuperadminCadanganbbController::class, 'store']);
        Route::get('/{id}', [SuperadminCadanganbbController::class, 'show']);
        Route::get('/{id}/edit', [SuperadminCadanganbbController::class, 'edit']);
        Route::put('/{id}', [SuperadminCadanganbbController::class, 'update']);
        Route::delete('/{id}', [SuperadminCadanganbbController::class, 'destroy']);
    });

    //Route Superadmin
    Route::group(['prefix' => 'level'], function () {
        Route::get('/', [LevelController::class, 'index']);
        Route::post('/list', [LevelController::class, 'list']);
        Route::get('/create', [LevelController::class, 'create']);
        Route::post('/', [LevelController::class, 'store']);
        Route::get('/{id}', [LevelController::class, 'show']);
        Route::get('/{id}/edit', [LevelController::class, 'edit']);
        Route::put('/{id}', [LevelController::class, 'update']);
        Route::delete('/{id}', [LevelController::class, 'destroy']);
    });

    Route::group(['prefix' => 'admin'], function () {
        Route::get('/', [AdminController::class, 'index']);
        Route::post('/list', [AdminController::class, 'list']);
        Route::get('/create', [AdminController::class, 'create']);
        Route::post('/', [AdminController::class, 'store']);
        Route::get('/{id}', [AdminController::class, 'show']);
        Route::get('/{id}/edit', [AdminController::class, 'edit']);
        Route::put('/{id}', [AdminController::class, 'update']);
        Route::delete('/{id}', [AdminController::class, 'destroy']);
    });
    Route::group(['prefix' => 'opco'], function () {
        Route::get('/', [OpcoController::class, 'index']);
        Route::post('/list', [OpcoController::class, 'list']);
        Route::get('/create', [OpcoController::class, 'create']);
        Route::post('/', [OpcoController::class, 'store']);
        Route::get('/{id}', [OpcoController::class, 'show']);
        Route::get('/{id}/edit', [OpcoController::class, 'edit']);
        Route::put('/{id}', [OpcoController::class, 'update']);
        Route::delete('/{id}', [OpcoController::class, 'destroy']);
    });

    Route::group(['prefix' => 'kriteria'], function () {
        Route::get('/', [KriteriaController::class, 'index']);
        Route::post('/list', [KriteriaController::class, 'list']);
        Route::get('/create', [KriteriaController::class, 'create']);
        Route::post('/', [KriteriaController::class, 'store']);
        Route::get('/{id}', [KriteriaController::class, 'show']);
        Route::get('/{id}/edit', [KriteriaController::class, 'edit']);
        Route::put('/{id}', [KriteriaController::class, 'update']);
        Route::delete('/{id}', [KriteriaController::class, 'destroy']);
    });
    Route::group(['prefix' => 'subkriteria'], function () {
        Route::get('/', [SubKriteriaController::class, 'index']);
        Route::post('/list', [SubKriteriaController::class, 'list']);
        Route::get('/create', [SubKriteriaController::class, 'create']);
        Route::post('/', [SubKriteriaController::class, 'store']);
        Route::get('/{id}', [SubKriteriaController::class, 'show']);
        Route::get('/{id}/edit', [SubKriteriaController::class, 'edit']);
        Route::put('/{id}', [SubKriteriaController::class, 'update']);
        Route::delete('/{id}', [SubKriteriaController::class, 'destroy']);
    });

    Route::group(['prefix' => 'rekomendasi'], function () {
        Route::get('/', [HasilRekomendasiController::class, 'index']);
        Route::post('/list', [HasilRekomendasiController::class, 'list']);
        Route::get('/rekomendasi', [HasilRekomendasiController::class, 'index']);
        Route::get('/cetak-pdf', [HasilRekomendasiController::class, 'cetakPdf'])->name('rekomendasi.cetak');
        Route::post('/rekomendasi/simpan-penilaian', [HasilRekomendasiController::class, 'simpanPenilaian'])->name('rekomendasi.simpan');
        Route::get('/history/detail/{index}', [HasilRekomendasiController::class, 'showDetail'])->name('history.detail');
    });
    Route::group(['prefix' => 'umurcadangan'], function () {
        Route::get('/', [UmurCadanganController::class, 'index']);
        Route::post('/list', [UmurCadanganController::class, 'list']);
    });
    Route::group(['prefix' => 'umurizin'], function () {
        Route::get('/', [UmurIzinController::class, 'index']);
        Route::post('/list', [UmurIzinController::class, 'list']);
        Route::get('/rekomendasi', [UmurIzinController::class, 'index']);
    });
    Route::group(['prefix' => 'detailrekomendasi'], function () {
        Route::get('/', [DetailHasilRekomendasiController::class, 'index']);
        Route::post('/list', [DetailHasilRekomendasiController::class, 'list']);
        Route::get('/rekomendasi', [DetailHasilRekomendasiController::class, 'index']);
    });
    Route::group(['prefix' => 'history'], function () {
        Route::get('/', [HasilRekomendasiController::class, 'riwayat'])->name('superadmin.history.index');
        Route::post('/list', [HasilRekomendasiController::class, 'list']);
        Route::delete('/hapus/{index}', [HasilRekomendasiController::class, 'hapusRiwayat'])->name('history.hapus');
        Route::get('/history/cetak-pdf/{index}', [HasilRekomendasiController::class, 'cetakPdfRiwayat'])->name('history.cetak-pdf');
        Route::post('/history/restore/{index}', [HasilRekomendasiController::class, 'restorePenilaian'])->name('history.restore');
    });

    //route admin 
    Route::group(['prefix' => 'admincadanganbb'], function () {
        Route::get('/', [AdminCadanganbbController::class, 'index']);
        Route::post('/list', [AdminCadanganbbController::class, 'list']);
        Route::get('/create', [AdminCadanganbbController::class, 'create']);
        Route::post('/', [AdminCadanganbbController::class, 'store']);
        Route::get('/{id}', [AdminCadanganbbController::class, 'show']);
        Route::get('/{id}/edit', [AdminCadanganbbController::class, 'edit']);
        Route::put('/{id}', [AdminCadanganbbController::class, 'update']);
        Route::delete('/{id}', [AdminCadanganbbController::class, 'destroy']);
        Route::get('admincadanganbb/export-pdf', [AdminCadanganbbController::class, 'exportPDF'])->name('admincadanganbb.exportPDF');
    });
    Route::group(['prefix' => 'umurcadanganadmin'], function () {
        Route::get('/', [UmurCadanganAdminController::class, 'index']);
        Route::post('/list', [UmurCadanganAdminController::class, 'list']);
    });
    Route::group(['prefix' => 'umurizinadmin'], function () {
        Route::get('/', [UmurIzinAdminController::class, 'index']);
        Route::post('/list', [UmurIzinAdminController::class, 'list']);
        Route::get('/rekomendasi', [UmurIzinAdminController::class, 'index']);
    });
    //Route Hasil Rekomendasi
    Route::group(['prefix' => 'rekomendasiadmin'], function () {
        Route::get('/', [HasilRekomendasiAdminController::class, 'index']);
        Route::post('/list', [HasilRekomendasiAdminController::class, 'list']);
        Route::get('/rekomendasi', [HasilRekomendasiAdminController::class, 'index']);
        Route::get('/cetak-pdf', [HasilRekomendasiAdminController::class, 'cetakPdf'])->name('rekomendasi.cetak');
    });
    //Route Detail Hasil Rekomendasi
    Route::group(['prefix' => 'detailrekomendasiadmin'], function () {
        Route::get('/', [DetailHasilRekomendasiAdminController::class, 'index']);
        Route::post('/list', [DetailHasilRekomendasiAdminController::class, 'list']);
        Route::get('/rekomendasi', [DetailHasilRekomendasiAdminController::class, 'index']);
    });
    //Route History Admin
    Route::group(['prefix' => 'historyadmin'], function () {
        Route::get('/', [HasilRekomendasiController::class, 'riwayatadmin'])->name('admin.history.index');
        Route::get('/history/cetak-pdf/{index}', [HasilRekomendasiController::class, 'cetakpdfAdmin'])->name('history.cetak-pdf');
        Route::get('/history/detail/{index}', [HasilRekomendasiController::class, 'showDetailAdmin'])->name('history.detail');
    });
});






//PETA
// Route::group(['prefix' => 'petageologi'], function () {
//     Route::get('/', [PetaGeologiController::class, 'index']);
//     Route::post('/list', [PetaGeologiController::class, 'list']);
//     Route::get('/dashboard', [PetaGeologiController::class, 'index']);

// });
// Route::group(['prefix' => 'petartrw'], function () {
//     Route::get('/', [PetaRTRWController::class, 'index']);
//     Route::post('/list', [PetaRTRWController::class, 'list']);
//     Route::get('/dashboard', [PetaRTRWController::class, 'index']);

// });


//Route Admin




//Route Notifikasi Admin
Route::get('/notifikasi', [NotifikasiAdminController::class, 'getNotifikasi'])->name('notifikasi');
