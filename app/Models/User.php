<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ENCARGADO = 'encargado';
    public const ESTUDIANTE = 'estudiante';

    // 'rol' NO está aquí a propósito: así ningún formulario puede cambiarlo
    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function esEncargado(): bool
    {
        return $this->rol === self::ENCARGADO;
    }

    public function esEstudiante(): bool
    {
        return $this->rol === self::ESTUDIANTE;
    }

    public function prestamos(): HasMany
    {
        return $this->hasMany(Prestamo::class, 'estudiante_id');
    }

    public function solicitudes(): HasMany
    {
        return $this->hasMany(Solicitud::class, 'estudiante_id');
    }
}