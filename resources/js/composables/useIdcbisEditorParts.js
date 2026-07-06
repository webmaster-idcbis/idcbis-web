import { computed } from 'vue'

export function useIdcbisEditorParts(props, emit) {
  const isEditorMode = computed(() => !props.preview)

  const partClasses = (anchor) => {
    if (!isEditorMode.value) return {}
    return {
      'editor-part-target': true,
      'editor-part-target--active': props.focusedPart === anchor,
    }
  }

  const focusPart = (anchor, label, event) => {
    if (props.preview) return
    event?.stopPropagation?.()
    emit('focus-part', { anchor, label })
  }

  return { isEditorMode, partClasses, focusPart }
}
