<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // ─────────────────────────────────────────────────────────
        // COORDINADOR: todo excepto eliminar (incluye eventos)
        // ─────────────────────────────────────────────────────────
        $coordinador = Role::findByName('coordinador');
        $coordinador->syncPermissions([
            // Portada
            'view_hero',
            'view_any_hero',
            'create_hero',
            'update_hero',
            'reorder_hero',
            // Noticias
            'view_news',
            'view_any_news',
            'create_news',
            'update_news',
            'reorder_news',
            // Perfil
            'view_profile',
            'view_any_profile',
            'create_profile',
            'update_profile',
            'reorder_profile',
            // Temas
            'view_theme',
            'view_any_theme',
            'create_theme',
            'update_theme',
            'reorder_theme',
            // Configuración (solo ver)
            'view_site::setting',
            'view_any_site::setting',
            // 🆕 AGENDA: ver, crear, editar (sin eliminar)
            'view_event',
            'view_any_event',
            'create_event',
            'update_event',
            'reorder_event',
        ]);

        // ─────────────────────────────────────────────────────────
        // EDITOR: control total de contenido público + ver eventos
        // ─────────────────────────────────────────────────────────
        $editor = Role::findByName('editor');
        $editor->syncPermissions([
            // Portada
            'view_hero',
            'view_any_hero',
            'create_hero',
            'update_hero',
            'delete_hero',
            'delete_any_hero',
            'reorder_hero',
            // Noticias
            'view_news',
            'view_any_news',
            'create_news',
            'update_news',
            'delete_news',
            'delete_any_news',
            'reorder_news',
            // Perfil
            'view_profile',
            'view_any_profile',
            'create_profile',
            'update_profile',
            'delete_profile',
            'delete_any_profile',
            'reorder_profile',
            // Temas
            'view_theme',
            'view_any_theme',
            'create_theme',
            'update_theme',
            'delete_theme',
            'delete_any_theme',
            'reorder_theme',
            // 🆕 AGENDA: solo ver
            'view_event',
            'view_any_event',
        ]);

        // ─────────────────────────────────────────────────────────
        // PUBLICISTA: solo ver contenido + ver eventos
        // ─────────────────────────────────────────────────────────
        $publicista = Role::findByName('publicista');
        $publicista->syncPermissions([
            'view_hero',
            'view_any_hero',
            'view_news',
            'view_any_news',
            'view_profile',
            'view_any_profile',
            'view_theme',
            'view_any_theme',
            // 🆕 AGENDA: solo ver
            'view_event',
            'view_any_event',
        ]);

        // ─────────────────────────────────────────────────────────
        // COLABORADOR: solo ver contenido + ver eventos
        // ─────────────────────────────────────────────────────────
        $colaborador = Role::findByName('colaborador');
        $colaborador->syncPermissions([
            'view_hero',
            'view_any_hero',
            'view_news',
            'view_any_news',
            'view_profile',
            'view_any_profile',
            'view_theme',
            'view_any_theme',
            // 🆕 AGENDA: solo ver
            'view_event',
            'view_any_event',
        ]);

        // ─────────────────────────────────────────────────────────
        // SUPER ADMIN: todos los permisos
        // ─────────────────────────────────────────────────────────
        $superAdmin = Role::findByName('super_admin');
        $superAdmin->syncPermissions(Permission::all());

        // Resumen
        $this->command->info('✅ Permisos asignados:');
        foreach (['super_admin', 'coordinador', 'editor', 'publicista', 'colaborador'] as $roleName) {
            $role = Role::findByName($roleName);
            $this->command->info("   - {$roleName}: {$role->permissions->count()} permisos");
        }
    }
}
