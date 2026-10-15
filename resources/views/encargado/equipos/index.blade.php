@extends('layouts.app')

@section('titulo', 'Equipos')

@section('contenido')
    <div class="cabecera">
        <h1>Equipos</h1>
        <a href="{{ route('encargado.equipos.create') }}" class="btn-pizarra">Añadir equipo</a>
    </div>

    @forelse ($equipos->groupBy('categoria') as $categoria => $grupo)
        <h2 class="grupo-titulo">{{ $categoria }}</h2>

        @foreach ($grupo as $equipo)
            @php $prestamo = $equipo->prestamos->first(); @endphp

            <article class="fila-equipo">
                <span class="codigo">{{ $equipo->codigo }}</span>

                <div>
                    <h3>{{ $equipo->nombre }}</h3>
                    @if ($prestamo)
                        <p class="detalle">Con {{ $prestamo->estudiante->name }} desde el {{ $prestamo->fecha_prestamo->format('d/m H:i') }}</p>
                    @endif
                </div>

                <span class="estado estado-{{ $equipo->estado }}">{{ ucfirst($equipo->estado) }}</span>

                <div class="acciones">
                    @if ($prestamo)
                        <form action="{{ route('encargado.prestamos.devolver', $prestamo) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn-pizarra">Registrar devolución</button>
                        </form>
                    @else
                        <details class="prestar">
                            <summary>Prestar</summary>
                            <form action="{{ route('encargado.prestamos.store', $equipo) }}" method="POST">
                                @csrf
                                <label for="est-{{ $equipo->id }}" class="visually-hidden">Estudiante</label>
                                <select id="est-{{ $equipo->id }}" name="estudiante_id" class="form-select form-select-sm" required>
                                    <option value="">Elige estudiante</option>
                                    @foreach ($estudiantes as $estudiante)
                                        <option value="{{ $estudiante->id }}">{{ $estudiante->name }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn-pizarra">Confirmar</button>
                            </form>
                        </details>
                    @endif

                    <a href="{{ route('encargado.equipos.edit', $equipo) }}" class="btn-quieto">Editar</a>

                    <form action="{{ route('encargado.equipos.destroy', $equipo) }}" method="POST"
                          onsubmit="return confirm('¿Eliminar este equipo?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-quieto btn-peligro">Eliminar</button>
                    </form>
                </div>
            </article>
        @endforeach
    @empty
        <div class="vacio">
            <p class="mb-3">Aún no hay equipos registrados.</p>
            <a href="{{ route('encargado.equipos.create') }}" class="btn-pizarra">Añadir el primer equipo</a>
        </div>
    @endforelse
@endsection