<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Solicitud extends Model
{
    public const PENDIENTE = 'pendiente';
    public const APROBADA = 'aprobada';
    public const RECHAZADA = 'rechazada';

    // Laravel pluralizaría "Solicitud" como "solicituds", así que se indica a mano
    protected $table = 'solicitudes';

    protected $fillable = ['equipo_id', 'estudiante_id'];

    public function equipo(): BelongsTo
    {
        return $this->belongsTo(Equipo::class);
    }

    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(User::class, 'estudiante_id');
    }

    public function scopePendientes(Builder $consulta): Builder
    {
        return $consulta->where('estado', self::PENDIENTE);
    }
}
