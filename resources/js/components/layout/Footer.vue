<template>
  <footer class="bg-[#003C5F] text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

        <div>
          <h3 class="text-[#C4A140] font-semibold text-sm uppercase tracking-wider mb-4">
            Información Pública
          </h3>
          <ul class="space-y-2">
            <li v-for="item in infoPublica" :key="item.href">
              <router-link
                :to="item.href"
                class="text-sm text-white/80 hover:text-white transition-colors"
              >
                {{ item.name }}
              </router-link>
            </li>
          </ul>
        </div>

        <div>
          <h3 class="text-[#C4A140] font-semibold text-sm uppercase tracking-wider mb-4">
            Infórmate
          </h3>
          <ul class="space-y-2">
            <li v-for="item in informate" :key="item.href">
              <router-link
                :to="item.href"
                class="text-sm text-white/80 hover:text-white transition-colors"
              >
                {{ item.name }}
              </router-link>
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
          <h3 class="text-[#C4A140] font-semibold text-sm uppercase tracking-wider mb-4">
            Contáctenos
          </h3>
          <div class="space-y-3 text-sm text-white/80">
            <p>Dirección: Carrera 32 # 12-81</p>
            <p>Torre 1 Piso 12 - Bogotá D.C.</p>
            <p>Teléfono: (601) 364 9624</p>
            <p>Email: contacto@idcbis.org.co</p>
          </div>
          <router-link
            to="/contacto"
            class="inline-block mt-4 text-sm text-[#C4A140] hover:text-[#D9B85A]"
          >
            Formulario de contacto →
          </router-link>
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
            <router-link to="/mapa-del-sitio" class="text-sm text-[#C4A140] hover:text-[#D9B85A]">
              Mapa del sitio
            </router-link>
            <router-link to="/contacto" class="text-sm text-[#C4A140] hover:text-[#D9B85A]">
              Contáctenos
            </router-link>
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
  { name: 'Programa de Transparencia y Ética Pública', href: '/programa-transparencia-etica-publica' },
  { name: 'Plan anticorrupción y atención al ciudadano', href: '/plan-anticorrupcion' },
  { name: 'Estados financieros', href: '/estados-financieros' },
  { name: 'Ejecución presupuestal', href: '/ejecucion-presupuestal' },
  { name: 'Contratación bienes y servicios', href: '/contratacion-bienes-servicios' },
  { name: 'Rendición de Cuentas', href: '/rendicion-de-cuentas' },
  { name: 'Transparencia', href: '/transparencia' },
  { name: 'Mapa del sitio', href: '/mapa-del-sitio' },
];

const informate = [
  { name: 'Trabaje con nosotros', href: '/trabaje-con-nosotros' },
  { name: 'Apoyo financiero', href: '/apoyo-financiero' },
  { name: 'Noticias', href: '/noticias' },
  { name: 'Publicaciones científicas', href: '/publicaciones-cientificas' },
  { name: 'Atención a usuarios', href: '/atencion-a-usuarios' },
  { name: 'Información a proveedores', href: '/informacion-a-proveedores' },
  { name: 'Contáctenos', href: '/contacto' },
];
</script>
