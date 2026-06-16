<template>
  <footer class="bg-[#003C5F] text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

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

        <!-- Logos institucionales -->
        <div class="flex flex-col gap-5 items-start">
          <router-link to="/" class="block">
            <img
              :src="siteLogos.footer.src"
              :alt="siteLogos.footer.alt"
              :class="siteLogos.footer.class"
            >
          </router-link>
          <img
            :src="institutional.idcbisInstitute.src"
            :alt="institutional.idcbisInstitute.alt"
            :class="institutional.idcbisInstitute.class"
          >
          <img
            :src="institutional.colombia.src"
            :alt="institutional.colombia.alt"
            :class="institutional.colombia.class"
          >
          <img
            :src="institutional.ministerioSalud.src"
            :alt="institutional.ministerioSalud.alt"
            :class="institutional.ministerioSalud.class"
          >
        </div>

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
import { SITE_LOGOS, INSTITUTIONAL_LOGOS } from '../../config/siteLogos';

const siteLogos = SITE_LOGOS;
const institutional = INSTITUTIONAL_LOGOS;

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
