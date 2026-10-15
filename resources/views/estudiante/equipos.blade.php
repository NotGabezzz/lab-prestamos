@extends('layouts.app')

@section('titulo', 'Equipos')

@section('contenido')
    <div class="cabecera">
        <h1>Equipos del laboratorio</h1>
    </div>

    @forelse ($equipos->groupBy('categoria') as $categoria => $grupo)
        <h2 class="grupo-titulo">{{ $categoria }}</h2>

        @foreach ($grupo as $equipo)
            <article class="fila-equipo">
                <span class="codigo">{{ $equipo->codigo }}</span>
                <div><h3>{{ $equipo->nombre }}</h3></div>
                <span class="estado estado-{{ $equipo->estado }}">{{ ucfirst($equipo->estado) }}</span>

                <div class="acciones">
                    @if ($equipo->estaDisponible())
                        @if (in_array($equipo->id, $pendientes))
                            <span class="detalle">Solicitud enviada</span>
                        @else
                            <form action="{{ route('estudiante.solicitar', $equipo) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-pizarra">Solicitar</button>
                            </form>
                        @endif
                    @endif
                </div>
            </article>
        @endforeach
    @empty
        <div class="vacio">Todavía no hay equipos en el laboratorio.</div>
    @endforelse
@endsection