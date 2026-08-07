/**
 * Overlays de contenido por slug/locale para el sitio público.
 * Sirve como respaldo mientras las traducciones viven también en pages.translations.
 * Prioridad: page.translations[locale] (API) > este registro.
 */
export const PAGE_TRANSLATION_OVERLAYS = {
  contacto: {
    en: {
      title: 'Contact us | IDCBIS',
      meta_title: 'Contact us — IDCBIS',
      meta_description:
        'Get in touch with the District Institute of Science, Biotechnology and Health Innovation. Write to us or visit our headquarters in Bogotá.',
      content: [
        {
          id: 'contacto_hero',
          type: 'hero',
          color: '#ffffff',
          title: 'Contact us',
          content: '',
          subtitle:
            'We are here to answer your questions, requests and comments about IDCBIS services.',
          fullBleed: true,
          minHeight: '260px',
          textAlign: 'center',
          blockLabel: 'Header',
          borderRadius: '1px',
          backgroundColor: 'linear-gradient(135deg, #0b4f6c 0%, #2c8c99 100%)',
          backgroundImage: '',
        },
        {
          id: 'contacto_form',
          type: 'form',
          title: 'Write to us',
          fields: [
            {
              name: 'nombre',
              type: 'text',
              label: 'Full name',
              required: true,
              placeholder: 'Enter your name',
            },
            {
              name: 'email',
              type: 'email',
              label: 'Email address',
              required: true,
              placeholder: 'email@example.com',
            },
            {
              name: 'asunto',
              type: 'text',
              label: 'Subject',
              required: true,
              placeholder: 'Reason for your inquiry',
            },
            {
              name: 'mensaje',
              rows: 5,
              type: 'textarea',
              label: 'Message',
              required: true,
              placeholder: 'Write your message here',
            },
          ],
          padding: '2rem',
          blockLabel: 'Form',
          description: 'Complete the form and we will get back to you as soon as possible.',
          submitLabel: 'Send message',
          borderRadius: '12px',
          backgroundColor: '#ffffff',
        },
        {
          id: 'contacto_info',
          type: 'idcbis-contact',
          items: [
            {
              id: 'contacto_sede',
              icon: '📍',
              text: 'Carrera 32 #12-81\nBogotá D.C., Colombia',
              title: 'Main headquarters',
            },
            {
              id: 'contacto_tel',
              icon: '📞',
              text: 'PBX (+57) 1 3649620',
              title: 'Phone',
            },
            {
              id: 'contacto_mail',
              icon: '📧',
              text: 'contacto@idcbis.org.co',
              title: 'Email',
            },
            {
              id: 'contacto_horario',
              icon: '🕐',
              text: 'Monday to Friday\n7:30 a.m. – 4:30 p.m.',
              title: 'Business hours',
            },
          ],
          fullBleed: true,
          blockLabel: 'Contact details',
        },
      ],
    },
  },
}

export function getPageTranslationOverlay(slug, locale) {
  if (!slug || !locale) {
    return null
  }
  return PAGE_TRANSLATION_OVERLAYS[slug]?.[locale] || null
}
