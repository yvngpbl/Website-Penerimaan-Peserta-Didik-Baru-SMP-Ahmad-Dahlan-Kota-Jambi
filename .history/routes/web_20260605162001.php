<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

Route::get('/', function () { 
    return view('welcome'); 
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ==========================================
    // AKSES KHUSUS ADMIN
    // ==========================================
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/pendaftaran', [AdminController::class, 'pendaftaran'])->name('pendaftaran');
        Route::post('/pendaftaran/{id}/verifikasi', [AdminController::class, 'verifikasiBerkas'])->name('verifikasi');
        Route::get('/kelulusan', [AdminController::class, 'kelulusan'])->name('kelulusan');
        Route::post('/kelulusan/{id}/update', [AdminController::class, 'updateKelulusan'])->name('kelulusan.update');
        Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan');
        Route::get('/pendaftar/detail/{id}', [AdminController::class, 'detailPendaftar'])->name('pendaftar.detail');

        // Rute untuk menampilkan daftar akun
        Route::get('/admin/akun', [\App\Http\Controllers\AdminController::class, 'akunPendaftar'])->name('admin.akun');

        // Rute untuk menghapus akun
        Route::delete('/admin/akun/{id}', [\App\Http\Controllers\AdminController::class, 'hapusAkun'])->name('admin.akun.destroy');
        
        // --- ROUTE BARU: KONTROL BUKA/TUTUP PENDAFTARAN OLEH ADMIN ---
        Route::post('/pengaturan/toggle-pendaftaran', [AdminController::class, 'togglePendaftaran'])->name('toggle_pendaftaran');
    });

    // ==========================================
    // AKSES KHUSUS USER (CALON SISWA)
    // ==========================================
    Route::middleware('role:user')->prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
        
        // Rute Pendaftaran Gabungan (Mengecek Buka/Tutup & Simpan Semua Form)
        Route::get('/pendaftaran', [UserController::class, 'pendaftaran'])->name('pendaftaran');
        Route::post('/pendaftaran/simpan', [UserController::class, 'storePendaftaran'])->name('store_pendaftaran');
        
        Route::get('/riwayat', [UserController::class, 'riwayat'])->name('riwayat');
        Route::get('/kelulusan', [UserController::class, 'kelulusan'])->name('kelulusan');
        Route::get('/cetak-lulus', [UserController::class, 'cetakSuratLulus'])->name('cetak_lulus');
         // Halaman Formulir Tambahan (Pernyataan & TTD)
        Route::get('/pendaftaran/tambahan', [UserController::class, 'tambahan'])->name('pendaftaran.tambahan');
        Route::post('/pendaftaran/tambahan/simpan', [UserController::class, 'storeTambahan'])->name('pendaftaran.store_tambahan');
        Route::get('/user/pendaftaran/pdf', [UserController::class, 'downloadPernyataanPDF'])->name('user.pendaftaran.pdf');

        Route::get('/user/pendaftaran/edit/{id}', [UserController::class, 'editPendaftaran'])->name('pendaftaran.edit');
        Route::put('/user/pendaftaran/update/{id}', [UserController::class, 'updatePendaftaran'])->name('pendaftaran.update');
    });

    // Route untuk halaman Informasi
Route::get('/informasi/sekilas', function () {
    return view('user.informasi.sekilas');
})->name('info.sekilas');

Route::get('/informasi/visi-misi', function () {
    return view('user.informasi.visimisi');
})->name('info.visimisi');

Route::get('/informasi/fasilitas', function () {
    return view('user.informasi.fasilitas');
})->name('info.fasilitas');

Route::get('/informasi/ekstrakurikuler', function () {
    return view('user.informasi.ekstrakulikuler');
})->name('info.ekskul');

Route::get('/informasi/prestasi', function () {
    return view('user.informasi.prestasi');
})->name('info.prestasi');
});