# 🗺️ PROMPT MAESTRO CONSOLIDADO — PROYECTO JORGE PINTO

> **Instrucciones de uso:** copia este archivo completo (`PROMPT_MAESTRO_JORGE_PINTO.md`) y pégalo al inicio de una conversación con GitHub Copilot, Cursor, Claude, ChatGPT o cualquier IA dentro de VS Code / Android Studio. Sirve como contexto técnico completo del proyecto para generar código coherente.

---

## 📌 CONTEXTO DEL PROYECTO

**Nombre:** Jorge Pinto — Sitio Web + Agenda WhatsApp + App Móvil
**Cliente:** Campaña política de Jorge Pinto, Pichincha, Ecuador
**Repositorio:** https://github.com/paulduque/jorgepinto
**Ruta local (Windows):** `F:\DISCO D\Paul\Documents\+Web Plus\Proyectos\Jorge Pinto\sitio`
**VPS:** `jorgepinto.ec` (usuario `jorge5217`)
**Ruta VPS:** `/home/jorgepinto.ec/laravel`
**Inspiración visual:** https://bidenwhitehouse.archives.gov/es/

**Objetivo:** sitio web institucional de campaña + panel administrativo + agenda gestionada por WhatsApp con IA + app móvil Android.

---

## 🧱 STACK TECNOLÓGICO

### Backend

- **Laravel 11** (PHP 8.2+)
- **MySQL 8** (VPS) / **SQLite** (local)
- **Filament 3.3** (panel admin)
- **Laravel Sanctum** (tokens API)
- **Spatie Laravel Permission** (roles y permisos)
- **Spatie Laravel Sluggable** (slugs automáticos)
- **BezhanSalleh Filament Shield** (permisos en Filament)
- **Saade Filament FullCalendar** (calendario)
- **Cheesegrits Filament Google Maps** (mapa interactivo con Places API)

### Frontend

- **Blade templates**
- **Tailwind CSS v4** (colores personalizados)
- **Alpine.js**
- **Vite** (build de assets)
- **@tailwindcss/typography** (estilos de contenido)

### Integraciones

- **WAHA** (WhatsApp HTTP API) → `https://waha-jorgepinto.onrender.com`
- **n8n** (automatización de flujos)
- **Groq API**
    - Transcripción: `whisper-large-v3`
    - IA: `openai/gpt-oss-120b`

### Móvil (a crear)

- **Kotlin**
- **Jetpack Compose**
- **Retrofit + OkHttp**
- **Hilt**
- **Room**
- **Coil**
- **Navigation Compose**
- **DataStore**
- **Firebase Cloud Messaging**

---

## 📐 ARQUITECTURA GENERAL

```
JORGE PINTO
│
├── SITIO PÚBLICO (Laravel + Blade + Tailwind)
│   ├── Home (hero, momentos, noticias, agenda pública)
│   ├── Noticias (listado + detalle)
│   ├── Agenda pública
│   ├── Perfil / biografía
│   └── Contacto
│
├── PANEL ADMIN (Filament 3.3)
│   ├── Eventos (CRUD + calendario)
│   ├── Noticias (CRUD + imágenes)
│   ├── Momentos (destacados home)
│   ├── SiteSettings (configuración global)
│   ├── Mensajes de contacto
│   ├── Usuarios y roles
│   └── Dashboard con widgets
│
├── API REST (Sanctum)
│   └── /api/agenda/*
│
├── AGENDA WHATSAPP (n8n + WAHA + Groq)
│   └── Webhook → IA → API Laravel → Respuesta
│
└── APP ANDROID (Kotlin + Compose)
    ├── Público (noticias, agenda, perfil, contacto)
    └── Admin (login, CRUD eventos/noticias)
```

---

## 🗄️ ESQUEMA DE BASE DE DATOS

### `events`

| Campo       | Tipo          | Notas                                         |
| ----------- | ------------- | --------------------------------------------- |
| id          | bigint        | PK                                            |
| title       | string(255)   | requerido                                     |
| slug        | string(255)   | único, auto                                   |
| description | text          | **notas/observaciones desde WhatsApp**        |
| image       | string        | nullable                                      |
| type        | enum          | mitin, reunion, entrevista, gira, tarea, otro |
| start_at    | datetime      | requerido                                     |
| end_at      | datetime      | nullable                                      |
| all_day     | boolean       | default false                                 |
| location    | string(255)   | nullable                                      |
| address     | string(255)   | nullable                                      |
| latitude    | decimal(10,7) | nullable                                      |
| longitude   | decimal(10,7) | nullable                                      |
| is_public   | boolean       | default false                                 |
| status      | enum          | planificado, en_curso, completado, cancelado  |
| color       | string        | default #3b82f6                               |
| created_by  | FK users      | nullable                                      |
| timestamps  |               |                                               |

### `event_user` (pivote)

`event_id`, `user_id`, `role_in_event`, `attendance_status`, `timestamps`

### `news`

`id`, `title`, `slug`, `excerpt`, `content`, `image`, `category`, `is_published`, `published_at`, `created_by`, `timestamps`

### `moments`

`id`, `news_id` (FK), `order` (int), `is_active` (bool), `timestamps`

### `site_settings`

`id`, `person_name`, `site_name` (subtítulo del header), `logo`, `favicon`, `hero_title`, `hero_subtitle`, `hero_image`, `social_facebook`, `social_twitter`, `social_instagram`, `social_tiktok`, `contact_email`, `contact_phone`, `timestamps`

### `contact_messages`

`id`, `name`, `email`, `phone`, `subject`, `message`, `is_read`, `timestamps`

### `users`, `roles`, `permissions`

Tablas estándar de Laravel + Spatie Permission.

### `personal_access_tokens`

Tabla estándar de Sanctum.

---

## 🔌 API REST

**Base URL:** `https://jorgepinto.ec/api`
**Auth:** `Bearer {token}` (Sanctum)

### `POST /api/agenda/crear`

```json
{
    "title": "string (req)",
    "description": "string (opcional, notas)",
    "start_at": "YYYY-MM-DD HH:MM (req)",
    "end_at": "YYYY-MM-DD HH:MM (opcional)",
    "location": "string (opcional)",
    "address": "string (opcional)",
    "type": "mitin|reunion|entrevista|gira|tarea|otro",
    "status": "planificado|en_curso|completado|cancelado",
    "is_public": true
}
```

**Response 201:** `{ success, message, event }`

### `PUT /api/agenda/editar/{id}`

Mismos campos, todos opcionales. **Response 200:** `{ success, message, event }`

### `DELETE /api/agenda/eliminar/{id}`

**Response 200:** `{ success, message }`

### `GET /api/agenda/hoy?date=YYYY-MM-DD`

**Response:** `{ success, date, total, events: [...] }`

### `GET /api/agenda/proximos?limit=10`

**Response:** `{ success, total, events: [...] }`

### `GET /api/agenda/buscar?q=termino`

**Response:** `{ success, query, total, events: [...] }`

### Formato de evento (`formatEvent`)

```json
{
    "id": 1,
    "title": "...",
    "description": "...",
    "type": "reunion",
    "type_label": "Reunión",
    "start_at": "2026-09-19T15:00:00-05:00",
    "start_at_formatted": "sábado, 19 de septiembre de 2026 - 15:00",
    "end_at": null,
    "location": "...",
    "address": "...",
    "status": "planificado",
    "status_label": "Planificado",
    "is_public": false,
    "assigned_users": ["..."]
}
```

---

## 🤖 AGENDA POR WHATSAPP

### Componentes

- **WAHA:** `https://waha-jorgepinto.onrender.com` · API Key `JorgePintoWAHA2026` · Session `default` · Webhook solo evento `message`
- **n8n:** workflow `Jorge Pinto - Agenda WhatsApp` · path `jorgepinto-agenda`
- **Groq:** transcripción `whisper-large-v3` + IA `openai/gpt-oss-120b`

### Flujo del workflow

```
Webhook WAHA
  → Responder OK inmediato (200)
  → Extraer mensaje (deduplicación + filtros)
  → Recuperar contexto (historial + pendiente)
  → ¿Es audio?
      ├── true → Descargar audio → Renombrar → Transcribir Groq → Inyectar transcripción
      └── false
  → Construir contexto (prompt con historial + pendiente)
  → Groq AI Agenda
  → Procesar respuesta (validación + merge + guardar contexto)
  → Switch Intenciones
      ├── crear_evento → API Crear
      ├── consultar_agenda → API Hoy
      ├── consultar_proximos → API Próximos
      ├── editar_evento → API Buscar → IF → API Editar
      ├── eliminar_evento → API Buscar → IF → API Eliminar
      └── conversacional → Respuesta
  → Enviar WhatsApp
  → Notificar Contactos → Enviar Notificación
```

### Deduplicación

- Fingerprint: `from + mensaje + timestamp(seg)`
- Lista de últimos 100 fingerprints
- Ventana: mismo fingerprint en `<5s` se ignora
- **Recomendado:** desactivar reintentos en WAHA (`attempts: 0`)

### Memoria conversacional

- `$getWorkflowStaticData('global')`
- Estructura: `{ conversaciones: { [from]: { historial, pendiente, ultimaActividad } } }`
- Expiración: 30 min sin actividad
- Historial: últimos 20 turnos

### Números de notificación

- `593992398915@s.whatsapp.net` (Paul)
- `593984708395@s.whatsapp.net` (Jorge Pinto)

### Pendiente

- Lista blanca de números autorizados
- Validar búsqueda antes de editar/eliminar (`events.length > 0`)
- Guardar `ultimoEventoId` en contexto para editar notas después

---

## 🎨 DISEÑO Y ESTILOS

### Paleta

- Azul principal: `#1a3a6b`
- Dorado: `#c9a84c`
- Fondo: blanco / slate-50
- Texto: slate-900 / slate-600
- Gris UI: slate-200 / slate-300

### Tipografía

- Títulos: **Merriweather** (serif)
- Cuerpo: **Open Sans** (sans-serif)
- Fallback: system-ui, sans-serif

### Convenciones visuales

- Header fijo con blur al hacer scroll
- Hero con imagen de fondo y overlay degradado
- Tarjetas con hover (translate-y y shadow)
- Grid responsivo (md:grid-cols-3, md:grid-cols-12)
- Badges con colores por tipo
- Iconografía emoji para notas de WhatsApp

### Header

- Arriba: `person_name` (ej: "JORGE PINTO")
- Abajo: `site_name` (ej: "SITIO OFICIAL") — 2 palabras máximo
- Protección anti-duplicado: si `site_name == person_name`, forzar fallback

### Open Graph

- Imágenes destacadas: 1.91:1 (1200x630)
- Tags OG configurados en layout base + home + noticias
- Imágenes de noticias y eventos redimensionadas automáticamente

---

## 💻 CONVENCIONES DE CÓDIGO

- **PSR-12**
- Clases: `PascalCase`
- Tablas: `snake_case` plural
- Columnas: `snake_case`
- Comentarios en **español**
- Filament 3.3: `Forms\Components\*`, `Tables\Columns\*`, `Infolists\Components\*`
- Eloquent sobre Query Builder
- Form Requests para validación compleja
- API Resources para respuestas
- Código limpio y testeable

---

## 🗺️ MAPA INTERACTIVO (GOOGLE MAPS)

### Paquete

- **`cheesegrits/filament-google-maps`** v4.x
- Config publicado: `config/filament-google-maps.php`
- API Key: variable `GOOGLE_MAPS_API_KEY` en `.env`

### APIs de Google Cloud requeridas

- **Maps JavaScript API** (mapa en el navegador)
- **Places API** (autocompletado de direcciones)
- **Geocoding API** (reverse geocoding)

**Importante:** la cuenta de Google Cloud debe tener **Billing habilitado** (aunque se use la capa gratuita de $200 USD/mes). Sin Billing, el mapa no carga y muestra `BillingNotEnabledMapError`.

### Modelo `Event`

El modelo tiene un **atributo computado** llamado `location_map` (NO `location`, para evitar conflicto con la columna física `location` de la tabla `events`, que guarda el nombre del lugar):

- `$appends = ['location_map']`
- `$fillable` incluye `'location_map'`
- Métodos: `getLocationMapAttribute()`, `setLocationMapAttribute()`, `getLatLngAttributes()`, `getComputedLocation()`

### Convenciones del paquete

| Elemento           | Método correcto                   | Método incorrecto      |
| ------------------ | --------------------------------- | ---------------------- |
| Zoom               | `->defaultZoom(15)`               | ~~`->zoom(15)`~~       |
| Ubicación inicial  | `->defaultLocation([lat, lng])`   | —                      |
| Altura             | `->height(300)`                   | —                      |
| Autocomplete       | `->autocomplete('address')`       | —                      |
| Actualizar lat/lng | automático con atributo computado | ~~`->updateLatLng()`~~ |

### Formulario (`EventResource`)

```php
Map::make('location_map')
    ->label('Ubicación en el mapa')
    ->columnSpanFull()
    ->height(450)
    ->defaultLocation([-0.1807, -78.4678]) // Quito
    ->defaultZoom(12)
    ->autocomplete('address')
    ->autocompleteReverse(true)
    ->reverseGeocode([
        'address' => '%S %n, %z %L',
    ])
    ->geolocate()
    ->geolocateOnLoad(false),
```

### Vista de detalle (`ViewEvent`)

```php
MapEntry::make('location_map')
    ->height(300)
    ->defaultZoom(15)
    ->columnSpanFull()
    ->visible(fn($record) => $record->latitude && $record->longitude),
```

Más un `Action` "Ver en Google Maps" en la cabecera.

### Widget Agenda

Botón "Ver en mapa" con `<button>`, no `<a>` (HTML5 no permite anidar `<a>` dentro de `<a>`).

### Regla del autoload en Windows

Ejecutar `composer dump-autoload --optimize` después de instalar paquetes nuevos.

### Assets del paquete

Los JS del paquete se publican en `public/js/cheesegrits/`. **No se versionan**. En cada deploy al VPS:

```bash
php artisan filament:assets
```

### Deploy al VPS

```bash
composer install --no-dev --optimize-autoloader
composer dump-autoload --optimize
php artisan filament:assets
php artisan optimize:clear
php artisan filament:cache-components
chown -R jorge5217:jorge5217 storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

Agregar `https://jorgepinto.ec/*` a las restricciones de la API Key en Google Cloud Console.

---

## 🔍 SEO TÉCNICO

### Meta tags por página

Todas las vistas públicas usan `@section()` para sobrescribir los meta tags del layout:

| Sección                               | Uso                                     |
| ------------------------------------- | --------------------------------------- |
| `@section('title', '...')`            | `<title>` de la página                  |
| `@section('meta_description', '...')` | `<meta name="description">`             |
| `@section('meta_keywords', '...')`    | `<meta name="keywords">`                |
| `@section('canonical', '...')`        | `<link rel="canonical">`                |
| `@section('og_type', '...')`          | `og:type` (website / article / profile) |
| `@section('og_title', '...')`         | `og:title`                              |
| `@section('og_description', '...')`   | `og:description`                        |
| `@section('og_image', '...')`         | `og:image` (1200x630 ideal)             |

### JSON-LD Schema

`resources/views/partials/seo-schema.blade.php` genera los schemas base:

- `Person` (Jorge Pinto) — siempre presente
- `WebSite` — siempre presente

Cada vista puede **inyectar schemas adicionales** con `$extraSchema` antes del `@extends`:

| Vista                          | Schema extra  |
| ------------------------------ | ------------- |
| `news/show.blade.php`          | `NewsArticle` |
| `public/agenda/show.blade.php` | `Event`       |
| `contact/show.blade.php`       | `ContactPage` |

**Ejemplo:**

```blade
@php
    $extraSchema = [
        [
            '@type' => 'NewsArticle',
            'headline' => $news->title,
            // ...
        ],
    ];
@endphp

@extends('layouts.app')
```

---

## 📁 ESTRUCTURA DE ARCHIVOS

```

sitio/
├── app/
│ ├── Filament/
│ │ ├── Pages/
│ │ │ ├── Calendar.php
│ │ │ └── Auth/Register.php
│ │ │
│ │ ├── Resources/
│ │ │ ├── Frontend/
│ │ │ │ ├── EventResource.php
│ │ │ │ ├── NewsResource.php
│ │ │ │ ├── MomentResource.php
│ │ │ │ ├── SiteSettingResource.php
│ │ │ │ ├── UserResource.php
│ │ │ │ ├── ContactMessageResource.php
│ │ │ │ ├── HeroResource.php
│ │ │ │ ├── ThemeResource.php
│ │ │ │ └── ProfileResource.php
│ │ │ │
│ │ │ └── Campaña/
│ │ │ ├── ZonaResource.php
│ │ │ ├── SemanaPlanResource.php
│ │ │ ├── TareaResource.php
│ │ │ ├── ContactoResource.php
│ │ │ ├── ValidadorResource.php
│ │ │ ├── KpiSemanalResource.php
│ │ │ ├── AvanceKpiResource.php
│ │ │ ├── EventoCampanaResource.php
│ │ │ ├── PiezaContenidoResource.php
│ │ │ ├── IncidenteResource.php
│ │ │ └── DocumentoCampanaResource.php
│ │ │
│ │ └── Widgets/
│ │ ├── Frontend/
│ │ │ ├── AgendaWidget.php
│ │ │ ├── LatestNewsWidget.php
│ │ │ ├── QuickActionsWidget.php
│ │ │ ├── CalendarWidget.php
│ │ │ ├── NewMessagesWidget.php
│ │ │ ├── SiteStatsOverview.php
│ │ │ └── WelcomeWidget.php
│ │ │
│ │ └── Campaña/
│ │ ├── KpiOverviewWidget.php
│ │ ├── AlcanceSemanalChart.php
│ │ ├── ProgresoFasesChart.php
│ │ └── DistribucionZonasChart.php
│ │
│ ├── Http/Controllers/
│ │ ├── Api/AgendaController.php
│ │ ├── HomeController.php
│ │ ├── NewsController.php
│ │ └── ContactController.php
│ │
│ ├── Models/
│ │ ├── Frontend/
│ │ │ ├── Event.php
│ │ │ ├── News.php
│ │ │ ├── Moment.php
│ │ │ ├── SiteSetting.php
│ │ │ ├── ContactMessage.php
│ │ │ ├── User.php
│ │ │ ├── Hero.php
│ │ │ ├── Theme.php
│ │ │ └── Profile.php
│ │ │
│ │ └── Campaña/
│ │ ├── Zona.php
│ │ ├── SemanaPlan.php
│ │ ├── Tarea.php
│ │ ├── Contacto.php
│ │ ├── Validador.php
│ │ ├── EventoCampana.php
│ │ ├── PiezaContenido.php
│ │ ├── KpiSemanal.php
│ │ ├── AvanceKpi.php
│ │ ├── Incidente.php
│ │ └── DocumentoCampana.php
│ │
│ ├── Observers/
│ │ └── AvanceKpiObserver.php
│ │
│ └── Policies/ (20 policies generadas por Shield)
│
├── database/
│ ├── migrations/
│ │ ├── (migraciones del frontend existentes)
│ │ └── (13 migraciones del módulo Campaña)
│ │
│ └── seeders/
│ ├── Frontend/
│ │ ├── SiteDataSeeder.php
│ │ ├── RolesAndPermissionsSeeder.php
│ │ └── RolePermissionsSeeder.php
│ │
│ └── Campaña/
│ ├── ZonaSeeder.php
│ ├── SemanaPlanSeeder.php
│ ├── TareaSeeder.php
│ ├── KpiSemanalSeeder.php
│ ├── DocumentoCampanaSeeder.php
│ └── CampanaRolePermissionsSeeder.php
│
├── resources/
│ ├── css/app.css
│ ├── js/app.js
│ │
│ └── views/
│ ├── layouts/app.blade.php
│ ├── components/ (header, footer, ...)
│ ├── home.blade.php
│ ├── news/
│ ├── agenda/
│ ├── contact/
│ │
│ └── filament/
│ ├── documento-campana.blade.php
│ └── widgets/
│ ├── agenda-widget.blade.php
│ ├── kpi-overview.blade.php
│ ├── quick-actions.blade.php
│ └── welcome-widget.blade.php
│
├── routes/
│ ├── web.php
│ └── api.php
│
├── ESTRATEGIAS_CAMPANA.md
├── CHANGELOG_MODULO_CAMPANA.md
├── PROMPT_MAESTRO_JORGE_PINTO.md
└── .env

```

### Resumen de archivos por módulo

| Módulo       | Resources | Widgets | Models | Seeders |
| ------------ | :-------: | :-----: | :----: | :-----: |
| **Frontend** |     9     |    7    |   9    |    3    |
| **Campaña**  |    11     |    4    |   11   |    6    |
| **Total**    |  **20**   | **11**  | **20** |  **9**  |

---

## 🚀 DEPLOY EN VPS

```bash
ssh root@webplusec
cd /home/jorgepinto.ec/laravel

# 1. Verificar estado
git status

# 2. Si hay cambios locales:
# git restore .

# 3. Traer cambios
git pull origin main

# 4. Instalar dependencias (si hay cambios en package.json)
npm install

# 5. Compilar assets (si hay cambios en CSS/JS)
npm run build

# 6. Migraciones (si las hay)
php artisan migrate --force

# 7. Limpiar cachés
php artisan optimize:clear
php artisan filament:cache-components

# 8. Permisos
chown -R jorge5217:jorge5217 storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

---

## 📱 APP ANDROID (a crear)

### Stack

Kotlin · Jetpack Compose · Retrofit · Hilt · Room · Coil · Navigation Compose · DataStore · FCM

### Pantallas

1. SplashScreen
2. OnboardingScreen
3. HomeScreen
4. NewsListScreen
5. NewsDetailScreen
6. AgendaScreen (calendario)
7. EventDetailScreen
8. ProfileScreen
9. ContactScreen
10. LoginScreen (admin)
11. AdminDashboardScreen
12. EventFormScreen (crear/editar)
13. NewsFormScreen (crear/editar)
14. SettingsScreen

### Arquitectura

- **MVVM**
- Capas: `data`, `domain`, `presentation`
- Coroutines + Flow
- StateFlow para UI state
- Tests unitarios para ViewModels

### API a consumir

- `POST /api/login`
- `GET /api/agenda/hoy`
- `GET /api/agenda/proximos`
- `GET /api/agenda/buscar`
- `POST /api/agenda/crear`
- `PUT /api/agenda/editar/{id}`
- `DELETE /api/agenda/eliminar/{id}`
- _(pendiente crear)_ `GET /api/news`, `GET /api/site-settings`, `POST /api/contact`

### Diseño

- Material Design 3
- Colores: `#1a3a6b`, `#c9a84c`, blanco, gris
- Tipografía: Merriweather (títulos), Open Sans (texto)
- Modo claro/oscuro
- Responsive

### Auth

- Login email/password → token Sanctum
- Token en DataStore
- Interceptor Retrofit `Authorization: Bearer {token}`

---

## ✅ TAREAS FRECUENTES QUE NECESITO

Al generar código, cubre estos casos:

1. Crear/editar recursos de Filament (form, table, infolist, actions)
2. Crear/editar vistas Blade con Tailwind
3. Crear/editar controladores (web y API)
4. Crear/editar migraciones y modelos Eloquent
5. Crear/editar componentes Livewire
6. Crear/editar tests (Feature y Unit)
7. Crear/editar endpoints API
8. Crear/editar widgets de Filament
9. Crear/editar policies y permisos
10. Crear/editar seeders y factories

---

## 📋 REGLAS AL GENERAR CÓDIGO

1. Incluir **todos** los `use` necesarios al inicio del archivo
2. Seguir convenciones de Laravel 11
3. Usar **Eloquent** en lugar de Query Builder cuando sea posible
4. Usar **Form Requests** para validación compleja
5. Usar **API Resources** para respuestas JSON
6. Comentar en **español**
7. Nombres de métodos en **camelCase**, clases en **PascalCase**
8. No usar `dd()` ni `dump()` en código de producción
9. Manejar errores con try/catch y devolver respuestas JSON consistentes
10. Validar siempre la entrada del usuario
11. Usar `Filament::auth()->user()` en lugar de `auth()->user()` en contextos de Filament
12. Recargar el modelo User desde la BD (`User::find($user->id)`) antes de usar `->can()` o `->hasRole()`
13. Los permisos se controlan **exclusivamente** con Shield. **Nunca** escribir `canAccess()` con `hasRole('super_admin')` hardcodeado: si necesitas restringir un Resource, crea un permiso con Shield y asígnalo al rol correspondiente.

---

## 🎯 OBJETIVO FINAL

Un ecosistema completo que permita:

1. **Al público:** informarse sobre la campaña, ver noticias, consultar agenda, contactar.
2. **Al equipo:** gestionar todo el contenido desde un panel Filament.
3. **A los coordinadores:** agendar eventos por WhatsApp con IA conversacional.
4. **A los simpatizantes:** acceder a todo desde una app Android nativa.

---

**Fin del prompt maestro.**

> Al recibir este documento, actúa como un desarrollador senior full-stack especializado en Laravel + Filament + Kotlin. Genera código listo para producción, coherente con la arquitectura descrita, y pregunta solo cuando falte información crítica.

---

## 🆕 MÓDULO CAMPAÑA

> Módulo en desarrollo que convierte el mapa estratégico de la campaña
> (`mapa-campana-pinto-pichincha.md`) en una herramienta viva dentro de Filament.

### Objetivo

Gestionar el avance de la campaña desde el panel administrativo:

1. Consultar el documento maestro de campaña (solo `super_admin`)
2. Trackear avances por fase y semana
3. Visualizar KPIs con charts y tableros
4. Gestionar contactos, validadores, eventos, piezas e incidentes
5. Compartir KPIs según el rol del usuario

### Estado actual

- **Estado:** ✅ Completado y desplegado en producción
- **Inicio:** 20 sep 2026
- **Deploy al VPS:** 21 sep 2026
- **Changelog:** ver `CHANGELOG_MODULO_CAMPANA.md`
- **Rama:** fusionada a `main`

### Arquitectura del módulo

FILAMENT /admin
│
├── 📊 Dashboard de Campaña (widgets)
│ ├── KPI Overview (cards)
│ ├── Chart: Alcance semanal
│ ├── Chart: Progreso por fase
│ └── Chart: Contactos por zona
│
├── 📁 Campaña (grupo de navegación)
│ ├── 📄 Documento Maestro (visor .md)
│ ├── 🎯 Semanas del Plan
│ ├── ✅ Tareas
│ ├── 👥 Contactos
│ ├── ⭐ Validadores
│ ├── 📍 Zonas
│ ├── 🎪 Eventos de Campaña
│ ├── 📸 Piezas Publicadas
│ ├── 📊 KPIs Semanales
│ └── ⚠️ Incidentes
│
└── ⚙️ Configuración (solo super_admin)

### Widgets del dashboard (4)

| Widget                   | Permiso                         | Descripción                       |
| ------------------------ | ------------------------------- | --------------------------------- |
| `KpiOverviewWidget`      | `widget_KpiOverviewWidget`      | Tarjetas de KPIs con modal inline |
| `AlcanceSemanalChart`    | `widget_AlcanceSemanalChart`    | Gráfico de líneas                 |
| `ProgresoFasesChart`     | `widget_ProgresoFasesChart`     | Gráfico de barras apiladas        |
| `DistribucionZonasChart` | `widget_DistribucionZonasChart` | Gráfico de dona                   |

### Sistema de avances diarios

- **Tabla `avances_kpi`:** registra el avance de cada día.
- **Observer `AvanceKpiObserver`:** recalcula automáticamente el valor total del KPI semanal.
- **Modal inline en `KpiOverviewWidget`:** permite registrar el avance sin salir del dashboard.
- **Constraint único:** un solo avance por KPI por día.

### Acceso al Documento Maestro

El `DocumentoCampanaResource` (`/admin/documento-maestro`) ya **no usa `canAccess()` hardcodeado**. Su acceso se controla exclusivamente con permisos de Shield:

| Permiso                       | Para qué sirve            |
| ----------------------------- | ------------------------- |
| `view_any_documento::campana` | Ver la entrada en el menú |
| `view_documento::campana`     | Ver el detalle            |
| `update_documento::campana`   | Editar el documento       |

**Asignación por rol (estado actual en producción):**

- `super_admin`: todos (vía `Permission::all()`)
- `coordinador`: `view_any` + `view` + `update`
- `editor`: `view_any` + `view`
- `publicista` y `colaborador`: sin acceso

**Importante:** el `CampanaRolePermissionsSeeder` documenta estos permisos como referencia en el repo, pero **NO se ejecuta en el VPS** para no sobrescribir la configuración manual de roles en producción.

### Tablas del módulo (11)

| Tabla               | Propósito                                       |
| ------------------- | ----------------------------------------------- |
| `zonas`             | Cantones y parroquias con prioridad             |
| `semanas_plan`      | S1 a S7 + Cierre + Oficial + Silencio           |
| `tareas`            | Tareas operativas                               |
| `contactos`         | Base de contactos captados (con consentimiento) |
| `validadores`       | Líderes locales que apoyan la campaña           |
| `eventos_campana`   | Eventos de campo con métricas                   |
| `piezas_contenido`  | Piezas publicadas en redes                      |
| `kpis_semanales`    | KPIs por semana con meta/valor                  |
| `incidentes`        | Ataques, desinformación, crisis                 |
| `documento_campana` | Versiones del mapa estratégico (markdown)       |

### Tablas del Módulo Campaña (11)

#### `zonas`

`id`, `canton`, `parroquia`, `prioridad` (alta/media/baja), `notas`, `timestamps`

#### `semanas_plan`

`id`, `codigo` (S1-S7, Cierre, Oficial, Silencio), `fecha_inicio`, `fecha_fin`, `fase`, `objetivo`, `estado`, `timestamps`

#### `tareas`

`id`, `titulo`, `descripcion`, `fase`, `semana_id` (FK), `responsable_id` (FK), `fecha_limite`, `estado`, `prioridad`, `orden`, `timestamps`

#### `contactos`

`id`, `nombre`, `telefono`, `email`, `zona_id` (FK), `origen`, `consentimiento`, `capturado_por` (FK), `fecha_consentimiento`, `consentimiento_verbal`, `notas`, `timestamps`

#### `validadores`

`id`, `nombre`, `cargo`, `telefono`, `zona_id` (FK), `estado`, `fecha_apoyo`, `notas`, `timestamps`

#### `eventos_campana`

`id`, `titulo`, `fecha`, `zona_id` (FK), `descripcion`, `contactos_captados`, `piezas_publicadas`, `estado`, `timestamps`

#### `piezas_contenido`

`id`, `fecha`, `formato` (reel/post/story/video/carrusel), `mensaje`, `zona_id` (FK), `estado`, `alcance`, `interacciones`, `url`, `timestamps`

#### `kpis_semanales`

`id`, `semana_id` (FK), `kpi` (contactos/validadores/suscriptores/alcance/eventos), `valor`, `meta`, `notas`, `timestamps`
**Constraint:** unique (semana_id, kpi)

#### `avances_kpi`

`id`, `kpi_semanal_id` (FK), `fecha`, `valor`, `notas`, `created_by` (FK), `timestamps`
**Constraint:** unique (kpi_semanal_id, fecha)

#### `incidentes`

`id`, `fecha`, `tipo` (ataque/desinformacion/crisis/otro), `descripcion`, `respuesta`, `estado`, `timestamps`

#### `documento_campana`

`id`, `titulo`, `contenido` (markdown), `version`, `updated_by` (FK), `timestamps`

### Roles y permisos

| Rol           | Permisos | Descripción                                                                    |
| ------------- | -------- | ------------------------------------------------------------------------------ |
| `super_admin` | 246      | Todo el sistema                                                                |
| `coordinador` | 93       | Campaña completa + frontend + Documento Maestro (lectura y edición)            |
| `editor`      | 46       | Contenido, tareas, eventos, piezas, avances + Documento Maestro (solo lectura) |
| `publicista`  | 15       | Solo piezas de contenido                                                       |
| `colaborador` | 20       | Captación (contactos, avances) + lectura                                       |

### Fases de implementación

- [x] **Fase 1** — Estructura base (11 tablas, 10 modelos, 6 seeders)
- [x] **Fase 2** — Recursos Filament (11 Resources)
- [x] **Fase 3** — Documento + Eventos + Piezas + Incidentes
- [x] **Fase 4** — Dashboard + Widgets + Charts + Roles (Shield)
- [x] **Fase 5** — Deploy al VPS + Orden del menú

### Reglas del módulo

1. El desarrollo NO compite con la campaña. Máximo 8 h/semana.
2. Prioridad 1: campaña. Prioridad 2: herramienta.
3. Cada fase se completa, prueba y hace commit antes de pasar a la siguiente.
4. El `CHANGELOG_MODULO_CAMPANA.md` se actualiza en cada sesión.
5. Los datos sensibles (contactos, validadores) requieren consentimiento explícito.
