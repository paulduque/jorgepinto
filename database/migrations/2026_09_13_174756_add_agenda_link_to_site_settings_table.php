<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->boolean('agenda_link_visible')->default(true)->after('agenda_image');
            $table->boolean('agenda_link_public_only')->default(false)->after('agenda_link_visible');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['agenda_link_visible', 'agenda_link_public_only']);
        });
    }
};
