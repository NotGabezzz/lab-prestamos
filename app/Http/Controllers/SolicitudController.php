<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Prestamo;
use App\Models\Solicitud;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SolicitudController extends Controller
{
    public function index(): View
    {
        $solicitudes = Solicitud::pendientes()
            ->with(['equipo', 'estudiante'])
            ->oldest()
            ->get();

        return view('encargado.solicitudes.index', compact('solicitudes'));
    }

    // aprobar = prestar el equipo al estudiante que lo pidió
    public function aprobar(Request $request, Solicitud $solicitud): RedirectResponse
    {
        $hecho = DB::transaction(function () use ($solicitud, $request) {
            $equipo = Equipo::whereKey($solicitud->equipo_id)->lockForUpdate()->first();

            if ($solicitud->estado !== Solicitud::PENDIENTE || ! $equipo->estaDisponible()) {
                return false;
            }

            Prestamo::create([
                'equipo_id'     => $equipo->id,
                'estudiante_id' => $solicitud->estudiante_id,
                'encargado_id'  => $request->user()->id,
            ]);
            $equipo->marcarPrestado();
            $solicitud->forceFill(['estado' => Solicitud::APROBADA])->save();

            return true;
        });

        return $hecho
            ? back()->with('ok', 'Solicitud aprobada y equipo prestado.')
            : back()->with('error', 'No se pudo aprobar: el equipo ya no está disponible o la solicitud ya fue respondida.');
    }

    public function rechazar(Solicitud $solicitud): RedirectResponse
    {
        if ($solicitud->estado !== Solicitud::PENDIENTE) {
            return back()->with('error', 'Esa solicitud ya fue respondida.');
        }

        $solicitud->forceFill(['estado' => Solicitud::RECHAZADA])->save();

        return back()->with('ok', 'Solicitud rechazada.');
    }
}