<template>
  <div class="space-y-3">
    <div>
      <label class="block text-xs text-gray-600 mb-1">Marca / logo texto</label>
      <input v-model="element.brand" type="text" class="editor-field-input">
    </div>

    <div class="space-y-2">
      <label class="block text-xs text-gray-600">Enlaces del menú</label>
      <div
        v-for="(link, index) in element.links"
        :key="index"
        class="editor-repeater-item space-y-2"
      >
        <div class="flex justify-between items-center">
          <span class="text-xs text-gray-500">Enlace {{ index + 1 }}</span>
          <button type="button" class="text-xs text-red-600" @click="removeLink(index)">Quitar</button>
        </div>
        <input v-model="link.text" type="text" placeholder="Texto" class="editor-field-input">
        <input v-model="link.href" type="text" placeholder="URL (/pagina o #seccion)" class="editor-field-input">
      </div>
      <button type="button" class="editor-add-btn" @click="addLink">+ Agregar enlace</button>
    </div>

    <div class="grid grid-cols-2 gap-3">
      <div>
        <label class="block text-xs text-gray-600 mb-1">Fondo</label>
        <input v-model="element.backgroundColor" type="color" class="w-full h-9 border border-gray-300 rounded cursor-pointer">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Color texto</label>
        <input v-model="element.color" type="color" class="w-full h-9 border border-gray-300 rounded cursor-pointer">
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({ element: { type: Object, required: true } })

const addLink = () => {
  if (!props.element.links) props.element.links = []
  props.element.links.push({ text: 'Nuevo enlace', href: '#' })
}

const removeLink = (index) => {
  props.element.links.splice(index, 1)
}
</script>
