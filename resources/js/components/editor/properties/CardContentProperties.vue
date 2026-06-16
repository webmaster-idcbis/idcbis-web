<template>
  <div class="space-y-3">
    <div>
      <label class="block text-xs text-gray-600 mb-1">Estilo</label>
      <select v-model="element.variant" class="editor-field-input">
        <option value="">Normal</option>
        <option value="featured">Destacada</option>
        <option value="soft">Suave (sin borde)</option>
        <option value="feature">Destacado con icono</option>
        <option value="type">Tipo de servicio</option>
        <option value="info">Panel informativo</option>
      </select>
    </div>
    <input v-model="element.icon" type="text" class="editor-field-input" placeholder="Icono (emoji)">
    <input v-model="element.tag" type="text" class="editor-field-input" placeholder="Etiqueta (#SERVICIO)">
    <input v-model="element.title" type="text" class="editor-field-input" placeholder="Título">
    <input v-model="element.subtitle" type="text" class="editor-field-input" placeholder="Subtítulo">
    <textarea v-model="element.content" rows="4" class="editor-field-input" placeholder="Descripción" />
    <input v-model="element.image" type="text" class="editor-field-input" placeholder="URL imagen superior">
    <div class="grid grid-cols-2 gap-2">
      <input v-model="element.href" type="text" class="editor-field-input" placeholder="Enlace (URL)">
      <input v-model="element.linkLabel" type="text" class="editor-field-input" placeholder="Texto del enlace">
    </div>
    <div class="grid grid-cols-2 gap-2">
      <div>
        <label class="block text-xs text-gray-600 mb-1">Color título</label>
        <input v-model="element.titleColor" type="color" class="w-full h-9 border rounded cursor-pointer">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Alineación</label>
        <select v-model="element.textAlign" class="editor-field-input">
          <option value="left">Izquierda</option>
          <option value="center">Centro</option>
        </select>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({ element: { type: Object, required: true } })
</script>
