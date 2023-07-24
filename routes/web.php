<?php

use App\Http\Controllers\DireccionesController;
use App\Http\Controllers\HistorialController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RutasController;
use App\Http\Controllers\UserController;
use App\Models\Historial;
use App\Http\Controllers\TSPcontroller;
use Illuminate\Support\Facades\Auth;

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

Route::post('direcciones/rutas', [DireccionesController::class, 'store'])->name('direcciones.store');

Auth::routes();





//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



//API PARA COMUNICARSE CON GOOGLE EN DESARROLLO

Route::get('/google', function (){
    return view('backend.google');
});

// Route::get('/google', [TSPcontroller::class, 'postDirections']);

Route::post('/google', [TSPcontroller::class, 'postDirections'])->name('postDirections');
