<?php

/**
 * Bloques compartidos de Ingeniería de tejidos.
 * Las fotografías de laboratorio siguen pendientes: se reserva el mismo espacio visual.
 */

function ingenieriaTisularImagen(): string
{
    return '/img/ingenieria-tisular/espacio.svg';
}

function ingenieriaTisularHero(
    string $id,
    string $title,
    string $description,
    string $buttonText,
    string $buttonUrl,
    string $height = '620px'
): array {
    $overlay = 'linear-gradient(90deg, rgba(0, 60, 95, 0.92) 0%, rgba(0, 86, 116, 0.72) 46%, rgba(0, 60, 95, 0.28) 100%)';

    return [
        'id' => $id,
        'type' => 'carousel',
        'height' => $height,
        'slides' => [
            [
                'id' => $id.'_s1',
                'link' => null,
                'image' => ingenieriaTisularImagen(),
                'title' => $title,
                'overlay' => $overlay,
                'buttonUrl' => $buttonUrl,
                'buttonText' => $buttonText,
                'description' => $description,
            ],
        ],
        'content' => null,
        'overlay' => $overlay,
        'variant' => 'hero-full',
        'autoPlay' => false,
        'buttonBg' => '#C4A140',
        'buttonColor' => '#003C5F',
        'fullBleed' => true,
        'textAlign' => 'left',
        'showArrows' => false,
        'borderRadius' => '0px',
        'verticalAlign' => 'center',
        'showIndicators' => false,
    ];
}

function ingenieriaTisularCta(string $id, string $title, string $subtitle, array $buttons): array
{
    return [
        'id' => $id,
        'type' => 'cta-banner',
        'title' => $title,
        'buttons' => $buttons,
        'subtitle' => $subtitle,
        'fullBleed' => true,
        'blockLabel' => 'Llamado a la acción',
        'backgroundColor' => 'linear-gradient(135deg, #005674 0%, #008996 100%)',
    ];
}
