<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\WaController;


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

Route::middleware(['auth:sanctum'])->get('/dashboard', function () {
    return view('backend.dashboard');
})->name('dashboard');
