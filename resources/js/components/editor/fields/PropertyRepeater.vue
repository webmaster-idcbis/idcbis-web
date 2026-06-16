<template>
  <div class="space-y-2">
    <div
      v-for="(item, index) in items"
      :key="item.id || index"
      class="editor-repeater-item space-y-2"
    >
      <div class="flex justify-between items-center gap-2">
        <span class="text-xs font-medium text-gray-600">{{ itemLabel }} {{ index + 1 }}</span>
        <div class="flex items-center gap-1 shrink-0">
          <button
            v-if="index > 0"
            type="button"
            class="props-mini-btn"
            title="Subir"
            @click="$emit('move', index, -1)"
          >↑</button>
          <button
            v-if="index < items.length - 1"
            type="button"
            class="props-mini-btn"
            title="Bajar"
            @click="$emit('move', index, 1)"
          >↓</button>
          <button
            type="button"
            class="props-mini-btn props-mini-btn--danger"
            @click="$emit('remove', index)"
          >✕</button>
        </div>
      </div>
      <slot :item="item" :index="index" />
    </div>
    <button type="button" class="editor-add-btn" @click="$emit('add')">
      + {{ addLabel }}
    </button>
  </div>
</template>

<script setup>
defineProps({
  items: { type: Array, default: () => [] },
  itemLabel: { type: String, default: 'Elemento' },
  addLabel: { type: String, default: 'Agregar' },
})

defineEmits(['add', 'remove', 'move'])
</script>

<style scoped>
.props-mini-btn {
  padding: 0.125rem 0.375rem;
  font-size: 0.6875rem;
  border: 1px solid #d1d5db;
  border-radius: 0.25rem;
  background: #fff;
  color: #4b5563;
  line-height: 1.2;
}
.props-mini-btn:hover {
  background: #f3f4f6;
}
.props-mini-btn--danger {
  color: #dc2626;
  border-color: #fecaca;
}
.props-mini-btn--danger:hover {
  background: #fef2f2;
}
</style>
