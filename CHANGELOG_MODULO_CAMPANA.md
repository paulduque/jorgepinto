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

#### 20 sep 2026 - Arranque

- OK Rama `feature/modulo-campana` creada
- OK Seccion "Modulo Campana" agregada al `PROMPT_MAESTRO_JORGE_PINTO.md`
- OK Changelog inicial creado

#### 20 sep 2026 - Migraciones base

- OK Migracion `create_zonas_table` aplicada
- OK Migracion `create_semanas_plan_table` aplicada
- OK Migracion `create_tareas_table` aplicada
- OK Verificadas con `php artisan db:show --counts` (26 tablas)
- OK Columnas verificadas con tinker

#### 20 sep 2026 - Migraciones del modulo

- OK Migracion `create_contactos_table` aplicada
- OK Migracion `create_validadores_table` aplicada
- OK Migracion `create_eventos_campana_table` aplicada
- OK Migracion `create_piezas_contenido_table` aplicada
- OK Migracion `create_kpis_semanales_table` aplicada
- OK Migracion `create_incidentes_table` aplicada
- OK Migracion `create_documento_campana_table` aplicada
- OK Total: 11 tablas del modulo Campana creadas
- OK Verificadas con `php artisan db:show --counts` (33 tablas)
- OK Columnas verificadas con tinker

#### 20 sep 2026 - Modelos Eloquent

- OK `Zona` con relaciones (contactos, validadores, eventosCampana, piezasContenido)
- OK `Contacto` con relacion a Zona
- OK `Validador` con relacion a Zona
- OK `EventoCampana` con relacion a Zona
- OK `PiezaContenido` con relacion a Zona
- OK `KpiSemanal` con relacion a SemanaPlan
- OK `Incidente`
- OK `DocumentoCampana` con relacion a User
- OK `SemanaPlan` con relaciones (tareas, kpis)
- OK `Tarea` con relaciones (semana, responsable)
- OK Verificado con tinker (todos los `count()` = 0)

#### 20 sep 2026 - Seeders del modulo

- OK `ZonaSeeder` -> 11 zonas de Pichincha
- OK `SemanaPlanSeeder` -> 10 semanas del plan (S1-S7, Cierre, Oficial, Silencio)
- OK `TareaSeeder` -> 9 tareas del plan de choque S1
- OK Verificado con tinker (Zonas: 11, Semanas: 10, Tareas: 9)
- OK **Fase 1 completada**

#### 20 sep 2026 - ZonaResource

- OK `ZonaResource` creado en Filament
- OK Formulario con canton, parroquia, prioridad, notas
- OK Tabla con badges de prioridad y contadores de contactos/validadores
- OK Filtro por prioridad
- OK Grupo de navegacion "Campana" con icono de pin
- OK Verificado en `/admin/zonas` con las 11 zonas cargadas

#### 20 sep 2026 - SemanaPlanResource

- OK `SemanaPlanResource` creado en Filament
- OK Formulario con codigo, fase, fechas, estado, objetivo
- OK Tabla con badges de estado y contadores de tareas/KPIs
- OK Filtro por estado
- OK Verificado en `/admin/semana-plans` con las 10 semanas cargadas

#### Pendiente Fase 1

- Pendiente: probar migraciones y seeders en VPS MySQL

---

### Fase 2 - Recursos Filament (MVP)

**Objetivo:** CRUD funcional desde el panel.

- OK `ZonaResource`
- OK `SemanaPlanResource`
- OK `TareaResource`
- OK `ContactoResource`
- OK `ValidadorResource`
- OK `KpiSemanalResource`
- OK **Fase 2 completada**

#### 20 sep 2026 - TareaResource

- OK `TareaResource` creado en Filament
- OK Formulario con titulo, descripcion, semana, responsable, fecha limite, estado, prioridad, orden
- OK Tabla con edicion inline de estado (SelectColumn)
- OK Filtros por estado, prioridad y semana
- OK Fecha limite se muestra en rojo si esta vencida
- OK Verificado en `/admin/tareas` con las 9 tareas de S1

#### 20 sep 2026 - ContactoResource

- OK `ContactoResource` creado en Filament
- OK Migracion adicional: `capturado_por` y `consentimiento_verbal` en contactos
- OK Modelo `Contacto` actualizado con relacion a User (capturadoPor)
- OK Formulario con nombre, telefono, email, zona, origen, capturado_por
- OK Dos toggles de consentimiento: digital y verbal
- OK Tabla con iconos separados para consentimiento digital y verbal
- OK Filtros por zona, origen, consentimiento digital y verbal
- OK Verificado en `/admin/contactos`

#### 20 sep 2026 - ValidadorResource

- OK `ValidadorResource` creado en Filament
- OK Slug forzado a `validadores` (evita pluralizacion inglesa)
- OK Formulario con nombre, cargo, telefono, zona, estado, fecha_apoyo, notas
- OK Tabla con badges de estado y copiado de telefono
- OK Filtros por estado y zona
- OK Verificado en `/admin/validadores`

#### 20 sep 2026 - KpiSemanalResource

- OK `KpiSemanalResource` creado en Filament
- OK Slug forzado a `kpis-semanales`
- OK Archivo `ListKpiSemanales.php` renombrado (evita pluralizacion inglesa)
- OK Formulario con semana, kpi, valor, meta, notas
- OK Tabla con badges de colores por tipo de KPI
- OK Calculo automatico de cumplimiento (valor / meta)
- OK Filtros por semana y tipo de KPI
- OK Verificado en `/admin/kpis-semanales`
- OK **Fase 2 completada**

#### 20 sep 2026 - KpiSemanalSeeder con metas y justificaciones

- OK `KpiSemanalSeeder` creado
- OK 35 KPIs cargados (7 semanas × 5 KPIs: contactos, validadores, suscriptores, alcance, eventos)
- OK Cada KPI incluye justificación en campo `notas`:
    - Fuente: Proyección CNE 2021 + padrón Pichincha 2026 (RPubs)
    - Cálculo: 5% de los 574.000 votos necesarios para ganar
    - Referencia: resultados Asambleístas Pichincha 2021
- OK Metas cargadas por semana (progresión exponencial):
    - Contactos: 500 → 28.700
    - Validadores: 10 → 57
    - Suscriptores: 1.000 → 57.400
    - Alcance: 250K → 3.5M
- OK Verificado con tinker (35 registros)
- OK `DatabaseSeeder` actualizado con `KpiSemanalSeeder`

#### Documento de estrategias

- OK Análisis del terreno 2021 documentado
- OK Metas por KPI calculadas con datos reales
- OK Progresión semanal definida (S1-S7)

#### 20 sep 2026 - Documento de estrategias

- OK `ESTRATEGIAS_CAMPANA.md` creado con:
    - Analisis del terreno 2021 (padron Pichincha, resultados 1ra y 2da vuelta)
    - Objetivos por KPI con justificacion
    - Progresion semanal (S1-S7)
    - Estrategias por KPI
    - Estrategias por zona
    - Lineas rojas y fuentes
- OK Fuentes: RPubs (padron 2026) + PDF CNE 2021

#### 20 sep 2026 - DocumentoCampanaResource

- OK `DocumentoCampanaSeeder` creado y ejecutado (1 documento cargado)
- OK `DocumentoCampanaResource` creado en Filament
- OK Slug forzado a `documento-maestro`
- OK Acceso restringido solo a `super_admin` (via canAccess)
- OK Sin creacion ni eliminacion (documento unico)
- OK MarkdownEditor en formulario de edicion
- OK Vista custom `documento-campana.blade.php` con estilos del front
- OK Boton "Editar documento" visible en el hero
- OK Verificado en `/admin/documento-maestro`

---

### Fase 3 - Documento + Eventos + Piezas + Incidentes

**Objetivo:** visor del mapa estrategico y CRUD avanzado.

- OK `DocumentoCampanaResource` (visor markdown)
- OK `EventoCampanaResource`
- OK `PiezaContenidoResource`
- OK `IncidenteResource`
- OK **Fase 3 completada**

#### 20 sep 2026 - EventoCampanaResource

- OK `EventoCampanaResource` creado en Filament
- OK Slug forzado a `eventos-campana`
- OK Pagina `ListEventosCampana.php` renombrada (evita pluralizacion inglesa)
- OK Formulario con titulo, fecha, zona, estado, descripcion
- OK Metricas: contactos_captados, piezas_publicadas
- OK Tabla con badges de estado y contadores
- OK Filtros por estado, zona y rango de fechas
- OK Verificado en `/admin/eventos-campana`

#### 20 sep 2026 - IncidenteResource

- OK `IncidenteResource` creado en Filament
- OK Slug forzado a `incidentes`
- OK Formulario con fecha, tipo, estado, descripcion, respuesta
- OK Tabla con badges de tipo y estado
- OK Icono indicador de si tiene respuesta
- OK Filtros por estado, tipo y rango de fechas
- OK Verificado en `/admin/incidentes`
- OK **Fase 3 completada**

---

### Fase 4 - Dashboard + Widgets + Charts + Roles

**Objetivo:** visualizacion de KPIs y permisos por rol.

- OK `KpiOverviewWidget` (tarjetas + modal inline para registrar avance)
- OK `AlcanceSemanalChart` (grafico de lineas de metas por semana)
- OK `ProgresoFasesChart` (grafico de barras apiladas de tareas por semana)
- OK `DistribucionZonasChart` (grafico de dona de contactos por canton)
- OK `AvanceKpiResource` + sistema de avances diarios
- OK Widgets del dashboard reordenados (Campana primero, frontend despues)
- En progreso Definir roles: `super_admin`, `coordinador`, `editor`, `analista`, `candidato`
- En progreso Aplicar `canAccess()` / `canView()` a Resources y Widgets

#### 20 sep 2026 - Sistema de avances diarios de KPIs

- OK Migracion `add_unique_constraint_to_kpis_semanales` aplicada
- OK Constraint unico (semana_id, kpi) - evita duplicados
- OK Migracion `create_avances_kpi_table` aplicada
- OK Modelo `AvanceKpi` creado con relaciones
- OK Observer `AvanceKpiObserver` registrado en AppServiceProvider
- OK Resource `AvanceKpiResource` en `/admin/avances-kpi`
- OK Validacion `unique` en formulario de KpiSemanalResource (mensaje amigable)
- OK `KpiOverviewWidget` mejorado con modal inline para registrar avances
- OK Recalculo automatico del KPI al guardar un avance
- OK Actualizacion del widget sin recargar la pagina
- OK Verificado en `/admin` con todas las funcionalidades

#### 20 sep 2026 - Sistema de avances diarios de KPIs

- OK Migracion `add_unique_constraint_to_kpis_semanales` aplicada
- OK Constraint unico (semana_id, kpi) - evita duplicados
- OK Migracion `create_avances_kpi_table` aplicada
- OK Modelo `AvanceKpi` creado con relaciones a `KpiSemanal` y `User`
- OK Observer `AvanceKpiObserver` registrado en `AppServiceProvider`
- OK Resource `AvanceKpiResource` en `/admin/avances-kpi`
- OK Validacion `unique` en formulario de `KpiSemanalResource` (mensaje amigable)
- OK KPI mal etiquetado (id 4) corregido: "suscriptores" -> "alcance"
- OK Verificado con tinker (35 KPIs, constraint funcionando)

#### 20 sep 2026 - Widgets del dashboard

- OK `KpiOverviewWidget` con tarjetas y modal inline para registrar avances
- OK Modal permite crear/editar avance del dia sin salir del dashboard
- OK Recalculo automatico del KPI al guardar un avance
- OK Actualizacion del widget sin recargar la pagina
- OK `AlcanceSemanalChart` con grafico de lineas (contactos, validadores, suscriptores)
- OK `ProgresoFasesChart` con grafico de barras apiladas (completadas/en progreso/pendientes)
- OK `DistribucionZonasChart` con grafico de dona (contactos por canton)
- OK Widgets reordenados: Agenda (1), Campana (2-5), Frontend (10-14)
- OK Verificado en `/admin` con los 3 charts funcionando

#### 20 sep 2026 - Limpieza de widgets duplicados

- OK Eliminada carpeta `app/Filament/Resources/AdminResource` (duplicado)
- OK Eliminados widgets duplicados: `AlcanceSemanalChart.php`, `ProgresoFasesChart.php`
- OK Widgets correctos confirmados en `app/Filament/Widgets/`

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

| Fecha       | Decision                                                        | Motivo                                         |
| ----------- | --------------------------------------------------------------- | ---------------------------------------------- |
| 20 sep 2026 | Implementar modulo Campana como herramienta viva                | Mejor que un .md estatico                      |
| 20 sep 2026 | Avanzar en rama `feature/modulo-campana`                        | Mantener `main` limpio                         |
| 20 sep 2026 | Desarrollo maximo 8h/semana                                     | Prioridad 1: campana                           |
| 20 sep 2026 | Guardar notas de WhatsApp en `description` de events            | Ya existe la columna, sin migracion extra      |
| 20 sep 2026 | Avances diarios con modal inline en el dashboard                | Mejor UX que redirigir a un Resource externo   |
| 20 sep 2026 | Constraint unico (semana_id, kpi)                               | Evita duplicados accidentales                  |
| 20 sep 2026 | Meta semanal fija, valor calculado automaticamente              | Evita descuadres por edicion manual            |
| 20 sep 2026 | Avances diarios con modal inline en el dashboard                | Mejor UX que redirigir a un Resource externo   |
| 20 sep 2026 | Widgets de Campana primero (sort 2-5), frontend despues (10-14) | Priorizar el modulo de campana en el dashboard |
