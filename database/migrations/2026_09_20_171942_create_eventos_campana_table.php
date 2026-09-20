<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Eventos de campaña en campo: mitines, recorridos, reuniones con métricas.
     */
    public function up(): void
    {
        Schema::create('eventos_campana', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 255);
            $table->date('fecha');
            $table->foreignId('zona_id')
                ->nullable()
                ->constrained('zonas')
                ->nullOnDelete();
            $table->text('descripcion')->nullable();
            $table->integer('contactos_captados')->default(0);
            $table->integer('piezas_publicadas')->default(0);
            $table->string('estado', 30)->default('planificado'); // planificado, realizado, cancelado
            $table->timestamps();

            $table->index('fecha');
            $table->index('estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eventos_campana');
    }
};
