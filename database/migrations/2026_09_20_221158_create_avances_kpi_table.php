<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('avances_kpi', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kpi_semanal_id')
                ->constrained('kpis_semanales')
                ->cascadeOnDelete();

            $table->date('fecha');
            $table->decimal('valor', 12, 2)->default(0);
            $table->text('notas')->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            // Un solo avance por KPI por día
            $table->unique(['kpi_semanal_id', 'fecha'], 'avances_kpi_semanal_fecha_unique');
            $table->index('fecha');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('avances_kpi');
    }
};
