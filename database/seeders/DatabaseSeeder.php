<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Ejecuta todos los seeders del sistema en el orden correcto.
     */
    public function run(): void
    {
        $this->call([
            // 1. Roles y permisos (deben ir primero)
            RolesAndPermissionsSeeder::class,
            RolePermissionsSeeder::class,

            // 2. Datos base del sitio
            SiteDataSeeder::class,

            // 3. Módulo Campaña
            ZonaSeeder::class,
            SemanaPlanSeeder::class,
            TareaSeeder::class,
        ]);
    }
}
