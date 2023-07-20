<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;



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

        $idRuta = $this->findMaxIdRuta();//buscar la ruta mas actual para mostrar en el inicio
        session(['idRuta' => $idRuta]);


        return view('backend.rutas.index', compact('idUsuario'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //$categorias = Categoria::pluck('name', 'id');
        return view('backend.rutas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $categoria = Categoria::findOrFail($id);
        $validatedData = $request->validate(
            [
                'name' => 'required',
                'description' => 'required',
            ]
        );

        //$categoria = new Categoria();
        $categoria->name = $request->input('name');
        $categoria->description = $request->input('description');

        $categoria->update($validatedData);
        $categoria->save();

        $request->session()->flash('status', 'Se guardó correctamente la categoria ' . $categoria->name);
        return redirect()->route('rutas.index', $categoria->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //$categoria = Categoria::findOrFail($id);
        return view('backend.rutas.show');
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
        //$categoria = Categoria::findOrFail($id);
        $validatedData = $request->validate(
            [
                'name' => 'required',
                'description' => 'required',
            ]
        );


        $categoria->update($validatedData);
        $categoria->name = $request->input('name');
        $categoria->description = $request->input('description');
        $categoria->save();

        $request->session()->flash('status', 'Se guardó correctamente la noticia ' . $categoria->titulo);
        return redirect()->route('rutas.index', $categoria->id);
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

    private function findMaxIdRuta(){

        $idUsuario = 1; // Reemplaza esto por el idUsuario que desees consultar

        $mayorIdRuta = DB::table('usuarios_ruta')
                        ->join('rutas', 'usuarios_ruta.idRuta', '=', 'rutas.idRuta')
                        ->where('usuarios_ruta.idUsuario', $idUsuario)
                        ->max('usuarios_ruta.idRuta');

        return $mayorIdRuta;

    }


}
