<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::get('/', [UserController::class, 'index'])->name('users.index');
Route::get('/login', [UserController::class, 'login'])->name('users.login');
Route::get('/signup', [UserController::class, 'signup'])->name('users.signup');

//Route::resource('users', UserController::class);
