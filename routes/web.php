<?php

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WaController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::get('auth/wa', [WaController::class, 'index']);
Route::post('auth/wa', [WaController::class, 'check']);
Route::post('auth/wa-login', [WaController::class, 'login']);

Route::get('/', function () {
    return view('home');
});

Route::get('/login', function () {
    return view('backend.auth.login');
})->name('login');

Route::get('/register', [RegisterController::class, 'index']);
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware(['auth'])->group(function() {
    Route::get('profile', [ProfileController::class, 'index']);
    Route::get('list-pesanan', [PesananController::class, 'list']);
    Route::get('laporan/keuangan', [LaporanController::class, 'keuangan']);
    Route::get('laporan/pesanan', [LaporanController::class, 'pesanan']);
    Route::get('user/customer', [UserController::class, 'customer']);
    Route::get('user/kurir', [UserController::class, 'kurir']);
});

Route::middleware(['auth:sanctum'])->get('/dashboard', function () {
    return view('backend.dashboard');
})->name('dashboard');
