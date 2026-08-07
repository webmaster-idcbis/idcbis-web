<template>
  <div
    class="form-element"
    :class="{ 'form-element--preview': preview, 'form-element--editor': !preview }"
    :style="formStyles"
    @click.stop="!preview && $emit('click', element)"
  >
    <header v-if="element.title || element.description" class="form-header">
      <h3 v-if="element.title" class="form-title">{{ element.title }}</h3>
      <p v-if="element.description" class="form-description">{{ element.description }}</p>
    </header>

    <div
      v-if="status === 'success'"
      class="form-feedback form-feedback--success"
      role="status"
      aria-live="polite"
    >
      {{ successMessage }}
    </div>

    <div
      v-else-if="status === 'error'"
      class="form-feedback form-feedback--error"
      role="alert"
      aria-live="assertive"
    >
      {{ errorMessage }}
    </div>

    <form
      v-if="status !== 'success'"
      class="form-content"
      novalidate
      @submit.prevent="handleSubmit"
    >
      <div
        v-for="field in element.fields"
        :key="field.name"
        class="form-field"
      >
        <label class="form-label" :for="fieldId(field.name)">
          {{ field.label }}
          <span v-if="field.required" class="required" aria-hidden="true">*</span>
          <span v-if="field.required" class="sr-only"> {{ t('form.required') }}</span>
        </label>

        <input
          v-if="field.type === 'text' || field.type === 'email'"
          :id="fieldId(field.name)"
          :type="field.type"
          :name="field.name"
          :placeholder="field.placeholder || field.label"
          :required="field.required"
          :disabled="submitting"
          class="form-input"
          :class="{ 'form-input--error': fieldErrors[field.name] }"
          :aria-invalid="fieldErrors[field.name] ? 'true' : undefined"
          :aria-describedby="fieldErrors[field.name] ? `${fieldId(field.name)}-error` : undefined"
        />

        <textarea
          v-else-if="field.type === 'textarea'"
          :id="fieldId(field.name)"
          :name="field.name"
          :placeholder="field.placeholder || field.label"
          :required="field.required"
          :rows="field.rows || 4"
          :disabled="submitting"
          class="form-textarea"
          :class="{ 'form-input--error': fieldErrors[field.name] }"
          :aria-invalid="fieldErrors[field.name] ? 'true' : undefined"
          :aria-describedby="fieldErrors[field.name] ? `${fieldId(field.name)}-error` : undefined"
        ></textarea>

        <select
          v-else-if="field.type === 'select'"
          :id="fieldId(field.name)"
          :name="field.name"
          :required="field.required"
          :disabled="submitting"
          class="form-select"
          :class="{ 'form-input--error': fieldErrors[field.name] }"
        >
          <option value="">{{ t('form.selectPlaceholder') }}</option>
          <option
            v-for="option in field.options"
            :key="option.value"
            :value="option.value"
          >
            {{ option.label }}
          </option>
        </select>

        <p
          v-if="fieldErrors[field.name]"
          :id="`${fieldId(field.name)}-error`"
          class="form-field-error"
          role="alert"
        >
          {{ fieldErrors[field.name] }}
        </p>
      </div>

      <div class="form-actions">
        <button
          type="submit"
          class="form-submit"
          :disabled="submitting"
          :aria-busy="submitting ? 'true' : undefined"
        >
          <span v-if="submitting">{{ t('form.submitting') }}</span>
          <span v-else>{{ element.submitLabel || t('form.submit') }}</span>
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue'
import axios from 'axios'
import { resolveBackgroundColor } from '../../composables/useElementStyles'
import { useI18n } from '../../i18n'

const props = defineProps({
  element: {
    type: Object,
    required: true,
  },
  preview: {
    type: Boolean,
    default: false,
  },
})

const emit = defineEmits(['click', 'submit'])
const { t } = useI18n()

const submitting = ref(false)
const status = ref('idle')
const errorMessage = ref('')
const fieldErrors = ref({})
const successMessage = ref('')

const formStyles = computed(() => ({
  backgroundColor: resolveBackgroundColor(props.element.backgroundColor, '#ffffff'),
  padding: props.element.padding || '2rem',
  borderRadius: props.element.borderRadius || '12px',
  boxShadow: props.preview ? '0 2px 12px rgba(0, 86, 116, 0.08)' : undefined,
  marginBottom: props.preview ? undefined : '16px',
}))

const fieldId = (name) => `form-${props.element.id || 'contact'}-${name}`

const collectFormData = (form) => {
  const formData = new FormData(form)
  const data = {}

  props.element.fields.forEach((field) => {
    data[field.name] = String(formData.get(field.name) || '').trim()
  })

  return data
}

const applyServerErrors = (errors) => {
  const mapped = {}
  Object.entries(errors).forEach(([key, messages]) => {
    if (Array.isArray(messages) && messages[0]) {
      mapped[key] = messages[0]
    }
  })
  fieldErrors.value = mapped
}

const handleSubmit = async (event) => {
  if (!props.preview) {
    event.preventDefault()
    const data = collectFormData(event.target)
    emit('submit', data)
    return
  }

  fieldErrors.value = {}
  errorMessage.value = ''
  submitting.value = true

  const data = collectFormData(event.target)

  try {
    const response = await axios.post('/api/contact', data)
    successMessage.value = response.data?.message || t('form.success')
    status.value = 'success'
    event.target.reset()
  } catch (error) {
    status.value = 'error'

    if (error.response?.status === 422) {
      applyServerErrors(error.response.data?.errors || {})
      errorMessage.value = t('form.validationError')
    } else {
      errorMessage.value =
        error.response?.data?.message ||
        t('form.sendError')
    }
  } finally {
    submitting.value = false
  }
}
</script>

<style scoped>
.form-element {
  font-family: var(--font-idcbis);
}

.form-element--editor {
  cursor: pointer;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.form-element--editor:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
}

.form-header {
  margin-bottom: 1.5rem;
}

.form-title {
  font-family: var(--font-idcbis-display);
  font-size: 1.5rem;
  font-weight: 700;
  color: #0b4f6c;
  margin: 0 0 0.5rem;
}

.form-description {
  margin: 0;
  color: #607d8b;
  font-size: 1rem;
  line-height: 1.65;
}

.form-field {
  margin-bottom: 1.25rem;
}

.form-label {
  display: block;
  font-size: 0.9375rem;
  font-weight: 600;
  color: #1a1a1a;
  margin-bottom: 0.5rem;
}

.required {
  color: #d32f2f;
  margin-left: 0.25rem;
}

.sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border: 0;
}

.form-input,
.form-textarea,
.form-select {
  width: 100%;
  padding: 0.75rem 1rem;
  border: 1px solid #cfd8dc;
  border-radius: 8px;
  font-size: 1rem;
  font-family: inherit;
  color: #1a1a1a;
  background: #fff;
  transition: border-color 0.15s ease, box-shadow 0.15s ease;
}

.form-input:focus-visible,
.form-textarea:focus-visible,
.form-select:focus-visible {
  outline: none;
  border-color: #005674;
  box-shadow: 0 0 0 3px rgba(0, 86, 116, 0.2);
}

.form-input--error {
  border-color: #d32f2f;
}

.form-textarea {
  resize: vertical;
  min-height: 120px;
}

.form-field-error {
  margin: 0.375rem 0 0;
  font-size: 0.875rem;
  color: #d32f2f;
}

.form-actions {
  margin-top: 1.5rem;
}

.form-submit {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-height: 44px;
  min-width: 140px;
  padding: 0.75rem 1.5rem;
  background-color: #005674;
  color: #fff;
  border: none;
  border-radius: 8px;
  font-size: 1rem;
  font-weight: 600;
  font-family: inherit;
  cursor: pointer;
  transition: background-color 0.15s ease;
}

.form-submit:hover:not(:disabled) {
  background-color: #003c5f;
}

.form-submit:focus-visible {
  outline: none;
  box-shadow: 0 0 0 3px rgba(0, 86, 116, 0.35);
}

.form-submit:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

.form-feedback {
  padding: 1rem 1.25rem;
  border-radius: 8px;
  font-size: 1rem;
  line-height: 1.6;
}

.form-feedback--success {
  background: #e8f5e9;
  color: #1b5e20;
  border: 1px solid #a5d6a7;
}

.form-feedback--error {
  background: #ffebee;
  color: #b71c1c;
  border: 1px solid #ef9a9a;
  margin-bottom: 1rem;
}

@media (prefers-reduced-motion: reduce) {
  .form-element--editor {
    transition: none;
  }

  .form-element--editor:hover {
    transform: none;
  }
}
</style>
