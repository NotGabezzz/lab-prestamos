<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Prestamo;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PrestamoController extends Controller
{
    public function index(): View
    {
        $prestamos = Prestamo::with(['equipo', 'estudiante', 'encargado'])
            ->latest('fecha_prestamo')
            ->get();

        return view('encargado.prestamos.index', compact('prestamos'));
    }

    public function store(Request $request, Equipo $equipo): RedirectResponse
    {
        $datos = $request->validate([
            // solo se puede prestar a usuarios con rol estudiante
            'estudiante_id' => ['required', Rule::exists('users', 'id')->where('rol', User::ESTUDIANTE)],
        ], [
            'required' => 'Elige un estudiante.',
            'exists'   => 'Ese estudiante no existe.',
        ]);

        // la transacción y el bloqueo evitan prestar dos veces el mismo equipo
        $prestado = DB::transaction(function () use ($equipo, $datos, $request) {
            $equipo = Equipo::whereKey($equipo->id)->lockForUpdate()->first();

            if (! $equipo->estaDisponible()) {
                return false;
            }

            Prestamo::create([
                'equipo_id'     => $equipo->id,
                'estudiante_id' => $datos['estudiante_id'],
                'encargado_id'  => $request->user()->id,
            ]);
            $equipo->marcarPrestado();

            return true;
        });

        return $prestado
            ? back()->with('ok', 'Préstamo registrado.')
            : back()->with('error', 'Ese equipo ya está prestado.');
    }

    public function devolver(Prestamo $prestamo): RedirectResponse
    {
        if ($prestamo->fecha_devolucion) {
            return back()->with('error', 'Ese préstamo ya fue devuelto.');
        }

        DB::transaction(function () use ($prestamo) {
            $prestamo->update(['fecha_devolucion' => now()]);
            $prestamo->equipo->marcarDisponible();
        });

        return back()->with('ok', 'Devolución registrada.');
    }
}// Parte del companero cuatro
