# IDCBIS Web — guía para agentes

Stack: Vue 3 + Tailwind CSS 4 + Laravel API + Pinia + Vite.
Diseño: ver `.cursor/rules/web-design.mdc` y `.cursor/rules/design-tokens.mdc`.
Accesibilidad objetivo: WCAG 2.1 AA.
Idioma de UI: español institucional.

## Reglas críticas

- Colores institucionales: `#005674`, `#008996`, `#003C5F`, `#C4A140`.
- Focus visible obligatorio: `focus:ring-2 focus:ring-[#005674]`.
- Botones reales, no `<div @click>`.
- Logos: `IDCBIS_BRAND_LOGO_ON_BLUE` en fondo azul, `IDCBIS_BRAND_LOGO` en claro.
- No romper page builder (`element`, `preview`, `focusedPart`).
