<?php

use App\Http\Controllers\Backend\DashboardController;

/*
 * All route names are prefixed with 'admin.'.
 */
//Route::redirect('/', '/admin/dashboard', 301);
Route::redirect('/', '/admin/', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
//Route::get('blade', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/', [DashboardController::class, 'index'])->name('home');
