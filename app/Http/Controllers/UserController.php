<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; //Referencia al Modelo User
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; //Clase utilizada para encriptar la contraseña
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('backend.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'tipo' => ['required', 'string']
            ]
        );
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'tipo' => $request->input('tipo'),
            'empresa' => session('empresa')
        ]);


        $request->session()->flash('status', 'Se guardó correctamente el usuario ' . $user->name);
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('backend.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('backend.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
/*         $validatedData = $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,id,' . $id],
                'telefono' => ['required', 'integer'],
                // 'password' => ['required', 'string', 'min:8', 'confirmed'],
                // 'tipo' => ['required', 'string'],
                // 'empresa' => ['string']
            ]
        );

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->telefono = $request->input('telefono');
        $user->password = Hash::make($request->input('password'));
        $user->tipo = $request->input('tipo');
        $user->empresa = $request->input('empresa');
        $user->save(); */

        $user->update([
            'name' => $request->input('nombre'),
            'lastName' => $request->input('apellido'),
            'email' => $request->input('email'),
            'telefono' => $request->input('telefono')
        ]);
        $request->session()->flash('status', 'Se modificó correctamente el usuario ' . $user->name);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index');
    }


    public function miCuenta()
    {
        $user = Auth()->user();

        return view('backend.users.miCuenta', compact('user'));
    }
}