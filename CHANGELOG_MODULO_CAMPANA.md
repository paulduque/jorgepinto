# CHANGELOG — Modulo Campana

Registro cronologico de avances del modulo Campana en Filament.
Se actualiza al final de cada sesion de trabajo.

---

## Convenciones

- OK = completado
- En progreso = en progreso
- Pausado = pausado o bloqueado
- Descartado = descartado
- Fecha: DD mmm YYYY (ej: 20 sep 2026)

---

## [No publicado] - En desarrollo

### Fase 1 - Estructura base

**Objetivo:** crear las tablas, modelos y seeders del modulo.

- OK Rama `feature/modulo-campana` creada
- OK Seccion "Modulo Campana" agregada al `PROMPT_MAESTRO_JORGE_PINTO.md`
- OK Changelog inicial creado
- OK Migraciones base aplicadas (`create_zonas_table`, `create_semanas_plan_table`, `create_tareas_table`)
- OK 8 migraciones adicionales aplicadas (`contactos`, `validadores`, `eventos_campana`, `piezas_contenido`, `kpis_semanales`, `incidentes`, `documento_campana`)
- OK **Total: 11 tablas del modulo Campana**
- OK Verificadas con `php artisan db:show --counts` (33 tablas en total)
- OK 10 modelos Eloquent con relaciones
- OK `ZonaSeeder` -> 11 zonas de Pichincha
- OK `SemanaPlanSeeder` -> 10 semanas del plan (S1-S7, Cierre, Oficial, Silencio)
- OK `TareaSeeder` -> 9 tareas del plan de choque S1
- OK **Fase 1 completada**

#### Pendiente Fase 1

- Pendiente: probar migraciones y seeders en VPS MySQL (hecho el 21 sep 2026)

---

### Fase 2 - Recursos Filament (MVP)

**Objetivo:** CRUD funcional desde el panel.

- OK `ZonaResource` (`/admin/zonas`)
- OK `SemanaPlanResource` (`/admin/semana-plans`)
- OK `TareaResource` (`/admin/tareas`) con edicion inline de estado
- OK `ContactoResource` (`/admin/contactos`) con capturado_por y consentimiento verbal
- OK `ValidadorResource` (`/admin/validadores`)
- OK `KpiSemanalResource` (`/admin/kpis-semanales`) con calculo automatico de cumplimiento
- OK **Fase 2 completada**

#### 20 sep 2026 - KpiSemanalSeeder con metas y justificaciones

- OK 35 KPIs cargados (7 semanas × 5 KPIs: contactos, validadores, suscriptores, alcance, eventos)
- OK Cada KPI incluye justificacion en campo `notas`:
    - Fuente: Proyeccion CNE 2021 + padron Pichincha 2026 (RPubs)
    - Calculo: 5% de los 574.000 votos necesarios para ganar
    - Referencia: resultados Asambleistas Pichincha 2021
- OK Metas cargadas por semana (progresion exponencial):
    - Contactos: 500 -> 28.700
    - Validadores: 10 -> 57
    - Suscriptores: 1.000 -> 57.400
    - Alcance: 250K -> 3.5M

#### 20 sep 2026 - Documento de estrategias

- OK `ESTRATEGIAS_CAMPANA.md` creado con:
    - Analisis del terreno 2021 (padron Pichincha, resultados 1ra y 2da vuelta)
    - Objetivos por KPI con justificacion
    - Progresion semanal (S1-S7)
    - Estrategias por KPI
    - Estrategias por zona
    - Lineas rojas y fuentes
- OK Fuentes: RPubs (padron 2026) + PDF CNE 2021

---

### Fase 3 - Documento + Eventos + Piezas + Incidentes

**Objetivo:** visor del mapa estrategico y CRUD avanzado.

- OK `DocumentoCampanaResource` (`/admin/documento-maestro`) con visor markdown y vista custom
- OK `EventoCampanaResource` (`/admin/eventos-campana`) con metricas de campo
- OK `PiezaContenidoResource` (`/admin/piezas-contenido`) con tasa de interaccion
- OK `IncidenteResource` (`/admin/incidentes`) con tipo y respuesta
- OK **Fase 3 completada**

---

### Fase 4 - Dashboard + Widgets + Charts + Roles

**Objetivo:** visualizacion de KPIs y permisos por rol.

- OK `KpiOverviewWidget` (tarjetas + modal inline para registrar avance)
- OK `AlcanceSemanalChart` (grafico de lineas de metas por semana)
- OK `ProgresoFasesChart` (grafico de barras apiladas de tareas por semana)
- OK `DistribucionZonasChart` (grafico de dona de contactos por canton)
- OK `AvanceKpiResource` (`/admin/avances-kpi`) + sistema de avances diarios
- OK Widgets del dashboard reordenados (Campana 2-5, frontend 10-14)
- OK Roles definidos: `super_admin`, `coordinador`, `editor`, `publicista`, `colaborador`
- OK Permisos generados por Shield (20 Resources, 11 Widgets, 1 Page)
- OK `CampanaRolePermissionsSeeder` con matriz de permisos por rol
- OK `canAccess()` verificado en `DocumentoCampanaResource` (solo super_admin)
- OK `WelcomeWidget` restringido solo a colaboradores
- OK **Fase 4 completada**

#### 20 sep 2026 - Sistema de avances diarios de KPIs

- OK Migracion `add_unique_constraint_to_kpis_semanales` aplicada
- OK Constraint unico (semana_id, kpi) - evita duplicados
- OK Migracion `create_avances_kpi_table` aplicada
- OK Modelo `AvanceKpi` con relaciones a `KpiSemanal` y `User`
- OK Observer `AvanceKpiObserver` registrado en `AppServiceProvider`
- OK Resource `AvanceKpiResource` en `/admin/avances-kpi`
- OK Validacion `unique` en formulario de `KpiSemanalResource` (mensaje amigable)
- OK KPI mal etiquetado (id 4) corregido: "suscriptores" -> "alcance"
- OK `KpiOverviewWidget` con modal inline para registrar avances del dia
- OK Recalculo automatico del KPI al guardar un avance
- OK Actualizacion del widget sin recargar la pagina

#### 20 sep 2026 - Limpieza de widgets duplicados

- OK Eliminada carpeta `app/Filament/Resources/AdminResource` (duplicado)
- OK Widgets correctos confirmados en `app/Filament/Widgets/`

#### 20 sep 2026 - Sistema de roles y permisos

- OK `php artisan shield:generate --all` ejecutado
- OK 20 Policies generadas por Shield para los Resources
- OK 246 permisos generados en total
- OK `CampanaRolePermissionsSeeder` creado con matriz de permisos
- OK Roles con permisos:
    - `super_admin`: 246 permisos (todo)
    - `coordinador`: 90 permisos (campana + frontend)
    - `editor`: 44 permisos (contenido + avances)
    - `publicista`: 15 permisos (solo piezas de contenido)
    - `colaborador`: 20 permisos (captacion + lectura)
- OK `canAccess()` verificado en `DocumentoCampanaResource` (solo super_admin)
- OK `canAccess()` verificado en `EventResource` y `UserResource` (super_admin + coordinador)
- OK `WelcomeWidget` restringido solo a colaboradores
- OK 7 usuarios de prueba creados con roles asignados

---

### Fase 5 - Deploy y orden del menu

**Objetivo:** subir a produccion y organizar el menu lateral.

- OK Deploy al VPS (MariaDB 10.11) ejecutado el 21 sep 2026
- OK 13 migraciones aplicadas en VPS
- OK 5 seeders ejecutados (Zona, SemanaPlan, Tarea, KpiSemanal, DocumentoCampana)
- OK `shield:generate --all` ejecutado en VPS
- OK `CampanaRolePermissionsSeeder` ejecutado en VPS
- OK Build de assets (`npm run build`)
- OK Resources del grupo Campana reordenados por jerarquia:
    1. Documento Maestro (estrategico)
    2. KPIs Semanales (estrategico)
    3. Avances de KPIs (estrategico)
    4. Tareas (operativo)
    5. Eventos de Campo (operativo)
    6. Piezas de Contenido (operativo)
    7. Contactos (base de datos)
    8. Validadores (base de datos)
    9. Zonas (configuracion)
    10. Semanas del Plan (configuracion)
    11. Incidentes (seguridad)
- OK **Fase 5 completada**

---

## Resumen de la Fase 1

| Componente       | Cantidad |
| ---------------- | -------- |
| Migraciones      | 11       |
| Modelos Eloquent | 10       |
| Seeders          | 3        |
| Tablas en BD     | 33       |
| Zonas cargadas   | 11       |
| Semanas cargadas | 10       |
| Tareas cargadas  | 9        |

---

## Registro de decisiones

| Fecha       | Decision                                                                   | Motivo                                         |
| ----------- | -------------------------------------------------------------------------- | ---------------------------------------------- |
| 20 sep 2026 | Implementar modulo Campana como herramienta viva                           | Mejor que un .md estatico                      |
| 20 sep 2026 | Avanzar en rama `feature/modulo-campana`                                   | Mantener `main` limpio                         |
| 20 sep 2026 | Desarrollo maximo 8h/semana                                                | Prioridad 1: campana                           |
| 20 sep 2026 | Guardar notas de WhatsApp en `description` de events                       | Ya existe la columna, sin migracion extra      |
| 20 sep 2026 | Constraint unico (semana_id, kpi)                                          | Evita duplicados accidentales                  |
| 20 sep 2026 | Meta semanal fija, valor calculado automaticamente                         | Evita descuadres por edicion manual            |
| 20 sep 2026 | Avances diarios con modal inline en el dashboard                           | Mejor UX que redirigir a un Resource externo   |
| 20 sep 2026 | Widgets de Campana primero (sort 2-5), frontend despues (10-14)            | Priorizar el modulo de campana en el dashboard |
| 20 sep 2026 | Roles definidos: super_admin, coordinador, editor, publicista, colaborador | Adaptado a los roles reales del equipo         |
| 20 sep 2026 | Permisos via Shield + Policies (no canAccess manual)                       | Arquitectura escalable y mantenible            |
| 20 sep 2026 | WelcomeWidget solo para colaboradores                                      | La imagen es para trabajo de campo             |
| 20 sep 2026 | Resources ordenados por jerarquia (estrategico > operativo > datos)        | Coherencia con los widgets del dashboard       |
