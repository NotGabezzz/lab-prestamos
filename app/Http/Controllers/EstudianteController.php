<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Solicitud;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EstudianteController extends Controller
{
    public function equipos(Request $request): View
    {
        $equipos = Equipo::orderBy('categoria')->orderBy('codigo')->get();

        // equipos que este estudiante ya solicitó y siguen pendientes
        $pendientes = Solicitud::pendientes()
            ->where('estudiante_id', $request->user()->id)
            ->pluck('equipo_id')
            ->all();

        return view('estudiante.equipos', compact('equipos', 'pendientes'));
    }

    public function actividad(Request $request): View
    {
        $usuario = $request->user();

        $solicitudes = $usuario->solicitudes()->with('equipo')->latest()->get();
        $prestamos = $usuario->prestamos()->with('equipo')->latest('fecha_prestamo')->get();

        return view('estudiante.actividad', compact('solicitudes', 'prestamos'));
    }

    // el estudiante solo pide, no se lleva el equipo: lo decide el encargado
    public function solicitar(Request $request, Equipo $equipo): RedirectResponse
    {
        $usuario = $request->user();

        if (! $equipo->estaDisponible()) {
            return back()->with('error', 'Ese equipo ya está prestado.');
        }

        $yaPidio = Solicitud::pendientes()
            ->where('equipo_id', $equipo->id)
            ->where('estudiante_id', $usuario->id)
            ->exists();

        if ($yaPidio) {
            return back()->with('error', 'Ya solicitaste este equipo, espera la respuesta del encargado.');
        }

        Solicitud::create([
            'equipo_id'     => $equipo->id,
            'estudiante_id' => $usuario->id,
        ]);

        return back()->with('ok', 'Solicitud enviada. El encargado la revisará.');
    }
}