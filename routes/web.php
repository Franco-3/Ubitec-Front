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


    Route::get('cuenta', [UserController::class, 'miCuenta'])->name('miCuenta');
});




//verificar si es admin
Route::group(['middleware' => 'admin'], function () {
    Route::resource('users', UserController::class);
    Route::resource('vehiculos', VehiculoController::class);
    Route::post('vehiculos/updateVehiculos', [DireccionesController::class, 'updateVehiculos'])->name('post');;
    Route::resource('dashboard', AdminController::class);
    Route::get('dashboard/nueva-ruta/{id}', [AdminController::class, 'create'])->name('nueva_ruta');
});






//rutas para cargar excel
Route::get('/cargarExcel', function () {
    return view('backend.excel');
});

Route::post('/cargar-excel', [ExcelController::class, 'cargarExcel'])->name('cargar.excel');
Route::post('/dividir-excel', [ExcelController::class, 'dividirExcelEntreVehiculos'])->name('dividir.excel');
Route::get('/tspAdmin', [TSPcontroller::class, 'dividirDirecciones'])->name('excel.admin');
Route::get('/generar-excel', [ExcelController::class, 'generarExcel'])->name('generar.excel');









