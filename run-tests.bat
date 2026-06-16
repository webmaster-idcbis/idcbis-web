@echo off
chcp 65001 >nul
echo ╔══════════════════════════════════════════════════════════╗
echo ║           IDCBIS CMS - PLAN DE PRUEBAS                   ║
echo ╚══════════════════════════════════════════════════════════╝
echo.

:: Verificar si estamos en el directorio correcto
if not exist "artisan" (
    echo ❌ Error: No se encontró artisan. Ejecuta desde la raíz del proyecto.
    exit /b 1
)

echo 📋 PASO 1: Preparando base de datos de prueba...
echo ─────────────────────────────────────────────────────────
php artisan migrate:fresh --env=testing --force
if %errorlevel% neq 0 (
    echo ❌ Error en migraciones
    exit /b 1
)
echo ✅ Migraciones completadas

:: Ejecutar tests de API
echo.
echo 🧪 PASO 2: Ejecutando Tests de API - Menús
echo ─────────────────────────────────────────────────────────
php artisan test --filter=MenuApiTest --testdox
if %errorlevel% neq 0 (
    echo ❌ Tests de Menús fallaron
) else (
    echo ✅ Tests de Menús aprobados
)

echo.
echo 🧪 PASO 3: Ejecutando Tests de API - SEO
echo ─────────────────────────────────────────────────────────
php artisan test --filter=PageSeoTest --testdox
if %errorlevel% neq 0 (
    echo ❌ Tests de SEO fallaron
) else (
    echo ✅ Tests de SEO aprobados
)

echo.
echo 🧪 PASO 4: Ejecutando Tests de API - Plantillas
echo ─────────────────────────────────────────────────────────
php artisan test --filter=PageTemplateTest --testdox
if %errorlevel% neq 0 (
    echo ❌ Tests de Plantillas fallaron
) else (
    echo ✅ Tests de Plantillas aprobados
)

echo 🧪 PASO 5: Ejecutando Tests de API - Búsqueda
echo ─────────────────────────────────────────────────────────
php artisan test --filter=SearchTest --testdox
if %errorlevel% neq 0 (
    echo ❌ Tests de Búsqueda fallaron
) else (
    echo ✅ Tests de Búsqueda aprobados
)

echo.
echo 🧪 PASO 6: Todos los tests de Feature
echo ─────────────────────────────────────────────────────────
php artisan test --filter=Feature --testdox

:: Mostrar resumen
echo.
echo ╔══════════════════════════════════════════════════════════╗
echo ║                    RESUMEN                               ║
echo ╚══════════════════════════════════════════════════════════╝
echo.
echo Para pruebas manuales del frontend:
echo   1. Inicia el servidor: php artisan serve
echo   2. Compila assets: npm run dev
echo   3. Accede a: http://localhost:8000/admin/menus
echo   4. Accede a: http://localhost:8000/admin/pages/create
echo.
echo Para ejecutar tests individuales:
echo   php artisan test --filter=test_can_create_menu_header
echo   php artisan test --filter=test_can_create_page_with_seo_fields
echo.

pause
