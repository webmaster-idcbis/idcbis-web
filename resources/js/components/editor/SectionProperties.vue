<template>
  <div class="space-y-6">
    <!-- Section Info -->
    <div>
      <h3 class="text-sm font-semibold text-gray-700 mb-2">Información</h3>
      <div class="space-y-3">
        <div>
          <label class="block text-xs text-gray-500 mb-1">Nombre de la sección</label>
          <input
            :value="section.name"
            @input="updateField('name', $event.target.value)"
            type="text"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#005674]"
          >
        </div>
        <div>
          <label class="block text-xs text-gray-500 mb-1">Tipo</label>
          <input
            :value="section.type"
            disabled
            type="text"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-gray-100"
          >
        </div>
      </div>
    </div>

    <!-- Styles -->
    <div>
      <h3 class="text-sm font-semibold text-gray-700 mb-2">Estilos</h3>
      <div class="space-y-3">
        <div>
          <label class="block text-xs text-gray-500 mb-1">Padding superior (px)</label>
          <input
            :value="section.styles?.paddingTop || 0"
            @input="updateStyle('paddingTop', $event.target.value)"
            type="number"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
          >
        </div>
        <div>
          <label class="block text-xs text-gray-500 mb-1">Padding inferior (px)</label>
          <input
            :value="section.styles?.paddingBottom || 0"
            @input="updateStyle('paddingBottom', $event.target.value)"
            type="number"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
          >
        </div>
        <div>
          <label class="block text-xs text-gray-500 mb-1">Color de fondo</label>
          <div class="flex gap-2">
            <input
              :value="section.styles?.backgroundColor || '#ffffff'"
              @input="updateStyle('backgroundColor', $event.target.value)"
              type="color"
              class="w-10 h-10 rounded border border-gray-300 cursor-pointer"
            >
            <input
              :value="section.styles?.backgroundColor || '#ffffff'"
              @input="updateStyle('backgroundColor', $event.target.value)"
              type="text"
              class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm"
              placeholder="#ffffff"
            >
          </div>
        </div>
      </div>
    </div>

    <!-- Advanced Settings -->
    <div>
      <h3 class="text-sm font-semibold text-gray-700 mb-2">Configuración avanzada</h3>
      <div class="space-y-3">
        <div>
          <label class="block text-xs text-gray-500 mb-1">ID personalizado</label>
          <input
            :value="section.settings?.id || ''"
            @input="updateSetting('id', $event.target.value)"
            type="text"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
            placeholder="section-id"
          >
        </div>
        <div>
          <label class="block text-xs text-gray-500 mb-1">Clases CSS</label>
          <input
            :value="section.settings?.className || ''"
            @input="updateSetting('className', $event.target.value)"
            type="text"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
            placeholder="custom-class"
          >
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  section: {
    type: Object,
    required: true
  }
});

const emit = defineEmits(['update']);

const updateField = (field, value) => {
  emit('update', { [field]: value });
};

const updateStyle = (property, value) => {
  const styles = { ...(props.section.styles || {}), [property]: value };
  emit('update', { styles });
};

const updateSetting = (property, value) => {
  const settings = { ...(props.section.settings || {}), [property]: value };
  emit('update', { settings });
};
</script>
