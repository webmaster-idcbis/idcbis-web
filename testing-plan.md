# Plan de Pruebas - IDCBIS CMS

## Resumen
Plan completo para validar funcionalidades: Vista Previa, Menús, SEO y Modo Oscuro.

---

## 1. Pruebas de API - Menús

### 1.1 CRUD Básico de Menús
```bash
# Obtener token de autenticación primero
POST /api/login
Body: { "email": "admin@test.com", "password": "password" }
```

#### Test 1.1.1: Crear Menú Header
```http
POST /api/menus
Headers: Authorization: Bearer {token}
Content-Type: application/json

Body:
{
  "name": "Menú Principal",
  "location": "header",
  "items": [
    {
      "type": "page",
      "title": "Inicio",
      "page_id": 1,
      "url": "/",
      "target": "_self",
      "order": 0
    },
    {
      "type": "url",
      "title": "Contacto Externo",
      "url": "https://externo.com",
      "target": "_blank",
      "order": 1
    }
  ],
  "is_active": true,
  "order": 1
}

# Respuesta esperada: 201 Created
# Verificar: Estructura JSON con data.id
```

#### Test 1.1.2: Crear Menú Footer
```http
POST /api/menus
Body:
{
  "name": "Enlaces Footer",
  "location": "footer",
  "items": [
    {
      "type": "page",
      "title": "Políticas",
      "page_id": 2,
      "url": "/politicas",
      "target": "_self",
      "order": 0
    }
  ],
  "is_active": true,
  "order": 1
}
```

#### Test 1.1.3: Listar Menús
```http
GET /api/menus
Headers: Authorization: Bearer {token}

# Respuesta esperada: 200 OK
# Verificar: Array con estructura correcta
# Validar campos: id, name, location, items (JSON), is_active, order
```

#### Test 1.1.4: Actualizar Menú
```http
PUT /api/menus/{id}
Body:
{
  "name": "Menú Principal Actualizado",
  "items": [...],
  "is_active": true
}

# Verificar: items se guarda como JSON válido
```

#### Test 1.1.5: Eliminar Menú
```http
DELETE /api/menus/{id}

# Respuesta esperada: 204 No Content
# Verificar: GET /api/menus/{id} retorna 404
```

### 1.2 API Pública de Menús
```http
GET /api/menus/public

# Respuesta esperada: 200 OK
# Verificar:
# - Solo menús is_active = true
# - URLs resueltas correctamente
# - Items ordenados por campo order
# - Páginas no publicadas excluidas
```

### 1.3 Páginas Disponibles
```http
GET /api/menus/available-pages

# Respuesta esperada: Lista de páginas publicadas
# Verificar: Solo status = 'published'
```

---

## 2. Pruebas de API - SEO en Páginas

### 2.1 Crear Página con SEO
```http
POST /api/pages
Headers: Authorization: Bearer {token}

Body:
{
  "title": "Página de Prueba SEO",
  "slug": "pagina-seo-test",
  "status": "published",
  "meta_title": "Título SEO Personalizado",
  "meta_description": "Descripción para SEO con máximo 160 caracteres",
  "meta_keywords": "keyword1, keyword2, keyword3",
  "og_image": "https://ejemplo.com/imagen.jpg",
  "no_index": false,
  "canonical_url": "https://sitio.com/pagina-canonical",
  "sections": []
}

# Respuesta esperada: 201 Created
# Verificar: Todos los campos SEO retornados en response
```

### 2.2 Actualizar Campos SEO
```http
PUT /api/pages/{id}
Body:
{
  "meta_title": "Nuevo título SEO",
  "meta_description": "Nueva descripción",
  "no_index": true
}

# Verificar: Cambios persistidos en base de datos
```

### 2.3 Validación de Campos SEO
```http
POST /api/pages
Body: { "meta_title": "a".repeat(71) }

# Esperado: 422 Unprocessable Entity
# Validar: max:70 para meta_title
```

---

## 3. Pruebas de Frontend - Menús Admin

### 3.1 Lista de Menús
- [ ] Acceder a `/admin/menus`
- [ ] Verificar: Tabla carga datos correctamente
- [ ] Verificar: Columnas Name, Location, Items count, Status, Order
- [ ] Verificar: Botones Editar/Eliminar por fila

### 3.2 Crear Menú Header
- [ ] Click "Nuevo Menú"
- [ ] Completar:
  - Name: "Menú Test Header"
  - Location: "header"
  - Agregar 2 items (1 page + 1 URL externa)
  - Order: 1
  - is_active: true
- [ ] Click Guardar
- [ ] Verificar: Redirección a lista y mensaje de éxito

### 3.3 Validaciones de Formulario
- [ ] Intentar guardar sin nombre → Error requerido
- [ ] Intentar URL inválida → Error formato
- [ ] Orden negativo → Error

### 3.4 Editar Menú
- [ ] Click Editar en menú existente
- [ ] Modificar items (reordenar, eliminar, agregar)
- [ ] Guardar
- [ ] Verificar cambios persistidos

### 3.5 Eliminar Menú
- [ ] Click Eliminar
- [ ] Confirmar modal
- [ ] Verificar: Item desaparece de lista

### 3.6 Switch Location
- [ ] Cambiar entre Header/Footer
- [ ] Verificar: Items se mantienen

---

## 4. Pruebas de Frontend - PageEditor

### 4.1 Modo Claro/Oscuro
- [ ] Cargar `/admin/pages/create`
- [ ] Activar modo oscuro (toggle en AdminLayout)
- [ ] Verificar colores:
  - Header: `#161b22` fondo
  - Textos: `#e6edf3`
  - Bordes: `#30363d`
  - Canvas: `#0f1419`

### 4.2 Campos SEO
- [ ] Crear nueva página
- [ ] Completar SEO fields:
  - Meta Title: "Test Title"
  - Meta Keywords: "test, keywords"
  - Meta Description: "Test description"
  - OG Image: URL válida
  - Canonical URL: URL válida
  - No Index: true
- [ ] Guardar
- [ ] Recargar página
- [ ] Verificar: Todos los campos persistidos

### 4.3 Vista Previa
- [ ] Crear página con slug "test-preview"
- [ ] Verificar: Botón "Vista Previa" aparece
- [ ] Click botón → Abre en nueva pestaña `/{slug}`
- [ ] Sin slug → Botón oculto

### 4.4 Sidebar Componentes
- [ ] Verificar: Lista de componentes visible
- [ ] Verificar: Drag & drop funciona
- [ ] Verificar: Click agrega componente
- [ ] Toggle sidebar: Botón funciona

### 4.5 Propiedades de Sección
- [ ] Agregar Hero Section
- [ ] Click en sección → Panel derecho activo
- [ ] Verificar: Campos con modo oscuro
- [ ] Modificar propiedades:
  - Background color
  - Padding
  - Text align
  - Border
- [ ] Verificar: Cambios aplicados en canvas

### 4.6 Controles de Sección
- [ ] Verificar botones por sección:
  - Mover arriba/abajo
  - Duplicar
  - Eliminar
- [ ] Verificar: Modo oscuro en botones

---

## 5. Pruebas de Integración

### 5.1 Menú en Frontend Público
```
# Pre-requisito: Menú header creado con items

GET /

# Verificar:
# - Menú renderizado en header
# - Links funcionan correctamente
# - Target _blank abre nueva pestaña
# - Páginas no publicadas no aparecen
```

### 5.2 SEO Meta Tags
```
# Pre-requisito: Página con campos SEO

GET /{slug}

# Verificar en HTML:
# <title>{meta_title || title}</title>
# <meta name="description" content="{meta_description}">
# <meta name="keywords" content="{meta_keywords}">
# <meta property="og:image" content="{og_image}">
# <link rel="canonical" href="{canonical_url}">
# <meta name="robots" content="noindex"> (si no_index=true)
```

---

## 6. Pruebas de Validación

### 6.1 Validaciones Backend
| Campo | Regla | Prueba |
|-------|-------|--------|
| menu.name | required, string, max:255 | Enviar vacío, null, 300 chars |
| menu.location | required, in:header,footer | Enviar 'sidebar' |
| menu.items | required, array | Enviar string |
| menu.items.*.title | required | Omitir título |
| menu.items.*.type | required, in:page,url | Enviar 'invalid' |
| menu.items.*.url | required_if:type,url | Type=url sin URL |
| menu.order | integer, min:0 | Enviar -1 |
| page.meta_title | string, max:70 | 71 caracteres |
| page.meta_description | string, max:160 | 161 caracteres |
| page.canonical_url | url, nullable | URL inválida |
| page.no_index | boolean | Enviar string |

### 6.2 Permisos y Autenticación
```http
# Sin token
GET /api/menus
# Esperado: 401 Unauthorized

# Token inválido
GET /api/menus
Headers: Authorization: Bearer invalid
# Esperado: 401

# Usuario sin permisos
POST /api/menus
# Esperado: 403 Forbidden
```

---

## 7. Pruebas de Rendimiento

### 7.1 Carga de Menús
```bash
# 100 requests concurrentes
ab -n 100 -c 10 http://localhost/api/menus/public

# Esperado:
# - Tiempo respuesta < 200ms
# - Sin errores 5xx
```

### 7.2 Carga de Editor
- [ ] Página con 20+ secciones
- [ ] Verificar: Sin lag al editar
- [ ] Guardar: < 2 segundos

---

## 8. Pruebas de Edge Cases

### 8.1 Menús
- [ ] Menú con 0 items
- [ ] Menú con 50+ items
- [ ] Item con URL de 2000 caracteres
- [ ] Página vinculada eliminada → ¿qué pasa?
- [ ] Menú duplicado (misma location+order)

### 8.2 SEO
- [ ] Meta tags con HTML (<script>alert(1)</script>)
- [ ] URL canónica con espacios
- [ ] Keywords con caracteres especiales
- [ ] OG Image URL rota

### 8.3 Editor
- [ ] 100 secciones en una página
- [ ] Sección sin propiedades
- [ ] Drag & drop fuera de zona

---

## 9. Checklist de Navegación

- [ ] `/admin/menus` → Lista
- [ ] `/admin/menus` → Modal crear
- [ ] `/admin/menus` → Modal editar
- [ ] `/admin/pages` → Lista
- [ ] `/admin/pages/create` → Editor
- [ ] `/admin/pages/{id}/edit` → Editor con datos
- [ ] `/admin/dashboard` → Acceso rápido a menús
- [ ] Sidebar → Menú Menús visible

---

## 10. Herramientas Recomendadas

### Testing API
```bash
# Postman o curl
# Crear collection con todas las requests

# Laravel Testing
php artisan test --filter=MenuTest
php artisan test --filter=PageSeoTest
```

### Testing Frontend
```bash
# Instalar Cypress
npm install -D cypress

# Tests e2e
cypress/integration/menus.spec.js
cypress/integration/page-editor.spec.js
```

### Testing Visual
```bash
# Lighthouse CI para SEO
lighthouse http://localhost/pagina-test --preset=desktop

# WAVE para accesibilidad
```

---

## Resultados Esperados

| Módulo | Tests | Aprobados | Fallidos |
|--------|-------|-----------|----------|
| API Menús | 15 | 15 | 0 |
| API SEO | 10 | 10 | 0 |
| Frontend Menús | 20 | 20 | 0 |
| Frontend Editor | 25 | 25 | 0 |
| Integración | 5 | 5 | 0 |
| **TOTAL** | **75** | **75** | **0** |

---

## Comandos Rápidos

```bash
# Ejecutar todas las migraciones
php artisan migrate:fresh --seed

# Correr tests
php artisan test

# Ver logs
php artisan serve &
tail -f storage/logs/laravel.log

# Compilar assets
npm run dev
```
