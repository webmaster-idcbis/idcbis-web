<template>
  <div 
    class="form-element"
    :style="formStyles"
    @click.stop="$emit('click', element)"
  >
    <div v-if="element.title" class="form-title">
      <h3>{{ element.title }}</h3>
    </div>
    <form class="form-content" @submit.prevent="handleSubmit">
      <div 
        v-for="field in element.fields" 
        :key="field.name"
        class="form-field"
      >
        <label class="form-label">
          {{ field.label }}
          <span v-if="field.required" class="required">*</span>
        </label>
        
        <input
          v-if="field.type === 'text' || field.type === 'email'"
          :type="field.type"
          :name="field.name"
          :placeholder="field.placeholder || field.label"
          :required="field.required"
          class="form-input"
        />
        
        <textarea
          v-else-if="field.type === 'textarea'"
          :name="field.name"
          :placeholder="field.placeholder || field.label"
          :required="field.required"
          :rows="field.rows || 4"
          class="form-textarea"
        ></textarea>
        
        <select
          v-else-if="field.type === 'select'"
          :name="field.name"
          :required="field.required"
          class="form-select"
        >
          <option value="">Seleccionar...</option>
          <option
            v-for="option in field.options"
            :key="option.value"
            :value="option.value"
          >
            {{ option.label }}
          </option>
        </select>
      </div>
      
      <div class="form-actions">
        <button type="submit" class="form-submit">
          Enviar
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { resolveBackgroundColor } from '../../composables/useElementStyles'

const props = defineProps({
  element: {
    type: Object,
    required: true
  }
})

const emit = defineEmits(['click'])

const formStyles = computed(() => {
  return {
    backgroundColor: resolveBackgroundColor(props.element.backgroundColor, '#f8f9fa'),
    padding: props.element.padding || '20px',
    borderRadius: props.element.borderRadius || '8px',
    boxShadow: '0 2px 4px rgba(0, 0, 0, 0.1)',
    marginBottom: '16px'
  }
})

const handleSubmit = (event) => {
  event.preventDefault()
  const formData = new FormData(event.target)
  const data = {}
  
  props.element.fields.forEach(field => {
    data[field.name] = formData.get(field.name)
  })
  
  console.log('Formulario enviado:', data)
  emit('submit', data)
}
</script>

<style scoped>
.form-element {
  cursor: pointer;
  transition: all 0.2s ease;
}

.form-element:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
}

.form-title {
  margin-bottom: 20px;
}

.form-title h3 {
  font-size: 1.25rem;
  font-weight: 600;
  color: #1a202c;
  margin: 0;
}

.form-field {
  margin-bottom: 16px;
}

.form-label {
  display: block;
  font-size: 0.875rem;
  font-weight: 500;
  color: #374151;
  margin-bottom: 6px;
}

.required {
  color: #ef4444;
  margin-left: 4px;
}

.form-input,
.form-textarea,
.form-select {
  width: 100%;
  padding: 10px 12px;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  font-size: 0.875rem;
  transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.form-input:focus,
.form-textarea:focus,
.form-select:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-textarea {
  resize: vertical;
  min-height: 100px;
}

.form-actions {
  margin-top: 24px;
  text-align: right;
}

.form-submit {
  background-color: #3b82f6;
  color: white;
  border: none;
  padding: 12px 24px;
  border-radius: 6px;
  font-size: 0.875rem;
  font-weight: 500;
  cursor: pointer;
  transition: background-color 0.15s ease-in-out;
}

.form-submit:hover {
  background-color: #2563eb;
}
</style>
