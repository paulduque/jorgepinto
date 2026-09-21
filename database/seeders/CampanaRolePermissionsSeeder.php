<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class CampanaRolePermissionsSeeder extends Seeder
{
    /**
     * Asigna permisos del módulo Campaña a cada rol.
     * Es idempotente: se puede correr varias veces sin duplicar.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // ─── Definición de permisos por rol ─────────────────────────────

        // Super admin: todo
        $superAdmin = Role::findByName('super_admin');
        $superAdmin->syncPermissions(Permission::all());

        // Coordinador: gestión completa de campaña + frontend
        $coordinador = Role::findByName('coordinador');
        $coordinador->syncPermissions([
            // Zona
            'view_any_zona',
            'view_zona',
            'create_zona',
            'update_zona',
            'delete_zona',
            // SemanaPlan
            'view_any_semana::plan',
            'view_semana::plan',
            'create_semana::plan',
            'update_semana::plan',
            // Tarea
            'view_any_tarea',
            'view_tarea',
            'create_tarea',
            'update_tarea',
            'delete_tarea',
            // Contacto
            'view_any_contacto',
            'view_contacto',
            'create_contacto',
            'update_contacto',
            'delete_contacto',
            // Validador
            'view_any_validador',
            'view_validador',
            'create_validador',
            'update_validador',
            'delete_validador',
            // KpiSemanal
            'view_any_kpi::semanal',
            'view_kpi::semanal',
            'create_kpi::semanal',
            'update_kpi::semanal',
            'delete_kpi::semanal',
            // AvanceKpi
            'view_any_avance::kpi',
            'view_avance::kpi',
            'create_avance::kpi',
            'update_avance::kpi',
            'delete_avance::kpi',
            // EventoCampana
            'view_any_evento::campana',
            'view_evento::campana',
            'create_evento::campana',
            'update_evento::campana',
            'delete_evento::campana',
            // PiezaContenido
            'view_any_pieza::contenido',
            'view_pieza::contenido',
            'create_pieza::contenido',
            'update_pieza::contenido',
            'delete_pieza::contenido',
            // Incidente
            'view_any_incidente',
            'view_incidente',
            'create_incidente',
            'update_incidente',
            'delete_incidente',
            // Widgets Campaña
            'widget_KpiOverviewWidget',
            'widget_AlcanceSemanalChart',
            'widget_ProgresoFasesChart',
            'widget_DistribucionZonasChart',
            // Frontend (event, news, hero, etc.)
            'view_any_event',
            'view_event',
            'create_event',
            'update_event',
            'delete_event',
            'view_any_news',
            'view_news',
            'create_news',
            'update_news',
            'delete_news',
            'view_any_hero',
            'view_hero',
            'create_hero',
            'update_hero',
            'delete_hero',
            'view_any_profile',
            'view_profile',
            'create_profile',
            'update_profile',
            'delete_profile',
            'view_any_contact::message',
            'view_contact::message',
            'update_contact::message',
            'delete_contact::message',
            'view_any_theme',
            'view_theme',
            'create_theme',
            'update_theme',
            'delete_theme',
            // Widgets frontend
            'widget_AgendaWidget',
            'widget_CalendarWidget',
            'widget_WelcomeWidget',
            'widget_NewMessagesWidget',
            'widget_SiteStatsOverview',
            'widget_LatestNewsWidget',
            'widget_QuickActionsWidget',
            // Page
            'page_Calendar',
        ]);

        // Editor: gestión de contenido (tareas, eventos, piezas, avances) + lectura de semanas
        $editor = Role::findByName('editor');
        $editor->syncPermissions([
            // SemanaPlan (solo lectura)
            'view_any_semana::plan',
            'view_semana::plan',
            // Tarea (completo)
            'view_any_tarea',
            'view_tarea',
            'create_tarea',
            'update_tarea',
            'delete_tarea',
            // AvanceKpi (completo)
            'view_any_avance::kpi',
            'view_avance::kpi',
            'create_avance::kpi',
            'update_avance::kpi',
            'delete_avance::kpi',
            // EventoCampana (completo)
            'view_any_evento::campana',
            'view_evento::campana',
            'create_evento::campana',
            'update_evento::campana',
            'delete_evento::campana',
            // PiezaContenido (completo)
            'view_any_pieza::contenido',
            'view_pieza::contenido',
            'create_pieza::contenido',
            'update_pieza::contenido',
            'delete_pieza::contenido',
            // Widgets Campaña
            'widget_KpiOverviewWidget',
            'widget_AlcanceSemanalChart',
            'widget_ProgresoFasesChart',
            'widget_DistribucionZonasChart',
            // Frontend (news, hero, etc.)
            'view_any_news',
            'view_news',
            'create_news',
            'update_news',
            'delete_news',
            'view_any_hero',
            'view_hero',
            'create_hero',
            'update_hero',
            'delete_hero',
            'view_any_event',
            'view_event',
            'create_event',
            'update_event',
            'delete_event',
            // Widgets frontend
            'widget_AgendaWidget',
            'widget_WelcomeWidget',
            'widget_LatestNewsWidget',
        ]);

        // Publicista: solo piezas de contenido + lectura de widgets
        $publicista = Role::findByName('publicista');
        $publicista->syncPermissions([
            // PiezaContenido (completo)
            'view_any_pieza::contenido',
            'view_pieza::contenido',
            'create_pieza::contenido',
            'update_pieza::contenido',
            'delete_pieza::contenido',
            // Widgets Campaña (solo lectura)
            'widget_KpiOverviewWidget',
            'widget_AlcanceSemanalChart',
            'widget_ProgresoFasesChart',
            'widget_DistribucionZonasChart',
            // Frontend (lectura)
            'view_any_news',
            'view_news',
            'view_any_hero',
            'view_hero',
            // Widgets frontend
            'widget_AgendaWidget',
            'widget_LatestNewsWidget',
        ]);

        // Colaborador: captación (contactos, avances) + lectura
        $colaborador = Role::findByName('colaborador');
        $colaborador->syncPermissions([
            // Tarea (solo lectura)
            'view_any_tarea',
            'view_tarea',
            // Contacto (completo)
            'view_any_contacto',
            'view_contacto',
            'create_contacto',
            'update_contacto',
            // Validador (solo lectura)
            'view_any_validador',
            'view_validador',
            // AvanceKpi (completo)
            'view_any_avance::kpi',
            'view_avance::kpi',
            'create_avance::kpi',
            'update_avance::kpi',
            // EventoCampana (solo lectura)
            'view_any_evento::campana',
            'view_evento::campana',
            // Widgets Campaña (solo lectura)
            'widget_KpiOverviewWidget',
            'widget_AlcanceSemanalChart',
            'widget_ProgresoFasesChart',
            'widget_DistribucionZonasChart',
            // Widgets frontend
            'widget_AgendaWidget',
            'widget_WelcomeWidget',
        ]);

        $this->command->info('✅ Permisos de Campaña asignados a todos los roles.');
    }
}
