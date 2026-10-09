<?php

/**
 * Página de un proyecto del grupo de Neurociencias.
 * El bosquejo entrega el nombre de la línea y el enfoque del grupo.
 */
function investigacionNeurocienciasProyecto(array $project): array
{
    $prefix = $project['prefix'];
    $title = $project['title'];
    $image = $project['image'];
    $imageAlt = $project['imageAlt'] ?? $title;
    $content = $title.' es un proyecto en desarrollo del grupo de Neurociencias de la Unidad de Terapias Avanzadas del IDCBIS.'
        ."\n\nEl grupo de Neurociencias de la Unidad de Terapias Avanzadas del IDCBIS es un equipo multidisciplinario enfocado en descifrar los mecanismos del sistema nervioso y transformar ese conocimiento en soluciones terapéuticas de vanguardia."
        ."\n\nCombinando rigurosidad científica y tecnología de punta, abordamos el estudio de las enfermedades neurológicas y la neuroregeneración a través de un enfoque traslacional integral que abarca tres niveles estratégicos: estudios in vitro, modelos in vivo (preclínicos) e investigación clínica."
        ."\n\nEn la intersección entre la neurobiología, la bioingeniería y la medicina traslacional, desarrollamos proyectos estratégicos orientados a superar los límites actuales en la reparación neural y las terapias avanzadas.";

    return [
        [
            'id' => $prefix.'_hero',
            'type' => 'carousel',
            'height' => '520px',
            'slides' => [
                [
                    'id' => $prefix.'_s1',
                    'link' => null,
                    'image' => $image,
                    'title' => $title,
                    'overlay' => 'linear-gradient(90deg, rgba(0, 60, 95, 0.92) 0%, rgba(0, 86, 116, 0.78) 55%, rgba(0, 60, 95, 0.4) 100%)',
                    'buttonUrl' => '#desarrollo',
                    'buttonText' => 'Leer el desarrollo',
                    'description' => $title.' es un proyecto en desarrollo del grupo de Neurociencias, Unidad de Terapias Avanzadas.',
                ],
            ],
            'content' => null,
            'overlay' => 'linear-gradient(90deg, rgba(0, 60, 95, 0.92) 0%, rgba(0, 86, 116, 0.78) 55%, rgba(0, 60, 95, 0.4) 100%)',
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
        ],
        [
            'id' => $prefix.'_desarrollo',
            'type' => 'idcbis-about',
            'variant' => 'clean',
            'anchorId' => 'desarrollo',
            'fullBleed' => true,
            'blockLabel' => 'Desarrollo',
            'title' => $title,
            'contentSize' => '1.2rem',
            'image' => $image,
            'imageAlt' => $imageAlt,
            'content' => $content,
        ],
        [
            'id' => $prefix.'_cta',
            'type' => 'cta-banner',
            'title' => 'Neurociencias',
            'buttons' => [
                [
                    'id' => $prefix.'_back',
                    'url' => '/investigacion-neurociencias',
                    'icon' => '←',
                    'label' => 'Volver a Neurociencias',
                    'variant' => 'primary',
                ],
                [
                    'id' => $prefix.'_proyectos',
                    'url' => '/investigacion-neurociencias#lineas',
                    'icon' => '↓',
                    'label' => 'Ver los demás proyectos',
                    'variant' => 'outline',
                ],
            ],
            'subtitle' => 'Regrese al grupo o recorra las otras líneas.',
            'fullBleed' => true,
            'blockLabel' => 'Llamado a la acción',
            'backgroundColor' => 'linear-gradient(135deg, #005674 0%, #008996 100%)',
        ],
    ];
}
