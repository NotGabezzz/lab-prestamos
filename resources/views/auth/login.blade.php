@extends('layouts.app')

@section('titulo', 'Iniciar sesión')

@section('contenido')
    <div class="login">
        <h1 class="mb-4">Iniciar sesión</h1>

        <form action="{{ url('/login') }}" method="POST" class="formulario" novalidate>
            @csrf

            <div class="mb-3">
                <label for="email">Correo</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                       class="form-control @error('email') is-invalid @enderror"
                       autocomplete="username" required autofocus>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       autocomplete="current-password" required>
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn-pizarra w-100">Entrar</button>
        </form>
    </div>
@endsection