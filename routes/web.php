<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DireccionesController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\HomeController;
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

//controlador home
Route::get('/', [HomeController::class, 'index'])->name('home');

Auth::routes();

//rutas si esta autenticado
Route::middleware('auth')->group(function () {

    Route::resource('rutas', RutasController::class);
    Route::resource('historial', HistorialController::class);
    Route::resource('direcciones', DireccionesController::class);

    Route::post('direcciones/rutas', [DireccionesController::class, 'store'])->name('direcciones.store');
    Route::delete('direcciones/rutas/{direccion}', [DireccionesController::class, 'destroy'])->name('direcciones.destroy');
    Route::get('tsp/ordenar', [TSPcontroller::class, 'osrmOrder'])->name('tsp.ordenar');
    Route::get('google/ordenar', [TSPcontroller::class, 'postDirections'])->name('google.ordenar');
    Route::put('cambiarEstado/{id}', [DireccionesController::class, 'actualizarEstado'])->name('cambiarEstado');


    Route::get('cuenta', [UserController::class, 'miCuenta'])->name('miCuenta');
    Route::put('cuenta/{id}', [UserController::class, 'updateMiCuenta'])->name('miCuenta.update');
    Route::patch('cuenta', [UserController::class, 'changePassword'])->name('miCuenta.password');


    Route::post('cargar-excel', [ExcelController::class, 'cargarExcel'])->name('cargar.excel');
    Route::get('generar-excel', [ExcelController::class, 'generarExcel'])->name('generar.excel');

    Route::post('subir-imagen', [RutasController::class, 'agregarCaptura'])->name('guardar.captura');

    Route::post('direccion-imagen', [DireccionesController::class, 'agregarImagenDireccion'])->name('direccion.imagen');
    Route::post('descargar-imagen', [DireccionesController::class, 'descargarImagen'])->name('descargar.imagen');
});




//verificar si es admin
Route::group(['middleware' => 'admin'], function () {
    Route::resource('users', UserController::class);
    Route::resource('vehiculos', VehiculoController::class);
    Route::get('vehiculos/updateUser/{id}', [VehiculoController::class, 'updateUser']);
    Route::resource('dashboard', AdminController::class);
    Route::get('dashboard/nueva-ruta/{id}', [AdminController::class, 'create'])->name('nueva_ruta');




    Route::post('dividir-excel', [ExcelController::class, 'dividirExcelEntreVehiculos'])->name('dividir.excel');
    Route::get('tspAdmin', [TSPcontroller::class, 'dividirDirecciones'])->name('excel.admin');
    
});











