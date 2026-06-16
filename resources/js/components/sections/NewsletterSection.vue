<template>
  <section class="newsletter-section" :style="sectionStyles">
    <div class="newsletter-container" :style="containerStyles">
      <div class="newsletter-content" :style="contentStyles">
        <div class="newsletter-icon" :style="iconStyles">
          <i :class="section.icon || 'fas fa-envelope-open-text'"></i>
        </div>
        <h2 :style="titleStyles">{{ section.title || 'Mantente Informado' }}</h2>
        <p :style="descriptionStyles">{{ section.description || 'Suscríbete para recibir información sobre campañas de donación, eventos especiales y consejos de salud.' }}</p>
        
        <form @submit.prevent="handleSubmit" class="newsletter-form" :style="formStyles">
          <div class="form-group" :style="inputGroupStyles">
            <input
              v-model="email"
              type="email"
              placeholder="Ingresa tu correo electrónico"
              required
              :style="inputStyles"
            >
            <button type="submit" :style="buttonStyles" :disabled="loading">
              <span v-if="!loading">{{ section.buttonText || 'Suscribirme' }}</span>
              <span v-else><i class="fas fa-spinner fa-spin"></i></span>
              <i v-if="!loading" class="fas fa-arrow-right"></i>
            </button>
          </div>
          <p v-if="message" :class="['form-message', messageType]" :style="messageStyles">{{ message }}</p>
        </form>
        
        <div v-if="section.showStats" class="newsletter-stats" :style="statsStyles">
          <div class="stat-item" v-for="(stat, index) in stats" :key="index">
            <span class="stat-number" :style="statNumberStyles">{{ stat.number }}</span>
            <span class="stat-label" :style="statLabelStyles">{{ stat.label }}</span>
          </div>
        </div>
      </div>
      
      <div v-if="section.showImage" class="newsletter-image" :style="imageStyles">
        <img :src="section.image || '/images/newsletter-illustration.svg'" alt="Newsletter">
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed } from 'vue'
import axios from 'axios'

const props = defineProps({
  section: {
    type: Object,
    required: true
  }
})

const email = ref('')
const loading = ref(false)
const message = ref('')
const messageType = ref('success')

const stats = computed(() => props.section.stats || [
  { number: '10K+', label: 'Suscriptores' },
  { number: '50+', label: 'Campañas/año' },
  { number: '100%', label: 'Información útil' }
])

const sectionStyles = computed(() => ({
  padding: props.section.padding || '5rem 0',
  background: props.section.backgroundGradient || 'linear-gradient(135deg, #1a237e 0%, #0d1642 100%)',
  position: 'relative',
  overflow: 'hidden'
}))

const containerStyles = computed(() => ({
  maxWidth: '1200px',
  margin: '0 auto',
  padding: '0 2rem',
  display: 'flex',
  alignItems: 'center',
  gap: '4rem',
  flexDirection: props.section.layout === 'image-left' ? 'row-reverse' : 'row'
}))

const contentStyles = computed(() => ({
  flex: 1,
  textAlign: 'center',
  color: 'white'
}))

const iconStyles = computed(() => ({
  fontSize: '4rem',
  color: props.section.iconColor || '#C4A140',
  marginBottom: '1.5rem',
  display: 'inline-block'
}))

const titleStyles = computed(() => ({
  fontSize: props.section.titleSize || '2.5rem',
  marginBottom: '1rem',
  fontWeight: 600,
  color: 'white'
}))

const descriptionStyles = computed(() => ({
  fontSize: props.section.descriptionSize || '1.1rem',
  marginBottom: '2rem',
  opacity: 0.9,
  maxWidth: '500px',
  marginLeft: 'auto',
  marginRight: 'auto',
  lineHeight: 1.6
}))

const formStyles = computed(() => ({
  maxWidth: '500px',
  margin: '0 auto'
}))

const inputGroupStyles = computed(() => ({
  display: 'flex',
  gap: '0.5rem',
  background: 'white',
  padding: '0.5rem',
  borderRadius: '50px',
  boxShadow: '0 10px 30px rgba(0, 0, 0, 0.2)'
}))

const inputStyles = computed(() => ({
  flex: 1,
  border: 'none',
  padding: '1rem 1.5rem',
  fontSize: '1rem',
  outline: 'none',
  background: 'transparent',
  color: '#333'
}))

const buttonStyles = computed(() => ({
  background: `linear-gradient(135deg, ${props.section.buttonColor || '#d32f2f'} 0%, #9a0007 100%)`,
  color: 'white',
  border: 'none',
  padding: '1rem 2rem',
  borderRadius: '50px',
  fontSize: '1rem',
  fontWeight: 600,
  cursor: 'pointer',
  display: 'flex',
  alignItems: 'center',
  gap: '0.5rem',
  transition: 'all 0.3s ease',
  boxShadow: '0 4px 15px rgba(211, 47, 47, 0.3)'
}))

const messageStyles = computed(() => ({
  marginTop: '1rem',
  padding: '0.8rem 1rem',
  borderRadius: '10px',
  fontSize: '0.95rem',
  fontWeight: 500,
  background: messageType.value === 'success' ? 'rgba(76, 175, 80, 0.2)' : 'rgba(244, 67, 54, 0.2)',
  color: messageType.value === 'success' ? '#4caf50' : '#f44336'
}))

const statsStyles = computed(() => ({
  display: 'flex',
  justifyContent: 'center',
  gap: '3rem',
  marginTop: '3rem',
  paddingTop: '2rem',
  borderTop: '1px solid rgba(255, 255, 255, 0.2)'
}))

const statNumberStyles = computed(() => ({
  fontSize: '2rem',
  fontWeight: 'bold',
  color: props.section.accentColor || '#C4A140',
  display: 'block'
}))

const statLabelStyles = computed(() => ({
  fontSize: '0.9rem',
  opacity: 0.8,
  color: 'white'
}))

const imageStyles = computed(() => ({
  flex: 1,
  display: 'flex',
  justifyContent: 'center',
  alignItems: 'center'
}))

const handleSubmit = async () => {
  loading.value = true
  message.value = ''
  
  try {
    await axios.post('/api/newsletter/subscribe', { email: email.value })
    message.value = '¡Gracias por suscribirte! Pronto recibirás nuestras novedades.'
    messageType.value = 'success'
    email.value = ''
  } catch (error) {
    message.value = error.response?.data?.message || 'Hubo un error. Por favor intenta de nuevo.'
    messageType.value = 'error'
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
.newsletter-section::before {
  content: '';
  position: absolute;
  top: -50%;
  right: -20%;
  width: 600px;
  height: 600px;
  background: radial-gradient(circle, rgba(196, 161, 64, 0.1) 0%, transparent 70%);
  border-radius: 50%;
  pointer-events: none;
}

.newsletter-form button:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(211, 47, 47, 0.4);
}

.newsletter-form button:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

.newsletter-image img {
  max-width: 100%;
  height: auto;
  filter: drop-shadow(0 20px 40px rgba(0, 0, 0, 0.2));
}

@media (max-width: 968px) {
  .newsletter-container {
    flex-direction: column !important;
    gap: 2rem;
  }
  
  .newsletter-image {
    order: -1;
  }
  
  .newsletter-stats {
    flex-wrap: wrap;
    gap: 1.5rem;
  }
}

@media (max-width: 480px) {
  .input-group {
    flex-direction: column;
    border-radius: 20px;
  }
  
  .newsletter-form button {
    width: 100%;
    justify-content: center;
  }
}
</style>
