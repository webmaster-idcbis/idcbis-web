<template>
  <MainLayout>
    <div class="bg-white">
      <!-- Hero Section -->
      <section class="relative bg-gradient-to-br from-[#005674] to-[#008996] py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-6">
              Instituto Distrital de Ciencia,<br />Biotecnología e Innovación en Salud
            </h1>
            <p class="text-xl text-white/90 max-w-3xl mx-auto">
              Lideramos el desarrollo científico y tecnológico en salud para el beneficio de todos los habitantes de Bogotá.
            </p>
            <div class="mt-8 flex justify-center gap-4">
              <router-link 
                to="/servicios"
                class="px-6 py-3 bg-yellow-400 text-[#003C5F] font-semibold rounded-lg hover:bg-yellow-300 transition-colors"
              >
                Nuestros Servicios
              </router-link>
              <router-link 
                to="/el-instituto"
                class="px-6 py-3 bg-white/20 text-white font-semibold rounded-lg hover:bg-white/30 transition-colors"
              >
                Conózcanos
              </router-link>
            </div>
          </div>
        </div>
      </section>

      <!-- Features Section -->
      <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
              <div class="w-12 h-12 bg-[#005674]/10 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-[#005674]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                </svg>
              </div>
              <h3 class="text-xl font-semibold text-gray-900 mb-2">Investigación</h3>
              <p class="text-gray-600">Desarrollamos proyectos de investigación científica de alto impacto en salud pública.</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
              <div class="w-12 h-12 bg-[#008996]/10 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-[#008996]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
              </div>
              <h3 class="text-xl font-semibold text-gray-900 mb-2">Biotecnología</h3>
              <p class="text-gray-600">Aplicamos tecnologías de punta para el desarrollo de soluciones en salud.</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
              <div class="w-12 h-12 bg-[#003C5F]/10 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-[#003C5F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
              </div>
              <h3 class="text-xl font-semibold text-gray-900 mb-2">Innovación</h3>
              <p class="text-gray-600">Transformamos el sistema de salud a través de la innovación y el conocimiento.</p>
            </div>
          </div>
        </div>
      </section>
    </div>
  </MainLayout>
</template>

<script setup>
import MainLayout from '../components/layout/MainLayout.vue';
</script>
