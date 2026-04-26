# IDCBIS CMS - Sistema de Gestión de Contenido

## Estructura del Proyecto

Sistema CMS Drag & Drop desarrollado con **Laravel 12 + Vue 3 + Tailwind CSS**.

### Características

- ✅ Editor visual Drag & Drop para páginas
- ✅ Gestión de roles y permisos (Spatie)
- ✅ Autenticación con Sanctum
- ✅ Componentes reutilizables (Hero, Cards, Text, Gallery, etc.)
- ✅ API RESTful completa
- ✅ Panel de administración moderno

### Componentes Disponibles

- **Hero Section**: Banner principal con título, subtítulo y CTA
- **Text Section**: Bloque de texto con formato HTML
- **Cards Section**: Tarjetas con imagen, título y descripción
- **Image Section**: Imagen individual con pie de foto
- **Gallery Section**: Galería de imágenes
- **Button Section**: Botones con estilos personalizables

### Instalación

```bash
# 1. Instalar dependencias PHP
composer install

# 2. Configurar entorno
copy .env.example .env
php artisan key:generate

# 3. Configurar base de datos en .env
DB_DATABASE=idcbis_cms
DB_USERNAME=root
DB_PASSWORD=

# 4. Ejecutar migraciones y seeders
php artisan migrate --seed

# 5. Instalar dependencias Node.js
npm install

# 6. Compilar assets
npm run build

# 7. Iniciar servidor
php artisan serve
```

### Accesos por defecto

- **Admin**: `admin@idcbis.org.co` / `Admin123!`

### Estructura de archivos

```
app/
├── Http/Controllers/Api/
│   ├── AuthController.php
│   └── PageController.php
└── Models/
    ├── Page.php
    ├── Section.php
    └── Block.php

database/
├── migrations/
│   ├── 2024_01_01_000001_create_pages_table.php
│   ├── 2024_01_01_000002_create_sections_table.php
│   └── 2024_01_01_000003_create_blocks_table.php
└── seeders/
    └── RolesAndPermissionsSeeder.php

resources/
├── js/
│   ├── App.vue
│   ├── app.js
│   ├── router/
│   │   └── index.js
│   ├── stores/
│   │   ├── auth.js
│   │   └── cms.js
│   ├── components/
│   │   ├── layout/
│   │   │   ├── Header.vue
│   │   │   ├── Footer.vue
│   │   │   └── MainLayout.vue
│   │   ├── sections/
│   │   │   ├── HeroSection.vue
│   │   │   ├── TextSection.vue
│   │   │   ├── CardsSection.vue
│   │   │   ├── ImageSection.vue
│   │   │   ├── GallerySection.vue
│   │   │   └── ButtonSection.vue
│   │   └── editor/
│   │       └── SectionProperties.vue
│   └── views/
│       ├── Home.vue
│       ├── Page.vue
│       ├── auth/
│       │   └── Login.vue
│       └── admin/
│           ├── AdminLayout.vue
│           ├── Dashboard.vue
│           ├── Pages.vue
│           ├── PageEditor.vue
│           ├── Users.vue
│           └── Roles.vue
└── views/
    └── app.blade.php
```

### Rutas API

| Método | Endpoint | Descripción |
|--------|----------|-------------|
| POST | /api/login | Iniciar sesión |
| POST | /api/logout | Cerrar sesión |
| GET | /api/user | Obtener usuario actual |
| GET | /api/pages | Listar páginas |
| POST | /api/pages | Crear página |
| GET | /api/pages/{id} | Ver página |
| PUT | /api/pages/{id} | Actualizar página |
| DELETE | /api/pages/{id} | Eliminar página |
| PATCH | /api/pages/{id}/publish | Publicar página |
| GET | /api/pages/slug/{slug} | Ver página por slug (público) |

### Roles y Permisos

- **admin**: Acceso completo al sistema
- **editor**: Crear, editar y publicar páginas
- **viewer**: Solo ver páginas

### Próximos pasos

1. Ejecutar `npm install` para instalar dependencias Vue
2. Configurar colores de IDCBIS en Tailwind
3. Crear página de inicio de ejemplo
4. Configurar almacenamiento de imágenes
