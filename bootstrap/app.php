<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // nombre corto para usar en las rutas: ->middleware('rol:encargado')
        $middleware->alias([
            'rol' => \App\Http\Middleware\RolRequerido::class,
        ]);

        // si alguien ya inició sesión y entra a /login, lo mandamos al panel
        $middleware->redirectUsersTo('/panel');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();