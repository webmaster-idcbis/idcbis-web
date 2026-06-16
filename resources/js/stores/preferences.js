import { defineStore } from 'pinia';
import { ref, computed } from 'vue';

export const usePreferencesStore = defineStore('preferences', () => {
  // State
  const theme = ref(localStorage.getItem('theme') || 'light');
  const language = ref(localStorage.getItem('language') || 'es');
  
  // Getters
  const isDarkMode = computed(() => theme.value === 'dark');
  const currentLanguage = computed(() => language.value);
  
  // Actions
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
    language.value = newLanguage;
    localStorage.setItem('language', newLanguage);
  };
  
  const applyTheme = () => {
    const html = document.documentElement;
    if (theme.value === 'dark') {
      html.classList.add('dark');
    } else {
      html.classList.remove('dark');
    }
  };
  
  // Initialize theme on load
  const initTheme = () => {
    applyTheme();
  };
  
  return {
    theme,
    language,
    isDarkMode,
    currentLanguage,
    toggleTheme,
    setTheme,
    setLanguage,
    initTheme
  };
});
