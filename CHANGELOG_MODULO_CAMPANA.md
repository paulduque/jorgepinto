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
- Pendiente `ValidadorResource`
- Pendiente `KpiSemanalResource`

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

---

### Fase 3 - Documento + Eventos + Piezas + Incidentes

**Objetivo:** visor del mapa estrategico y CRUD avanzado.

- Pendiente `DocumentoCampanaResource` (visor markdown)
- Pendiente `EventoCampanaResource`
- Pendiente `PiezaContenidoResource`
- Pendiente `IncidenteResource`

---

### Fase 4 - Dashboard + Widgets + Charts + Roles

**Objetivo:** visualizacion de KPIs y permisos por rol.

- Pendiente `KpiOverviewWidget`
- Pendiente `AlcanceSemanalChart`
- Pendiente `ProgresoFasesChart`
- Pendiente `DistribucionZonasChart`
- Pendiente Definir roles: `super_admin`, `coordinador`, `editor`, `analista`, `candidato`
- Pendiente Aplicar `canAccess()` / `canView()` a Resources y Widgets

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

| Fecha       | Decision                                             | Motivo                                    |
| ----------- | ---------------------------------------------------- | ----------------------------------------- |
| 20 sep 2026 | Implementar modulo Campana como herramienta viva     | Mejor que un .md estatico                 |
| 20 sep 2026 | Avanzar en rama `feature/modulo-campana`             | Mantener `main` limpio                    |
| 20 sep 2026 | Desarrollo maximo 8h/semana                          | Prioridad 1: campana                      |
| 20 sep 2026 | Guardar notas de WhatsApp en `description` de events | Ya existe la columna, sin migracion extra |
