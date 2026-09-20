<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Registro de incidentes: ataques, desinformación, crisis.
     */
    public function up(): void
    {
        Schema::create('incidentes', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('tipo', 50); // ataque, desinformacion, crisis, otro
            $table->text('descripcion');
            $table->text('respuesta')->nullable();
            $table->string('estado', 30)->default('abierto'); // abierto, en_proceso, resuelto
            $table->timestamps();

            $table->index('fecha');
            $table->index('tipo');
            $table->index('estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incidentes');
    }
};
