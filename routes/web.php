<?php

use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardAdmin;

// Públicas
Route::view('/', 'home.landing_page')->name('home');
Route::view('/nosotros', 'home.nosotros')->name('nosotros');
Route::view('/planes', 'home.planes')->name('planes');
Route::view('/contacto', 'home.contacto')->name('contacto');
Route::post('/contacto', [ContactoController::class, 'store'])->name('contacto.store');

// Protegidas (usuario)
Route::get('/dashboard', fn () => view('dashboard'))
    ->middleware(['auth','verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth','verified', EnsureUserIsAdmin::class])
    ->prefix('admin')->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardAdmin::class, 'index'])->name('dashboard');
        // PRUEBA: ruta de humo para chequear que estamos entrando aquí
        Route::get('/ping', fn() => 'ADMIN OK')->name('ping');
    });


// Utilidad de desarrollo: cerrar sesión rápido
Route::get('/dev-logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
});

// Rutas de autentificación (login/register/etc.)
require __DIR__.'/auth.php';
