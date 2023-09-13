<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //verificar si esta autenticado y es admin
        if(auth()->check() && auth()->user()->tipo === '0') return redirect('dashboard');

        // Verificar si el usuario está autenticado
        if (auth()->check()) {
            // Si el usuario está autenticado, redirige a la vista personalizada
            return redirect('/rutas');
        }

        // Si el usuario no está autenticado, muestra la vista 'home'
        return view('home');
    }
}
