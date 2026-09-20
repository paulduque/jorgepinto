<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * KPIs por semana del plan (alcance, suscriptores, contactos, validadores, etc.).
     */
    public function up(): void
    {
        Schema::create('kpis_semanales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('semana_id')
                ->constrained('semanas_plan')
                ->cascadeOnDelete();
            $table->string('kpi', 100); // alcance, suscriptores, contactos, validadores, eventos, reconocimiento
            $table->decimal('valor', 12, 2)->default(0);
            $table->decimal('meta', 12, 2)->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();

            $table->index(['semana_id', 'kpi']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kpis_semanales');
    }
};
