<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\ProfileController;
use App\Models\Galeri;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (TANPA LOGIN)
|--------------------------------------------------------------------------
*/

// Landing Page (halaman utama)
Route::get('/', function () {
    $galeris = Galeri::latest()->get();
return view('landing', compact('galeris'));
});

Route::get('/landing', function () {
    $galeris = Galeri::latest()->get();
return view('landing', compact('galeris'));
})->name('landing');

Route::get('/admin/login', [AdminAuthController::class, 'create'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'store'])->name('admin.login.store');

/*
|--------------------------------------------------------------------------
| PRIVATE ROUTES (HARUS LOGIN)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        $userId = auth()->id();

        return view('dashboard', [
            'jumlahPesanan' => Pemesanan::where('user_id', $userId)->count(),
            'jumlahTiket' => Pemesanan::where('user_id', $userId)->sum('jumlah_tiket'),
            'statusTerakhir' => optional(Pemesanan::where('user_id', $userId)->latest()->first())->status ?? '-',
        ]);
    })->name('dashboard');

    // Halaman Pemesanan
    Route::get('/pemesanan', [PemesananController::class, 'index'])->name('pemesanan');

    // Proses Simpan Pemesanan
    Route::post('/pemesanan', [PemesananController::class, 'store']);

    // Invoice
    Route::get('/invoice/{id}', [PemesananController::class, 'invoice'])->name('invoice');
    Route::get('/riwayat', [PemesananController::class, 'riwayat'])->name('riwayat');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

Route::middleware(['admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/transaksi', [AdminController::class, 'transaksi'])->name('admin.transaksi');
    Route::get('/admin/galeri', [AdminController::class, 'galeri'])->name('admin.galeri');
    Route::post('/admin/galeri', [AdminController::class, 'storeGaleri'])->name('admin.galeri.store');
    Route::delete('/admin/galeri/{id}', [AdminController::class, 'destroyGaleri'])->name('admin.galeri.destroy');
    Route::get('/admin/tiket-wisata', [AdminController::class, 'tiket'])->name('admin.tiket');
    Route::post('/admin/tiket-wisata', [AdminController::class, 'storeTiket'])->name('admin.tiket.store');
    Route::put('/admin/tiket-wisata/{id}', [AdminController::class, 'updateTiket'])->name('admin.tiket.update');
    Route::delete('/admin/tiket-wisata/{id}', [AdminController::class, 'destroyTiket'])->name('admin.tiket.destroy');
    Route::get('/admin/data-admin', [AdminController::class, 'admins'])->name('admin.admins');
    Route::get('/admin/data-member', [AdminController::class, 'members'])->name('admin.members');
    Route::get('/admin/transaksi/{pemesanan}/edit', [AdminController::class, 'editTransaksi'])->name('admin.transaksi.edit');
    Route::patch('/admin/transaksi/{pemesanan}', [AdminController::class, 'updateTransaksi'])->name('admin.transaksi.update');
    Route::delete('/admin/transaksi/{pemesanan}', [AdminController::class, 'destroyTransaksi'])->name('admin.transaksi.destroy');
    Route::post('/admin/verifikasi/{id}', [AdminController::class, 'verifikasi'])->name('admin.verifikasi');
});

Route::post('/midtrans/callback', [PemesananController::class, 'callback']);


/*
|--------------------------------------------------------------------------
| AUTH ROUTES (LOGIN, REGISTER, DLL)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
