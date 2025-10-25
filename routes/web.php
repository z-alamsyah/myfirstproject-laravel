<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login;

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

Route::get('/index', function () {
    return view('welcome');
});

// Route untuk login
Route::get('/login', [Login::class, 'showLoginForm'])->name('login');
Route::post('/login', [Login::class, 'login'])->name('login.process');

// Route untuk logout
Route::get('/logout', [Login::class, 'logout'])->name('logout');

// Route untuk dashboard (setelah login)
Route::get('/dashboard', function () {
    // Cek apakah user sudah login
    if (!session()->has('user_id')) {
        return redirect('/login')->with('error', 'Silakan login terlebih dahulu!');
    }

    return view('dashboard', [
        'username' => session('username'),
        'jwt_token' => session('jwt_token'),
        'user_id' => session('user_id')
    ]);
})->name('dashboard');