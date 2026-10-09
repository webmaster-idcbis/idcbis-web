<?php

require_once __DIR__.'/investigacion-inmunoterapia-proyecto.php';

return investigacionInmunoterapiaProyecto([
    'prefix' => 'itcr',
    'title' => 'TCR-T y VPH',
    'summary' => 'Receptor de célula T modificado para cáncer asociado al virus del papiloma humano.',
    'image' => '/img/inmunoterapia/espacio-hero.svg',
    'imageAlt' => 'Espacio reservado para las figuras de TCR-T. La lámina correspondiente del documento está vacía.',
    'content' => "La inmunoterapia con receptores de células T modificados (TCR-T) redirige la especificidad citotóxica frente a dianas tumorales intracelulares. Aprovecha la presentación de antígenos en el complejo mayor de histocompatibilidad (MHC) para que los linfocitos modificados reconozcan células que expresan oncoproteínas virales.\n\nEl grupo demuestra la viabilidad de este principio con linfocitos infiltrantes de tumor específicos contra el VPH en cáncer de cuello uterino de pacientes colombianas. En co-cultivo de TIL pre-REP con líneas de células B inmortalizadas (LCL) autólogas, pulsadas con péptidos virales, identificó reactividad contra las oncoproteínas E6 y E7, medida por CD137 e IFN-γ. El mapeo por citometría de flujo mostró enriquecimiento de subpoblaciones efectoras residentes (CD8⁺, CD39⁺, CD103⁺).\n\nEl aislamiento de secuencias de TCR desde esas subpoblaciones (SMART-seq) y su validación preclínica marcan la primera estrategia de este tipo en esta población. La plataforma permite escalar hacia modelos in vivo y la futura traslación clínica.\n\nLa lámina de figuras de esta línea está pendiente. El espacio de la imagen queda listo para esa figura.",
]);
