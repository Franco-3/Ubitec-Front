<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Direcciones;
use Symfony\Component\Console\Input\Input;

use function PHPUnit\Framework\isNull;

class DireccionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //MOSTRAR DIRECCIONES
        $direcciones = Direcciones::all();
        return view('backend.direcciones.index', compact('direcciones'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //CREAR DIRECCION
        return view('backend.direcciones.create');
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
        $direccion->latitud = $request->input('latitud');
        $direccion->longitud = $request->input('longitud');
        $direccion->tipo = $request->input('tipo');
        $direccion->orden = null;
        $direccion->update($validatedData);
        $direccion->save();



        if($request->input('tipo') === 'inicio' && is_null(session('final')))
        {
            $request->merge(['tipo' => 'final']);
            $this->store($request);
        }
        // $request->session()->flash('status', 'Se guardó correctamente la categoria ' . $categoria->name);
        //return $direccion;
        return redirect()->route('direcciones.index')->with('success', 'Dirección creada correctamente.');
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
        //EDITAR DIRECCIONES
        $direccion = Direcciones::findOrFail($id);
        return view('backend.direcciones.edit', compact('direccion'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //ACTUALIZAR DIRECCIONES
        $direccion = Direcciones::findOrFail($id);

        $request->validate([
            'direccion' => 'required',
            'latitud' => 'required',
            'longitud' => 'required',
        ]);

        $direccion->update([
            'direccion' => $request->input('direccion'),
            'latitud' => $request->input('latitud'),
            'longitud' => $request->input('longitud'),
            'tipo' => $request->input('tipo'),
            'orden' => $request->input('orden')
        ]);

        return redirect()->route('direcciones.index')->with('success', 'Dirección actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Direcciones $direccion)
    {
        // Aquí puedes realizar cualquier lógica que necesites antes de eliminar la dirección
        $direccion->delete();

        return back()->with('success', 'Dirección eliminada correctamente.');
    }



}
