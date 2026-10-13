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
    Schema::create('equipos', function (Blueprint $table) {
        $table->id();
        $table->string('codigo', 20)->unique();
        $table->string('nombre', 100);
        $table->string('categoria', 50);
        $table->string('estado', 20)->default('disponible');
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('equipos');
}
};
