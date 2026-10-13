<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipo extends Model
{
    public const DISPONIBLE = 'disponible';
    public const PRESTADO = 'prestado';

    // 'estado' tampoco se llena por formulario, solo con los métodos de abajo
    protected $fillable = ['codigo', 'nombre', 'categoria'];

    public function prestamos(): HasMany
    {
        return $this->hasMany(Prestamo::class);
    }

    public function solicitudes(): HasMany
    {
        return $this->hasMany(Solicitud::class);
    }

    public function estaDisponible(): bool
    {
        return $this->estado === self::DISPONIBLE;
    }

    public function marcarPrestado(): void
    {
    $this->forceFill(['estado' => self::PRESTADO])->save();
    }

    public function marcarDisponible(): void
    {
        $this->forceFill(['estado' => self::DISPONIBLE])->save();
    }
    public function scopeDisponibles(Builder $consulta): Builder
    {
        return $consulta->where('estado', self::DISPONIBLE);
    }
}