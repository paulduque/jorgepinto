<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Agrega campos para trackear quién capturó el contacto
     * y si dio consentimiento verbal (para capturas en campo).
     */
    public function up(): void
    {
        Schema::table('contactos', function (Blueprint $table) {
            $table->foreignId('capturado_por')
                ->nullable()
                ->after('consentimiento')
                ->constrained('users')
                ->nullOnDelete();

            $table->boolean('consentimiento_verbal')
                ->default(false)
                ->after('fecha_consentimiento');
        });
    }

    public function down(): void
    {
        Schema::table('contactos', function (Blueprint $table) {
            $table->dropForeign(['capturado_por']);
            $table->dropColumn(['capturado_por', 'consentimiento_verbal']);
        });
    }
};
