<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models;
use App\Models\Ruta;
use App\models\User_ruta;

class RutasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        session_start();
        ob_start();

        $idUsuario = Auth::id();
        session(['idUser' => $idUsuario]);

        $idRuta = $this->findMaxIdRuta($idUsuario);//buscar la ruta mas actual para mostrar en el inicio

        if(is_null($idRuta))
        {
            $newRuta = $this->store();
            session(['idRuta' => $newRuta]); //configrar para crear una nueva ruta en caso de que no exista ninguna
        }
        else{
            session(['idRuta' => $idRuta]); //almacenar el id ruta actual en una variable de session
        }



        $direcciones = $this->searchDirections(session('idRuta'));


        return view('backend.rutas.index', compact('idUsuario', 'direcciones'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $newRuta = $this->store();
        session(['idRuta' => $newRuta]);

        $direcciones = $this->searchDirections(session('idRuta'));
        return view('backend.rutas.index', compact('direcciones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        // generar nueva ruta
        $ruta = new Ruta();
        $ruta->estado = 'P';
        $ruta->kmTotal = null;
        $ruta->save();

        //enlazar la ruta y el usuario en la tabla usuarios_ruta
        $userRuta = new User_ruta();
        $userRuta->idRuta = $ruta->id;
        $userRuta->idUsuario = session('idUser');
        $userRuta->idVehiculo = null;
        $userRuta->save();

        return $ruta->id;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //$categoria = Categoria::findOrFail($id);
        return view('backend.rutas.sh.ow');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //$categoria = Categoria::findOrFail($id);
        //$users = User::pluck('name', 'id');
        //return view('backend.categorias.edit', compact('noticia', 'users'));
        return view('backend.rutas.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //$categoria = Categoria::findOrFail($id);
        //$categoria->delete();
        return redirect()->route('rutas.index');
    }

    private function findMaxIdRuta(string $id){

        $idUsuario = $id; // id del usuario

        $mayorIdRuta = DB::table('user_ruta')
                        ->join('rutas', 'user_ruta.idRuta', '=', 'rutas.idRuta')
                        ->where('user_ruta.idUsuario', $idUsuario)
                        ->max('user_ruta.idRuta');

        return $mayorIdRuta;

    }

    private function searchDirections(string $idRuta)
    {
        $direccionesUsuario = DB::table('rutas')
                            ->join('direcciones', 'rutas.idRuta', '=', 'direcciones.idRuta')
                            ->where('rutas.idRuta', $idRuta)
                            ->select('idDireccion','direccion', 'latitud', 'longitud', 'tipo')
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
