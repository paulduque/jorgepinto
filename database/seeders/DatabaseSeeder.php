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
            RolesAndPermissionsSeeder::class,
            RolePermissionsSeeder::class,
            SiteDataSeeder::class,
            ZonaSeeder::class,
            SemanaPlanSeeder::class,
            TareaSeeder::class,
            KpiSemanalSeeder::class,
            DocumentoCampanaSeeder::class,
        ]);
    }
}
