<?php

use App\Http\Controllers\AdminCadanganbbController;
use App\Http\Controllers\AdminCadpotController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminVendorController;
use App\Http\Controllers\OpcoController;
use App\Http\Controllers\CadangandanPotensiController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\DashboardCadpotSprAdmController;
use App\Http\Controllers\DashboardVendorSprAdmController;
use App\Http\Controllers\DashboardCadpotAdmController;
use App\Http\Controllers\DashboardSuperadminController;
use App\Http\Controllers\DashboardVendorAdmController;
use App\Http\Controllers\DetailHasilRekomendasiController;
use App\Http\Controllers\HasilRekomendasiController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\NotifikasiAdminController;
use App\Http\Controllers\NotifikasiSuperadminController;
use App\Http\Controllers\PetaGeologiController;
use App\Http\Controllers\PetaRTRWController;
use App\Http\Controllers\SubKriteriaController;
use App\Http\Controllers\SuperadminCadanganbbController;
use App\Http\Controllers\UmurCadanganController;
use App\Http\Controllers\UmurIzinController;
use App\Models\CadanganbbModel;

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

// Route Login
Route::group(['prefix' => 'login'], function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/', [LoginController::class, 'login_process'])->name('login');
});
Route::group(['middleware' => 'auth:admin'], function () {
    Route::get('/admincadpot', function () {
        return view('user.dashboard');
    });
});
Route::group(['middleware' => ['auth:superadmin']], function () {
    Route::get('/cadpot', [CadangandanPotensiController::class, 'index'])->name('superadmin.cadangan');
});

//Route Logout
Route::post('/logout', [LogoutController::class, 'index'])->name('logout');


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
Route::group(['prefix' => 'cadanganbb'], function () {
    Route::get('/', [SuperadminCadanganbbController::class, 'index']);
    Route::post('/list', [SuperadminCadanganbbController::class, 'list']);
    Route::get('/create', [SuperadminCadanganbbController::class, 'create']);
    Route::post('/', [SuperadminCadanganbbController::class, 'store']);
    Route::get('/{id}', [SuperadminCadanganbbController::class, 'show']);
    Route::get('/{id}/edit', [SuperadminCadanganbbController::class, 'edit']);
    Route::put('/{id}', [SuperadminCadanganbbController::class, 'update']);
    Route::delete('/{id}', [SuperadminCadanganbbController::class, 'destroy']);
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
//Route Notifications Superadmin
Route::get('/notifications', [NotifikasiSuperadminController::class, 'getNotifications'])->name('notifications');

//Routes Dashboard SUPERADMIN
Route::group(['prefix' => 'dashboardcadbb'], function () {
    Route::get('/', [DashboardSuperadminController::class, 'index']);
    Route::post('/list', [DashboardSuperadminController::class, 'list']);
    Route::get('/dashboard', [DashboardSuperadminController::class, 'index']);
});

//Route Hasil Rekomendasi
Route::group(['prefix' => 'rekomendasi'], function () {
    Route::get('/', [HasilRekomendasiController::class, 'index']);
    Route::post('/list', [HasilRekomendasiController::class, 'list']);
    Route::get('/rekomendasi', [HasilRekomendasiController::class, 'index']);
});
//Route Detail Hasil Rekomendasi
Route::group(['prefix' => 'detailrekomendasi'], function () {
    Route::get('/', [DetailHasilRekomendasiController::class, 'index']);
    Route::post('/list', [DetailHasilRekomendasiController::class, 'list']);
    Route::get('/rekomendasi', [DetailHasilRekomendasiController::class, 'index']);
});

Route::group(['prefix' => 'umurcadangan'], function () {
    Route::get('/', [UmurCadanganController::class, 'index']);
    Route::post('/list', [UmurCadanganController::class, 'list']);
    // Route::get('/get-lokasi_iup', [CadanganbbModel::class, 'getLokasiIUP']);

});
// routes/web.php
Route::get('/get-lokasi-iup/{opco_id}', [App\Http\Controllers\UmurCadanganController::class, 'getLokasiIUP']);



Route::group(['prefix' => 'umurizin'], function () {
    Route::get('/', [UmurIzinController::class, 'index']);
    Route::post('/list', [UmurIzinController::class, 'list']);
    Route::get('/rekomendasi', [UmurIzinController::class, 'index']);
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


Route::get('/dashboard', [DashboardCadpotSprAdmController::class, 'index'])->name('dashboard');
Route::get('/maps', [DashboardCadpotSprAdmController::class, 'map'])->name('maps');

Route::group(['prefix' => 'dashboardvendor'], function () {
    Route::get('/', [DashboardVendorSprAdmController::class, 'index']);
    Route::post('/list', [DashboardVendorSprAdmController::class, 'list']);
});

//Route Admin
Route::group(['prefix' => 'admincadpot'], function () {
    Route::get('/', [AdminCadpotController::class, 'index']);
    Route::post('/list', [AdminCadpotController::class, 'list']);
    Route::get('/create', [AdminCadpotController::class, 'create']);
    Route::post('/', [AdminCadpotController::class, 'store']);
    Route::get('/{id}', [AdminCadpotController::class, 'show']);
    Route::get('/{id}/edit', [AdminCadpotController::class, 'edit']);
    Route::put('/{id}', [AdminCadpotController::class, 'update']);
    Route::delete('/{id}', [AdminCadpotController::class, 'destroy']);
});
Route::group(['prefix' => 'adminvendorbb'], function () {
    Route::get('/', [AdminVendorController::class, 'index']);
    Route::post('/list', [AdminVendorController::class, 'list']);
    Route::get('/create', [AdminVendorController::class, 'create']);
    Route::post('/', [AdminVendorController::class, 'store']);
    Route::get('/{id}', [AdminVendorController::class, 'show']);
    Route::get('/{id}/edit', [AdminVendorController::class, 'edit']);
    Route::put('/{id}', [AdminVendorController::class, 'update']);
    Route::delete('/{id}', [AdminVendorController::class, 'destroy']);
});

Route::group(['prefix' => 'admincadanganbb'], function () {
    Route::get('/', [AdminCadanganbbController::class, 'index']);
    Route::post('/list', [AdminCadanganbbController::class, 'list']);
    Route::get('/create', [AdminCadanganbbController::class, 'create']);
    Route::post('/', [AdminCadanganbbController::class, 'store']);
    Route::get('/{id}', [AdminCadanganbbController::class, 'show']);
    Route::get('/{id}/edit', [AdminCadanganbbController::class, 'edit']);
    Route::put('/{id}', [AdminCadanganbbController::class, 'update']);
    Route::delete('/{id}', [AdminCadanganbbController::class, 'destroy']);
});

//Route Notifikasi Admin
Route::get('/notifikasi', [NotifikasiAdminController::class, 'getNotifikasi'])->name('notifikasi');

//Routes Dashboard Admin
Route::group(['prefix' => 'dashboardcadpot'], function () {
    Route::get('/', [DashboardCadpotAdmController::class, 'index']);
    Route::post('/list', [DashboardCadpotAdmController::class, 'list']);
});
Route::get('/dashboard', [DashboardCadpotAdmController::class, 'index'])->name('dashboard');
Route::get('/maps', [DashboardCadpotAdmController::class, 'map'])->name('maps');

Route::group(['prefix' => 'dashboardvendorbb'], function () {
    Route::get('/', [DashboardVendorAdmController::class, 'index']);
    Route::post('/list', [DashboardVendorAdmController::class, 'list']);
});

Route::group(['prefix' => 'dashboardcad'], function () {
    Route::get('/', [DashboardAdminController::class, 'index']);
    Route::post('/list', [DashboardAdminController::class, 'list']);
});
