<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\SumaController;
use App\Http\Controllers\ProductoController;

Route::get('/', function () {
    return view('home.landing_page');
});

Route::get('/nosotros', function () {
    return view('home.nosotros');
});

Route::get('/planes', function () {
    return view('home.planes');
});

Route::get('/contacto', function () {
    return view('home.contacto');
});

/* 
Route::get('/suma', function () {
    return view('suma');
});
 */

Route::post('/contacto', [ContactoController::class, 'store']);

Route::get('/suma',[SumaController::class, 'index']);

Route::post('/suma', [SumaController::class, 'suma']);

Route::get('/productos', [ProductoController::class, 'index']);
