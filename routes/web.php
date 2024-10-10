<?php

use App\Http\Controllers\AdminCadpotController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminVendorController;
use App\Http\Controllers\OpcoController;
use App\Http\Controllers\CadangandanPotensiController;
use App\Http\Controllers\DashboardCadpotSprAdmController;
use App\Http\Controllers\DashboardVendorSprAdmController;
use App\Http\Controllers\DashboardCadpotAdmController;
use App\Http\Controllers\DashboardVendorAdmController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;

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
Route::group(['prefix' => 'cadpot'], function () {
    Route::get('/', [CadangandanPotensiController::class, 'index']);
    Route::post('/list', [CadangandanPotensiController::class, 'list']);
    Route::get('/create', [CadangandanPotensiController::class, 'create']);
    Route::post('/', [CadangandanPotensiController::class, 'store']);
    Route::get('/{id}', [CadangandanPotensiController::class, 'show']);
    Route::get('/{id}/edit', [CadangandanPotensiController::class, 'edit']);
    Route::put('/{id}', [CadangandanPotensiController::class, 'update']);
    Route::delete('/{id}', [CadangandanPotensiController::class, 'destroy']);
});
Route::group(['prefix' => 'vendorbb'], function () {
    Route::get('/', [VendorController::class, 'index']);
    Route::post('/list', [VendorController::class, 'list']);
    Route::get('/create', [VendorController::class, 'create']);
    Route::post('/', [VendorController::class, 'store']);
    Route::get('/{id}', [VendorController::class, 'show']);
    Route::get('/{id}/edit', [VendorController::class, 'edit']);
    Route::put('/{id}', [VendorController::class, 'update']);
    Route::delete('/{id}', [VendorController::class, 'destroy']);
});
//Routes Dashboard
Route::group(['prefix' => 'dashboardcadangan'], function () {
    Route::get('/', [DashboardCadpotSprAdmController::class, 'index']);
    Route::post('/list', [DashboardCadpotSprAdmController::class, 'list']);
    Route::get('/dashboard', [DashboardCadpotSprAdmController::class, 'index']);
    
});
Route::get('/dashboard', [DashboardCadpotSprAdmController::class, 'index'])->name('dashboard');
Route::get('/maps', [DashboardCadpotSprAdmController::class, 'map'])->name('maps');

Route::group(['prefix' => 'dashboardvendor'], function () {
    Route::get('/', [DashboardVendorSprAdmController::class, 'index']);
    Route::post('/list', [DashboardVendorSprAdmController::class, 'list']);
});

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
