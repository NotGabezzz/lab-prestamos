@extends('layouts.app')

@section('titulo', 'Solicitudes')

@section('contenido')
    <div class="cabecera">
        <h1>Solicitudes pendientes</h1>
    </div>

    @if ($solicitudes->isEmpty())
        <div class="vacio">No hay solicitudes por revisar.</div>
    @else
        <div class="tabla-scroll">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Estudiante</th>
                        <th>Equipo</th>
                        <th>Pedida el</th>
                        <th>Equipo ahora</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($solicitudes as $solicitud)
                        <tr>
                            <td>{{ $solicitud->estudiante->name }}</td>
                            <td><strong>{{ $solicitud->equipo->codigo }}</strong> {{ $solicitud->equipo->nombre }}</td>
                            <td>{{ $solicitud->created_at->format('d/m/Y H:i') }}</td>
                            <td><span class="estado estado-{{ $solicitud->equipo->estado }}">{{ ucfirst($solicitud->equipo->estado) }}</span></td>
                            <td class="text-end">
                                <form action="{{ route('encargado.solicitudes.aprobar', $solicitud) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-pizarra" @disabled(! $solicitud->equipo->estaDisponible())>Aprobar y prestar</button>
                                </form>
                                <form action="{{ route('encargado.solicitudes.rechazar', $solicitud) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-quieto btn-peligro">Rechazar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection