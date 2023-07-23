<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Direcciones;

class DireccionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

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
        $validatedData = $request->validate(
            [
                'direccion' => 'required',
                'tipo' => 'required',
            ]
        );

        $direccion = new Direcciones();
        $direccion->idRuta = session('idRuta');
        $direccion->direccion = $request->input('direccion');
        $direccion->latitud = 100; //definidos fijos por el momento - para trabajar luego
        $direccion->longitud = 200; //definidos fijos por el momento - para trabajar luego
        $direccion->tipo = $request->input('tipo');
        $direccion->orden = null;

        $direccion->update($validatedData);
        $direccion->save();

        // $request->session()->flash('status', 'Se guardó correctamente la categoria ' . $categoria->name);
        return redirect()->route('rutas.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
