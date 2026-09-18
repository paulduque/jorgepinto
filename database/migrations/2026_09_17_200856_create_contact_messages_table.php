<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();

            // Datos del remitente
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();

            // Contenido
            $table->string('subject')->nullable();
            $table->text('message');

            // Consentimiento LOPDP (obligatorio en Ecuador)
            $table->boolean('consent_given')->default(false);
            $table->timestamp('consent_given_at')->nullable();

            // Estado y metadatos
            $table->enum('status', ['nuevo', 'leido', 'respondido', 'archivado'])->default('nuevo');
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('read_at')->nullable();

            $table->timestamps();

            // Índices
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
    }
};
