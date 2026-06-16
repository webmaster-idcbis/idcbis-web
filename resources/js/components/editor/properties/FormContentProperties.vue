<template>
  <div class="space-y-3">
    <div>
      <label class="block text-xs text-gray-600 mb-1">Título del formulario</label>
      <input v-model="element.title" type="text" class="editor-field-input">
    </div>

    <div class="space-y-2">
      <label class="block text-xs text-gray-600">Campos</label>
      <div
        v-for="(field, index) in element.fields"
        :key="field.name || index"
        class="editor-repeater-item space-y-2"
      >
        <div class="flex justify-between items-center">
          <span class="text-xs text-gray-500">Campo {{ index + 1 }}</span>
          <button type="button" class="text-xs text-red-600" @click="removeField(index)">Quitar</button>
        </div>
        <input v-model="field.label" type="text" placeholder="Etiqueta visible" class="editor-field-input">
        <input v-model="field.name" type="text" placeholder="nombre_campo" class="editor-field-input">
        <select v-model="field.type" class="editor-field-input">
          <option value="text">Texto</option>
          <option value="email">Email</option>
          <option value="textarea">Área de texto</option>
          <option value="select">Lista</option>
        </select>
        <label class="flex items-center gap-2 text-xs text-gray-700">
          <input v-model="field.required" type="checkbox" class="rounded">
          Obligatorio
        </label>
      </div>
      <button type="button" class="editor-add-btn" @click="addField">+ Agregar campo</button>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({ element: { type: Object, required: true } })

const addField = () => {
  if (!props.element.fields) props.element.fields = []
  const n = props.element.fields.length + 1
  props.element.fields.push({
    name: `campo_${n}`,
    label: `Campo ${n}`,
    type: 'text',
    required: false,
  })
}

const removeField = (index) => {
  props.element.fields.splice(index, 1)
}
</script>
