<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EquipoController extends Controller
{
    public function index(): View
    {
        // cada equipo trae su préstamo activo (si lo tiene) con el estudiante
        $equipos = Equipo::with(['prestamos' => fn ($q) => $q->activos()->with('estudiante')])
            ->orderBy('categoria')
            ->orderBy('codigo')
            ->get();

        $estudiantes = User::where('rol', User::ESTUDIANTE)->orderBy('name')->get();

        return view('encargado.equipos.index', compact('equipos', 'estudiantes'));
    }

    public function create(): View
    {
        return view('encargado.equipos.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Equipo::create($this->validar($request));

        return redirect()->route('encargado.equipos.index')->with('ok', 'Equipo añadido.');
    }

    public function edit(Equipo $equipo): View
    {
        return view('encargado.equipos.edit', compact('equipo'));
    }

    public function update(Request $request, Equipo $equipo): RedirectResponse
    {
        $equipo->update($this->validar($request, $equipo));

        return redirect()->route('encargado.equipos.index')->with('ok', 'Cambios guardados.');
    }

    public function destroy(Equipo $equipo): RedirectResponse
    {
        if (! $equipo->estaDisponible()) {
            return back()->with('error', 'No puedes eliminar un equipo que está prestado.');
        }

        $equipo->delete();

        return redirect()->route('encargado.equipos.index')->with('ok', 'Equipo eliminado.');
    }

    private function validar(Request $request, ?Equipo $equipo = null): array
    {
        return $request->validate([
            'codigo'    => ['required', 'string', 'max:20', Rule::unique('equipos', 'codigo')->ignore($equipo)],
            'nombre'    => ['required', 'string', 'max:100'],
            'categoria' => ['required', 'string', 'max:50'],
        ], [
            'required' => 'Este campo es obligatorio.',
            'max'      => 'Es demasiado largo.',
            'unique'   => 'Ese código ya está registrado.',
        ]);
    }
}