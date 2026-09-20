<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Contactos captados en eventos y canales digitales.
     * Requiere consentimiento explícito para tratamiento de datos.
     */
    public function up(): void
    {
        Schema::create('contactos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255);
            $table->string('telefono', 30);
            $table->string('email', 255)->nullable();
            $table->foreignId('zona_id')
                ->nullable()
                ->constrained('zonas')
                ->nullOnDelete();
            $table->string('origen', 30)->default('otro'); // evento, qr, whatsapp, referido, otro
            $table->boolean('consentimiento')->default(false);
            $table->timestamp('fecha_consentimiento')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();

            $table->index('telefono');
            $table->index('origen');
            $table->index('consentimiento');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contactos');
    }
};
