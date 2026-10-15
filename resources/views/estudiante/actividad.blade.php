@extends('layouts.app')

@section('titulo', 'Mi actividad')

@section('contenido')
    <div class="cabecera">
        <h1>Mi actividad</h1>
    </div>

    <h2 class="grupo-titulo">Mis solicitudes</h2>
    @if ($solicitudes->isEmpty())
        <div class="vacio">Aún no has solicitado equipos.</div>
    @else
        <div class="tabla-scroll">
            <table class="tabla">
                <thead><tr><th>Equipo</th><th>Pedida el</th><th>Estado</th></tr></thead>
                <tbody>
                    @foreach ($solicitudes as $solicitud)
                        <tr>
                            <td><strong>{{ $solicitud->equipo->codigo }}</strong> {{ $solicitud->equipo->nombre }}</td>
                            <td>{{ $solicitud->created_at->format('d/m/Y H:i') }}</td>
                            <td><span class="estado estado-{{ $solicitud->estado }}">{{ ucfirst($solicitud->estado) }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <h2 class="grupo-titulo">Mis préstamos</h2>
    @if ($prestamos->isEmpty())
        <div class="vacio">Aún no tienes préstamos.</div>
    @else
        <div class="tabla-scroll">
            <table class="tabla">
                <thead><tr><th>Equipo</th><th>Salida</th><th>Devolución</th></tr></thead>
                <tbody>
                    @foreach ($prestamos as $prestamo)
                        <tr>
                            <td><strong>{{ $prestamo->equipo->codigo }}</strong> {{ $prestamo->equipo->nombre }}</td>
                            <td>{{ $prestamo->fecha_prestamo->format('d/m/Y H:i') }}</td>
                            <td>
                                @if ($prestamo->fecha_devolucion)
                                    {{ $prestamo->fecha_devolucion->format('d/m/Y H:i') }}
                                @else
                                    <span class="estado estado-prestado">En uso</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection