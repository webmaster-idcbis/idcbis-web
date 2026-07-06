<template>
  <section class="team-grid" @click.stop="!preview && $emit('click', element)">
    <div class="team-grid__container">
      <header
        v-if="element.sectionTitle"
        class="team-grid__header"
        :class="partClasses('team:header')"
        @click.stop="focusPart('team:header', element.sectionTitle, $event)"
      >
        <span v-if="element.sectionIcon" class="team-grid__icon" aria-hidden="true">{{ element.sectionIcon }}</span>
        <h2>{{ element.sectionTitle }}</h2>
      </header>

      <div class="team-grid__grid">
        <article
          v-for="(member, index) in members"
          :key="member.id || index"
          class="team-card"
          :class="partClasses(memberAnchor(member, index))"
          @click.stop="onMemberClick(member, index, $event)"
        >
          <div class="team-card__photo-wrap">
            <img
              :src="photoSrc(member)"
              :alt="member.name"
              class="team-card__photo"
              loading="lazy"
              @error="onPhotoError($event, member)"
            >
          </div>
          <div class="team-card__body">
            <h3>{{ member.name }}</h3>
            <p class="team-card__role">{{ member.role }}</p>
            <p v-if="member.credentials" class="team-card__credentials">{{ member.credentials }}</p>
            <component
              :is="preview && member.email ? 'a' : 'span'"
              v-if="member.email"
              :href="preview ? `mailto:${member.email}` : undefined"
              class="team-card__email"
              @click.stop
            >{{ member.email }}</component>
          </div>
        </article>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { teamPhotoUrl, avatarFallbackUrl } from '../../../config/idcbisTeamPhotos'
import { useIdcbisEditorParts } from '../../../composables/useIdcbisEditorParts'
import { buildTeamFocusAnchor } from '../../../utils/editorPartFocus'

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
  focusedPart: { type: String, default: null },
})

const emit = defineEmits(['click', 'focus-part'])
const { partClasses, focusPart } = useIdcbisEditorParts(props, emit)

const members = computed(() => props.element.members || [])

const memberAnchor = (member, index) => buildTeamFocusAnchor(member.id || `index-${index}`)

const photoSrc = (member) => teamPhotoUrl(member)

const onPhotoError = (event, member) => {
  event.target.src = avatarFallbackUrl(member.name)
}

const onMemberClick = (member, index, event) => {
  focusPart(memberAnchor(member, index), member.name || `Miembro ${index + 1}`, event)
  if (!props.preview) emit('click', props.element)
}
</script>

<style scoped>
.team-grid {
  padding: 4rem 2rem;
  background: #fff;
  font-family: var(--font-idcbis);
  cursor: pointer;
}

.team-grid__container { max-width: 1200px; margin: 0 auto; }

.team-grid__header {
  text-align: center;
  margin-bottom: 2.5rem;
}

.team-grid__header h2 {
  margin: 0;
  font-size: clamp(1.5rem, 3vw, 2rem);
  color: #0b4f6c;
  text-transform: uppercase;
}

.team-grid__icon { display: block; font-size: 2rem; margin-bottom: 0.5rem; }

.team-grid__grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
  gap: 1.5rem;
}

.team-card {
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 16px;
  overflow: hidden;
  transition: box-shadow 0.2s;
}

.team-card__photo-wrap { aspect-ratio: 1; overflow: hidden; background: #e8f4f8; }

.team-card__photo { width: 100%; height: 100%; object-fit: cover; }

.team-card__body { padding: 1.25rem; }

.team-card__body h3 {
  margin: 0 0 0.35rem;
  font-size: 1rem;
  font-weight: 700;
  color: #0b4f6c;
}

.team-card__role { margin: 0 0 0.25rem; font-size: 0.875rem; color: #64748b; }

.team-card__credentials { margin: 0 0 0.5rem; font-size: 0.8125rem; color: #94a3b8; }

.team-card__email { font-size: 0.8125rem; color: #2c8c99; text-decoration: none; }
</style>
