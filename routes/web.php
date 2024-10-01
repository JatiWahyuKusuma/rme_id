<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OpcoController;
use App\Http\Controllers\CadangandanPotensiController;
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
    return view('welcome');
});

// Route Login
Route::group(['prefix' => 'login'], function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/', [LoginController::class, 'login_process'])->name('login');
});
Route::group(['middleware' => 'auth:web'], function () {
    Route::get('/dashboard_user', function () {
        return view('user.dashboard');
    });
});
Route::group(['middleware' => ['auth:superadmin']], function () {
    Route::get('/cadpot', [CadangandanPotensiController::class, 'index'])->name('superadmin.cadangan');
});

//Route Logout
Route::post('/logout', [LogoutController::class, 'index'])->name('logout');


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

