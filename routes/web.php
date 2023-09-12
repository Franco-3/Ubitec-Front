<?php

use App\Http\Controllers\DireccionesController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\HistorialController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RutasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehiculoController;
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

Route::get('/', function (){
    return view('backend/home');
});

Auth::routes();

Route::middleware('auth')->group(function () {

    Route::resource('rutas', RutasController::class);
    Route::resource('historial', HistorialController::class);
    Route::resource('direcciones', DireccionesController::class);

    Route::post('direcciones/rutas', [DireccionesController::class, 'store'])->name('direcciones.store');
    Route::delete('direcciones/rutas/{direccion}', [DireccionesController::class, 'destroy'])->name('direcciones.destroy');
    Route::get('direcciones/ordenar', [TSPcontroller::class, 'postDirections'])->name('direcciones.ordenar');

});

//verificar si es admin
Route::group(['middleware' => 'admin'], function () {
    Route::resource('users', UserController::class);
    Route::resource('vehiculos', VehiculoController::class);
});


Route::get('/cargarExcel', function () {
    return view('backend.excel');
});

Route::post('/cargar-excel', [ExcelController::class, 'cargarExcel'])->name('cargar.excel');
Route::get('/generar-excel', [ExcelController::class, 'generarExcel'])->name('generar.excel');




//API PARA COMUNICARSE CON GOOGLE EN DESARROLLO

Route::get('/google', function (){
    return view('backend.google');
});

// Route::get('/google', [TSPcontroller::class, 'postDirections']);

Route::post('/google', [TSPcontroller::class, 'postDirections'])->name('postDirections');

//Ruta para el CRUD direcciones
//Route::resource('direcciones', 'DireccionesController');

