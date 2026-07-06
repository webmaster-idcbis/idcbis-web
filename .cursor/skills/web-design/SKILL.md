---
name: web-design
description: >-
  Aplica usabilidad, accesibilidad (WCAG 2.1 AA), diseño responsive y buenas
  prácticas de UI/UX al crear o modificar interfaces del CMS IDCBIS. Usar al
  diseñar o editar componentes Vue, CSS, layouts, formularios, navegación,
  bloques idcbis, páginas públicas o admin, o cuando el usuario pida mejorar
  UX, usabilidad, diseño visual o accesibilidad.
---

# Diseño web — IDCBIS CMS

Sitio institucional colombiano con **Vue 3 + Tailwind CSS 4 + Laravel**. Priorizar claridad, accesibilidad y consistencia con los patrones ya existentes antes de inventar estilos nuevos.

## Antes de implementar

1. **Reutilizar** componentes en `resources/js/components/` (layout, elements, elements/idcbis).
2. **Consultar tokens** en [idcbis-tokens.md](idcbis-tokens.md) para colores, tipografía y layout.
3. **Seguir patrones Vue** del proyecto en [component-patterns.md](component-patterns.md).
4. **No romper el page builder**: los elementos deben seguir la estructura `element` + props `preview` / `focusedPart` cuando aplique.
5. **Textos en español** y tono institucional claro (sin jerga innecesaria).

## Stack y dónde tocar

| Área | Ubicación | Estilo habitual |
|------|-----------|-----------------|
| Layout público | `components/layout/` | Tailwind utility classes |
| Bloques CMS genéricos | `components/elements/` | Tailwind + scoped CSS |
| Bloques IDCBIS | `components/elements/idcbis/` | Scoped CSS + vars `--font-idcbis` |
| Panel editor | `components/editor/` | Tailwind + `editor-fields.css` |
| Admin | `views/admin/` | Tailwind + tema dark (`app.css` @theme) |
| Estilos globales | `resources/css/app.css`, `fonts.css` | Tailwind @theme, base typography |
| Tipografía JS | `config/siteTypography.js` | `SITE_TYPOGRAPHY`, `fontFamily` |

## Reglas de diseño IDCBIS

### Colores

Usar la paleta institucional documentada en `idcbis-tokens.md`. En Tailwind, los hex frecuentes son `#005674`, `#008996`, `#003C5F`, `#0B4F6C`, `#C4A140` (acento secundario dorado), `text-[#C4A140]` en footer.

**No** introducir azules genéricos (`#3b82f6`) en UI pública si ya existe equivalente institucional — el `FormElement.vue` aún usa azul genérico; al tocarlo, migrar a `#005674`.

### Tipografía

- Cuerpo: `var(--font-idcbis)` / Museo Sans Condensed, peso 500, line-height ~1.65.
- Títulos: `var(--font-idcbis-display)`, pesos 700–900 según nivel (`app.css` base).
- No añadir fuentes externas sin alinearlas con `resources/css/fonts.css`.

### Layout

- Contenedor estándar: `max-w-7xl mx-auto px-4 sm:px-6 lg:px-8`.
- Bloques IDCBIS full-bleed: `fullBleed: true` + CSS interno con `max-width: 1200px–1400px` centrado.
- Mobile-first; breakpoints comunes: `md:` (768px), `lg:` (1024px). Algunos bloques idcbis usan `@media (max-width: 900px)`.

### Iconos

- Público: `lucide-vue-next` (Header, documentos) o `@heroicons/vue`.
- Mantener `aria-hidden="true"` en iconos decorativos; `aria-label` en botones solo-icono.

### Logos IDCBIS

Definidos en `config/siteLogos.js`. **No mezclar variantes:**

- **`IDCBIS_BRAND_LOGO_ON_BLUE`** (`Logo IDCBIS-95.png`) → menú, footer y cualquier superficie azul institucional.
- **`IDCBIS_BRAND_LOGO`** (`logo.png`) → admin, bloques sobre fondo claro u otro color distinto al azul.

Importar las constantes exportadas; no hardcodear rutas a `public/images/logo/` ni a archivos sueltos en `public/img/`.

## Checklist rápido

Antes de dar por terminado un cambio de UI, revisar [checklist.md](checklist.md).

Mínimo obligatorio:

- [ ] Contraste legible (≥ 4.5:1 texto normal sobre fondo)
- [ ] `:focus-visible` o `focus:ring-[#005674]` en controles interactivos
- [ ] Botones reales (`<button type="button">`), no `<div @click>`
- [ ] Imágenes con `alt` descriptivo; slides con `imageAlt`
- [ ] Acordeones/carruseles con ARIA (`aria-expanded`, `aria-label` en nav)
- [ ] Touch targets ≥ 44×44 px en móvil
- [ ] `prefers-reduced-motion` para animaciones largas (carruseles, acordeones)
- [ ] Sin scroll horizontal accidental en móvil

## Formularios

- `<label>` visible asociado al control (`for` + `id` cuando sea posible).
- Indicar campos requeridos con `*` y texto, no solo color.
- Estados de error claros en español.
- Focus ring institucional: `focus:ring-2 focus:ring-[#005674]` (como en `TeamSection.vue`, admin).
- En admin, respetar variantes dark: `dark:border-[#30363d]`, `dark:focus:ring-[#58a6ff]`.

## Page builder / CMS

- Nuevos tipos de elemento: registrar en `config/pageElementPalette.js`, factory en `utils/pageElementFactory.js`, renderer en `composables/usePageElements.js`.
- Estilos dinámicos: usar `useElementStyles.js` (`getLayoutStyles`, `getTypographyStyles`, `getVisualStyles`, `mergeElementStyles`).
- Bloques idcbis editables por partes: seguir `useIdcbisEditorParts.js` + `utils/editorPartFocus.js`.
- Panel de propiedades: crear `*ContentProperties.vue` en `components/editor/properties/`.

## Admin vs sitio público

- **Público**: fondo claro (`bg-gray-50` layout, `bg-white` páginas), acentos `#005674`.
- **Admin**: tema oscuro con tokens `--color-dark-*` en `app.css`; acento `#58a6ff`.
- No mezclar estilos admin en componentes públicos ni viceversa.

## Formato de feedback al revisar UI

Al auditar o proponer cambios:

- **Crítico**: bloquea accesibilidad, usabilidad o coherencia institucional.
- **Mejora**: aumenta claridad, consistencia o mantenibilidad.
- **Opcional**: pulido visual menor.

Incluir referencia al archivo/componente afectado y sugerencia concreta (clase Tailwind, prop ARIA, token de color).

## Recursos

- Tokens y paleta: [idcbis-tokens.md](idcbis-tokens.md)
- Checklist extendida: [checklist.md](checklist.md)
- Patrones Vue del CMS: [component-patterns.md](component-patterns.md)
