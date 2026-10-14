<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RolRequerido
{
    public function handle(Request $request, Closure $next, string $rol): Response
    {
        $usuario = $request->user();

        // si no hay usuario o su rol no coincide, no entra
        if (! $usuario || $usuario->rol !== $rol) {
            abort(403);
        }

        return $next($request);
    }
}