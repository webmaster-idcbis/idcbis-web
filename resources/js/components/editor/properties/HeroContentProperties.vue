<template>
  <div class="space-y-3">
    <div>
      <label class="block text-xs text-gray-600 mb-1">Título principal</label>
      <input v-model="element.title" type="text" class="editor-field-input">
    </div>
    <div>
      <label class="block text-xs text-gray-600 mb-1">Subtítulo</label>
      <textarea v-model="element.subtitle" rows="2" class="editor-field-input" />
    </div>
    <div class="grid grid-cols-2 gap-3">
      <div>
        <label class="block text-xs text-gray-600 mb-1">Texto del botón</label>
        <input v-model="element.buttonText" type="text" placeholder="Ver más" class="editor-field-input">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">URL del botón</label>
        <input v-model="element.buttonUrl" type="text" placeholder="/pagina" class="editor-field-input">
      </div>
    </div>
    <div>
      <label class="block text-xs text-gray-600 mb-1">Imagen de fondo (URL)</label>
      <input v-model="element.backgroundImage" type="text" placeholder="/img/fondo.jpg" class="editor-field-input">
    </div>
    <div class="grid grid-cols-2 gap-3">
      <div>
        <label class="block text-xs text-gray-600 mb-1">Alto mínimo</label>
        <input v-model="element.minHeight" type="text" placeholder="280px" class="editor-field-input">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Alineación</label>
        <select v-model="element.textAlign" class="editor-field-input">
          <option value="center">Centro</option>
          <option value="left">Izquierda</option>
          <option value="right">Derecha</option>
        </select>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({ element: { type: Object, required: true } })
</script>
