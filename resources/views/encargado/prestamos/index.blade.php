@extends('layouts.app')

@section('titulo', 'Préstamos')

@section('contenido')
    <div class="cabecera">
        <h1>Préstamos</h1>
    </div>

    @if ($prestamos->isEmpty())
        <div class="vacio">Todavía no hay préstamos registrados.</div>
    @else
        <div class="tabla-scroll">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Equipo</th>
                        <th>Estudiante</th>
                        <th>Entregó</th>
                        <th>Salida</th>
                        <th>Devolución</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($prestamos as $prestamo)
                        <tr>
                            <td><strong>{{ $prestamo->equipo->codigo }}</strong> {{ $prestamo->equipo->nombre }}</td>
                            <td>{{ $prestamo->estudiante->name }}</td>
                            <td>{{ $prestamo->encargado->name }}</td>
                            <td>{{ $prestamo->fecha_prestamo->format('d/m/Y H:i') }}</td>
                            <td>
                                @if ($prestamo->fecha_devolucion)
                                    {{ $prestamo->fecha_devolucion->format('d/m/Y H:i') }}
                                @else
                                    <span class="estado estado-prestado">En uso</span>
                                @endif
                            </td>
                            <td>
                                @unless ($prestamo->fecha_devolucion)
                                    <form action="{{ route('encargado.prestamos.devolver', $prestamo) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn-pizarra">Devolver</button>
                                    </form>
                                @endunless
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection