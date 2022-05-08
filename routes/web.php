<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ReservasController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login')->withOk(' ');
});


Route::get('/holamundo', function () {
    return view('holamundo', ['name' => 'Aina']);
});


Route::get('/main', [MainController::class, 'index']);
Route::get('/main/1', [MainController::class, 'index2']);
Route::post('/main/checklogin', [MainController::class, 'checklogin']);
Route::get('main/successlogin',   [ReservasController::class, 'index']);
Route::get('main/successconductor',  [ReservasController::class, 'index']);
Route::get('main/successtrabajador',  [ReservasController::class, 'index']);
Route::get('main/logout',  [MainController::class, 'logout'])->name('main.logout');

Route::get('main/registro',  [MainController::class, 'registro']);
Route::post('/main/darAltaUser', [MainController::class, 'darAltaUser']);

Route::group(['prefix' => 'reservas'], function() {
            Route::get('/', [ReservasController::class, 'index'])->name('reservas.index');
            Route::get('/create', [ReservasController::class, 'create'])->name('reservas.create');
            Route::post('/darAltaReserva', [ReservasController::class, 'darAltaReserva']);
            /*Route::post('/create', [ReservasController::class, 'store'])->name('reservas.store');
            Route::get('/{reserva}/show', [ReservasController::class, 'show'])->name('reservas.show');*/
            Route::get('/{reserva}/edit', [ReservasController::class, 'edit'])->name('reservas.edit');
            Route::patch('/{reserva}/update', [ReservasController::class, 'update'])->name('reservas.update');
            Route::delete('/{reserva}/delete', [ReservasController::class, 'destroy'])->name('reservas.destroy');
    });