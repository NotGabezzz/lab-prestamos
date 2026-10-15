@php $e = $equipo ?? null; @endphp

<div class="mb-3">
    <label for="codigo">Código</label>
    <input type="text" id="codigo" name="codigo" value="{{ old('codigo', $e?->codigo) }}"
           class="form-control @error('codigo') is-invalid @enderror" maxlength="20" required>
    @error('codigo') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="nombre">Nombre</label>
    <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $e?->nombre) }}"
           class="form-control @error('nombre') is-invalid @enderror" maxlength="100" required>
    @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="categoria">Categoría</label>
    <input type="text" id="categoria" name="categoria" value="{{ old('categoria', $e?->categoria) }}"
           class="form-control @error('categoria') is-invalid @enderror" maxlength="50" required>
    @error('categoria') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>