import './bootstrap';
import { createApp } from 'vue';
import { createPinia } from 'pinia';
import router from './router';
import App from './App.vue';
import { initI18n, getStoredLocale } from './i18n';
import { initAccessibility } from './composables/useAccessibility';

initI18n(getStoredLocale());
initAccessibility();

const app = createApp(App);

app.use(createPinia());
app.use(router);

app.mount('#app');
