<?php

namespace Database\Seeders;

use App\Models\Equipo;
use App\Models\Prestamo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // forceCreate ignora $fillable; solo se usa aquí para poder poner el rol
        $encargado = User::forceCreate([
            'name' => 'Gabriel Velazco',
            'email' => 'encargado@lab.test',
            'password' => Hash::make('jefe-2026'),
            'rol' => User::ENCARGADO,
        ]);

        $ana = User::forceCreate([
            'name' => 'Ana Quispe',
            'email' => 'ana@lab.test',
            'password' => Hash::make('alumno-2026'),
            'rol' => User::ESTUDIANTE,
        ]);

        User::forceCreate([
            'name' => 'Luis Mamani',
            'email' => 'luis@lab.test',
            'password' => Hash::make('alumno-2026'),
            'rol' => User::ESTUDIANTE,
        ]);

        $equipos = [
            ['TAB-001', 'Tablet Aurora 01', 'Tablets'],
            ['TAB-002', 'Tablet Aurora 02', 'Tablets'],
            ['LAP-001', 'Laptop Nova 01', 'Laptops'],
            ['LAP-002', 'Laptop Nova 02', 'Laptops'],
            ['PRO-001', 'Proyector Faro', 'Proyectores'],
            ['ARD-001', 'Kit Arduino Brújula', 'Kits Arduino'],
            ['MUL-001', 'Multímetro Pulso', 'Multímetros'],
            ['REL-001', 'Reloj Inteligente Atlas', 'Relojes'],
        ];

        foreach ($equipos as [$codigo, $nombre, $categoria]) {
            Equipo::create([
                'codigo' => $codigo,
                'nombre' => $nombre,
                'categoria' => $categoria,
            ]);
        }

        // Un préstamo ya activo, para que se vea el botón de devolver en la demo
        $laptopPrestada = Equipo::where('codigo', 'LAP-002')->first();

        Prestamo::create([
            'equipo_id' => $laptopPrestada->id,
            'estudiante_id' => $ana->id,
            'encargado_id' => $encargado->id,
        ]);

        $laptopPrestada->marcarPrestado();
    }
}
