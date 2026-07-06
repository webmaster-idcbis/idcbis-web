# Patrones de componentes — IDCBIS CMS

Convenciones del repositorio para mantener consistencia al crear o modificar UI.

## Arquitectura frontend

```
Laravel API  →  Pinia (cms, auth, menus)  →  Vue Router  →  Views
                                                      ↓
                                              MainLayout (Header + main + Footer)
                                                      ↓
                              Page.vue → PageContentRenderer → elements/*
```

**Build**: Vite + `@tailwindcss/vite` v4. Estilos globales en `resources/css/app.css`.

## Dos estilos de componente

### A) Layout y secciones con Tailwind

Usado en: `Header.vue`, `Footer.vue`, `Page.vue`, muchas `sections/*`, admin.

```vue
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
  <router-link class="text-sm text-white/80 hover:text-white transition-colors">
```

- Utility-first; colores institucionales como arbitrary values: `text-[#005674]`, `from-[#005674]`.
- Iconos: `import { Menu, X } from 'lucide-vue-next'`.

### B) Bloques CMS con scoped CSS

Usado en: `elements/*`, especialmente `elements/idcbis/*`.

```vue
<template>
  <section class="idcbis-contact" @click.stop="$emit('click', element)">
    ...
  </section>
</template>

<style scoped>
.idcbis-contact {
  font-family: var(--font-idcbis);
  ...
}
</style>
```

- Prefijo BEM-like: `idcbis-contact__grid`, `idcbis-contact__item`.
- Colores en CSS cuando el bloque es autónomo; props `backgroundColor` cuando es configurable.
- Cursor `pointer` + `@click.stop` en modo editor para seleccionar el bloque.

## Props estándar de elementos CMS

```js
defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
  focusedPart: { type: String, default: null }, // bloques idcbis editables por partes
})
defineEmits(['click', 'focus-part'])
```

- **`preview: true`**: comportamiento de sitio público (links activos, acordeón puede abrir demo).
- **`preview: false`**: modo editor; click selecciona elemento.

## Estilos dinámicos del page builder

Importar desde `composables/useElementStyles.js`:

```js
import { mergeElementStyles, resolveBackgroundColor } from '../../composables/useElementStyles'

const sectionStyles = computed(() => ({
  backgroundColor: resolveBackgroundColor(props.element.backgroundColor, '#eceff1'),
  padding: props.element.padding || '5rem 2rem',
  ...mergeElementStyles(props.element),
}))
```

Campos comunes en `element`: `backgroundColor`, `padding`, `margin`, `maxWidth`, `borderRadius`, `titleColor`, `fullBleed`.

## Bloques IDCBIS editables por partes

Composable `useIdcbisEditorParts`:

```js
import { useIdcbisEditorParts } from '../../../composables/useIdcbisEditorParts'
import { buildContactFocusAnchor } from '../../../utils/editorPartFocus'

const { partClasses, focusPart } = useIdcbisEditorParts(props, emit)
```

- Cada subparte clickeable emite `focus-part` para abrir panel de propiedades contextual.
- Clases de foco editor: `partClasses(anchor)`.

## Registrar un nuevo elemento

1. **`utils/pageElementFactory.js`**: `createElement('mi-tipo')` con defaults.
2. **`config/pageElementPalette.js`**: entrada en categoría correcta (`idcbis` si es institucional).
3. **`composables/usePageElements.js`**: mapeo tipo → componente Vue.
4. **`components/elements/`**: componente render.
5. **`components/editor/properties/`**: `MiTipoContentProperties.vue`.
6. **`components/editor/ElementPropertiesPanel.vue`**: importar panel si hace falta.

## Referencias de calidad en el repo

| Patrón | Archivo referencia |
|--------|-------------------|
| ARIA carrusel | `IdcbisHeroCarouselElement.vue` |
| ARIA documentos + búsqueda | `IdcbisDocumentsListElement.vue` |
| Menú mobile accesible | `Header.vue` (`aria-expanded`, `aria-label`) |
| Focus ring institucional | `TeamSection.vue`, vistas admin |
| Full-bleed + grid responsive | `IdcbisContactElement.vue` |
| Estilos editor colapsables | `PropertySection.vue` (`aria-expanded`) |

## Mejoras conocidas pendientes (no replicar)

- `FormElement.vue`: focus azul genérico y botón `#3b82f6` — migrar a tokens IDCBIS al editar.
- `AccordionElement.vue`: falta `aria-expanded` / `aria-controls` — añadir al mejorar accesibilidad.
- Algunos `@click` en contenedores editor — correcto para selección, pero botones de acción deben ser `<button>`.

## Admin

- Layout: `views/admin/AdminLayout.vue`.
- Tema oscuro con clases `dark:*` y tokens `--color-dark-*`.
- Modales: `role="dialog"`, `aria-modal="true"`, `aria-labelledby` (ver `Users.vue`, `Permissions.vue`).

## Librerías UI disponibles

| Librería | Uso |
|----------|-----|
| `@headlessui/vue` | Componentes accesibles (disclosure, dialog, menu) |
| `@vueuse/core` | Utilidades reactivas |
| `swiper` | Carruseles avanzados si se necesitan |
| `sortablejs` | Reordenar en editor |
| `lucide-vue-next` | Iconos (preferido en layout público) |
| `@heroicons/vue` | Iconos alternativos |

Preferir Headless UI para widgets interactivos nuevos en lugar de implementar desde cero.

## Navegación y scroll

- Rutas: `resources/js/router/index.js`.
- Al cambiar de página: `scrollToTop()` en `Page.vue`.
- Links internos: `router-link` con paths slug (`/quienes-somos`, `/mapa-del-sitio`).

## Contenido y plantillas

- Plantilla inicio: `config/pageTemplates/propuestaAzulIdcbis.js`.
- Mapa del sitio estático: `config/siteSitemap.js`.
- Preparar guardado: `utils/preparePageContent.js`, `utils/pageSaveRequest.js`.
