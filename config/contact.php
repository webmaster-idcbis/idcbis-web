<?php

return [

  /*
  |--------------------------------------------------------------------------
  | Correo de destino del formulario de contacto
  |--------------------------------------------------------------------------
  |
  | Dirección a la que se envía cada mensaje recibido desde /contacto.
  |
  */

  'mail_to' => env('CONTACT_MAIL_TO', 'contacto@idcbis.org.co'),

  'mail_to_name' => env('CONTACT_MAIL_TO_NAME', 'IDCBIS'),

];
