<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Inicio') | {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,700&family=Source+Sans+3:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/lab.css') }}" rel="stylesheet">
</head>
<body>
    <header class="barra">
        <div class="contenedor barra-fila">
            <a class="marca" href="{{ auth()->check() ? route('panel') : route('login') }}">{{ config('app.name') }}</a>

            @auth
                <nav class="enlaces" aria-label="Principal">
                    <a href="{{ route('panel') }}" @class(['activo' => request()->routeIs('panel')])>Inicio</a>
                    @if (auth()->user()->esEncargado())
                        <a href="{{ route('encargado.equipos.index') }}" @class(['activo' => request()->routeIs('encargado.equipos.*')])>Equipos</a>
                        <a href="{{ route('encargado.solicitudes.index') }}" @class(['activo' => request()->routeIs('encargado.solicitudes.*')])>Solicitudes</a>
                        <a href="{{ route('encargado.prestamos.index') }}" @class(['activo' => request()->routeIs('encargado.prestamos.*')])>Préstamos</a>
                    @else
                        <a href="{{ route('estudiante.equipos') }}" @class(['activo' => request()->routeIs('estudiante.equipos')])>Equipos</a>
                        <a href="{{ route('estudiante.actividad') }}" @class(['activo' => request()->routeIs('estudiante.actividad')])>Mi actividad</a>
                    @endif
                </nav>

                <form action="{{ route('logout') }}" method="POST" class="salir">
                    @csrf
                    <span class="usuario">{{ auth()->user()->name }}</span>
                    <button type="submit" class="btn-quieto">Cerrar sesión</button>
                </form>
            @endauth
        </div>
    </header>

    <main class="contenedor principal">
        @if (session('ok'))
            <div class="aviso" role="status">{{ session('ok') }}</div>
        @endif
        @if (session('error'))
            <div class="aviso aviso-error" role="alert">{{ session('error') }}</div>
        @endif

        @yield('contenido')
    </main>
</body>
</html>