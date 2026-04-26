<template>
  <footer class="bg-[#003C5F] text-white">
    <!-- Main Footer Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        
        <!-- Información Pública -->
        <div>
          <h3 class="text-yellow-400 font-semibold text-sm uppercase tracking-wider mb-4">
            Información Pública
          </h3>
          <ul class="space-y-2">
            <li v-for="item in infoPublica" :key="item.name">
              <a 
                :href="item.href" 
                class="text-sm text-white/80 hover:text-white transition-colors"
              >
                {{ item.name }}
              </a>
            </li>
          </ul>
        </div>

        <!-- Infórmate -->
        <div>
          <h3 class="text-yellow-400 font-semibold text-sm uppercase tracking-wider mb-4">
            Infórmate
          </h3>
          <ul class="space-y-2">
            <li v-for="item in informate" :key="item.name">
              <a 
                :href="item.href" 
                class="text-sm text-white/80 hover:text-white transition-colors"
              >
                {{ item.name }}
              </a>
            </li>
          </ul>
        </div>

        <!-- Logos Column -->
        <div class="flex flex-col gap-6">
          <!-- INS Logo -->
          <div class="bg-white p-3 rounded">
            <div class="flex items-center gap-2">
              <div class="w-8 h-8 bg-[#E31937] rounded-full flex items-center justify-center">
                <span class="text-white text-xs font-bold">INS</span>
              </div>
              <div class="text-[#003C5F] text-xs leading-tight">
                <p class="font-semibold">INSTITUTO</p>
                <p class="font-semibold">NACIONAL DE</p>
                <p class="font-semibold">SALUD</p>
              </div>
            </div>
          </div>

          <!-- Colombia Logo -->
          <div class="flex items-center gap-2">
            <div class="w-12 h-12 bg-yellow-400 rounded-full flex items-center justify-center">
              <span class="text-[#E31937] text-xl font-bold">CO</span>
            </div>
            <span class="text-sm font-semibold">COLOMBIA</span>
          </div>

          <!-- Ministerio de Salud -->
          <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-white/10 rounded flex items-center justify-center">
              <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
              </svg>
            </div>
            <span class="text-2xl font-light text-white/90">Salud</span>
          </div>
        </div>

        <!-- Contact Info -->
        <div>
          <h3 class="text-yellow-400 font-semibold text-sm uppercase tracking-wider mb-4">
            Contáctenos
          </h3>
          <div class="space-y-3 text-sm text-white/80">
            <p>Dirección: Carrera 32 # 12-81</p>
            <p>Torre 1 Piso 12 - Bogotá D.C.</p>
            <p>Teléfono: (601) 364 9624</p>
            <p>Email: contacto@idcbis.org.co</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Bottom Bar -->
    <div class="border-t border-white/10">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
          <p class="text-sm text-white/60 text-center md:text-left">
            © Copyright Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud IDCBIS 2026. Todos los derechos reservados.
          </p>
          <div class="flex items-center gap-6">
            <a href="#" class="text-sm text-yellow-400 hover:text-yellow-300">Accesibilidad</a>
            <a href="#" class="text-sm text-yellow-400 hover:text-yellow-300">Sitemap</a>
            <a href="#" class="text-sm text-yellow-400 hover:text-yellow-300">Contacto de Privacidad</a>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup>
import { ref } from 'vue';

const hasColombiaLogo = ref(false);

const infoPublica = [
  { name: 'Programa de Transparencia y Ética Pública', href: '#' },
  { name: 'Plan anticorrupción y atención al ciudadano', href: '#' },
  { name: 'Mapa de riesgos asociados a actos de corrupción', href: '#' },
  { name: 'Matriz de riesgos de lavado de activos', href: '#' },
  { name: 'Estados financieros', href: '#' },
  { name: 'Ejecución presupuestal', href: '#' },
  { name: 'Contratación bienes y servicios', href: '#' },
  { name: 'Invitación abierta', href: '#' },
  { name: 'Rendición de Cuentas', href: '#' },
  { name: 'Mapa del sitio', href: '#' },
];

const informate = [
  { name: 'Trabaje con nosotros', href: '#' },
  { name: 'Apoyo financiero', href: '#' },
  { name: 'Noticias', href: '#' },
  { name: 'Publicaciones científicas', href: '#' },
  { name: 'Atención a usuarios', href: '#' },
  { name: 'Política de protección de datos', href: '#' },
  { name: 'Política seguridad de la información', href: '#' },
  { name: 'Términos y condiciones', href: '#' },
  { name: 'Información a proveedores', href: '#' },
  { name: 'Contáctenos', href: '/contacto' },
];
</script>
