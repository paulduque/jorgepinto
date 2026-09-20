<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Piezas de contenido publicadas en redes sociales.
     */
    public function up(): void
    {
        Schema::create('piezas_contenido', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('formato', 50); // reel, post, story, video, carrusel
            $table->text('mensaje');
            $table->foreignId('zona_id')
                ->nullable()
                ->constrained('zonas')
                ->nullOnDelete();
            $table->string('estado', 30)->default('borrador'); // borrador, aprobado, programado, publicado
            $table->integer('alcance')->default(0);
            $table->integer('interacciones')->default(0);
            $table->string('url', 500)->nullable();
            $table->timestamps();

            $table->index('fecha');
            $table->index('estado');
            $table->index('formato');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('piezas_contenido');
    }
};
