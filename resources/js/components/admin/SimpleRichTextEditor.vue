<template>
  <div class="rich-editor">
    <div class="rich-editor__toolbar" role="toolbar" aria-label="Formato de texto">
      <button type="button" class="rich-editor__btn" title="Negrita" @click="exec('bold')">
        <Bold class="w-4 h-4" aria-hidden="true" />
      </button>
      <button type="button" class="rich-editor__btn" title="Cursiva" @click="exec('italic')">
        <Italic class="w-4 h-4" aria-hidden="true" />
      </button>
      <button type="button" class="rich-editor__btn" title="Lista con viñetas" @click="exec('insertUnorderedList')">
        <List class="w-4 h-4" aria-hidden="true" />
      </button>
      <button type="button" class="rich-editor__btn" title="Enlace" @click="insertLink">
        <Link2 class="w-4 h-4" aria-hidden="true" />
      </button>
      <button
        type="button"
        class="rich-editor__btn"
        title="Insertar imagen"
        :disabled="imageProcessing"
        @click="imageInputRef?.click()"
      >
        <ImageIcon class="w-4 h-4" aria-hidden="true" />
      </button>
      <button type="button" class="rich-editor__btn" title="Insertar botón con enlace" @click="insertButton">
        <MousePointerClick class="w-4 h-4" aria-hidden="true" />
      </button>
      <button type="button" class="rich-editor__btn" title="Quitar formato" @click="exec('removeFormat')">
        <Eraser class="w-4 h-4" aria-hidden="true" />
      </button>
      <input
        ref="imageInputRef"
        type="file"
        accept="image/jpeg,image/png,image/webp"
        class="hidden"
        @change="onImageSelected"
      >
    </div>

    <p v-if="imageProcessing" class="rich-editor__status">Preparando imagen…</p>

    <div
      ref="editorRef"
      class="rich-editor__area"
      contenteditable="true"
      role="textbox"
      :aria-label="label"
      @input="onInput"
      @blur="onInput"
    />
  </div>
</template>

<script setup>
import { onMounted, ref, watch } from 'vue'
import { Bold, Italic, List, Link2, Eraser, Image as ImageIcon, MousePointerClick } from 'lucide-vue-next'
import { fileToDataUrl } from '../../utils/imageToDataUrl'

const props = defineProps({
  modelValue: { type: String, default: '' },
  label: { type: String, default: 'Contenido de la noticia' },
})

const emit = defineEmits(['update:modelValue'])

const editorRef = ref(null)
const imageInputRef = ref(null)
const imageProcessing = ref(false)

const escapeHtml = (value) => (value || '')
  .replace(/&/g, '&amp;')
  .replace(/</g, '&lt;')
  .replace(/>/g, '&gt;')
  .replace(/"/g, '&quot;')

const onInput = () => {
  emit('update:modelValue', editorRef.value?.innerHTML || '')
}

const exec = (command) => {
  editorRef.value?.focus()
  document.execCommand(command, false, null)
  onInput()
}

const insertHtml = (html) => {
  editorRef.value?.focus()
  document.execCommand('insertHTML', false, html)
  onInput()
}

const insertLink = () => {
  const url = window.prompt('URL del enlace (ej. https://idcbis.org.co)')
  if (!url) return

  editorRef.value?.focus()
  const selection = window.getSelection()?.toString().trim()

  if (selection) {
    document.execCommand('createLink', false, url)
  } else {
    const text = window.prompt('Texto del enlace', 'Más información')
    if (!text) return
    insertHtml(`<a href="${escapeHtml(url)}">${escapeHtml(text)}</a>`)
  }
  onInput()
}

const insertButton = () => {
  const text = window.prompt('Texto del botón', 'Ver más información')
  if (!text) return
  const url = window.prompt('Enlace del botón', 'https://idcbis.org.co')
  if (!url) return

  insertHtml(
    `<p class="news-content-cta"><a href="${escapeHtml(url)}" class="news-content-cta__btn" target="_blank" rel="noopener noreferrer">${escapeHtml(text)}</a></p><p><br></p>`,
  )
}

const onImageSelected = async (event) => {
  const file = event.target.files?.[0]
  event.target.value = ''
  if (!file) return

  const alt = window.prompt('Descripción de la imagen (para accesibilidad)', '') || ''

  imageProcessing.value = true
  try {
    const dataUrl = await fileToDataUrl(file)
    insertHtml(
      `<figure class="news-content-figure"><img src="${dataUrl}" alt="${escapeHtml(alt)}" loading="lazy"></figure><p><br></p>`,
    )
  } catch (error) {
    window.alert(error.message || 'No se pudo preparar la imagen')
  } finally {
    imageProcessing.value = false
  }
}

watch(() => props.modelValue, (value) => {
  if (!editorRef.value) return
  if (editorRef.value.innerHTML !== value) {
    editorRef.value.innerHTML = value || ''
  }
}, { immediate: true })

onMounted(() => {
  if (editorRef.value && props.modelValue) {
    editorRef.value.innerHTML = props.modelValue
  }
})

defineExpose({
  flush: onInput,
})
</script>

<style scoped>
.rich-editor {
  border: 1px solid #d1d5db;
  border-radius: 0.75rem;
  overflow: hidden;
  background: #fff;
}

:global(.dark) .rich-editor {
  border-color: #30363d;
  background: #0f1419;
}

.rich-editor__toolbar {
  display: flex;
  flex-wrap: wrap;
  gap: 0.25rem;
  padding: 0.5rem;
  border-bottom: 1px solid #e5e7eb;
  background: #f9fafb;
}

:global(.dark) .rich-editor__toolbar {
  border-color: #30363d;
  background: #21262d;
}

.rich-editor__btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 2.25rem;
  height: 2.25rem;
  border: none;
  border-radius: 0.5rem;
  background: transparent;
  color: #374151;
  cursor: pointer;
}

.rich-editor__btn:disabled {
  opacity: 0.45;
  cursor: not-allowed;
}

:global(.dark) .rich-editor__btn {
  color: #e6edf3;
}

.rich-editor__btn:hover:not(:disabled) {
  background: #e5e7eb;
}

:global(.dark) .rich-editor__btn:hover:not(:disabled) {
  background: #30363d;
}

.rich-editor__btn:focus-visible {
  outline: none;
  box-shadow: 0 0 0 2px #005674;
}

.rich-editor__status {
  margin: 0;
  padding: 0.5rem 1rem;
  font-size: 0.8125rem;
  color: #005674;
  background: #f0f9fb;
  border-bottom: 1px solid #e5e7eb;
}

.rich-editor__area {
  min-height: 260px;
  padding: 1rem;
  font-size: 0.9375rem;
  line-height: 1.65;
  color: #1f2937;
  outline: none;
}

:global(.dark) .rich-editor__area {
  color: #e6edf3;
}

.rich-editor__area:empty::before {
  content: 'Escribe el contenido de la noticia aquí…';
  color: #9ca3af;
}

.rich-editor__area :deep(.news-content-figure) {
  margin: 1.25rem 0;
}

.rich-editor__area :deep(.news-content-figure img) {
  width: 100%;
  max-width: 100%;
  height: auto;
  border-radius: 0.75rem;
  display: block;
}

.rich-editor__area :deep(.news-content-cta) {
  margin: 1.5rem 0;
  text-align: center;
}

.rich-editor__area :deep(.news-content-cta__btn) {
  display: inline-block;
  padding: 0.75rem 1.5rem;
  border-radius: 9999px;
  background: linear-gradient(135deg, #0b4f6c, #2c8c99);
  color: #fff !important;
  font-weight: 700;
  text-decoration: none !important;
}
</style>
