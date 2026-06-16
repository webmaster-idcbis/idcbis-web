<template>
  <div id="app" class="min-h-screen bg-gray-100 dark:bg-[#0f1419] font-sans antialiased">
    <router-view />
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { usePreferencesStore } from './stores/preferences';

const preferencesStore = usePreferencesStore();

onMounted(() => {
  preferencesStore.initTheme();
});
</script>
