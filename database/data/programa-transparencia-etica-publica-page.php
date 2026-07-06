<?php

/**
 * Bloque idcbis-documents-page — Programa de Transparencia y Ética Pública.
 * Fuente: https://idcbis.org.co/programa-de-transparencia-y-etica-publica/
 */

$doc = static function (
    string $id,
    string $title,
    string $publishedAt,
    string $url = '',
): array {
    return compact('id', 'title', 'publishedAt', 'url');
};

return [
    'id' => 'pte_page',
    'type' => 'idcbis-documents-page',
    'content' => '',
    'fullBleed' => true,
    'eyebrow' => 'Transparencia',
    'heroTitle' => 'Programa de Transparencia y Ética Pública',
    'heroSubtitle' => 'Consulta informes, seguimientos y documentos del programa de transparencia del IDCBIS.',
    'intro' => 'Accede a los documentos publicados por año. Cada archivo incluye la fecha de publicación oficial.',
    'layout' => 'sidebar',
    'documentColumns' => 2,
    'showSearch' => true,
    'groups' => [
        [
            'id' => 'pte-2026',
            'label' => '2026',
            'documents' => [
                $doc('pte-2026-01', 'Mapa de riesgos corrupción I trimestre 2026', '25 Mayo 2026'),
                $doc('pte-2026-02', 'Programa Transparencia y Ética Pública 2026', '25 Mayo 2026'),
                $doc('pte-2026-03', 'Programa Transparencia y Ética Pública 2026 – Matriz de riesgo', '25 Mayo 2026'),
            ],
        ],
        [
            'id' => 'pte-2025',
            'label' => '2025',
            'documents' => [
                $doc('pte-2025-01', 'Programa Transparencia y Ética Pública 2026 III cuatrimestre', '10 Marzo 2026'),
                $doc('pte-2025-02', 'Programa Transparencia y Ética Pública 2025 II cuatrimestre', '30 Enero 2026'),
                $doc('pte-2025-03', 'Programa Transparencia y Ética Pública 2025 I cuatrimestre', '30 Enero 2026'),
                $doc('pte-2025-04', 'Programa de Transparencia y Ética Pública', '30 Enero 2025'),
                $doc('pte-2025-05', 'Actividades de componente Transversal', '30 Enero 2025'),
                $doc('pte-2025-06', 'Actividades de componente programático', '30 Enero 2025'),
            ],
        ],
        [
            'id' => 'pte-2024',
            'label' => '2024',
            'documents' => [
                $doc('pte-2024-01', 'Programa Transparencia y Ética Pública 2024 III Cuatrimestre', '13 Enero 2025'),
                $doc('pte-2024-02', 'Programa de Transparencia y Ética Pública V2', '30 Diciembre 2024'),
                $doc('pte-2024-03', 'Programa Transparencia y Ética Pública 2024 II Cuatrimestre', '10 Septiembre 2024'),
                $doc('pte-2024-04', 'Programa de Transparencia y Ética Pública 2024', '30 Enero 2024'),
                $doc('pte-2024-05', 'Declaración Cumplimiento Normativo', '26 Abril 2024'),
                $doc('pte-2024-06', 'Declaración Cumplimiento Normativo (2)', '26 Abril 2024'),
                $doc('pte-2024-07', 'Declaración Cumplimiento Normativo Javeriana', '29 Abril 2024'),
                $doc('pte-2024-08', 'Seguimiento al Programa de Transparencia y Ética Pública I Cuatrimestre', '16 Mayo 2024'),
                $doc('pte-2024-09', 'Declaración de conocimiento y aceptación de la política de cumplimiento normativo', '17 Junio 2024'),
                $doc('pte-2024-10', 'Declaración cumplimiento Centro Oriente', '09 Agosto 2024'),
                $doc('pte-2024-11', 'Declaración cumplimiento Subred Sur', '09 Agosto 2024'),
                $doc('pte-2024-12', 'Declaración cumplimiento Unal', '09 Agosto 2024'),
            ],
        ],
        [
            'id' => 'pte-2023',
            'label' => '2023',
            'documents' => [
                $doc('pte-2023-01', 'Programa de Transparencia y Ética Pública', '27 Enero 2023'),
                $doc('pte-2023-02', 'Programa de Transparencia y Ética Pública V2', '10 Julio 2023'),
                $doc('pte-2023-03', 'Seguimiento I Cuatrimestre 2023', '15 Mayo 2023'),
                $doc('pte-2023-04', 'Seguimiento II Cuatrimestre 2023', '13 Septiembre 2023'),
                $doc('pte-2023-05', 'Seguimiento III Cuatrimestre 2023', '16 Enero 2024'),
            ],
        ],
    ],
];
