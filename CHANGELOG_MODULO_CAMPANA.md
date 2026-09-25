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

### Sesión 23 sep 2026 - Acceso al Documento Maestro por rol

**Objetivo:** permitir que roles distintos a `super_admin` puedan acceder al Documento Maestro sin hardcodear `canAccess()`.

#### Problema detectado

- `DocumentoCampanaResource` tenía `canAccess()` con `hasRole('super_admin')` hardcodeado.
- Eso impedía que `coordinador`, `editor` u otros roles pudieran ver el recurso, aunque tuvieran permisos de Shield.
- Además, violaba la regla del Prompt Maestro: "los permisos se controlan exclusivamente con Shield".

#### Solución aplicada

- OK Se eliminó el método `canAccess()` de `DocumentoCampanaResource.php` (-18 líneas)
- OK Se agregaron los permisos del Documento Maestro al `CampanaRolePermissionsSeeder` (+7 líneas) como referencia en el repo:
    - `coordinador`: `view_any_documento::campana`, `view_documento::campana`, `update_documento::campana`
    - `editor`: `view_any_documento::campana`, `view_documento::campana`
- OK Se ejecutó `php artisan shield:generate --resource=DocumentoCampanaResource --panel=admin` en el VPS
    - Generó `DocumentoCampanaPolicy.php` + 12 permisos
- OK Se limpiaron cachés en el VPS:
    - `php artisan permission:cache-reset`
    - `php artisan optimize:clear`
    - `php artisan filament:cache-components`
- OK Se asignaron los permisos **manualmente** en `/admin/roles` del VPS
    - **NO** se ejecutó el Seeder en el VPS (para no sobrescribir roles configurados manualmente)
- OK Verificado: usuario `coordinador` ve y accede al Documento Maestro ✅

#### Decisión importante

- El Seeder queda actualizado en el repo como **fuente de verdad documental**, pero **NO se ejecuta en producción**.
- Los permisos del VPS se gestionan manualmente desde `/admin/roles`.
- Documentar este flujo en `PROMPT_MAESTRO_JORGE_PINTO.md` (sección "Acceso al Documento Maestro").

---

### Sesión 24 sep 2026 - Mapa interactivo en eventos

**Objetivo:** reemplazar los campos `latitude` y `longitude` por un mapa interactivo con búsqueda de Google Places, en el formulario de eventos.

#### Paquete instalado

- OK `cheesegrits/filament-google-maps` v4.0.2 (compatible con Filament 3.3)
- OK API Key de Google Maps configurada en `.env` (`GOOGLE_MAPS_API_KEY`)
- OK 3 APIs habilitadas en Google Cloud Console: Maps JavaScript, Places, Geocoding
- OK Facturación (Billing) habilitada en Google Cloud (con capa gratuita de $200 USD/mes)

#### Problemas resueltos en el camino

- OK **Método `->zoom()` no existe** → se usa `->defaultZoom()` (tanto en `Map` como en `MapEntry`)
- OK **Método `->updateLatLng()` no existe** en v4.0.2 → se eliminó
- OK **Conflicto de nombres con la columna `location`** → el paquete espera un atributo computado, pero la tabla `events` ya tiene una columna `location` para el nombre del lugar. Solución: renombrar el atributo computado a `location_map`
- OK **Composer autoload en Windows** no encontraba la clase `FilamentGoogleMapsServiceProvider` → se solucionó con `composer dump-autoload --optimize`
- OK **`location_map` faltaba en `$fillable`** del modelo `Event` → se agregó para que el mutador se ejecute
- OK **Referer de Google Maps** rechazaba `127.0.0.1:8000` → se agregó a las restricciones de la API Key
- OK **Billing no habilitado** en Google Cloud → se habilitó (capa gratuita)

#### Archivos modificados

- OK `app/Filament/Resources/EventResource.php`
    - Reemplazados `TextInput('latitude')` y `TextInput('longitude')` por `Map::make('location_map')` con autocompletado
- OK `app/Filament/Resources/EventResource/Pages/ViewEvent.php`
    - Agregado `Action` "Ver en Google Maps" en la cabecera
    - Agregado `MapEntry` con mini mapa (300px, zoom 15) en la sección Ubicación
- OK `app/Models/Event.php`
    - Agregado `'location_map'` a `$appends` y `$fillable`
    - Agregados 4 métodos: `getLocationMapAttribute`, `setLocationMapAttribute`, `getLatLngAttributes`, `getComputedLocation`
- OK `resources/views/filament/widgets/agenda-widget.blade.php`
    - Agregado botón "Ver en mapa" (con `<button>` para evitar anidamiento inválido de `<a>`) en la metadata de cada evento
- OK `bootstrap/providers.php`
    - Registrado manualmente `Cheesegrits\FilamentGoogleMaps\FilamentGoogleMapsServiceProvider` (solución al autoload de Windows)
- OK `config/services.php`
    - Configuración de la API Key de Google Maps
- OK `composer.json` / `composer.lock`
    - Agregado `cheesegrits/filament-google-maps: ^4.0`
- OK `config/filament-google-maps.php` (nuevo)
    - Config publicada del paquete
- OK `.gitignore`
    - Excluido `/public/js/cheesegrits/` (assets generados por el paquete)

#### Decisiones importantes

- **`location_map` en lugar de `location`** como nombre del atributo computado, para evitar conflicto con la columna física `location` de la tabla `events` (que guarda el nombre del lugar).
- **`<button>` en lugar de `<a>`** para el botón "Ver en mapa" en la vista Blade del widget, porque HTML5 no permite anidar `<a>` dentro de `<a>`.
- **No versionar** los assets generados del paquete (`public/js/cheesegrits/`). Se regeneran en el VPS con `php artisan filament:assets`.
- **Deploy al VPS requiere** ejecutar `composer install --no-dev --optimize-autoloader` + `composer dump-autoload --optimize` + `php artisan filament:assets`.

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

| Fecha       | Decision                                                                   | Motivo                                                            |
| ----------- | -------------------------------------------------------------------------- | ----------------------------------------------------------------- |
| 20 sep 2026 | Implementar modulo Campana como herramienta viva                           | Mejor que un .md estatico                                         |
| 20 sep 2026 | Avanzar en rama `feature/modulo-campana`                                   | Mantener `main` limpio                                            |
| 20 sep 2026 | Desarrollo maximo 8h/semana                                                | Prioridad 1: campana                                              |
| 20 sep 2026 | Guardar notas de WhatsApp en `description` de events                       | Ya existe la columna, sin migracion extra                         |
| 20 sep 2026 | Constraint unico (semana_id, kpi)                                          | Evita duplicados accidentales                                     |
| 20 sep 2026 | Meta semanal fija, valor calculado automaticamente                         | Evita descuadres por edicion manual                               |
| 20 sep 2026 | Avances diarios con modal inline en el dashboard                           | Mejor UX que redirigir a un Resource externo                      |
| 20 sep 2026 | Widgets de Campana primero (sort 2-5), frontend despues (10-14)            | Priorizar el modulo de campana en el dashboard                    |
| 20 sep 2026 | Roles definidos: super_admin, coordinador, editor, publicista, colaborador | Adaptado a los roles reales del equipo                            |
| 20 sep 2026 | Permisos via Shield + Policies (no canAccess manual)                       | Arquitectura escalable y mantenible                               |
| 20 sep 2026 | WelcomeWidget solo para colaboradores                                      | La imagen es para trabajo de campo                                |
| 20 sep 2026 | Resources ordenados por jerarquia (estrategico > operativo > datos)        | Coherencia con los widgets del dashboard                          |
| 23 sep 2026 | Eliminar `canAccess()` hardcodeado del Documento Maestro                   | Permitir acceso a más roles vía Shield                            |
| 23 sep 2026 | Asignar permisos del Documento Maestro manualmente en el VPS               | Evitar que `syncPermissions` sobrescriba config manual            |
| 23 sep 2026 | Seeder actualizado en repo, pero NO ejecutado en VPS                       | Documentar sin romper la configuración en producción              |
| 23 sep 2026 | `coordinador` con `view + view_any + update` del Documento Maestro         | Puede leer y editar el documento estratégico                      |
| 23 sep 2026 | `editor` con `view + view_any` del Documento Maestro                       | Solo lectura del documento estratégico                            |
| 24 sep 2026 | Instalar `cheesegrits/filament-google-maps` para el mapa interactivo       | Búsqueda de Google Places + compatible con Filament 3.3           |
| 24 sep 2026 | Usar `location_map` como atributo computado en lugar de `location`         | Evitar conflicto con la columna `location` de la tabla `events`   |
| 24 sep 2026 | Registrar manualmente `FilamentGoogleMapsServiceProvider`                  | El autoload de Composer fallaba en Windows con rutas con espacios |
| 24 sep 2026 | Usar `<button>` en lugar de `<a>` para el botón "Ver en mapa"              | HTML5 no permite anidar `<a>` dentro de `<a>`                     |
| 24 sep 2026 | Habilitar Billing en Google Cloud                                          | Requisito de Google Maps API (aunque haya capa gratuita)          |
| 24 sep 2026 | No versionar los assets generados del paquete (`public/js/cheesegrits/`)   | Se regeneran con `php artisan filament:assets` en cada deploy     |
