<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('solicitudes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('equipo_id')->constrained('equipos')->cascadeOnDelete();
        $table->foreignId('estudiante_id')->constrained('users')->cascadeOnDelete();
        $table->string('estado', 20)->default('pendiente');
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('solicitudes');
}
};
