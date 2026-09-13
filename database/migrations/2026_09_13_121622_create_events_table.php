<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            // Información básica
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['mitin', 'reunion', 'entrevista', 'gira', 'tarea', 'otro'])
                ->default('reunion');

            // Fechas
            $table->dateTime('start_at');
            $table->dateTime('end_at')->nullable();
            $table->boolean('all_day')->default(false);

            // Ubicación
            $table->string('location')->nullable();
            $table->string('address')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // Visibilidad y estado
            $table->boolean('is_public')->default(false);
            $table->enum('status', ['planificado', 'en_curso', 'completado', 'cancelado'])
                ->default('planificado');

            // Color para el calendario (opcional)
            $table->string('color', 7)->nullable();

            // Quién lo creó
            $table->foreignId('created_by')->nullable()
                ->constrained('users')->nullOnDelete();

            $table->timestamps();

            // Índices para búsquedas rápidas
            $table->index('start_at');
            $table->index('status');
            $table->index('type');
            $table->index('is_public');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
