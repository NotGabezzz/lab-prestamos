@extends('layouts.app')

@section('titulo', 'Inicio')

@section('contenido')
    @php
        // un ícono por categoría, y uno genérico si la categoría es nueva
        $iconos = [
            'tablets' => 'bi-tablet',
            'laptops' => 'bi-laptop',
            'proyectores' => 'bi-projector',
            'kits arduino' => 'bi-cpu',
            'multímetros' => 'bi-speedometer2',
            'relojes' => 'bi-smartwatch',
        ];
    @endphp

    <h1>{{ $saludo }}, {{ $usuario->name }}</h1>

    <p class="guino">
        @if ($usuario->esEncargado())
            Eres el encargado: el jefe, el boss, lo top de lo top.
        @else
            Eres alumno: usuario básico, pero con mucho potencial.
        @endif
    </p>
    <p class="detalle">{{ $usuario->email }}, rol {{ $usuario->rol }}</p>

    @if ($usuario->esEncargado() && $pendientes > 0)
        <div class="aviso">
            Tienes {{ $pendientes }} {{ $pendientes === 1 ? 'solicitud pendiente' : 'solicitudes pendientes' }} por revisar.
            <a href="{{ route('encargado.solicitudes.index') }}">Ver solicitudes</a>
        </div>
    @elseif ($usuario->esEstudiante() && ($pendientes > 0 || $enUso > 0))
        <div class="aviso">
            Tienes {{ $pendientes }} {{ $pendientes === 1 ? 'solicitud pendiente' : 'solicitudes pendientes' }}
            y {{ $enUso }} {{ $enUso === 1 ? 'equipo en uso' : 'equipos en uso' }}.
            <a href="{{ route('estudiante.actividad') }}">Ver mi actividad</a>
        </div>
    @endif

    <h2 class="grupo-titulo">Equipos por categoría</h2>

    @forelse ($categorias as $categoria)
        @php $icono = $iconos[mb_strtolower($categoria->categoria)] ?? 'bi-box-seam'; @endphp

        <div class="resumen-fila">
            <i class="bi {{ $icono }}" aria-hidden="true"></i>
            <span class="resumen-nombre">{{ $categoria->categoria }}</span>
            <span class="estado estado-disponible">{{ $categoria->disponibles }} {{ $categoria->disponibles == 1 ? 'disponible' : 'disponibles' }}</span>
            <span class="estado estado-prestado">{{ $categoria->prestados }} {{ $categoria->prestados == 1 ? 'prestado' : 'prestados' }}</span>
        </div>
    @empty
        <div class="vacio">Aún no hay equipos registrados.</div>
    @endforelse
@endsection