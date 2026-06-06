<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PresensiWebController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\AuthController; 

// Import Livewire components
use App\Livewire\UserManagement;
use App\Livewire\EditProfile;

Route::get('/users', UserManagement::class)->name('users.index');

// Route awal (Welcome)
Route::get('/', function () {
    return view('welcome');
});

// --- ROUTE AUTH (Wajib di luar middleware auth agar tidak redirect loop) ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

/**
 * Grup rute yang mewajibkan login (auth).
 */
Route::middleware(['auth'])->group(function () {
    
    // Route Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Route untuk edit profil (Sesuai kode awal kamu)
    Route::get('/profil', EditProfile::class)->name('profile.edit');

    // Grup untuk Role: Superadmin DAN Admin
    Route::middleware(['role:superadmin,admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/presensi', [PresensiWebController::class, 'index'])->name('presensi.index');
        Route::get('/presensi/export', [PresensiWebController::class, 'exportExcel'])->name('presensi.export');
        Route::resource('santri', SantriController::class);
    });

    // Grup Khusus Role: HANYA Superadmin
    Route::middleware(['role:superadmin'])->group(function () {
        Route::resource('kegiatan', JadwalController::class);
        
        // Halaman Manajemen User (Sesuai kode awal kamu)
        Route::get('/users', UserManagement::class)->name('users.index');
    });

});