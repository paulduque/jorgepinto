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
- **MySQL 8**
- **Filament 3.3** (panel admin)
- **Laravel Sanctum** (tokens API)
- **Spatie Laravel Permission** (roles y permisos)
- **Spatie Laravel Sluggable** (slugs automáticos)
- **BezhanSalleh Filament Shield** (permisos en Filament)
- **Saade Filament FullCalendar** (calendario)

### Frontend

- **Blade templates**
- **Tailwind CSS** (colores personalizados)
- **Alpine.js**
- **Vite** (build de assets)

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

## 📁 ESTRUCTURA DE ARCHIVOS

```
sitio/
├── app/
│   ├── Filament/
│   │   ├── Pages/ (Calendar, Auth/Register)
│   │   ├── Resources/ (EventResource, NewsResource, MomentResource, SiteSettingResource, UserResource, ContactMessageResource)
│   │   └── Widgets/ (AgendaWidget, LatestNewsWidget, QuickActionsWidget, CalendarWidget, NewMessagesWidget, SiteStatsOverview)
│   ├── Http/Controllers/
│   │   ├── Api/AgendaController.php
│   │   ├── HomeController.php
│   │   ├── NewsController.php
│   │   └── ContactController.php
│   └── Models/ (Event, News, Moment, SiteSetting, ContactMessage, User)
├── database/migrations/
├── resources/
│   ├── css/app.css
│   ├── js/app.js
│   └── views/
│       ├── layouts/app.blade.php
│       ├── components/ (header, footer, ...)
│       ├── home.blade.php
│       ├── news/
│       ├── agenda/
│       └── contact/
├── routes/
│   ├── web.php
│   └── api.php
└── .env
```

---

## 🚀 DEPLOY EN VPS

```bash
ssh root@webplusec
cd /home/jorgepinto.ec/laravel

# 1. Verificar estado
git status

# 2. Si hay cambios locales:
# git stash

# 3. Traer cambios
git pull origin main

# 4. Restaurar (si se hizo stash)
# git stash pop

# 5. Migraciones (si las hay)
php artisan migrate --force

# 6. Limpiar cachés
php artisan optimize:clear
php artisan filament:cache-components

# 7. Permisos
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
