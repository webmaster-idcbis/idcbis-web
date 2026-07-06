# Checklist de usabilidad y accesibilidad — IDCBIS

Usar al crear o revisar interfaces. Nivel objetivo: **WCAG 2.1 AA** (sitio institucional público).

## 1. Percepción

- [ ] **Contraste**: texto normal ≥ 4.5:1; texto grande (≥18px o 14px bold) ≥ 3:1.
- [ ] **Color no es la única señal**: estados (error, activo, requerido) tienen icono, texto o patrón además de color.
- [ ] **Imágenes**: `alt` descriptivo; decorativas → `alt=""` o `aria-hidden`.
- [ ] **Texto sobre gradiente**: verificar legibilidad en todo el rango del gradiente (Header, heroes).
- [ ] **Redimensionado**: contenido usable hasta 200% zoom sin pérdida de funcionalidad.

## 2. Operabilidad

- [ ] **Teclado**: toda funcionalidad alcanzable con Tab, Enter, Space, Escape.
- [ ] **Focus visible**: nunca `outline: none` sin reemplazo (`:focus-visible`, `focus:ring-[#005674]`).
- [ ] **Touch targets**: mínimo 44×44 px en móvil (botones nav, carrusel, acordeón).
- [ ] **Sin trampas de foco** salvo modales (admin) con cierre por Escape.
- [ ] **Skip link**: considerar en mejoras futuras al layout (`MainLayout.vue`).

### Componentes interactivos

| Componente | Verificar |
|------------|-----------|
| Acordeón (`AccordionElement`, FAQ) | `aria-expanded`, `aria-controls`, id único por panel |
| Carrusel (`IdcbisHeroCarouselElement`, `CarouselElement`) | `aria-label` en prev/next/indicators; pausa con hover/focus |
| Menú mobile (`Header.vue`) | `aria-expanded` en toggle (ya presente); cerrar al navegar |
| Búsqueda (`SiteSearch.vue`) | `aria-label` en limpiar; resultados anunciables |
| Documentos (`IdcbisDocumentsListElement`) | `aria-label` en nav y búsqueda (referencia buena) |
| Modales admin | `aria-modal`, `aria-labelledby`, devolver foco al cerrar |

## 3. Comprensión

- [ ] **Lenguaje claro** en español; evitar siglas sin explicar en páginas públicas.
- [ ] **Jerarquía de headings**: un solo `h1` por vista; no saltar niveles (h2 → h4).
- [ ] **Enlaces**: texto descriptivo ("Formulario de contacto →"), no solo "clic aquí".
- [ ] **Formularios**: label visible; placeholder no sustituye label.
- [ ] **Mensajes de error**: específicos ("El email es obligatorio"), no genéricos.
- [ ] **Consistencia**: mismos patrones en Header, Footer y bloques idcbis.

## 4. Robustez

- [ ] **HTML semántico**: `header`, `main`, `footer`, `nav`, `section`, `button`.
- [ ] **Vue**: preferir `<router-link>` para navegación interna, `<a>` para externos.
- [ ] **Headless UI**: usar componentes accesibles cuando aplique (`@headlessui/vue`).
- [ ] **Validación**: inputs con `type` correcto (`email`, `tel`).

## 5. Responsive

- [ ] **Mobile-first**: probar 320px, 375px, 768px, 1024px.
- [ ] **Sin overflow-x** no intencional.
- [ ] **Menú mobile** usable; búsqueda accesible en móvil.
- [ ] **Tablas** (`TableElement`): scroll horizontal o stack en móvil si es necesario.
- [ ] **Grids idcbis**: verificar `repeat(auto-fit, minmax(...))` y breakpoints `@900px`.

## 6. Motion y animación

- [ ] Respetar `prefers-reduced-motion: reduce` en:
  - Transiciones acordeón (`max-height`, chevron)
  - Autoplay carrusel (`autoPlay`, `interval` en hero)
  - Hover `transform` en formularios/tarjetas
- [ ] Autoplay no esencial: permitir pausar o desactivar en prefers-reduced-motion.

## 7. CMS / editor

- [ ] Cambios en elementos no rompen vista **preview** vs **editor**.
- [ ] Props `element` serializables (sin funciones) para guardar en API.
- [ ] `blockLabel` descriptivo para editores de contenido.
- [ ] Colores editables en panel respetan contraste mínimo por defecto.

## 8. Rendimiento percibido

- [ ] Spinner de carga con color institucional (`border-[#005674]`).
- [ ] `font-display: swap` ya configurado en fuentes — no bloquear render.
- [ ] Imágenes hero: dimensiones razonables; `loading="lazy"` fuera del fold.

## 9. Institucional / confianza

- [ ] Datos de contacto visibles y coherentes (Footer vs bloques contacto).
- [ ] Logos con alt institucional y variante correcta según fondo (`IDCBIS_BRAND_LOGO` vs `IDCBIS_BRAND_LOGO_ON_BLUE` en `siteLogos.js`).
- [ ] Enlaces de transparencia accesibles desde Footer.
- [ ] Copyright y mapa del sitio en pie de página.

## Plantilla de revisión rápida

```markdown
## Revisión UI — [componente/página]

### Crítico
- ...

### Mejora
- ...

### Opcional
- ...

### Contraste verificado
- [ ] Texto principal
- [ ] Links / CTAs
- [ ] Estados focus
```
