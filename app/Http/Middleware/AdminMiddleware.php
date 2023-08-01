<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //verifica si esta logeado y si el usuario es administrador(0)
        if (auth()->check() && auth()->user()->tipo === '0'){
            return $next($request);
        }else{
            return redirect('/rutas');
        }
        
    }
}
