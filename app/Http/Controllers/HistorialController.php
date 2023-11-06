<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HistorialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rutas = DB::table('user_ruta')
        ->join('rutas', 'user_ruta.idRuta', '=', 'rutas.idRuta')
        ->join('direcciones as inicio', function ($join) {
            $join->on('inicio.idRuta', '=', 'rutas.idRuta')
                 ->where('inicio.tipo', 'inicio');
        })
        ->join('direcciones as final', function ($join) {
            $join->on('final.idRuta', '=', 'rutas.idRuta')
                 ->where('final.tipo', 'final');
        })
        ->select('rutas.idRuta', 'inicio.direccion as direccion_inicio', 'final.direccion as direccion_final', 'rutas.created_at', 'rutas.path')
        ->where('user_ruta.idUsuario', session('idUser'))
        ->get();
        return view('backend.historial.index', compact('rutas'));
    }

    // public function mostrarDatos()
    // {
    //     // $datos = DB::table('tabla')->get();
    //     // $datosPaginados = $datos->paginate(3);
    //     return view('backend.historial.index', compact('datosPaginados'));

    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        session(['idRuta' => $id]);

        return redirect()->route('rutas.index');

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
}
