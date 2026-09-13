<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_user', function (Blueprint $table) {
            $table->id();

            $table->foreignId('event_id')
                ->constrained('events')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Rol del usuario en el evento
            $table->string('role_in_event')->nullable(); // responsable, apoyo, invitado, etc.

            // Confirmación de asistencia
            $table->enum('attendance_status', ['pendiente', 'confirmado', 'rechazado'])
                ->default('pendiente');

            $table->timestamps();

            // Un usuario no puede estar dos veces en el mismo evento
            $table->unique(['event_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_user');
    }
};
