<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Crea los roles base del sistema.
     * Es idempotente: se puede correr varias veces sin duplicar.
     */
    public function run(): void
    {
        // Limpiar caché de permisos
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $roles = [
            'super_admin' => 'Control total del sistema',
            'coordinador' => 'Gestión de agenda y contenido',
            'editor'      => 'Edición de contenido público',
            'publicista'  => 'Gestión de redes sociales',
            'colaborador' => 'Acceso limitado a eventos asignados',
        ];

        foreach ($roles as $name => $description) {
            Role::firstOrCreate(
                ['name' => $name, 'guard_name' => 'web'],
            );
        }

        $this->command->info('✅ Roles creados/verificados: ' . implode(', ', array_keys($roles)));
    }
}
