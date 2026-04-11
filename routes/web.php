<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PresensiWebController;
use App\Http\Controllers\SantriController;

Route::resource('santri', SantriController::class);
Route::get('/presensi', [PresensiWebController::class,'index']);
Route::get('/dashboard', [DashboardController::class,'index']);
Route::get('/', function () {
    return view('welcome');
});
