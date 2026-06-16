<template>
  <div
    class="video-element"
    :style="wrapperStyles"
    @click.stop="$emit('click', element)"
  >
    <div v-if="embedUrl" class="video-wrapper">
      <iframe
        :src="embedUrl"
        title="Video"
        frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
        allowfullscreen
        class="video-iframe"
      />
    </div>
    <div v-else class="video-placeholder">
      <span>📹</span>
      <p>Pega la URL del video en propiedades</p>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { mergeElementStyles } from '../../composables/useElementStyles'

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
})

defineEmits(['click'])

const wrapperStyles = computed(() => mergeElementStyles(props.element, {
  width: props.element.width || '100%',
}))

const embedUrl = computed(() => toEmbedUrl(props.element.videoUrl || props.element.src || ''))

function toEmbedUrl(url) {
  if (!url?.trim()) return ''
  const u = url.trim()
  const ytMatch = u.match(/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/)
  if (ytMatch) return `https://www.youtube.com/embed/${ytMatch[1]}`
  if (u.includes('youtube.com/embed/')) return u
  if (u.includes('vimeo.com')) {
    const vimeoId = u.match(/vimeo\.com\/(\d+)/)?.[1]
    if (vimeoId) return `https://player.vimeo.com/video/${vimeoId}`
  }
  return u
}
</script>

<style scoped>
.video-element {
  cursor: pointer;
}

.video-wrapper {
  position: relative;
  padding-bottom: 56.25%;
  height: 0;
  overflow: hidden;
  border-radius: 8px;
  background: #000;
}

.video-iframe {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
}

.video-placeholder {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 200px;
  background: #f1f5f9;
  border: 2px dashed #cbd5e1;
  border-radius: 8px;
  color: #64748b;
  font-size: 0.875rem;
}

.video-placeholder span {
  font-size: 2rem;
  margin-bottom: 8px;
}
</style>
