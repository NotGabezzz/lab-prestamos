<?php

use App\Http\Middleware\RolRequerido;
use App\Http\Middleware\SinCache;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // nombre corto para usar en las rutas: ->middleware('rol:encargado')
        $middleware->alias([
            'rol' => RolRequerido::class,
        ]);

        // ninguna página web se guarda en la caché del navegador
        $middleware->appendToGroup('web', SinCache::class);

        // si alguien ya inició sesión y entra a /login, lo mandamos al panel
        $middleware->redirectUsersTo('/panel');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // si la base de datos falla, aviso corto y sin detalles técnicos
        $exceptions->render(function (\PDOException $e, Request $request) {
            // mientras desarrollas (APP_DEBUG=true) se ve el error completo
            if (config('app.debug')) {
                return null;
            }

            return response()->view('errors.bd', [], 503);
        });
    })->create();