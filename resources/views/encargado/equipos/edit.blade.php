@extends('layouts.app')

@section('titulo', 'Editar equipo')

@section('contenido')
    <h1 class="mb-4">Editar equipo</h1>

    <form action="{{ route('encargado.equipos.update', $equipo) }}" method="POST" class="formulario" novalidate>
        @csrf
        @method('PUT')
        @include('encargado.equipos._campos')

        <button type="submit" class="btn-pizarra">Guardar cambios</button>
        <a href="{{ route('encargado.equipos.index') }}" class="btn-quieto">Cancelar</a>
    </form>
@endsection