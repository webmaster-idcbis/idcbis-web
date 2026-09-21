import { IDCBIS_BRAND_LOGO } from './siteLogos'

/**
 * Rutas de imágenes para Propuesta Azul.
 * Coloca los archivos en public/img/ (URL: /img/nombre-archivo)
 */
export const IDCBIS_SERVICE_BANNERS = {
  home: '/img/Banners WEB/Baner-Pagina-WEB-1920x700-HOME.jpg',
  sangre: '/img/Banners WEB/Baner-Pagina-WEB-1920x700-BS.jpg',
  cordon: '/img/Banners WEB/Baner-Pagina-WEB-1920x700-CU.jpg',
  tejidos: '/img/Banners WEB/Baner-Pagina-WEB-1920x700-BT.jpg',
  terapias: '/img/Banners WEB/Baner-Pagina-WEB-1920x700-TA.jpg',
  donantes: '/img/Banners WEB/Baner-Pagina-WEB-1920x700-DC.jpg',
}

export const IDCBIS_PROPOSAL_IMAGES = {
  hero: '/img/banco-distrital-de-tejidos-01.jpg',
  heroHome: IDCBIS_SERVICE_BANNERS.home,
  about: IDCBIS_BRAND_LOGO,
  services: [
    '/img/Servicios%20Home/BS-1200x800.png',
    '/img/Servicios%20Home/B-Cordon-1200x800.png',
    '/img/Servicios%20Home/BT-1200x800.png',
    '/img/Servicios%20Home/TE-AV-1200x800.png',
    '/img/Servicios%20Home/DC-1200x800.png',
    '/img/Servicios%20Home/Bienestar-Charlas-Investigacion-1200x800.png',
  ],
}
