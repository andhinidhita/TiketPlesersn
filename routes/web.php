<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PemesananController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (TANPA LOGIN)
|--------------------------------------------------------------------------
*/

// Landing Page (halaman utama)
Route::get('/', function () {
    return view('landing');
});

Route::get('/landing', function () {
    return view('landing');
})->name('landing');


/*
|--------------------------------------------------------------------------
| PRIVATE ROUTES (HARUS LOGIN)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Halaman Pemesanan
    Route::get('/pemesanan', [PemesananController::class, 'index'])->name('pemesanan');

    // Proses Simpan Pemesanan
    Route::post('/pemesanan', [PemesananController::class, 'store']);

    // Invoice
    Route::get('/invoice/{id}', [PemesananController::class, 'invoice'])->name('invoice');
    Route::get('/riwayat', [PemesananController::class, 'riwayat'])->name('riwayat');

});


/*
|--------------------------------------------------------------------------
| AUTH ROUTES (LOGIN, REGISTER, DLL)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';