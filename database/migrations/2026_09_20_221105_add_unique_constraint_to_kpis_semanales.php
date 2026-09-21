<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kpis_semanales', function (Blueprint $table) {
            $table->unique(['semana_id', 'kpi'], 'kpis_semanales_semana_kpi_unique');
        });
    }

    public function down(): void
    {
        Schema::table('kpis_semanales', function (Blueprint $table) {
            $table->dropUnique('kpis_semanales_semana_kpi_unique');
        });
    }
};
