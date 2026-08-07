import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import { DEFAULT_LOCALE, setI18nLocale, getStoredLocale } from '../i18n';

export const usePreferencesStore = defineStore('preferences', () => {
  const theme = ref(localStorage.getItem('theme') || 'light');
  const language = ref(getStoredLocale() || DEFAULT_LOCALE);
  
  const isDarkMode = computed(() => theme.value === 'dark');
  const currentLanguage = computed(() => language.value);
  
  const toggleTheme = () => {
    theme.value = theme.value === 'light' ? 'dark' : 'light';
    localStorage.setItem('theme', theme.value);
    applyTheme();
  };
  
  const setTheme = (newTheme) => {
    theme.value = newTheme;
    localStorage.setItem('theme', newTheme);
    applyTheme();
  };
  
  const setLanguage = (newLanguage) => {
    const next = setI18nLocale(newLanguage);
    language.value = next;
  };
  
  const applyTheme = () => {
    const html = document.documentElement;
    if (theme.value === 'dark') {
      html.classList.add('dark');
    } else {
      html.classList.remove('dark');
    }
  };
  
  const initTheme = () => {
    applyTheme();
  };

  const initLocale = () => {
    setLanguage(language.value);
  };
  
  return {
    theme,
    language,
    isDarkMode,
    currentLanguage,
    toggleTheme,
    setTheme,
    setLanguage,
    initTheme,
    initLocale,
  };
});
