<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


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

Route::post('/login', [EmailController::class, 'login']);

Route::get('/register', [RegisterController::class, 'index']);
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware(['auth'])->group(function() {
    Route::get('dashboard', [UserController::class, 'dashboard']);

    Route::get('profile', [ProfileController::class, 'index']);
    Route::put('profile/ubah', [ProfileController::class, 'ubahProfile']);
    Route::put('profile/ubah-password', [ProfileController::class, 'ubahPassword']);


    Route::get('list-pesanan', [PesananController::class, 'index']);
    Route::get('list-pesanan/list', [PesananController::class, 'list']);
    Route::get('list-pesanan/detail/{id}', [PesananController::class, 'detail']);
    Route::post('list-pesanan/list', [PesananController::class, 'list']);
    Route::post('list-pesanan/detail/validasi/{id}', [PesananController::class, 'validasi']);
    Route::post('list-pesanan/detail/order-selesai/{id}', [PesananController::class, 'selesai']);
    Route::post('list-pesanan/detail/send-notif/{id}', [PesananController::class, 'sendNotif']);
    Route::post('list-pesanan/detail/bayar-cod/{id}', [PesananController::class, 'bayarCod']);
    Route::post('list-pesanan/detail/upload-bukti/{id}', [PesananController::class, 'uploadBukti']);
    Route::post('list-pesanan/detail/tolak-bukti/{id}', [PesananController::class, 'tolakBukti']);
    Route::post('list-pesanan/detail/terima-bukti/{id}', [PesananController::class, 'terimaBukti']);

    Route::get('tambah-pesanan', [PesananController::class, 'tambah']);
    Route::post('tambah-pesanan', [PesananController::class, 'simpan']);

    
    Route::middleware(['admin'])->group(function() {
        Route::get('user/customer', [UserController::class, 'customer']);
        Route::post('user/customer', [UserController::class, 'tambahCustomer']);
        Route::post('user/customer/list', [UserController::class, 'customerList']);
        Route::put('user/customer/update/{id}', [UserController::class, 'updateCustomer']);
        Route::delete('user/customer/delete/{id}', [UserController::class, 'hapusCustomer']);

        Route::get('user/kurir', [UserController::class, 'kurir']);
        Route::post('user/kurir', [UserController::class, 'tambahKurir']);
        Route::post('user/kurir/list', [UserController::class, 'kurirList']);
        Route::put('user/kurir/update/{id}', [UserController::class, 'updateKurir']);
        Route::delete('user/kurir/delete/{id}', [UserController::class, 'hapusKurir']);
        
        Route::get('laporan/keuangan', [LaporanController::class, 'keuangan']);
        Route::post('laporan/keuangan', [LaporanController::class, 'keuangan']);
        Route::post('laporan/keuangan/list', [LaporanController::class, 'listKeuangan']);
        Route::get('laporan/pesanan', [LaporanController::class, 'pesanan']);
        Route::post('laporan/pesanan', [LaporanController::class, 'pesanan']);
        Route::post('laporan/pesanan/list', [LaporanController::class, 'listPesanan']);
        
    });

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
     
        return redirect('/profile');
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verify', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
     
        return back()->with('success', 'Link verifikasi sudah terkirim! Cek email anda.');
    })->middleware('throttle:6,1')->name('verification.send');
});
