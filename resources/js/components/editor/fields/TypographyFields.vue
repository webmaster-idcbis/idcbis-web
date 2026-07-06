<template>
  <div class="space-y-3">
    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Tipografía</p>
    <div class="grid grid-cols-2 gap-3">
      <div>
        <label class="block text-xs text-gray-600 mb-1">Color</label>
        <input v-model="element.color" type="color" class="w-full h-9 border border-gray-300 rounded cursor-pointer">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Tamaño</label>
        <input v-model="element.fontSize" type="text" placeholder="16px" class="editor-field-input">
      </div>
    </div>
    <div class="grid grid-cols-2 gap-3">
      <div>
        <label class="block text-xs text-gray-600 mb-1">Peso</label>
        <select v-model="element.fontWeight" class="editor-field-input">
          <option value="300">Ligera</option>
          <option value="400">Normal</option>
          <option value="500">Medio</option>
          <option value="600">Seminegrita</option>
          <option value="700">Negrita</option>
          <option value="800">Extra negrita</option>
        </select>
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Alineación</label>
        <select v-model="element.textAlign" class="editor-field-input">
          <option value="left">Izquierda</option>
          <option value="center">Centro</option>
          <option value="right">Derecha</option>
          <option value="justify">Justificado</option>
        </select>
      </div>
    </div>
    <div class="grid grid-cols-2 gap-3">
      <div>
        <label class="block text-xs text-gray-600 mb-1">Fuente</label>
        <select v-model="element.fontFamily" class="editor-field-input">
          <option value="">Por defecto (IDCBIS)</option>
          <option value="Georgia, serif">Georgia</option>
          <option value="'Times New Roman', serif">Times New Roman</option>
          <option value="Arial, sans-serif">Arial</option>
          <option value="'Segoe UI', sans-serif">Segoe UI</option>
          <option value="monospace">Monoespaciada</option>
        </select>
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Altura de línea</label>
        <input v-model="element.lineHeight" type="text" placeholder="1.6" class="editor-field-input">
      </div>
    </div>
    <div class="grid grid-cols-2 gap-3">
      <div>
        <label class="block text-xs text-gray-600 mb-1">Espaciado de letras</label>
        <input v-model="element.letterSpacing" type="text" placeholder="0.02em" class="editor-field-input">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Transformación</label>
        <select v-model="element.textTransform" class="editor-field-input">
          <option value="">Normal</option>
          <option value="uppercase">MAYÚSCULAS</option>
          <option value="lowercase">minúsculas</option>
          <option value="capitalize">Capitalizar</option>
        </select>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({ element: { type: Object, required: true } })
</script>
