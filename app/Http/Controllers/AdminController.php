<?php

namespace App\Http\Controllers;

use App\Models\Ruta;
use App\Models\Direcciones;
use App\Models\Vehiculo;
use App\Models\User_ruta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empresa = Auth()->user()->empresa;
        $direcciones = DB::table('direcciones')
        ->join('rutas', 'direcciones.idRuta', '=', 'rutas.idRuta')
        ->join('user_ruta', 'rutas.idRuta', '=', 'user_ruta.idRuta')
        ->join('users', 'user_ruta.idUsuario', '=', 'users.id')
        ->where('users.empresa', $empresa)
        ->where('direcciones.estado', false)
        ->where('direcciones.tipo', '<>', 'inicio')
        ->where('direcciones.tipo', '<>', 'final')
        ->select('direcciones.*', 'users.name')
        ->get();
        $vehiculos = Vehiculo::all()->whereNull('idUsuario');
        //$vehiculos = Vehiculo::all();
        session(['empresa' => $empresa]);
        //dd($vehiculos);
        $vehiculosUsuario = DB::table('users')
                ->join('vehiculos', 'users.id', '=', 'vehiculos.idUsuario')
                ->select('*')
                ->where('users.empresa', '=', $empresa)
                ->get();
        
        return view('admin.index', compact('vehiculosUsuario', 'direcciones', 'vehiculos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id)
    {
        $ruta = $this->newRuta($id);

        return redirect()->route('dashboard.show', $id);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $idRuta = $this->findMaxIdRuta($id); //econtrar la ruta mas actual
        session(['idRuta' => $idRuta]);

        if(is_null($idRuta))
        {
            $newRuta = $this->newRuta($id); //generar una nueva ruta
            session(['idRuta' => $newRuta]);
            $idRuta = $newRuta;
        }

        $direcciones = $this->searchDirections($idRuta);
        

        return view('admin.show', compact('idRuta', 'direcciones', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    private function findMaxIdRuta(string $id){

        $idUsuario = $id; // id del usuario

        $mayorIdRuta = DB::table('user_ruta')
                        ->join('rutas', 'user_ruta.idRuta', '=', 'rutas.idRuta')
                        ->where('user_ruta.idUsuario', $idUsuario)
                        ->max('user_ruta.idRuta');

        return $mayorIdRuta;

    }

    public function newRuta(string $id)
    {
        // generar nueva ruta
        $ruta = new Ruta();
        $ruta->estado = 'P';
        $ruta->kmTotal = null;
        $ruta->path = 'storage/images_ruta/default.png';
        $ruta->save();

        //enlazar la ruta y el usuario en la tabla usuarios_ruta
        $userRuta = new User_ruta();
        $userRuta->idRuta = $ruta->getKey();
        $userRuta->idUsuario = $id;
        $userRuta->idVehiculo = null;
        $userRuta->save();

        return $ruta->getKey();
    }

    private function searchDirections(string $idRuta)
    {
        $direccionesUsuario = DB::table('rutas')
                            ->join('direcciones', 'rutas.idRuta', '=', 'direcciones.idRuta')
                            ->where('rutas.idRuta', $idRuta)
                            ->select('idDireccion','direccion', 'latitud', 'longitud', 'tipo')
                            ->orderBy('orden', 'asc')
                            ->get();


        //buscar las direcciones de inicio y final
        $inicio = null;
        $final = null;

        foreach ($direccionesUsuario as $direccion) {
            if ($direccion->tipo === 'inicio') {
                $inicio = $direccion;
            } elseif ($direccion->tipo === 'final') {
                $final = $direccion;
            }
        }
        //guardar en session el inicio y final
        session(['inicio' => $inicio]);
        session(['final' => $final]);


        // Filtrar las direcciones para eliminar "inicio" y "final"
        $direccionesUsuario = $direccionesUsuario->filter(function ($direccion) {
            return $direccion->tipo !== 'inicio' && $direccion->tipo !== 'final';
        });

        return $direccionesUsuario;
    }

}
