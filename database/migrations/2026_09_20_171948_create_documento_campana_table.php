<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Versiones del documento maestro de la campaña (markdown).
     */
    public function up(): void
    {
        Schema::create('documento_campana', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 255);
            $table->longText('contenido'); // markdown
            $table->integer('version')->default(1);
            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documento_campana');
    }
};
