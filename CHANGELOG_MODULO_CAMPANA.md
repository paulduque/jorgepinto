# CHANGELOG - Modulo Campana

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

#### 20 sep 2026 — Arranque

- ✅ Rama `feature/modulo-campana` creada
- ✅ Sección "Módulo Campaña" agregada al `PROMPT_MAESTRO_JORGE_PINTO.md`
- ✅ Changelog inicial creado

#### 20 sep 2026 — Migraciones base completadas

- ✅ Migración `create_zonas_table` aplicada
- ✅ Migración `create_semanas_plan_table` aplicada
- ✅ Migración `create_tareas_table` aplicada
- ✅ Verificadas con `php artisan db:show --counts` (26 tablas)
- ✅ Verificadas columnas con tinker
- ⏳ Pendiente: probar en VPS MySQL

---

### Fase 2 - Recursos Filament (MVP)

**Objetivo:** CRUD funcional desde el panel.

- SemanaPlanResource
- TareaResource
- ContactoResource
- ValidadorResource
- KpiSemanalResource
- ZonaResource

---

### Fase 3 - Documento + Eventos + Piezas + Incidentes

**Objetivo:** visor del mapa estrategico y CRUD avanzado.

- DocumentoCampanaResource (visor markdown)
- EventoCampanaResource
- PiezaContenidoResource
- IncidenteResource

---

### Fase 4 - Dashboard + Widgets + Charts + Roles

**Objetivo:** visualizacion de KPIs y permisos por rol.

- KpiOverviewWidget
- AlcanceSemanalChart
- ProgresoFasesChart
- DistribucionZonasChart
- Definir roles: super_admin, coordinador, editor, analista, candidato
- Aplicar canAccess() / canView() a Resources y Widgets

---

## Registro de decisiones

| Fecha       | Decision                                         | Motivo                    |
| ----------- | ------------------------------------------------ | ------------------------- |
| 20 sep 2026 | Implementar modulo Campana como herramienta viva | Mejor que un .md estatico |
| 20 sep 2026 | Avanzar en rama feature/modulo-campana           | Mantener main limpio      |
| 20 sep 2026 | Desarrollo maximo 8h/semana                      | Prioridad 1: campana      |
