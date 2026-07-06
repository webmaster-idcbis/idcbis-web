<?php

namespace App\Support;

/**
 * Convierte bloques monolíticos en arrays de elementos editables por separado.
 */
class SplitPageContent
{
    public static function split(array $content): array
    {
        $result = [];

        foreach ($content as $element) {
            if (! is_array($element) || empty($element['type'])) {
                continue;
            }

            $split = match ($element['type']) {
                'idcbis-quienes-somos' => self::splitQuienesSomos($element),
                'idcbis-documents-page' => self::splitDocumentsPage($element),
                default => [$element],
            };

            foreach ($split as $block) {
                $result[] = $block;
            }
        }

        return $result;
    }

    public static function splitQuienesSomos(array $data): array
    {
        $blocks = [];

        if (! empty($data['heroEyebrow'])) {
            $blocks[] = self::block([
                'id' => 'qs_eyebrow',
                'type' => 'badge',
                'blockLabel' => 'Etiqueta superior',
                'content' => $data['heroEyebrow'],
                'backgroundColor' => 'rgba(255,255,255,0.15)',
                'color' => '#ffffff',
                'fullBleed' => true,
                'padding' => '12px 24px',
                'margin' => '24px auto 0',
                'textAlign' => 'center',
            ]);
        }

        $blocks[] = self::block([
            'id' => 'qs_hero',
            'type' => 'hero',
            'blockLabel' => 'Encabezado',
            'fullBleed' => true,
            'title' => $data['heroTitle'] ?? 'Quiénes Somos',
            'subtitle' => $data['heroSubtitle'] ?? '',
            'minHeight' => '340px',
            'backgroundImage' => $data['heroImage'] ?? '',
            'backgroundColor' => 'linear-gradient(rgba(11, 79, 108, 0.88), rgba(44, 140, 153, 0.82))',
            'textAlign' => 'center',
            'color' => '#ffffff',
        ]);

        foreach ($data['intro'] ?? [] as $i => $paragraph) {
            $blocks[] = self::block([
                'id' => 'qs_intro_'.$i,
                'type' => 'text',
                'blockLabel' => 'Introducción '.($i + 1),
                'content' => $paragraph,
                'fullBleed' => false,
                'maxWidth' => '800px',
                'margin' => '0 auto',
                'padding' => '16px 24px',
                'fontSize' => '18px',
                'lineHeight' => '1.7',
                'color' => '#374151',
            ]);
        }

        if (! empty($data['mission']) || ! empty($data['vision'])) {
            $blocks[] = self::block([
                'id' => 'qs_mission_vision',
                'type' => 'dual-panel',
                'blockLabel' => 'Misión y visión',
                'fullBleed' => true,
                'backgroundColor' => 'linear-gradient(135deg, #0b4f6c 0%, #2c8c99 100%)',
                'padding' => '5rem 2rem',
                'panels' => [
                    [
                        'id' => 'qs_mission',
                        'title' => 'Misión',
                        'icon' => '🎯',
                        'listStyle' => 'bullet',
                        'items' => array_filter([$data['mission'] ?? '']),
                    ],
                    [
                        'id' => 'qs_vision',
                        'title' => 'Visión 2030',
                        'icon' => '🔭',
                        'listStyle' => 'bullet',
                        'items' => array_filter([$data['vision'] ?? '']),
                    ],
                ],
            ]);
        }

        if (! empty($data['purpose'])) {
            $blocks[] = self::block([
                'id' => 'qs_purpose',
                'type' => 'cta-banner',
                'blockLabel' => 'Propósito superior',
                'fullBleed' => true,
                'title' => 'Propósito superior',
                'subtitle' => $data['purpose'],
                'backgroundColor' => '#0b4f6c',
                'padding' => '4rem 2rem',
            ]);
        }

        if (! empty($data['principles'])) {
            $blocks[] = self::block([
                'id' => 'qs_principles',
                'type' => 'idcbis-highlights',
                'blockLabel' => 'Principios rectores',
                'fullBleed' => true,
                'sectionTitle' => 'Principios',
                'sectionHighlight' => 'rectores',
                'items' => array_map(
                    fn (array $p) => [
                        'id' => $p['id'] ?? uniqid('pr_'),
                        'text' => trim(($p['icon'] ?? '').' '.($p['title'] ?? '')),
                    ],
                    $data['principles']
                ),
            ]);
        }

        if (! empty($data['director'])) {
            $director = $data['director'];
            $photoSlug = $director['photoSlug'] ?? '';
            $blocks[] = self::block([
                'id' => 'qs_director',
                'type' => 'card',
                'blockLabel' => 'Director',
                'fullBleed' => false,
                'maxWidth' => '900px',
                'margin' => '2rem auto',
                'variant' => 'team',
                'title' => $director['name'] ?? '',
                'subtitle' => ($director['role'] ?? '').($director['credentials'] ? ' · '.$director['credentials'] : ''),
                'content' => $director['bio'] ?? '',
                'image' => $photoSlug ? '/img/equipo/'.$photoSlug.'.jpg' : '',
                'href' => ! empty($director['email']) ? 'mailto:'.$director['email'] : '',
                'linkLabel' => $director['email'] ?? '',
            ]);
        }

        foreach ($data['sections'] ?? [] as $section) {
            $blocks = array_merge($blocks, self::splitQuienesSomosSection($section));
        }

        return $blocks;
    }

    private static function splitQuienesSomosSection(array $section): array
    {
        $layout = $section['layout'] ?? 'list';
        $title = $section['title'] ?? 'Sección';
        $id = $section['id'] ?? uniqid('qs_sec_');

        return match ($layout) {
            'team' => [self::block([
                'id' => $id,
                'type' => 'idcbis-team-grid',
                'blockLabel' => $title,
                'fullBleed' => true,
                'sectionTitle' => $title,
                'sectionIcon' => $section['icon'] ?? '👥',
                'members' => $section['members'] ?? [],
            ])],
            'policies' => [self::block([
                'id' => $id,
                'type' => 'idcbis-links',
                'blockLabel' => $title,
                'fullBleed' => true,
                'sectionTitle' => $title,
                'sectionHighlight' => '',
                'links' => array_map(
                    fn (array $item) => [
                        'id' => $item['id'] ?? uniqid('pol_'),
                        'icon' => $item['icon'] ?? '📋',
                        'label' => $item['title'] ?? '',
                        'description' => $item['description'] ?? '',
                        'url' => $item['url'] ?? '#',
                    ],
                    $section['items'] ?? []
                ),
            ])],
            'contact' => [self::block([
                'id' => $id,
                'type' => 'idcbis-contact',
                'blockLabel' => $title,
                'fullBleed' => true,
                'items' => array_map(
                    fn (array $item) => [
                        'id' => $item['id'] ?? uniqid('ct_'),
                        'icon' => $item['icon'] ?? '📍',
                        'title' => $item['title'] ?? '',
                        'text' => $item['text'] ?? '',
                    ],
                    $section['items'] ?? []
                ),
            ])],
            'founders' => [
                self::block([
                    'id' => $id.'_heading',
                    'type' => 'heading',
                    'blockLabel' => 'Título — '.$title,
                    'content' => $title,
                    'level' => 'h2',
                    'variant' => 'section',
                    'textAlign' => 'center',
                    'fullBleed' => true,
                ]),
                self::block([
                    'id' => $id,
                    'type' => 'list',
                    'blockLabel' => $title,
                    'fullBleed' => false,
                    'maxWidth' => '900px',
                    'margin' => '0 auto 3rem',
                    'padding' => '0 2rem 2rem',
                    'listStyle' => 'bullet',
                    'items' => $section['items'] ?? [],
                ]),
            ],
            default => [self::block([
                'id' => $id.'_heading',
                'type' => 'heading',
                'blockLabel' => 'Título — '.$title,
                'content' => $title,
                'level' => 'h2',
                'variant' => 'section',
                'textAlign' => 'center',
                'fullBleed' => true,
            ]), self::block([
                'id' => $id,
                'type' => 'list',
                'blockLabel' => $title,
                'fullBleed' => false,
                'maxWidth' => '900px',
                'margin' => '0 auto 3rem',
                'padding' => '0 2rem 2rem',
                'listStyle' => 'bullet',
                'items' => $section['items'] ?? [],
            ])],
        };
    }

    public static function splitDocumentsPage(array $data): array
    {
        $blocks = [];

        $blocks[] = self::block([
            'id' => ($data['id'] ?? 'docs').'_hero',
            'type' => 'hero',
            'blockLabel' => 'Encabezado',
            'fullBleed' => true,
            'title' => $data['heroTitle'] ?? 'Documentos',
            'subtitle' => trim(($data['eyebrow'] ?? '').($data['heroSubtitle'] ? "\n".$data['heroSubtitle'] : '')),
            'minHeight' => '280px',
            'backgroundImage' => $data['heroImage'] ?? '',
            'backgroundColor' => 'linear-gradient(135deg, #0b4f6c 0%, #2c8c99 100%)',
            'textAlign' => 'center',
            'color' => '#ffffff',
        ]);

        if (! empty($data['intro'])) {
            $blocks[] = self::block([
                'id' => ($data['id'] ?? 'docs').'_intro',
                'type' => 'text',
                'blockLabel' => 'Introducción',
                'content' => $data['intro'],
                'fullBleed' => false,
                'maxWidth' => '720px',
                'margin' => '2rem auto',
                'padding' => '0 24px',
                'fontSize' => '17px',
                'lineHeight' => '1.65',
                'color' => '#4b5563',
                'textAlign' => 'center',
            ]);
        }

        $blocks[] = self::block([
            'id' => ($data['id'] ?? 'docs').'_list',
            'type' => 'idcbis-documents-list',
            'blockLabel' => 'Listado de documentos',
            'fullBleed' => true,
            'layout' => $data['layout'] ?? 'sidebar',
            'documentColumns' => $data['documentColumns'] ?? 1,
            'showSearch' => $data['showSearch'] ?? true,
            'groups' => $data['groups'] ?? [],
        ]);

        return $blocks;
    }

    private static function block(array $data): array
    {
        return array_merge([
            'content' => '',
            'color' => '#000000',
            'fontSize' => '16px',
        ], $data);
    }
}
