<template>
  <section class="process-section" :style="sectionStyles">
    <div class="process-container">
      <div v-if="section.showTitle" class="section-header" :style="headerStyles">
        <h2 :style="titleStyles">{{ section.title || 'Proceso de Donación' }}</h2>
        <p :style="subtitleStyles">{{ section.subtitle || '4 pasos simples para salvar vidas' }}</p>
      </div>
      
      <div class="process-timeline" :class="{ 'horizontal': layout === 'horizontal', 'vertical': layout === 'vertical' }">
        <div
          v-for="(step, index) in steps"
          :key="index"
          class="process-step"
          :style="stepStyles"
          :class="{ 'active': index <= activeStep }"
        >
          <div class="step-number" :style="numberStyles">
            <span>{{ index + 1 }}</span>
          </div>
          <div class="step-content" :style="contentStyles">
            <div class="step-icon" :style="iconStyles">
              <i :class="step.icon"></i>
            </div>
            <h3 class="step-title" :style="stepTitleStyles">{{ step.title }}</h3>
            <p class="step-description" :style="descriptionStyles">{{ step.description }}</p>
            <span v-if="step.time" class="step-time" :style="timeStyles">
              <i class="fas fa-clock"></i> {{ step.time }}
            </span>
          </div>
          <div v-if="index < steps.length - 1" class="step-connector" :style="connectorStyles"></div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed, ref, onMounted } from 'vue'

const props = defineProps({
  section: {
    type: Object,
    required: true
  }
})

const activeStep = ref(0)

const layout = computed(() => props.section.layout || 'horizontal')

const steps = computed(() => {
  return props.section.steps || [
    {
      icon: 'fas fa-clipboard-list',
      title: 'Registro',
      description: 'Llena el formulario de donante con tus datos personales y de contacto.',
      time: '2 min'
    },
    {
      icon: 'fas fa-stethoscope',
      title: 'Evaluación Médica',
      description: 'Un profesional de salud revisa tus signos vitales y historia clínica.',
      time: '5 min'
    },
    {
      icon: 'fas fa-tint',
      title: 'Donación',
      description: 'Proceso indoloro y seguro de extracción de sangre.',
      time: '8-10 min'
    },
    {
      icon: 'fas fa-coffee',
      title: 'Recuperación',
      description: 'Disfruta de refrigerios y descansa antes de retirarte.',
      time: '15 min'
    }
  ]
})

const sectionStyles = computed(() => ({
  padding: props.section.padding || '4rem 0',
  backgroundColor: props.section.backgroundColor || '#f5f7fa',
  position: 'relative'
}))

const headerStyles = computed(() => ({
  textAlign: 'center',
  marginBottom: '3rem'
}))

const titleStyles = computed(() => ({
  fontSize: props.section.titleSize || '2.5rem',
  color: props.section.titleColor || '#1a237e',
  marginBottom: '1rem',
  fontWeight: 600
}))

const subtitleStyles = computed(() => ({
  fontSize: props.section.subtitleSize || '1.2rem',
  color: props.section.subtitleColor || '#607d8b',
  maxWidth: '600px',
  margin: '0 auto'
}))

const stepStyles = computed(() => ({
  flex: 1,
  textAlign: 'center',
  position: 'relative',
  padding: '0 1rem'
}))

const numberStyles = computed(() => ({
  width: '50px',
  height: '50px',
  borderRadius: '50%',
  background: `linear-gradient(135deg, ${props.section.primaryColor || '#d32f2f'} 0%, ${props.section.primaryDark || '#9a0007'} 100%)`,
  color: 'white',
  display: 'flex',
  alignItems: 'center',
  justifyContent: 'center',
  fontSize: '1.5rem',
  fontWeight: 'bold',
  margin: '0 auto 1rem',
  boxShadow: '0 4px 15px rgba(211, 47, 47, 0.3)',
  position: 'relative',
  zIndex: 2
}))

const contentStyles = computed(() => ({
  background: 'white',
  padding: '2rem',
  borderRadius: '20px',
  boxShadow: '0 10px 30px rgba(0, 0, 0, 0.08)',
  transition: 'all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.1)',
  position: 'relative',
  zIndex: 1
}))

const iconStyles = computed(() => ({
  fontSize: '2.5rem',
  color: props.section.primaryColor || '#d32f2f',
  marginBottom: '1rem'
}))

const stepTitleStyles = computed(() => ({
  fontSize: '1.3rem',
  color: '#1a237e',
  marginBottom: '0.5rem',
  fontWeight: 600
}))

const descriptionStyles = computed(() => ({
  fontSize: '0.95rem',
  color: '#607d8b',
  lineHeight: 1.6,
  marginBottom: '1rem'
}))

const timeStyles = computed(() => ({
  display: 'inline-flex',
  alignItems: 'center',
  gap: '0.5rem',
  fontSize: '0.85rem',
  color: props.section.primaryColor || '#d32f2f',
  fontWeight: 600,
  background: 'rgba(211, 47, 47, 0.1)',
  padding: '0.4rem 1rem',
  borderRadius: '20px'
}))

const connectorStyles = computed(() => ({
  position: 'absolute',
  top: '25px',
  left: '60%',
  width: '80%',
  height: '3px',
  background: `linear-gradient(90deg, ${props.section.primaryColor || '#d32f2f'} 0%, ${props.section.accentColor || '#00acc1'} 100%)`,
  zIndex: 0
}))

onMounted(() => {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        let step = 0
        const interval = setInterval(() => {
          if (step < steps.value.length) {
            activeStep.value = step
            step++
          } else {
            clearInterval(interval)
          }
        }, 500)
      }
    })
  }, { threshold: 0.5 })
  
  observer.observe(document.querySelector('.process-section'))
})
</script>

<style scoped>
.process-section {
  overflow: hidden;
}

.process-container {
  max-width: 1400px;
  margin: 0 auto;
  padding: 0 2rem;
}

.process-timeline {
  display: flex;
  justify-content: space-between;
  gap: 2rem;
}

.process-timeline.vertical {
  flex-direction: column;
}

.process-step {
  opacity: 0.6;
  transform: translateY(20px);
  transition: all 0.5s ease;
}

.process-step.active {
  opacity: 1;
  transform: translateY(0);
}

.process-step:hover .step-content {
  transform: translateY(-10px);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.step-number span {
  display: block;
  transition: transform 0.3s ease;
}

.process-step.active .step-number span {
  transform: scale(1.2);
}

@media (max-width: 968px) {
  .process-timeline {
    flex-direction: column;
    gap: 2rem;
  }
  
  .step-connector {
    display: none;
  }
  
  .process-step {
    width: 100%;
  }
}
</style>
