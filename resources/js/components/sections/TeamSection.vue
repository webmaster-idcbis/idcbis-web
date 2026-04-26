<template>
  <section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div v-if="!isEditing" class="grid gap-8" :class="`grid-cols-1 md:grid-cols-${section.content?.columns || 3}`">
        <div 
          v-for="(member, index) in section.content?.items" 
          :key="index"
          class="text-center"
        >
          <div class="w-32 h-32 mx-auto mb-4 rounded-full bg-gray-200 overflow-hidden">
            <img v-if="member.image" :src="member.image" :alt="member.name" class="w-full h-full object-cover">
            <div v-else class="w-full h-full flex items-center justify-center text-gray-400">
              <Users class="w-12 h-12" />
            </div>
          </div>
          <h3 class="text-lg font-semibold text-gray-900">{{ member.name }}</h3>
          <p class="text-[#005674] font-medium mb-2">{{ member.role }}</p>
          <p class="text-gray-600 text-sm">{{ member.bio }}</p>
        </div>
      </div>
      
      <div v-else class="space-y-4">
        <div class="flex items-center gap-4 mb-6">
          <label class="text-sm font-medium text-gray-700">Columnas:</label>
          <select 
            v-model="editableContent.columns" 
            @change="updateContent"
            class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#005674]"
          >
            <option :value="2">2</option>
            <option :value="3">3</option>
            <option :value="4">4</option>
          </select>
        </div>
        
        <div 
          v-for="(member, index) in editableContent.items" 
          :key="index"
          class="bg-gray-50 rounded-lg p-4 border border-gray-200 space-y-3"
        >
          <div class="flex items-center justify-between">
            <span class="font-medium text-gray-700">Miembro {{ index + 1 }}</span>
            <button 
              @click="removeMember(index)"
              class="text-red-500 hover:text-red-700"
            >
              <Trash2 class="w-4 h-4" />
            </button>
          </div>
          <input
            v-model="member.name"
            @input="updateContent"
            type="text"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#005674]"
            placeholder="Nombre"
          >
          <input
            v-model="member.role"
            @input="updateContent"
            type="text"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#005674]"
            placeholder="Cargo"
          >
          <input
            v-model="member.image"
            @input="updateContent"
            type="text"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#005674]"
            placeholder="URL de imagen"
          >
          <textarea
            v-model="member.bio"
            @input="updateContent"
            rows="2"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#005674]"
            placeholder="Biografía"
          ></textarea>
        </div>
        
        <button 
          @click="addMember"
          class="w-full py-2 border-2 border-dashed border-gray-300 rounded-lg text-gray-500 hover:border-[#005674] hover:text-[#005674] transition-colors"
        >
          <Plus class="w-4 h-4 inline mr-2" />
          Agregar miembro
        </button>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, watch } from 'vue';
import { Users, Plus, Trash2 } from 'lucide-vue-next';

const props = defineProps({
  section: { type: Object, required: true },
  isEditing: { type: Boolean, default: false }
});

const emit = defineEmits(['update']);

const editableContent = ref({
  columns: props.section.content?.columns || 3,
  items: props.section.content?.items || []
});

watch(() => props.section, (newSection) => {
  editableContent.value = {
    columns: newSection.content?.columns || 3,
    items: newSection.content?.items || []
  };
}, { deep: true });

const updateContent = () => {
  emit('update', { content: { ...editableContent.value } });
};

const addMember = () => {
  editableContent.value.items.push({
    name: 'Nuevo miembro',
    role: 'Cargo',
    image: '',
    bio: 'Breve descripción'
  });
  updateContent();
};

const removeMember = (index) => {
  editableContent.value.items.splice(index, 1);
  updateContent();
};
</script>
