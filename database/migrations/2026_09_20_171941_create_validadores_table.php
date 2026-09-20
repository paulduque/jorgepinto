<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Validadores locales: líderes, dirigentes y referentes que apoyan la campaña.
     */
    public function up(): void
    {
        Schema::create('validadores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255);
            $table->string('cargo', 255);
            $table->string('telefono', 30)->nullable();
            $table->foreignId('zona_id')
                ->nullable()
                ->constrained('zonas')
                ->nullOnDelete();
            $table->string('estado', 30)->default('contactado'); // contactado, comprometido, activo, inactivo
            $table->date('fecha_apoyo')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();

            $table->index('estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('validadores');
    }
};
