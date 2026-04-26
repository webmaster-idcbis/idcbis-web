<template>
  <section class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <div v-if="!isEditing" class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ section.content?.title }}</h2>
        <p class="text-lg text-gray-600">{{ section.content?.subtitle }}</p>
      </div>
      
      <div v-if="!isEditing" class="grid md:grid-cols-3 gap-8 mb-12">
        <div class="text-center">
          <div class="w-12 h-12 bg-[#005674] rounded-lg flex items-center justify-center mx-auto mb-4">
            <Mail class="w-6 h-6 text-white" />
          </div>
          <h3 class="font-semibold text-gray-900 mb-1">Email</h3>
          <p class="text-gray-600">{{ section.content?.email }}</p>
        </div>
        <div class="text-center">
          <div class="w-12 h-12 bg-[#005674] rounded-lg flex items-center justify-center mx-auto mb-4">
            <Phone class="w-6 h-6 text-white" />
          </div>
          <h3 class="font-semibold text-gray-900 mb-1">Teléfono</h3>
          <p class="text-gray-600">{{ section.content?.phone }}</p>
        </div>
        <div class="text-center">
          <div class="w-12 h-12 bg-[#005674] rounded-lg flex items-center justify-center mx-auto mb-4">
            <MapPin class="w-6 h-6 text-white" />
          </div>
          <h3 class="font-semibold text-gray-900 mb-1">Dirección</h3>
          <p class="text-gray-600">{{ section.content?.address }}</p>
        </div>
      </div>
      
      <div v-if="!isEditing" class="bg-white rounded-xl p-8 shadow-sm">
        <form @submit.prevent class="space-y-4">
          <div class="grid md:grid-cols-2 gap-4">
            <input type="text" placeholder="Nombre" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#005674] focus:border-transparent">
            <input type="email" placeholder="Email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#005674] focus:border-transparent">
          </div>
          <input type="text" placeholder="Asunto" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#005674] focus:border-transparent">
          <textarea rows="4" placeholder="Mensaje" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#005674] focus:border-transparent resize-none"></textarea>
          <button type="submit" class="w-full py-3 bg-[#005674] text-white font-semibold rounded-lg hover:bg-[#003C5F] transition-colors">
            Enviar mensaje
          </button>
        </form>
      </div>
      
      <div v-else class="space-y-4">
        <h3 class="font-semibold text-gray-900 mb-4">Editar información de contacto</h3>
        <input
          v-model="editableContent.title"
          @input="updateContent"
          type="text"
          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#005674]"
          placeholder="Título"
        >
        <input
          v-model="editableContent.subtitle"
          @input="updateContent"
          type="text"
          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#005674]"
          placeholder="Subtítulo"
        >
        <input
          v-model="editableContent.email"
          @input="updateContent"
          type="email"
          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#005674]"
          placeholder="Email"
        >
        <input
          v-model="editableContent.phone"
          @input="updateContent"
          type="tel"
          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#005674]"
          placeholder="Teléfono"
        >
        <textarea
          v-model="editableContent.address"
          @input="updateContent"
          rows="2"
          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#005674]"
          placeholder="Dirección"
        ></textarea>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, watch } from 'vue';
import { Mail, Phone, MapPin } from 'lucide-vue-next';

const props = defineProps({
  section: { type: Object, required: true },
  isEditing: { type: Boolean, default: false }
});

const emit = defineEmits(['update']);

const editableContent = ref({
  title: props.section.content?.title || 'Contáctanos',
  subtitle: props.section.content?.subtitle || 'Estamos aquí para ayudarte',
  email: props.section.content?.email || 'contacto@ejemplo.com',
  phone: props.section.content?.phone || '+57 300 000 0000',
  address: props.section.content?.address || 'Dirección de la oficina'
});

watch(() => props.section, (newSection) => {
  editableContent.value = {
    title: newSection.content?.title || 'Contáctanos',
    subtitle: newSection.content?.subtitle || 'Estamos aquí para ayudarte',
    email: newSection.content?.email || 'contacto@ejemplo.com',
    phone: newSection.content?.phone || '+57 300 000 0000',
    address: newSection.content?.address || 'Dirección de la oficina'
  };
}, { deep: true });

const updateContent = () => {
  emit('update', { content: { ...editableContent.value } });
};
</script>
