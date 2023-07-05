<?php

use App\Http\Controllers\HistorialController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RutasController;
use App\Http\Controllers\UserController;
use App\Models\Historial;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', [NoticiaController::class, 'index'])->name('noticias.index');

/* Route::get('/', function () {
    return view('backend/home');
}); */

/* Route::get('/', function (){
    return redirect('/home')
}); */

Route::get('/', [UserController::class, 'index'])->name('users.index');
//Route::get('/login', [UserController::class, 'login'])->name('users.login');
//Route::get('/signup', [UserController::class, 'signup'])->name('users.signup');

Route::resource('rutas', RutasController::class);
Route::resource('historial', HistorialController::class);

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
