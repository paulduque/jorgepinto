<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Semanas del plan de campaña: S1 a S7 + Cierre + Oficial + Silencio.
     */
    public function up(): void
    {
        Schema::create('semanas_plan', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 20)->unique(); // S1, S2, ..., Cierre, Oficial, Silencio
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('fase', 100);
            $table->text('objetivo')->nullable();
            $table->string('estado', 20)->default('pendiente'); // pendiente, en_curso, completada
            $table->timestamps();

            $table->index('estado');
            $table->index('fecha_inicio');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('semanas_plan');
    }
};