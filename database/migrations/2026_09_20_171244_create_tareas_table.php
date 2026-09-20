<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tareas: checklist operativo del plan de choque y tareas generales.
     */
    public function up(): void
    {
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 255);
            $table->text('descripcion')->nullable();
            $table->string('fase', 100)->nullable();
            $table->foreignId('semana_id')
                ->nullable()
                ->constrained('semanas_plan')
                ->nullOnDelete();
            $table->foreignId('responsable_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->date('fecha_limite')->nullable();
            $table->string('estado', 20)->default('pendiente'); // pendiente, en_curso, completada, bloqueada
            $table->string('prioridad', 20)->default('media');  // alta, media, baja
            $table->integer('orden')->default(0);
            $table->timestamps();

            $table->index('estado');
            $table->index('prioridad');
            $table->index('fase');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tareas');
    }
};