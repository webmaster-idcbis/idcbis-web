# 📋 Guía de Ejecución de Pruebas - IDCBIS CMS

## 🚀 Paso a Paso Completo

---

## **PASO 1: Preparar Entorno**

Abre **Laragon Terminal** o **CMD** en la carpeta del proyecto:

```bash
cd c:\laragon\www\idcbis-web
```

Verifica que todo esté en orden:
```bash
php artisan --version
npm --version
```

---

## **PASO 2: Ejecutar Migraciones y Seeders**

```bash
# Base de datos principal
php artisan migrate:fresh --seed

# Base de datos de testing (si quieres probar ahí)
php artisan migrate:fresh --env=testing
```

---

## **PASO 3: Tests Backend (PHPUnit)**

### Opción A: Script Automatizado (Windows)
```bash
run-tests.bat
```

### Opción B: Manual - Todos los tests
```bash
php artisan test
```

### Opción C: Tests específicos
```bash
# Solo tests de Menús
php artisan test --filter=MenuApiTest

# Solo tests de SEO
php artisan test --filter=PageSeoTest

# Solo tests de Feature
php artisan test --filter=Feature

# Con formato detallado
php artisan test --filter=MenuApiTest --testdox
```

### Opción D: Tests individuales
```bash
# Test específico
php artisan test --filter=test_can_create_menu_header
php artisan test --filter=test_can_create_page_with_seo_fields
```

**Resultado esperado:** ✅ Todos los tests verdes

---

## **PASO 4: Iniciar Servidor y Compilar Assets**

### Terminal 1 - Servidor Laravel:
```bash
php artisan serve
```

### Terminal 2 - Vite/NPM (nueva terminal):
```bash
cd c:\laragon\www\idcbis-web
npm run dev
```

Espera a que aparezca: `VITE v4.x ready in xxx ms`

---

## **PASO 5: Tests Frontend Cypress (E2E)**

### Instalar Cypress (solo primera vez):
```bash
npm install -D cypress
```

### Opción A: Interfaz Gráfica (recomendado)
```bash
npx cypress open
```

Se abre ventana de Cypress:
1. Click **"E2E Testing"**
2. Selecciona navegador (Chrome)
3. Click **"Start E2E Testing"**
4. Selecciona spec:
   - `admin-menus.spec.js`
   - `page-editor.spec.js`

### Opción B: Modo Headless (CI/CD)
```bash
# Todos los tests
npx cypress run

# Spec específico
npx cypress run --spec "cypress/integration/admin-menus.spec.js"
npx cypress run --spec "cypress/integration/page-editor.spec.js"
```

---

## **PASO 6: Pruebas Manuales en Navegador**

Abre: `http://localhost:8000`

### 6.1 Test de Autenticación
- [ ] Login con credenciales válidas
- [ ] Login con credenciales inválidas (error)
- [ ] Logout

### 6.2 Test de Menús
- [ ] Ir a `/admin/menus`
- [ ] Crear menú Header
- [ ] Crear menú Footer
- [ ] Agregar 2+ items a cada menú
- [ ] Editar menú existente
- [ ] Eliminar menú
- [ ] Verificar modo oscuro en tabla y modal

### 6.3 Test de SEO en Páginas
- [ ] Ir a `/admin/pages/create`
- [ ] Completar campos SEO:
  - Meta Title: "Test SEO Title"
  - Meta Keywords: "test, keywords, seo"
  - Meta Description: "Descripción de prueba"
  - OG Image: `https://via.placeholder.com/1200x630`
  - Canonical URL: `http://localhost:8000/test-page`
  - No Index: ✅ (marcar)
- [ ] Agregar sección Hero
- [ ] Guardar página
- [ ] Recargar y verificar persistencia

### 6.4 Test de Vista Previa
- [ ] Crear página con slug "test-preview"
- [ ] Verificar botón "Vista Previa" visible
- [ ] Click en botón → abre nueva pestaña
- [ ] Verificar URL: `/test-preview`

### 6.5 Test de Modo Oscuro
- [ ] Activar modo oscuro (toggle en AdminLayout)
- [ ] Verificar colores:
  - Header: fondo oscuro `#161b22`
  - Texto: `#e6edf3`
  - Bordes: `#30363d`
  - Canvas: `#0f1419`
- [ ] Navegar a Menús (debe mantener modo oscuro)
- [ ] Recargar página (debe persistir)

---

## **PASO 7: Verificar API Endpoints**

Con Postman o navegador:

```bash
# 1. Login y obtener token
POST http://localhost:8000/api/login
Body: {"email": "admin@test.com", "password": "password"}

# 2. Listar menús (con token)
GET http://localhost:8000/api/menus
Authorization: Bearer {token}

# 3. Crear menú
POST http://localhost:8000/api/menus
Body: {
  "name": "Test Menú",
  "location": "header",
  "items": [{"type": "url", "title": "Google", "url": "https://google.com", "target": "_blank", "order": 0}],
  "is_active": true,
  "order": 1
}

# 4. Menús públicos (sin auth)
GET http://localhost:8000/api/menus/public

# 5. Páginas disponibles
GET http://localhost:8000/api/menus/available-pages

# 6. Crear página con SEO
POST http://localhost:8000/api/pages
Body: {
  "title": "API Test",
  "slug": "api-test",
  "status": "published",
  "meta_title": "API Meta Title",
  "meta_description": "API Description",
  "meta_keywords": "api, test",
  "og_image": "https://test.com/image.jpg",
  "no_index": false,
  "canonical_url": "https://test.com/canonical",
  "sections": []
}
```

---

## **PASO 8: Tests de Integración**

### Verificar Menús en Frontend Público:
```bash
# Crear menú header con items
# Ir a homepage y verificar que renderiza
GET http://localhost:8000/
```

### Verificar Meta Tags SEO:
```bash
# Crear página publicada con SEO
# Ir a la página y verificar HTML:
GET http://localhost:8000/{slug}

# Verificar en HTML:
<title>{meta_title}</title>
<meta name="description" content="{meta_description}">
<meta name="keywords" content="{meta_keywords}">
<meta property="og:image" content="{og_image}">
<meta name="robots" content="noindex"> (si no_index=true)
<link rel="canonical" href="{canonical_url}">
```

---

## **RESUMEN EJECUCIÓN RÁPIDA**

```bash
# 1. Preparar DB
php artisan migrate:fresh --seed

# 2. Tests Backend
php artisan test --filter=Feature

# 3. Iniciar servidores (2 terminales)
php artisan serve
npm run dev

# 4. Tests E2E
npx cypress open

# 5. Pruebas manuales en: http://localhost:8000
```

---

## **✅ CHECKLIST FINAL**

| Módulo | Test | Estado |
|--------|------|--------|
| Backend API | MenuApiTest | ⬜ |
| Backend API | PageSeoTest | ⬜ |
| Frontend E2E | admin-menus.spec.js | ⬜ |
| Frontend E2E | page-editor.spec.js | ⬜ |
| Manual | Crear/Editar/Eliminar menús | ⬜ |
| Manual | SEO fields persisten | ⬜ |
| Manual | Vista previa funciona | ⬜ |
| Manual | Modo oscuro aplicado | ⬜ |
| Integración | Menús renderizan en frontend | ⬜ |
| Integración | Meta tags en HTML | ⬜ |

**Total:** 10 pruebas exitosas = ✅ **SISTEMA LISTO**

---

## **❌ SOLUCIÓN DE PROBLEMAS**

### Error: "Column already exists"
```bash
php artisan migrate:fresh --seed
```

### Error: "Permission denied"
```bash
# Windows - CMD como Administrador
# o usar Laragon Terminal
```

### Error: "VITE not found"
```bash
npm install
npm run dev
```

### Error: "Database not found"
```bash
# Crear base de datos manualmente en phpMyAdmin
# o usar: php artisan db:create idcbis_cms
```

### Error: "Port 8000 in use"
```bash
php artisan serve --port=8080
```

---

## **📞 COMANDOS ÚTILES**

```bash
# Ver rutas API
php artisan route:list | findstr api

# Limpiar caché
php artisan cache:clear
php artisan config:clear

# Ver logs
php artisan serve &
tail -f storage/logs/laravel.log

# Compilar producción
npm run build
```
