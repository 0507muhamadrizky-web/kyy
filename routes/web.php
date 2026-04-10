<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [WelcomeController::class, 'index']);

// =============================================
// ADMIN ROUTES
// =============================================
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->middleware('verified')->name('dashboard');


    // Verifikasi Peminjaman
    Route::get('/admin/peminjaman', [PeminjamanController::class, 'adminIndex'])->name('admin.peminjaman.index');
    Route::put('/admin/peminjaman/{id}/verify', [PeminjamanController::class, 'updateStatus'])->name('admin.peminjaman.verify');

    // Verifikasi Pengembalian
    Route::get('/admin/pengembalian', [PengembalianController::class, 'adminIndex'])->name('admin.pengembalian.index');
    Route::put('/admin/pengembalian/{id}/verify', [PengembalianController::class, 'updateStatus'])->name('admin.pengembalian.verify');

    // Data Barang (existing)
    Route::get('/data-barang-masuk', function () {
        return view('admin.data-barang-masuk');
    })->name('data.barang.masuk');
    Route::get('/data-barang-keluar', function () {
        return view('admin.data-barang-keluar');
    })->name('data.barang.keluar');

    // Input Barang (existing)
    Route::get('/input-barang-keluar', function () {
        return view('admin.input-barang-keluar');
    })->name('input.barang.keluar');
    Route::post('/input-barang-keluar', [\App\Http\Controllers\BarangKeluarController::class, 'store'])->name('input.barang.keluar.store');
    Route::get('/input-barang-masuk', function () {
        return view('admin.input-barang-masuk');
    })->name('input.barang.masuk');
    Route::post('/input-barang-masuk', [\App\Http\Controllers\BarangMasukController::class, 'store'])->name('input.barang.masuk.store');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Riwayat (existing)
    Route::get('/riwayat', function () {
        return view('admin.riwayat');
    })->name('riwayat');
    Route::get('/riwayat/export/excel', [\App\Http\Controllers\ExportController::class, 'exportExcel'])->name('riwayat.export.excel');
    Route::get('/riwayat/export/pdf', [\App\Http\Controllers\ExportController::class, 'exportPDF'])->name('riwayat.export.pdf');

    // Barang Masuk Edit & Hapus
    Route::get('/barangmasuk/{id}/edit', [\App\Http\Controllers\BarangMasukController::class, 'edit'])->name('barangmasuk.edit');
    Route::put('/barangmasuk/{id}', [\App\Http\Controllers\BarangMasukController::class, 'update'])->name('barangmasuk.update');
    Route::delete('/barangmasuk/{id}', [\App\Http\Controllers\BarangMasukController::class, 'destroy'])->name('barangmasuk.destroy');

    // Barang Keluar Edit & Hapus
    Route::get('/barangkeluar/{id}/edit', [\App\Http\Controllers\BarangKeluarController::class, 'edit'])->name('barangkeluar.edit');
    Route::put('/barangkeluar/{id}', [\App\Http\Controllers\BarangKeluarController::class, 'update'])->name('barangkeluar.update');
    Route::delete('/barangkeluar/{id}', [\App\Http\Controllers\BarangKeluarController::class, 'destroy'])->name('barangkeluar.destroy');
});

// =============================================
// USER ROUTES
// =============================================
Route::middleware(['auth', 'user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');


    // Peminjaman
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/peminjaman/check-stock', [PeminjamanController::class, 'checkStock'])->name('peminjaman.check-stock');

    // Pengembalian
    Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
    Route::get('/pengembalian/{peminjaman}/create', [PengembalianController::class, 'create'])->name('pengembalian.create');
    Route::post('/pengembalian/{peminjaman}', [PengembalianController::class, 'store'])->name('pengembalian.store');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
