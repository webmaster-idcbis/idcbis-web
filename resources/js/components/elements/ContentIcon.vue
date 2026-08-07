<template>
  <span
    v-if="isSvg"
    class="content-icon content-icon--mask"
    :style="{ '--content-icon-url': `url('${encodedSource}')` }"
    :role="decorative ? undefined : 'img'"
    :aria-label="decorative ? undefined : alt"
    :aria-hidden="decorative ? 'true' : undefined"
  />
  <img
    v-else-if="isImage"
    :src="imageSource"
    :alt="decorative ? '' : alt"
    class="content-icon content-icon--image"
    :aria-hidden="decorative ? 'true' : undefined"
  >
  <span
    v-else
    class="content-icon content-icon--text"
    :aria-hidden="decorative ? 'true' : undefined"
  >{{ value }}</span>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  value: { type: String, default: '' },
  alt: { type: String, default: '' },
  decorative: { type: Boolean, default: true },
})

const institutionalIcons = {
  '🏛️': '/img/Iconos/IDCBIS.svg',
  '🏢': '/img/Iconos/IDCBIS.svg',
  '🩸': '/img/Iconos/banco de sangre.svg',
  '❤️': '/img/Iconos/compromiso social.svg',
  '💚': '/img/Iconos/compromiso social.svg',
  '💙': '/img/Iconos/compromiso social.svg',
  '🤝': '/img/Iconos/compromiso social.svg',
  '📞': '/img/Iconos/contacto.svg',
  '📧': '/img/Iconos/correo.svg',
  '✉️': '/img/Iconos/correo.svg',
  '🕐': '/img/Iconos/horario.svg',
  '⏱': '/img/Iconos/horario.svg',
  '📅': '/img/Iconos/horario.svg',
  '⭐': '/img/Iconos/excelencia.svg',
  '🏅': '/img/Iconos/excelencia.svg',
  '🏆': '/img/Iconos/excelencia.svg',
  '🌟': '/img/Iconos/excelencia.svg',
  '⚖️': '/img/Iconos/etica.svg',
  '⚠️': '/img/Iconos/etica.svg',
  '🔍': '/img/Iconos/transparencia.svg',
  '🕵️': '/img/Iconos/transparencia.svg',
  '⚙️': '/img/Iconos/gestion.svg',
  '📋': '/img/Iconos/gestion.svg',
  '📝': '/img/Iconos/gestion.svg',
  '📑': '/img/Iconos/politicas y lineamientos.svg',
  '📚': '/img/Iconos/politicas y lineamientos.svg',
  '👥': '/img/Iconos/gestores lideres.svg',
  '🗣️': '/img/Iconos/contacto.svg',
  '📍': '/img/Iconos/IDCBIS.svg',
}

const imageSource = computed(() => {
  const value = props.value?.trim() || ''
  return institutionalIcons[value] || value
})

const isImage = computed(() => {
  const value = imageSource.value
  return /^(?:https?:\/\/|\/|data:image\/)|\.(?:svg|png|jpe?g|gif|webp)(?:[?#].*)?$/i.test(value)
})

const isSvg = computed(() => isImage.value && /\.svg(?:[?#].*)?$/i.test(imageSource.value))

// Codifica solo espacios/caracteres conflictivos manteniendo la ruta legible
const encodedSource = computed(() => imageSource.value.replace(/'/g, "\\'").replace(/ /g, '%20'))
</script>

<style scoped>
.content-icon {
  display: inline-block;
  flex: 0 0 auto;
  line-height: 1;
  vertical-align: middle;
}

.content-icon--image {
  width: calc(1em + 2px);
  height: calc(1em + 2px);
  object-fit: contain;
}

/* SVG monocromo recoloreable: hereda `color` (negro por defecto) vía máscara */
.content-icon--mask {
  width: calc(1em + 2px);
  height: calc(1em + 2px);
  background-color: currentColor;
  -webkit-mask: var(--content-icon-url) center / contain no-repeat;
  mask: var(--content-icon-url) center / contain no-repeat;
}
</style>
