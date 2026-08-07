<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Motor de traducción offline / pregeneración
    |--------------------------------------------------------------------------
    |
    | gtx            → endpoint público no oficial de Google (sin instalar nada)
    | libretranslate → open source autoalojado (recomendado, gratis y local)
    |
    | Arranque rápido LibreTranslate:
    |   docker run -d -p 5000:5000 libretranslate/libretranslate
    |
    */
    'driver' => env('TRANSLATION_DRIVER', 'gtx'),

    'libretranslate' => [
        'url' => env('LIBRETRANSLATE_URL', 'http://127.0.0.1:5000'),
        'api_key' => env('LIBRETRANSLATE_API_KEY'),
    ],
];
