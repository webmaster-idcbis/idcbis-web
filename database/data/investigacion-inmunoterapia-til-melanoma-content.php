<?php

require_once __DIR__.'/investigacion-inmunoterapia-proyecto.php';

return investigacionInmunoterapiaProyecto([
    'prefix' => 'itil',
    'title' => 'TIL en melanoma',
    'summary' => 'Linfocitos infiltrantes de tumor para melanoma avanzado. Grupo de Inmunoterapias, Unidad de Terapias Avanzadas.',
    'image' => '/img/inmunoterapia/espacio-hero.svg',
    'imageAlt' => 'Espacio reservado para las figuras de la terapia TIL en melanoma. La lámina del documento solo trae el título.',
    'content' => "La terapia con linfocitos infiltrantes de tumor (TIL) parte de que el sistema inmunitario del paciente ya ha reconocido el tumor, pero su capacidad efectora está suprimida y metabólicamente agotada por el microambiente tumoral. La estrategia rescata el infiltrado linfocitario nativo poliespecífico desde el tejido neoplásico primario o metastásico. Al liberar estas células de las señales inhibitorias, expandirlas ex vivo y reintroducirlas, se restaura la capacidad citotóxica policlonal para atacar varios neoantígenos a la vez.\n\nEl grupo implementa este enfoque a partir de resecciones y biopsias de pacientes con melanoma maligno. El proceso incluye la disgregación del tejido, cultivos primarios en fase pre-REP con altas dosis de IL-2 y un protocolo de rápida expansión (REP) en configuración masiva (bulk), con anticuerpos anti-CD3 (OKT3) y células alimentadoras irradiadas.\n\nLa estandarización de la manipulación de muestras primarias, el cultivo y la validación de la actividad citotóxica sirven de base para las líneas de redirección de antígeno, edición génica e ingeniería de TCR-T.\n\nLa lámina de figuras de este proyecto está pendiente.",
]);
