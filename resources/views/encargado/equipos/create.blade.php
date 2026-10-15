@extends('layouts.app')

@section('titulo', 'Añadir equipo')

@section('contenido')
    <h1 class="mb-4">Añadir equipo</h1>

    <form action="{{ route('encargado.equipos.store') }}" method="POST" class="formulario" novalidate>
        @csrf
        @include('encargado.equipos._campos')

        <button type="submit" class="btn-pizarra">Guardar equipo</button>
        <a href="{{ route('encargado.equipos.index') }}" class="btn-quieto">Cancelar</a>
    </form>
@endsection