<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Zonas: cantones y parroquias de Pichincha con prioridad estratégica.
     */
    public function up(): void
    {
        Schema::create('zonas', function (Blueprint $table) {
            $table->id();
            $table->string('canton', 100);
            $table->string('parroquia', 100)->nullable();
            $table->string('prioridad', 20)->default('media'); // alta, media, baja
            $table->text('notas')->nullable();
            $table->timestamps();

            $table->index('canton');
            $table->index('prioridad');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zonas');
    }
};