import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useUiStore = defineStore('ui', () => {
  const flash = ref(null);

  const setFlash = (message, type = 'success') => {
    flash.value = { message, type, id: Date.now() };
  };

  const clearFlash = () => {
    flash.value = null;
  };

  return { flash, setFlash, clearFlash };
});
