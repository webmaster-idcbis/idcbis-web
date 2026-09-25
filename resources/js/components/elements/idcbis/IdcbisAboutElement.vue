<template>
  <section
    class="idcbis-about"
    :class="{ 'idcbis-about--clean': element.variant === 'clean' }"
    @click.stop="$emit('click', element)"
  >
    <div class="idcbis-about__flex">
      <div
        class="idcbis-about__text"
        :class="partClasses('about:text')"
        @click.stop="focusPart('about:text', 'Texto Somos IDCBIS', $event)"
      >
        <div v-if="element.leaderName" class="idcbis-about__leader">
          <span class="idcbis-about__leader-label">{{ element.leaderLabel || 'Línea de servicio' }}</span>
          <strong>{{ element.leaderName }}</strong>
          <span v-if="element.leaderContact" class="idcbis-about__leader-contact">{{ element.leaderContact }}</span>
        </div>
        <h2>{{ element.title || 'Somos IDCBIS' }}</h2>
        <div class="idcbis-about__body">{{ element.content }}</div>
        <blockquote v-if="element.quote" class="idcbis-about__quote">
          <p>{{ element.quote }}</p>
          <footer v-if="element.quoteAuthor">
            <cite>{{ element.quoteAuthor }}</cite>
            <span v-if="element.quoteRole">, {{ element.quoteRole }}</span>
          </footer>
        </blockquote>
        <component
          :is="preview ? 'a' : 'button'"
          v-if="element.buttonText"
          class="idcbis-about__cta"
          :href="preview ? (element.buttonUrl || '#') : undefined"
          type="button"
          @click.stop="!preview && $event.preventDefault()"
        >
          {{ element.buttonText }}
        </component>
      </div>
      <div
        v-if="element.image"
        class="idcbis-about__image-wrap"
        :class="[isLogoImage ? 'idcbis-about__image-wrap--logo' : '', partClasses('about:image')]"
        @click.stop="focusPart('about:image', 'Imagen Somos IDCBIS', $event)"
      >
        <img :src="element.image" :alt="element.imageAlt || 'IDCBIS'" class="idcbis-about__image" :class="{ 'idcbis-about__image--logo': isLogoImage }">
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { useIdcbisEditorParts } from '../../../composables/useIdcbisEditorParts'

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
  focusedPart: { type: String, default: null },
})

const emit = defineEmits(['click', 'focus-part'])
const { partClasses, focusPart } = useIdcbisEditorParts(props, emit)

const isLogoImage = computed(() => {
  const src = props.element.image || ''
  return src.includes('/images/logo/') || src.includes('logo-IDCBIS') || src.includes('Logo%20IDCBIS') || src.includes('Logo IDCBIS')
})
</script>

<style scoped>
.idcbis-about {
  padding: 5rem 2rem;
  background: #f5f8fa;
  cursor: pointer;
  font-family: var(--font-idcbis);
}

.idcbis-about__flex {
  max-width: 1400px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  gap: 4rem;
  background: white;
  padding: 3rem;
  border-radius: 80px 20px 80px 20px;
  box-shadow: 0 20px 30px rgba(0, 0, 0, 0.05);
}

.idcbis-about__text {
  flex: 1;
}

.idcbis-about__text h2 {
  font-family: var(--font-idcbis-display);
  font-size: clamp(2rem, 3vw, 2.8rem);
  font-weight: 800;
  margin: 0 0 1rem;
  color: #0B4F6C;
  line-height: 1.15;
}

.idcbis-about__leader {
  margin-bottom: 1.25rem;
  padding: 1rem 1.25rem;
  background: #e1f0f5;
  border-radius: 12px;
  border-left: 4px solid #0b4f6c;
}

.idcbis-about__leader-label {
  display: block;
  font-size: 0.7rem;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  color: #2c8c99;
  margin-bottom: 0.25rem;
}

.idcbis-about__leader strong {
  display: block;
  color: #0b4f6c;
  font-size: 1.1rem;
}

.idcbis-about__leader-contact {
  display: block;
  font-size: 0.9rem;
  color: #555;
  margin-top: 0.35rem;
  white-space: pre-line;
}

.idcbis-about__body {
  font-size: 1.05rem;
  color: #1a1a1a;
  line-height: 1.65;
  white-space: pre-line;
}

.idcbis-about__quote {
  margin: 1.25rem 0 0;
  padding: 0.9rem 1rem 0.9rem 1.1rem;
  border-left: 4px solid #C4A140;
  background: #f8f9fa;
  border-radius: 0 0.75rem 0.75rem 0;
}

.idcbis-about__quote p {
  margin: 0;
  color: #003C5F;
  font-size: 1.05rem;
  line-height: 1.5;
}

.idcbis-about__quote footer {
  margin-top: 0.45rem;
  color: #607d8b;
  font-size: 0.95rem;
  font-style: normal;
}

.idcbis-about__quote cite {
  font-style: normal;
  font-weight: 700;
  color: #0B4F6C;
}

.idcbis-about__cta {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  margin-top: 1.25rem;
  min-height: 44px;
  padding: 0.7rem 1.25rem;
  border-radius: 999px;
  background: #005674;
  color: #ffffff;
  font-weight: 700;
  text-decoration: none;
  border: 2px solid #005674;
}

.idcbis-about__cta:hover {
  background: #003C5F;
  border-color: #003C5F;
}

.idcbis-about__cta:focus-visible {
  outline: 3px solid #005674;
  outline-offset: 3px;
}

.idcbis-about__image-wrap {
  background: linear-gradient(135deg, #0b4f6c, #2c8c99);
  padding: 1rem;
  border-radius: 50% 50% 30% 30%;
  flex-shrink: 0;
}

.idcbis-about__image {
  max-width: 420px;
  width: 100%;
  height: auto;
  aspect-ratio: 4 / 3;
  object-fit: cover;
  border-radius: 1.25rem;
  display: block;
}

.idcbis-about--clean {
  padding: 4rem 1.5rem;
  background: #ffffff;
}

.idcbis-about--clean .idcbis-about__flex {
  max-width: 1100px;
  align-items: center;
  gap: 3.5rem;
  background: transparent;
  padding: 0;
  border-radius: 0;
  box-shadow: none;
}

.idcbis-about--clean .idcbis-about__image-wrap,
.idcbis-about--clean .idcbis-about__image-wrap--logo {
  background: transparent;
  padding: 0;
  border-radius: 0;
  flex: 1 1 46%;
  width: auto;
  max-width: 520px;
}

.idcbis-about--clean .idcbis-about__image,
.idcbis-about--clean .idcbis-about__image--logo {
  max-width: 100%;
  width: 100%;
  height: auto;
  aspect-ratio: 3 / 2;
  object-fit: cover;
  object-position: center;
  border-radius: 0;
  box-shadow: none;
  background: transparent;
}

.idcbis-about--clean .idcbis-about__text h2 {
  text-align: center;
}

.idcbis-about--clean .idcbis-about__cta {
  display: flex;
  width: fit-content;
  margin-left: auto;
  margin-right: auto;
}

.idcbis-about--clean .idcbis-about__body {
  text-align: justify;
  hyphens: auto;
  -webkit-hyphens: auto;
}

.idcbis-about--clean .idcbis-about__quote {
  margin: 1.5rem 0 0;
  padding: 0;
  border: none;
  background: transparent;
  text-align: center;
}

.idcbis-about--clean .idcbis-about__quote p {
  font-size: 1.25rem;
  font-weight: 700;
  line-height: 1.4;
  color: #0B4F6C;
  text-align: center;
}

.idcbis-about--clean .idcbis-about__quote p::before {
  content: "“";
  display: block;
  margin-bottom: 0.15rem;
  font-family: Georgia, "Times New Roman", serif;
  font-size: 2.75rem;
  font-weight: 700;
  line-height: 0.8;
  color: #C4A140;
}

@media (max-width: 900px) {
  .idcbis-about--clean {
    padding: 2.5rem 1.25rem;
  }

  .idcbis-about--clean .idcbis-about__flex {
    gap: 1.75rem;
    padding: 0;
    border-radius: 0;
  }

  .idcbis-about--clean .idcbis-about__image-wrap,
  .idcbis-about--clean .idcbis-about__image-wrap--logo {
    flex: none;
    width: 100%;
    max-width: none;
  }

  .idcbis-about--clean .idcbis-about__image,
  .idcbis-about--clean .idcbis-about__image--logo {
    max-width: none;
  }
}

.idcbis-about__image-wrap--logo {
  background: transparent;
  padding: 0;
  border-radius: 0;
}

.idcbis-about__image--logo {
  max-width: 320px;
  aspect-ratio: auto;
  border-radius: 12px;
  object-fit: contain;
  box-shadow: 0 8px 24px rgba(11, 79, 108, 0.12);
}

@media (max-width: 900px) {
  .idcbis-about {
    padding: 2.5rem 1rem;
  }

  .idcbis-about__flex {
    flex-direction: column;
    gap: 1.5rem;
    padding: 1.25rem;
    border-radius: 1.25rem;
  }

  .idcbis-about__image {
    max-width: none;
  }
}

@media (prefers-reduced-motion: reduce) {
  .idcbis-about__cta {
    transition: none;
  }
}
</style>
