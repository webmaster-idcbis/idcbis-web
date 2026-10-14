<?php

/**
 * Textos de las fichas de Ingeniería de tejidos.
 * Cada página de proyecto toma una entrada y la arma con investigacionIngenieriaTisularProyecto().
 */

$hueso = '/investigacion-ingenieria-tisular-hueso';
$piel = '/investigacion-ingenieria-tisular-piel';
$cartilago = '/investigacion-ingenieria-tisular-cartilago';
$otras = '/investigacion-ingenieria-tisular-otras';

return [
    'investigacion-ingenieria-tisular-3d-quyne' => [
        'prefix' => 'itq',
        'title' => '3D QUYNE',
        'eyebrow' => 'Proyecto · Hueso',
        'summary' => 'Dispositivo personalizado para reparación de defectos óseos críticos mediante impresión 3D y recubrimiento electrohilado.',
        'lineTitle' => 'Hueso',
        'backUrl' => $hueso,
        'backLabel' => 'Volver a proyectos de hueso',
        'highlightsAnchor' => 'resultados',
        'highlights' => [
            ['id' => 'itq_h1', 'text' => 'Pharmaceutics. 2023;15(11):2529. doi:10.3390/pharmaceutics15112529'],
            ['id' => 'itq_h2', 'text' => 'Regenerative Therapy. 2024;26:145–160. doi:10.1016/j.reth.2024.05.017'],
            ['id' => 'itq_h3', 'text' => 'Propiedad intelectual: WO2023170557A1 / US20250177145A1'],
        ],
        'sections' => [
            [
                'anchor' => 'presentacion',
                'nav' => 'Presentación',
                'title' => 'Presentación de 3D QUYNE',
                'content' => "3D QUYNE es un proyecto de investigación de la Unidad de Ingeniería Tisular del Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud (IDCBIS), orientado al desarrollo de un dispositivo médico personalizado para la reparación de defectos óseos críticos. El sistema integra una estructura tridimensional fabricada en poli(ácido láctico) (PLA) mediante impresión 3D y un recubrimiento electrohilado que complementa su función biológica. Su diseño busca adaptarse a la geometría del defecto, mantener un canal medular funcional y proporcionar una arquitectura porosa que favorezca el tránsito de células, fluidos, nutrientes y elementos vasculares durante la reparación del tejido óseo.",
            ],
            [
                'anchor' => 'consiste',
                'nav' => '¿En qué consiste?',
                'title' => '¿En qué consiste 3D QUYNE?',
                'content' => "3D QUYNE se fundamenta en una arquitectura tridimensional personalizada que actúa como soporte osteoconductivo dentro del defecto óseo. La porosidad interconectada facilita el intercambio de nutrientes y la migración celular, mientras que el canal medular permite el tránsito de componentes provenientes de la médula ósea, favoreciendo la repoblación celular, la vascularización interna y la continuidad entre el hueso huésped y el tejido en formación.\n\nEl recubrimiento electrohilado de fibras micrométricas cumple una función complementaria semejante a una barrera periostal: limita la invasión de tejidos blandos hacia el defecto y genera una interfaz favorable para la adhesión y diferenciación osteogénica. En conjunto, la estructura impresa, el canal interno y el recubrimiento buscan crear un microambiente que guíe la regeneración ósea de manera espacialmente organizada.",
            ],
            [
                'anchor' => 'proceso',
                'nav' => 'Proceso',
                'title' => 'Desarrollo tecnológico y proceso de fabricación',
                'content' => "El desarrollo tecnológico de 3D QUYNE inicia con la planificación a partir de imágenes diagnósticas y el modelado asistido por computador de la geometría requerida. El dispositivo se fabrica mediante modelado por deposición fundida de PLA, incorporando una arquitectura macroporosa y un canal medular interno. Posteriormente, la superficie externa se recubre mediante electrohilado con una membrana polimérica bioactiva, seguida de secado para retirar solvente residual y esterilización. De forma complementaria, las guías quirúrgicas personalizadas permiten transferir la planificación al procedimiento, facilitando la preparación del defecto, la alineación y el posicionamiento preciso del dispositivo.",
            ],
            [
                'anchor' => 'resultados',
                'nav' => 'Resultados',
                'title' => 'Resultados científicos y propiedad intelectual',
                'content' => "La estrategia que sustenta 3D QUYNE ha sido evaluada mediante estudios in vitro y preclínicos. Los andamios electrohilados de PLA con fosfato de calcio presentan morfología fibrosa, poros interconectados, biocompatibilidad y capacidad para favorecer proliferación y diferenciación osteogénica de células estromales mesenquimales derivadas de gelatina de Wharton. En el desarrollo del dispositivo, la combinación de impresión 3D y electrohilado permite integrar soporte estructural, arquitectura porosa y una barrera externa orientada a la reparación ósea.\n\nEn modelos animales de defecto óseo crítico se ha observado integración del dispositivo con el tejido huésped, presencia de vascularización y tejido neoformado dentro de la estructura, además de hallazgos histológicos compatibles con células formadoras de hueso, células endoteliales y formación de cartílago y hueso. La evaluación radiográfica e histológica respalda la continuidad del proceso de reparación dentro y alrededor del dispositivo.\n\nReferencias: Cárdenas-Aguazaco W. et al. Pharmaceutics. 2023;15(11):2529. doi:10.3390/pharmaceutics15112529. Cárdenas-Aguazaco W. et al. Regenerative Therapy. 2024;26:145–160. doi:10.1016/j.reth.2024.05.017. Propiedad intelectual: Method of Manufacturing a Medical Device Using 3D Printing and Electrospinning, WO2023170557A1 / US20250177145A1.",
            ],
            [
                'anchor' => 'proyeccion',
                'nav' => 'Proyección',
                'title' => 'Proyección en ingeniería de tejidos',
                'content' => "3D QUYNE representa una plataforma de ingeniería de tejidos para abordar defectos óseos de tamaño crítico mediante la integración de diseño personalizado, manufactura aditiva y electrohilado. Su configuración permite ajustar la geometría externa y el canal medular al sitio anatómico, mientras que la arquitectura interna busca mantener condiciones favorables para la infiltración celular, el transporte de nutrientes y la vascularización del tejido neoformado.\n\nLa continuidad del proyecto se orienta a fortalecer la validación preclínica, la estandarización del proceso de fabricación y esterilización, y la generación de evidencia de seguridad y desempeño necesaria para su futura traslación. Las guías quirúrgicas personalizadas complementan esta estrategia al mejorar la reproducibilidad de la preparación del defecto y del posicionamiento del dispositivo en escenarios anatómicos complejos.",
            ],
        ],
    ],
    'investigacion-ingenieria-tisular-matriacel' => [
        'prefix' => 'itm',
        'title' => 'MatriAcel',
        'eyebrow' => 'Proyecto · Piel',
        'summary' => 'Desarrollo de una matriz dérmica humana descelularizada para aplicaciones en ingeniería de tejidos.',
        'lineTitle' => 'Piel',
        'backUrl' => $piel,
        'backLabel' => 'Volver a proyectos de piel',
        'highlightsAnchor' => 'resultados',
        'highlights' => [
            ['id' => 'itm_h1', 'text' => 'Inicio del proyecto: 2017'],
            ['id' => 'itm_h2', 'text' => 'Patente concedida, asociada a su proceso tecnológico'],
            ['id' => 'itm_h3', 'text' => 'Publicaciones de la evaluación experimental, incluido el nivel preclínico'],
        ],
        'sections' => [
            [
                'anchor' => 'presentacion',
                'nav' => 'Presentación',
                'title' => 'Presentación de MatriAcel',
                'content' => "MatriAcel es un proyecto de investigación de la Unidad de Ingeniería Tisular del Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud (IDCBIS), iniciado en el año 2017, cuyo propósito es desarrollar una matriz dérmica de origen humano mediante la aplicación de diferentes estrategias de descelularización. Esta investigación surge del interés por aprovechar las propiedades estructurales y biológicas de la dermis humana como una alternativa basada en biomateriales de origen natural para aplicaciones en ingeniería de tejidos y reparación cutánea.",
            ],
            [
                'anchor' => 'consiste',
                'nav' => '¿En qué consiste?',
                'title' => '¿En qué consiste MatriAcel?',
                'content' => "El proyecto se fundamenta en la obtención de una matriz extracelular dérmica a partir de piel humana, mediante un protocolo que integra métodos de descelularización enzimáticos, químicos y físicos. La combinación de estas estrategias permite remover el componente celular del tejido en un periodo aproximado de una semana, procurando conservar los principales componentes estructurales de la matriz extracelular, particularmente el colágeno y la elastina presentes de manera natural en la dermis.\n\nA diferencia de los materiales elaborados exclusivamente a partir de polímeros aislados o sintetizados, MatriAcel busca aprovechar la arquitectura propia del tejido humano, conservando una estructura de origen biológico cuya composición resulta de especial interés para el desarrollo de sustitutos dérmicos. La preservación de las fibras de colágeno y elastina constituye uno de los aspectos centrales de esta investigación, debido a su participación en las propiedades estructurales y mecánicas de la piel.",
            ],
            [
                'anchor' => 'proceso',
                'nav' => 'Proceso',
                'title' => 'Desarrollo tecnológico y proceso de obtención',
                'content' => "Uno de los principales componentes de innovación del proyecto es la integración de tres mecanismos de descelularización dentro de un mismo procedimiento. El tratamiento enzimático, junto con los procesos químicos y físicos, permite abordar la eliminación de los componentes celulares del tejido, procurando minimizar las alteraciones sobre su matriz extracelular.\n\nEsta metodología ha sido desarrollada para obtener una dermis descelularizada en aproximadamente siete días, manteniendo como criterio fundamental la conservación de sus componentes fibrilares naturales. El resultado es una matriz de origen humano que puede ser estudiada y caracterizada desde diferentes perspectivas, incluyendo su composición, organización estructural y comportamiento biológico, con el fin de establecer su potencial para aplicaciones relacionadas con la reparación de tejidos cutáneos.",
            ],
            [
                'anchor' => 'resultados',
                'nav' => 'Resultados',
                'title' => 'Resultados científicos y propiedad intelectual',
                'content' => "Desde su inicio en 2017, MatriAcel ha avanzado a través de diferentes etapas de investigación y desarrollo tecnológico, que han permitido consolidar el proceso de obtención de la matriz dérmica descelularizada. Como resultado de este trabajo, la tecnología cuenta con una patente concedida, que reconoce el desarrollo asociado a su proceso tecnológico.\n\nAdicionalmente, la investigación dispone de publicaciones científicas en las que se presentan los resultados obtenidos durante su evaluación experimental, incluyendo estudios a nivel preclínico. Estos trabajos constituyen un respaldo científico para el desarrollo de MatriAcel y permiten documentar las características y el comportamiento del material en los modelos estudiados.",
            ],
            [
                'anchor' => 'proyeccion',
                'nav' => 'Proyección',
                'title' => 'Proyección en ingeniería de tejidos',
                'content' => "MatriAcel representa una línea de desarrollo tecnológico centrada en el aprovechamiento de la matriz extracelular humana como biomaterial para aplicaciones biomédicas. Su proceso de obtención, basado en la combinación de métodos de descelularización y en la conservación del colágeno y la elastina naturales, permite explorar el potencial de la dermis descelularizada como soporte biológico en estrategias de reparación cutánea.\n\nLa continuidad de esta investigación busca contribuir al desarrollo de alternativas para el tratamiento de lesiones de la piel, integrando el conocimiento sobre procesamiento de tejidos humanos, caracterización de biomateriales y evaluación biológica dentro de las capacidades científicas y tecnológicas de la Unidad de Ingeniería Tisular del IDCBIS.",
            ],
        ],
    ],
    'investigacion-ingenieria-tisular-pcem-tgpiel' => [
        'prefix' => 'itg',
        'title' => 'PCEM-TGPiel',
        'eyebrow' => 'Proyecto · Piel',
        'summary' => 'Membrana biosintética electrohilada de poli(ε-caprolactona)/colágeno y TGF-β3 para reparación cutánea. TRL 5.',
        'lineTitle' => 'Piel',
        'backUrl' => $piel,
        'backLabel' => 'Volver a proyectos de piel',
        'highlightsAnchor' => 'resultados',
        'highlights' => [
            ['id' => 'itg_h1', 'text' => 'TRL 5: validada en entorno preclínico relevante'],
            ['id' => 'itg_h2', 'text' => 'En biomodelo porcino, cierre superior al 90 % a los 30 días'],
            ['id' => 'itg_h3', 'text' => 'Patente NC2020/0008252 · WO2022003652A1'],
        ],
        'sections' => [
            [
                'anchor' => 'presentacion',
                'nav' => 'Presentación',
                'title' => 'Presentación de PCEM-TGPiel',
                'content' => "PCEM-TGPiel es un proyecto de investigación desarrollado en la Unidad de Ingeniería Tisular del IDCBIS, orientado al desarrollo de una membrana biosintética para reparación cutánea. La tecnología combina poli(ε-caprolactona), un polímero sintético biodegradable y de alta compatibilidad para fabricación de andamios; colágeno, componente estructural clave de la matriz extracelular cutánea; y TGF-β3, un factor de crecimiento antifibrótico.\n\nLa membrana se obtiene mediante electrohilado, generando una red de fibras submicrométricas que funciona como soporte físico para la cobertura del lecho de la herida, la adhesión celular, la migración celular y la organización progresiva del tejido reparado. Cuenta con evaluación preclínica en biomodelo porcino, que la ubica en un nivel de madurez tecnológica TRL 5, correspondiente a validación en entorno relevante.",
            ],
            [
                'anchor' => 'consiste',
                'nav' => '¿En qué consiste?',
                'title' => '¿En qué consiste PCEM-TGPiel?',
                'content' => "El proyecto se fundamenta en el diseño de una membrana electrohilada compuesta por PCL, colágeno y TGF-β3. La incorporación de colágeno modifica la superficie del andamio, incrementa su hidrofilicidad y mejora las condiciones para la interacción célula-andamio.\n\nLa estructura fibrosa obtenida busca imitar aspectos de la matriz extracelular, proporcionando una superficie flexible y suturable que puede adaptarse al lecho de la herida. En los ensayos preclínicos, la membrana mostró adecuada manipulación, permanencia sobre el defecto y contacto con el tejido lesionado.\n\nEl desarrollo también ha permitido evaluar constructos PCEM-TGPiel con células estromales mesenquimales derivadas de gelatina de Wharton, con el fin de estudiar el efecto del componente celular sobre la maduración del tejido reparado.",
            ],
            [
                'anchor' => 'proceso',
                'nav' => 'Proceso',
                'title' => 'Desarrollo tecnológico y proceso de fabricación',
                'content' => "El componente tecnológico central es la fabricación de membranas mediante electrohilado, técnica que permite obtener redes de fibras continuas a partir de una solución polimérica. En el desarrollo experimental se empleó poli(ε-caprolactona) (PCL) como matriz sintética, colágeno como componente bioactivo asociado con la interacción celular y la reparación cutánea, y TGF-β3 como componente para mejorar la apariencia final de la cicatriz.\n\nPCEM-TGPiel cuenta con resultados de evaluación preclínica en modelos de reparación cutánea, lo que ha permitido avanzar en la caracterización de su desempeño biológico y sustentar la madurez tecnológica alcanzada.\n\nLa transferencia tecnológica a BOTTOM comprende la tecnología en su conjunto, incluyendo las formulaciones con y sin TGF-β3, así como el conocimiento técnico asociado a su fabricación, caracterización y escalamiento. En la etapa actual, el desarrollo conjunto se encuentra enfocado inicialmente en la membrana PCL–COL, con el objetivo de consolidar un proceso reproducible de manufactura, control de calidad, esterilización, empaque, estabilidad y escalamiento productivo.",
            ],
            [
                'anchor' => 'resultados',
                'nav' => 'Resultados',
                'title' => 'Resultados científicos y estado de madurez',
                'content' => "PCEM-TGPiel cuenta con resultados de caracterización fisicoquímica, mecánica, biológica y preclínica.\n\nEn la evaluación in vivo en biomodelo porcino, las membranas y constructos mostraron buena adherencia al sitio de la herida y cierre superior al 90 % a los 30 días. El análisis histológico evidenció formación de membrana basal, presencia de papilas dérmicas, vasos sanguíneos, estratificación epidérmica y fibras de colágeno más organizadas en comparación con el control negativo.\n\nEstado de madurez: TRL 5, validado en entorno relevante preclínico. El desarrollo aún requiere completar validaciones de seguridad, desempeño, escalamiento, esterilización, estabilidad y documentación regulatoria antes de proyectar una salida al mercado.\n\nReferencias: Ciencia en Desarrollo 10.2 (2019): 197-208. DOI: 10.19053/01217488.v10.n2.2019.9841. Regenerative Therapy 24 (2023) 11–24. DOI: 10.1016/j.reth.2023.05.005. Biomaterials and Biosystems (2025): 100122. DOI: 10.1016/j.bbiosy.2025.100122. Patente No. NC2020/0008252. WO2022003652A1 (WIPO, PCT).",
            ],
            [
                'anchor' => 'proyeccion',
                'nav' => 'Proyección',
                'title' => 'Proyección, escalamiento y ruta',
                'content' => "PCEM-TGPiel representa una línea de desarrollo tecnológico orientada a generar una membrana biosintética para aplicaciones en reparación cutánea. Para avanzar desde TRL 5 hacia etapas de transferencia, el proyecto debe completar una ruta de desarrollo que integre escalamiento, validación del proceso y documentación técnica.\n\nLa proyección incluye el escalamiento del electrohilado con apoyo de BOTTOM y equipos piloto tipo NanoSpinner/PILOTLINE, con el fin de pasar de lotes experimentales a membranas producidas bajo condiciones más controladas y reproducibles. Este paso debe acompañarse de especificaciones de materia prima, controles de proceso, caracterización por lote, validación de esterilización, empaque, estabilidad y pruebas complementarias de biocompatibilidad y seguridad.\n\nAntes de una eventual salida al mercado, será necesario definir la indicación de uso, la clasificación regulatoria, los requisitos INVIMA, la estrategia de propiedad intelectual, el nombre comercial, el empaque, la vida útil, la evidencia preclínica complementaria y, de ser requerido, estudios adicionales de desempeño o seguridad.",
            ],
        ],
    ],
    'investigacion-ingenieria-tisular-fibroglic' => [
        'prefix' => 'itf',
        'title' => 'Fibroglic',
        'eyebrow' => 'Proyecto · Piel',
        'summary' => 'Andamio electrohilado de nanofibras de poli(ε-caprolactona) funcionalizado con glicina para heridas cutáneas crónicas.',
        'lineTitle' => 'Piel',
        'backUrl' => $piel,
        'backLabel' => 'Volver a proyectos de piel',
        'highlightsAnchor' => 'resultados',
        'highlights' => [
            ['id' => 'itf_h1', 'text' => 'Viabilidad celular superior al 95 % en los tiempos evaluados'],
            ['id' => 'itf_h2', 'text' => 'Prieto-Abello et al., Polymers 2026, 18, 1920. doi:10.3390/polym18151920'],
            ['id' => 'itf_h3', 'text' => 'Solicitud de patente en trámite: NC2022/0006262'],
        ],
        'sections' => [
            [
                'anchor' => 'presentacion',
                'nav' => 'Presentación',
                'title' => 'Presentación de Fibroglic',
                'content' => "Fibroglic es un proyecto de investigación de la Unidad de Ingeniería Tisular del Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud (IDCBIS), cuyo propósito es desarrollar andamios de nanofibras electrohiladas de poli(ε-caprolactona) (PCL) funcionalizadas con glicina para aplicaciones en reparación de heridas cutáneas crónicas. Esta investigación surge del interés por superar las limitaciones de bioactividad del PCL convencional, empleando la glicina —el aminoácido más pequeño— como aditivo citoprotector e inmunomodulador incorporado directamente durante el proceso de electrohilado, sin necesidad de recubrimientos ni pasos de reticulación posteriores.",
            ],
            [
                'anchor' => 'consiste',
                'nav' => '¿En qué consiste?',
                'title' => '¿En qué consiste Fibroglic?',
                'content' => "Fibroglic se fundamenta en la fabricación de nanofibras de poli(ε-caprolactona) (PCL) funcionalizadas con glicina mediante electrohilado. Este proceso permite obtener andamios fibrosos con diámetros de fibra a escala nanométrica y alta porosidad, características adecuadas para la regeneración de heridas cutáneas.\n\nLa incorporación de glicina mejora la estructura del andamio, reduciendo el diámetro de las fibras y aumentando la porosidad, mientras conserva propiedades mecánicas compatibles con la piel. Los análisis espectroscópicos y de difracción de rayos X confirman la incorporación de la glicina en la matriz polimérica.",
            ],
            [
                'anchor' => 'proceso',
                'nav' => 'Proceso',
                'title' => 'Desarrollo tecnológico y proceso de fabricación',
                'content' => "El principal componente de innovación de Fibroglic es la funcionalización directa de nanofibras de PCL con glicina durante el electrohilado, sin pasos de recubrimiento ni reticulación posteriores. Se prepara una solución de PCL y glicina en trifluoroetanol. La solución se procesa mediante electrohilado de aguja única, obteniendo fibras de tamaño similar a las fibras naturales de la dermis, organizadas aleatoriamente.",
            ],
            [
                'anchor' => 'resultados',
                'nav' => 'Resultados',
                'title' => 'Resultados científicos y propiedad intelectual',
                'content' => "Fibroglic ha sido evaluado en estudios in vitro e in vivo con resultados publicados en revista internacional indexada (Prieto-Abello et al., Polymers 2026, 18, 1920; doi:10.3390/polym18151920). Las células estromales mesenquimales de gelatina de Wharton (hWJ-MSCs) cultivadas sobre Fibroglic mostraron viabilidad superior al 95 % en todos los tiempos evaluados (24, 72 y 120 h), con un pico de aproximadamente 99,6 % a las 120 h, significativamente mayor que el control de PCL puro (p < 0,05).\n\nFibroglic promovió mayor actividad metabólica y proliferación celular a las 72 h. Únicamente sobre este andamio se detectó secreción de VEGF, con niveles progresivamente crecientes y significativamente superiores a los controles PCL y placa de cultivo (p < 0,05). Los niveles de HGF también fueron más elevados, sugiriendo un perfil secretor proangiogénico y proregenerativo. En un modelo in vivo de herida de espesor completo en cobayo (día 18), el constructo Fibroglic + hWJ-MSCs promovió respuesta inflamatoria modulada y depósito de colágeno más organizado frente al control no tratado.\n\nEl desarrollo de Fibroglic también cuenta con una solicitud de patente en trámite (NC2022/0006262).",
            ],
            [
                'anchor' => 'proyeccion',
                'nav' => 'Proyección',
                'title' => 'Proyección en ingeniería de tejidos',
                'content' => "Fibroglic representa una línea de desarrollo tecnológico centrada en la fabricación de biomateriales nanofibrilares funcionalizados con moléculas bioactivas de bajo peso molecular mediante electrohilado. Su proceso, basado en la incorporación directa de glicina durante el electrohilado sin reticulación ni recubrimientos posteriores a la fabricación, ofrece ventajas de reproducibilidad, estandarización y escalabilidad frente a alternativas con polímeros naturales como colágeno o gelatina.\n\nLa continuidad de esta investigación busca contribuir al desarrollo de alternativas para el tratamiento de úlceras cutáneas crónicas, integrando el conocimiento sobre biomateriales electrohilados, células estromales mesenquimales de cordón umbilical y evaluación biológica preclínica dentro de las capacidades científicas y tecnológicas de la Unidad de Ingeniería Tisular del IDCBIS.",
            ],
        ],
    ],
    'investigacion-ingenieria-tisular-hyalovite' => [
        'prefix' => 'ithy',
        'title' => 'Hyalovite',
        'eyebrow' => 'Proyecto · Piel',
        'summary' => 'Apósito de hidrogel a base de alcohol polivinílico, en proceso de escalamiento.',
        'lineTitle' => 'Piel',
        'backUrl' => $piel,
        'backLabel' => 'Volver a proyectos de piel',
        'highlightsAnchor' => 'resultados',
        'highlights' => [
            ['id' => 'ithy_h1', 'text' => 'Apósito de hidrogel de alcohol polivinílico (PVA)'],
            ['id' => 'ithy_h2', 'text' => 'Biocompatibilidad favorable en modelo murino, con resolución de la inflamación aguda inicial'],
        ],
        'sections' => [
            [
                'anchor' => 'presentacion',
                'nav' => 'Presentación',
                'title' => 'Presentación de Hyalovite',
                'content' => "Apósito de hidrogel a base de alcohol polivinílico (PVA), diseñado para adaptarse al lecho de la herida y mantener un ambiente húmedo y estable que favorezca las condiciones necesarias para la reparación tisular. Su formulación integra capacidad de retención de humedad, estabilidad estructural y facilidad de aplicación, contribuyendo al manejo integral de heridas. Esta tecnología es resultado de un codesarrollo y actualmente se encuentra en proceso de escalamiento para su producción industrial.",
            ],
            [
                'anchor' => 'consiste',
                'nav' => '¿En qué consiste?',
                'title' => '¿En qué consiste Hyalovite?',
                'content' => "Este dispositivo médico tipo apósito actúa mediante el intercambio y la gestión de humedad en el lecho de la herida. Al entrar en contacto con este, su matriz polimérica aporta soporte estructural, retiene agua y absorbe exudado en cantidades leves, contribuyendo a mantener un microambiente húmedo favorable para el proceso de cicatrización. Asimismo, Hyalovite actúa como una barrera física que protege la zona frente a contaminantes externos y favorece el debridamiento autolítico mediante los mecanismos fisiológicos naturales del organismo.\n\nEstabilidad controlada: está diseñado para conservar sus atributos críticos de calidad, integridad física y desempeño funcional durante el periodo de almacenamiento y bajo las condiciones previstas de uso.",
            ],
            [
                'anchor' => 'proceso',
                'nav' => 'Proceso',
                'title' => 'Desarrollo tecnológico y proceso de obtención',
                'content' => "El desarrollo se orienta a obtener una formulación reproducible, segura y estable durante su almacenamiento, manteniendo sus propiedades fisicoquímicas y funcionales durante la vida útil establecida. Para ello, se evalúan parámetros críticos como apariencia, pH, contenido de humedad, integridad del hidrogel, estabilidad microbiológica y desempeño funcional, tanto en condiciones de almacenamiento en tiempo real como mediante estudios de estabilidad acelerada.\n\nDurante su diseño se evalúan factores como la selección de materias primas, la preparación de la formulación, la homogenización, la formación del hidrogel, el acondicionamiento y empacado, el control de calidad y la estabilidad.",
            ],
            [
                'anchor' => 'resultados',
                'nav' => 'Resultados',
                'title' => 'Resultados científicos y propiedad intelectual',
                'content' => "El apósito de hidrogel presentó resultados favorables en el ensayo de biocompatibilidad en modelo murino, mostrando resolución total de la inflamación aguda inicial.",
            ],
            [
                'anchor' => 'proyeccion',
                'nav' => 'Proyección',
                'title' => 'Proyección en ingeniería de tejidos',
                'content' => "El hidrogel constituye una plataforma con potencial para evolucionar desde un apósito hacia un biomaterial para ingeniería y regeneración tisular, con posibles aplicaciones como:\n\n• Hidrogel para heridas\n• Hidrogel bioactivo o funcionalizado\n• Incorporación de moléculas o señales biológicas\n• Interacción controlada con células y matriz extracelular\n• Soporte o sistema regenerativo específico para un tejido\n\nLa plataforma desarrollada puede constituir la base tecnológica para futuras soluciones de medicina regenerativa, adaptando su composición, arquitectura y funcionalidad a diferentes necesidades de reparación tisular.",
            ],
        ],
    ],
    'investigacion-ingenieria-tisular-dispositivos-osteocondrales' => [
        'prefix' => 'itoo',
        'title' => 'Dispositivos médicos osteocondrales',
        'eyebrow' => 'Proyecto · Cartílago',
        'summary' => 'Dispositivos preclínicos BOTÓN y OAT para lesiones osteocondrales, mediante impresión 3D e hidrogel de alginato de calcio.',
        'lineTitle' => 'Cartílago',
        'backUrl' => $cartilago,
        'backLabel' => 'Volver a proyectos de cartílago',
        'highlightsAnchor' => 'resultados',
        'highlights' => [
            ['id' => 'itoo_h1', 'text' => 'Sin patente en esta etapa'],
            ['id' => 'itoo_h2', 'text' => 'Investigación preclínica en curso'],
            ['id' => 'itoo_h3', 'text' => 'Lara-Bertrand et al. Journal of Functional Biomaterials. 2026;17(3):128'],
        ],
        'sections' => [
            [
                'anchor' => 'presentacion',
                'nav' => 'Presentación',
                'title' => 'Presentación de los dispositivos osteocondrales',
                'content' => "Los dispositivos médicos osteocondrales corresponden a una investigación en fase preclínica de la Unidad de Ingeniería Tisular del IDCBIS, orientada al desarrollo de soluciones para lesiones osteocondrales articulares, es decir, defectos que comprometen simultáneamente el cartílago articular y el tejido óseo subyacente.\n\nLa línea incluye los dispositivos BOTÓN y OAT, concebidos bajo un mismo principio general de funcionamiento, pero diferenciados por la profundidad del daño que buscan abordar: BOTÓN para lesiones osteocondrales de menor profundidad y OAT para lesiones osteocondrales más profundas.",
            ],
            [
                'anchor' => 'consiste',
                'nav' => '¿En qué consiste?',
                'title' => '¿En qué consisten BOTÓN y OAT?',
                'content' => "BOTÓN y OAT se fundamentan en la combinación de una estructura fabricada mediante impresión 3D con un hidrogel de alginato de calcio. La manufactura aditiva permite ajustar la geometría del dispositivo a las características de la lesión, mientras que el hidrogel proporciona un entorno tridimensional favorable para la interacción y actividad celular durante el proceso de reparación.\n\nAmbos dispositivos buscan contribuir a la reparación del cartílago articular y del componente óseo comprometido. En esta fase no se afirman propiedades osteoinductivas, condrogénicas ni eficacia terapéutica demostrada en animales, hasta contar con resultados específicos confirmados.",
            ],
            [
                'anchor' => 'proceso',
                'nav' => 'Proceso',
                'title' => 'Desarrollo tecnológico y evaluación preclínica',
                'content' => "El desarrollo tecnológico integra diseño digital del defecto, fabricación mediante impresión 3D y combinación con hidrogel de alginato de calcio. La estructura impresa aporta soporte geométrico y adaptación a la lesión, mientras que el componente hidrogel funciona como matriz blanda para favorecer la interacción celular en el sitio de reparación.\n\nLa evaluación se ha desarrollado con células mesenquimales, modelos anatómicos y modelos animales en curso. En esta etapa, el proyecto se mantiene como investigación preclínica.",
            ],
            [
                'anchor' => 'resultados',
                'nav' => 'Resultados',
                'title' => 'Resultados científicos y propiedad intelectual',
                'content' => "El desarrollo cuenta con ensayos con células mesenquimales, evaluaciones en modelos anatómicos y evaluación mediante modelos animales en curso. El estado actual no permite afirmar todavía que los dispositivos sean osteoinductivos, condrogénicos o que regeneren un tejido específico con eficacia demostrada, hasta disponer de resultados concretos confirmados. No hay una patente asociada en este momento.\n\nComo soporte contextual, Lara-Bertrand et al. (2026) describen que la reparación del cartílago articular continúa siendo un reto traslacional y que las estrategias emergentes integran biomateriales, células y andamios tridimensionales para abordar la reparación de la unidad osteocondral.\n\nReferencia: Lara-Bertrand A.L., Lizarazo-Fonseca L., Correa-Araujo L., Salguero G., Silva-Cote I. Innovative Technologies for Articular Cartilage Repair: Research, Development, and Clinical Translation—A Narrative Review. Journal of Functional Biomaterials. 2026;17(3):128. doi:10.3390/jfb17030128.",
            ],
            [
                'anchor' => 'proyeccion',
                'nav' => 'Proyección',
                'title' => 'Proyección en ingeniería de tejidos',
                'content' => "Los dispositivos médicos osteocondrales representan una línea de desarrollo en ingeniería de tejidos orientada a explorar alternativas para lesiones articulares que comprometen el cartílago y el hueso subyacente. Su propuesta tecnológica integra diseño personalizado, manufactura aditiva e hidrogel de alginato de calcio como plataforma experimental para evaluación preclínica.\n\nLa continuidad del proyecto deberá centrarse en consolidar evidencia biológica, histológica, mecánica y funcional que permita definir con precisión el desempeño de BOTÓN y OAT, diferenciando sus indicaciones por profundidad de lesión.",
            ],
        ],
    ],
    'investigacion-ingenieria-tisular-pcl-pva' => [
        'prefix' => 'itpv',
        'title' => 'Impresión 3D de PCL con hidrogel de PVA/LP',
        'eyebrow' => 'Proyecto · Cartílago',
        'summary' => 'Proyecto de la línea de cartílago. El documento aún no incluye su desarrollo.',
        'lineTitle' => 'Cartílago',
        'backUrl' => $cartilago,
        'backLabel' => 'Volver a proyectos de cartílago',
        'sections' => [
            [
                'anchor' => 'presentacion',
                'nav' => 'Presentación',
                'title' => 'Impresión 3D de PCL con hidrogel de PVA/LP',
                'content' => "La línea de cartílago incluye este proyecto: impresión 3D de PCL con hidrogel de PVA/LP. El material entregado conserva el nombre y reserva esta ficha. El desarrollo científico —en qué consiste, el proceso, los resultados y la proyección— se publicará cuando la unidad lo entregue.",
            ],
        ],
    ],
    'investigacion-ingenieria-tisular-vesiculas-extracelulares' => [
        'prefix' => 'itve',
        'title' => 'Vesículas extracelulares',
        'eyebrow' => 'Proyecto · Otras líneas',
        'summary' => 'Aislamiento y caracterización de vesículas extracelulares derivadas de células estromales mesenquimales de gelatina de Wharton.',
        'lineTitle' => 'Otras líneas de investigación',
        'backUrl' => $otras,
        'backLabel' => 'Volver a otras líneas',
        'sections' => [
            [
                'anchor' => 'presentacion',
                'nav' => 'Presentación',
                'title' => 'Aislamiento y caracterización de vesículas extracelulares',
                'content' => "Las vesículas extracelulares constituyen una estrategia emergente para estudiar y aprovechar los mecanismos de comunicación intercelular asociados con la actividad biológica de las células estromales mesenquimales. En este contexto, la Unidad de Ingeniería Tisular (UIT) del Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud (IDCBIS) desarrolla una línea de investigación orientada al aislamiento y concentración de vesículas extracelulares derivadas de células estromales mesenquimales de gelatina de Wharton, mediante la obtención de medio condicionado y el empleo de tecnologías de filtración por flujo tangencial, complementadas con metodologías de caracterización fisicoquímica y biológica. Esta aproximación permite estudiar su composición, distribución de tamaño, estabilidad y actividad funcional, y avanzar en el desarrollo de plataformas con potencial de desarrollo biotecnológico.",
            ],
        ],
    ],
    'investigacion-ingenieria-tisular-progenitores-hematopoyeticos' => [
        'prefix' => 'itph',
        'title' => 'Progenitores hematopoyéticos',
        'eyebrow' => 'Proyecto · Otras líneas',
        'summary' => 'Interacción de progenitores de sangre de cordón umbilical con constructos que recrean componentes del nicho hematopoyético.',
        'lineTitle' => 'Otras líneas de investigación',
        'backUrl' => $otras,
        'backLabel' => 'Volver a otras líneas',
        'sections' => [
            [
                'anchor' => 'presentacion',
                'nav' => 'Presentación',
                'title' => 'Progenitores hematopoyéticos en matrices biomiméticas',
                'content' => "Los progenitores hematopoyéticos constituyen una población celular con capacidad de autorrenovación y diferenciación hacia los distintos linajes sanguíneos, cuyo comportamiento está estrechamente regulado por las características del microambiente que los rodea. A partir de este principio, la Unidad de Ingeniería Tisular (UIT) del Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud (IDCBIS) desarrolla investigaciones orientadas al estudio de progenitores hematopoyéticos provenientes de sangre de cordón umbilical y su interacción con constructos tridimensionales diseñados para recrear componentes del nicho hematopoyético. Estas aproximaciones integran biomateriales, cultivo celular y evaluación funcional para analizar la viabilidad, el mantenimiento y el potencial de diferenciación de estas células, avanzando hacia el desarrollo de plataformas experimentales que permitan estudiar de manera controlada las interacciones entre los progenitores hematopoyéticos y su microambiente.",
            ],
        ],
    ],
    'investigacion-ingenieria-tisular-tejido-vascular' => [
        'prefix' => 'ittv',
        'title' => 'Tejido vascular',
        'eyebrow' => 'Proyecto · Otras líneas',
        'summary' => 'Andamio biosintético tubular para reparación de tejido vascular, en estudio preclínico in vitro.',
        'lineTitle' => 'Otras líneas de investigación',
        'backUrl' => $otras,
        'backLabel' => 'Volver a otras líneas',
        'sections' => [
            [
                'anchor' => 'presentacion',
                'nav' => 'Presentación',
                'title' => 'Investigación en ingeniería de tejido vascular',
                'content' => "La Unidad de Ingeniería Tisular (UIT) del IDCBIS desarrolla un estudio preclínico in vitro orientado al diseño y fabricación de un andamio biosintético tubular para reparación de tejido vascular. El proyecto contempla el aislamiento y expansión de células endoteliales y células de músculo liso obtenidas de venas y arterias de cordón umbilical, con el fin de evaluar su adhesión, viabilidad y proliferación sobre los andamios fabricados. Esta estrategia integra biomateriales, impresión 3D, electrohilado y caracterización fisicoquímica, mecánica y biológica, como una aproximación experimental para generar constructos tisulares vasculares con potencial aplicación futura en enfermedades asociadas al deterioro u obstrucción de vasos sanguíneos.",
            ],
        ],
    ],
];
