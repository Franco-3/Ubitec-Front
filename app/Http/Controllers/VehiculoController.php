<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Factories\VehiculoFactory;
use App\Models\Vehiculo;
use App\Models\User;

class VehiculoController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehiculos = Vehiculo::all();
        return view('backend.vehiculos.index', compact('vehiculos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empresa = session('empresa');
        $vehiculos = Vehiculo::pluck('nombre', 'idVehiculo');
        $users = User::where('empresa', $empresa)->get();
        return view('backend.vehiculos.create', compact('vehiculos', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required',
                'patente' => 'required',
                'usuario' => 'required',
            ]
        );

        $vehiculo = new Vehiculo();
        $vehiculo->nombre = $request->input('name');
        $vehiculo->patente = $request->input('patente');
        $vehiculo->idUsuario = $request->input('usuario');

        $vehiculo->update($validatedData);
        $vehiculo->save();

        $request->session()->flash('status', 'Se guardó correctamente el vehiculo ' . $vehiculo->name);
        return redirect()->route('vehiculos.index', $vehiculo->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $vehiculo = Vehiculo::findOrFail($id);
        return view('backend.vehiculos.show', compact('vehiculo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $vehiculo = Vehiculo::findOrFail($id);
        //$users = User::pluck('name', 'id');
        //return view('backend.Vehiculos.edit', compact('noticia', 'users'));
        return view('backend.vehiculos.edit', compact('vehiculo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $vehiculo = Vehiculo::findOrFail($id);
        $validatedData = $request->validate(
            [
                'name' => 'required',
                'description' => 'required',
            ]
        );
        
        
        $vehiculo->update($validatedData);
        $vehiculo->name = $request->input('name');
        $vehiculo->description = $request->input('description');
        $vehiculo->save();

        $request->session()->flash('status', 'Se guardó correctamente el vehiculo ' . $vehiculo->titulo);
        return redirect()->route('vehiculos.index', $vehiculo->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vehiculo = Vehiculo::where('idVehiculo', $id);
        $vehiculo->delete();
        return redirect()->route('vehiculos.index');
    }
    
}
