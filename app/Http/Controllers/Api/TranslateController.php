<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Endpoint deshabilitado para traducción en caliente (era demasiado lento en SPA).
 * Usa: php artisan pages:pretranslate
 */
class TranslateController extends Controller
{
    public function __invoke(Request $request)
    {
        return response()->json([
            'message' => 'La traducción en tiempo real está deshabilitada. Pregenera con: php artisan pages:pretranslate',
        ], 410);
    }
}
