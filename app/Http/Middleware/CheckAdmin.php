<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    public function handle($request, Closure $next)
    {
        // Verifica si el usuario está autenticado y es administrador
        if (Auth::check() && Auth::user()->fk_type == 1) {
            return $next($request);
        }

        // Redirige al usuario a la página principal o a la ruta de inicio de sesión
        return redirect('/')->with('error', 'No tienes permiso para acceder a esta página.');
    }
}
