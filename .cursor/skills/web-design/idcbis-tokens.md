# Tokens de diseño — IDCBIS

Referencia extraída del código actual. Actualizar este archivo si cambian colores o tipografía en `app.css`, Header/Footer o bloques idcbis.

## Paleta institucional (sitio público)

| Token | Hex / valor | Uso en el proyecto |
|-------|-------------|-------------------|
| `brand-primary` | `#005674` | Header gradient inicio, links, spinners, focus rings, acentos |
| `brand-primary-dark` | `#003C5F` | Footer fondo, hover botones admin |
| `brand-secondary` | `#008996` | Header gradient fin, gradientes decorativos |
| `brand-deep` | `#0B4F6C` | Bloques idcbis (contacto, hero), títulos sección |
| `brand-deep-alt` | `#003d52` | Gradientes hero (`HeroBlockElement`, factory) |
| `brand-accent` | `#C4A140` | **Color secundario principal** — stats idcbis, títulos contacto, acentos dorados, CTAs footer |
| `accent-red` | `#d32f2f` | Subrayados acordeón, botones donación en carrusel |
| `accent-teal` | `#00acc1` | Gradientes decorativos acordeón |
| `text-body` | `#1a1a1a` | Color base `body` en `app.css` |
| `text-muted` | `#607d8b` / `text-gray-600` | Subtítulos, texto secundario |
| `surface-light` | `#eceff1` | Fondo acordeón por defecto |
| `surface-page` | `#f8f9fa` / `bg-gray-50` | Fondos suaves, layout |

### Gradientes frecuentes

```css
/* Header */
background: linear-gradient(to right, #005674, #008996);

/* Hero institucional */
background: linear-gradient(135deg, #005674 0%, #003d52 100%);

/* Búsqueda / banners */
background: linear-gradient(135deg, #005674 0%, #008996 100%);
```

## Tipografía

Definida en `resources/css/fonts.css` y `resources/css/app.css`.

| Rol | CSS variable | Familia | Peso habitual |
|-----|--------------|---------|---------------|
| Cuerpo | `--font-idcbis` | Museo Sans Condensed | 500 |
| Display / títulos | `--font-idcbis-display` | Museo Sans Condensed | 700–900 (h1: 900) |
| Alternativa | `--font-idcbis-alt` | Museo Sans | según necesidad |

**JS inline** (cuando no aplica Tailwind):

```js
import { SITE_TYPOGRAPHY, fontFamily } from '@/config/siteTypography'
// SITE_TYPOGRAPHY.body → 'var(--font-idcbis)'
```

### Escala tipográfica observada

| Elemento | Tamaño aprox. |
|----------|---------------|
| Nav desktop | `text-sm` (14px) |
| Nav mobile | `text-base` (16px) |
| Footer headings | `text-sm uppercase tracking-wider` |
| Footer links | `text-sm text-white/80` |
| Section title (acordeón) | `2.5rem` |
| Contact item h4 | `1.8rem` |
| Body | `1rem`, line-height `1.65` |

## Espaciado y layout

| Patrón | Valor |
|--------|-------|
| Contenedor global | `max-w-7xl mx-auto px-4 sm:px-6 lg:px-8` |
| Header height | `h-16 md:h-[72px]` |
| Footer padding | `py-12` sección principal, `py-4` barra inferior |
| Grid footer | `grid-cols-1 md:grid-cols-4 gap-8` |
| Bloques idcbis padding | `4rem 2rem` típico |
| Bloques idcbis max-width | `1200px`–`1400px` centrado |
| Border radius idcbis contact | `40px 10px 40px 10px` (forma distintiva) |
| Border radius acordeón/tarjetas | `12px`–`30px` |

## Tema admin (oscuro)

Tokens en `resources/css/app.css` → `@theme`:

| Token | Valor |
|-------|-------|
| `--color-dark-bg` | `#0f1419` |
| `--color-dark-surface` | `#161b22` |
| `--color-dark-elevated` | `#21262d` |
| `--color-dark-border` | `#30363d` |
| `--color-dark-text` | `#e6edf3` |
| `--color-dark-text-secondary` | `#8b949e` |
| `--color-dark-accent` | `#58a6ff` |
| `--color-dark-accent-hover` | `#79c0ff` |

Uso Tailwind: `dark:bg-[#0f1419]`, `dark:text-[#e6edf3]`, `dark:focus:ring-[#58a6ff]`.

## Estados interactivos

| Estado | Patrón del proyecto |
|--------|---------------------|
| Link header/footer | `hover:text-white/80` o `hover:text-[#D9B85A]` sobre acentos `#C4A140` |
| Botón mobile menu | `hover:bg-white/10`, `p-2 rounded-md` |
| Focus inputs (público) | `focus:ring-2 focus:ring-[#005674]` |
| Focus inputs (admin) | `dark:focus:ring-[#58a6ff]` |
| Item nav activo | `bg-white/10` (mobile), `text-white/90` (desktop) |
| Loading spinner | `border-b-2 border-[#005674]` |

## Imágenes institucionales

### Logos IDCBIS (`config/siteLogos.js`)

Carpeta: `public/img/Logo IDCBIS/`. Usar la variante según el fondo:

| Variante | Constante | Archivo | Cuándo usar |
|----------|-----------|---------|-------------|
| A color | `IDCBIS_BRAND_LOGO` | `logo.png` | Fondos claros, blancos o distintos al azul institucional (admin, sección “Somos IDCBIS”, etc.) |
| Blanco | `IDCBIS_BRAND_LOGO_ON_BLUE` | `Logo IDCBIS-95.png` | Fondos azules: header (`#005674`→`#008996`), footer (`#003C5F`) |

Mapa en `SITE_LOGOS`:

| Clave | Variante |
|-------|----------|
| `header`, `footer` | `IDCBIS_BRAND_LOGO_ON_BLUE` |
| `admin`, `adminCompact`, `icon`, `about` | `IDCBIS_BRAND_LOGO` |

Otros logos: `INSTITUTIONAL_LOGOS` (footer institucional). No reutilizar rutas antiguas en `public/images/logo/` para marca IDCBIS.

- Fotos equipo: `public/img/equipo/` + `config/idcbisTeamPhotos.js`
- Plantilla referencia: `config/pageTemplates/propuestaAzulIdcbis.js`

## Qué evitar

- Azul Tailwind genérico (`blue-500`, `#3b82f6`) en UI pública nueva.
- Fuentes distintas a Museo Sans / Museo Sans Condensed sin aprobación.
- Contenedores más anchos que `max-w-7xl` en layout global (salvo full-bleed intencional).
- Colores de acento aleatorios fuera de la paleta anterior.
