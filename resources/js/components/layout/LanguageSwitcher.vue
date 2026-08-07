<template>
  <div
    class="language-switcher"
    :class="compact ? 'language-switcher--compact' : 'language-switcher--default'"
    role="group"
    :aria-label="t('language.switcherLabel')"
  >
    <button
      v-for="item in availableLocales"
      :key="item.code"
      type="button"
      class="language-switcher__btn"
      :class="{ 'language-switcher__btn--active': locale === item.code }"
      :aria-pressed="locale === item.code"
      :aria-label="t(item.labelKey)"
      :title="t(item.labelKey)"
      @click="selectLocale(item.code)"
    >
      {{ item.short }}
    </button>
  </div>
</template>

<script setup>
import { useI18n } from '../../i18n'
import { usePreferencesStore } from '../../stores/preferences'

defineProps({
  compact: {
    type: Boolean,
    default: false,
  },
})

const preferencesStore = usePreferencesStore()
const { locale, availableLocales, t } = useI18n()

const selectLocale = (code) => {
  if (code === locale.value) {
    return
  }
  preferencesStore.setLanguage(code)
  document.documentElement.lang = code
}
</script>

<style scoped>
.language-switcher {
  display: inline-flex;
  align-items: center;
  gap: 0.15rem;
  padding: 0.15rem;
  border-radius: 0.375rem;
  border: 1px solid rgba(255, 255, 255, 0.35);
  background: rgba(0, 0, 0, 0.12);
}

.language-switcher--compact {
  border-color: rgba(0, 86, 116, 0.25);
  background: rgba(0, 86, 116, 0.06);
}

.language-switcher__btn {
  min-width: 2.75rem;
  min-height: 2.75rem;
  padding: 0.25rem 0.55rem;
  border-radius: 0.25rem;
  font-size: 0.75rem;
  font-weight: 700;
  letter-spacing: 0.04em;
  line-height: 1;
  color: rgba(255, 255, 255, 0.85);
  transition: background-color 0.15s ease, color 0.15s ease;
}

.language-switcher--compact .language-switcher__btn {
  color: #005674;
}

.language-switcher__btn:hover {
  background: rgba(255, 255, 255, 0.12);
  color: #fff;
}

.language-switcher--compact .language-switcher__btn:hover {
  background: rgba(0, 86, 116, 0.12);
  color: #003c5f;
}

.language-switcher__btn:focus-visible {
  outline: 2px solid #c4a140;
  outline-offset: 2px;
}

.language-switcher--compact .language-switcher__btn:focus-visible {
  outline-color: #005674;
}

.language-switcher__btn--active {
  background: #c4a140;
  color: #003c5f;
}

.language-switcher--compact .language-switcher__btn--active {
  background: #005674;
  color: #fff;
}

@media (prefers-reduced-motion: reduce) {
  .language-switcher__btn {
    transition: none;
  }
}
</style>
