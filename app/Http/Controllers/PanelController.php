<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PanelController extends Controller
{
    public function __invoke(Request $request): View
    {
        $usuario = $request->user();

        // saludo según la hora de Lima (la zona horaria está en config/app.php)
        $hora = now()->hour;
        $saludo = $hora < 12 ? 'Buenos días' : ($hora < 19 ? 'Buenas tardes' : 'Buenas noches');

        // una sola consulta agrupada: disponibles y prestados por categoría
        $categorias = Equipo::selectRaw(
                'categoria, SUM(estado = ?) as disponibles, SUM(estado = ?) as prestados',
                [Equipo::DISPONIBLE, Equipo::PRESTADO]
            )
            ->groupBy('categoria')
            ->orderBy('categoria')
            ->get();

        if ($usuario->esEncargado()) {
            $pendientes = Solicitud::pendientes()->count();
            $enUso = 0;
        } else {
            $pendientes = $usuario->solicitudes()->pendientes()->count();
            $enUso = $usuario->prestamos()->activos()->count();
        }

        return view('panel', compact('usuario', 'saludo', 'categorias', 'pendientes', 'enUso'));
    }
}