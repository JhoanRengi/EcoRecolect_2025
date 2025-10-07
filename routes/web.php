<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardAdmin;
use App\Http\Middleware\EnsureUserIsAdmin;

// Públicas
Route::get('/',           [HomeController::class, 'landing'])->name('home');
Route::get('/nosotros',   [HomeController::class, 'nosotros'])->name('nosotros');
Route::get('/planes',     [HomeController::class, 'planes'])->name('planes');
Route::get('/contacto',   [HomeController::class, 'contacto'])->name('contacto');
Route::post('/contacto',  [ContactoController::class, 'store'])->name('contacto.store');

// Usuario
Route::get('/dashboard', fn() => view('dashboard'))
    ->middleware(['auth','verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin
Route::middleware(['auth','verified', EnsureUserIsAdmin::class])
    ->prefix('admin')->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardAdmin::class, 'index'])->name('dashboard');
        // Route::get('/ping', fn() => 'ADMIN OK')->name('ping');
    });

// Logout rápido (opcional en dev)
Route::get('/dev-logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
});

// Rutas de login/registro/reset
require __DIR__.'/auth.php';
