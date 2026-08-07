<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ContactFormSubmitted;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:120',
            'email' => 'required|email|max:255',
            'asunto' => 'required|string|max:200',
            'mensaje' => 'required|string|max:5000',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Ingrese un correo electrónico válido.',
            'asunto.required' => 'El asunto es obligatorio.',
            'mensaje.required' => 'El mensaje es obligatorio.',
        ]);

        $recipient = config('contact.mail_to');
        $recipientName = config('contact.mail_to_name');

        try {
            Mail::to($recipient, $recipientName)
                ->send(new ContactFormSubmitted($validated));
        } catch (\Throwable $e) {
            Log::error('Error al enviar formulario de contacto', [
                'error' => $e->getMessage(),
                'email' => $validated['email'],
            ]);

            return response()->json([
                'message' => 'No fue posible enviar su mensaje en este momento. Intente de nuevo más tarde.',
            ], 503);
        }

        return response()->json([
            'message' => 'Su mensaje fue enviado correctamente. Nos pondremos en contacto pronto.',
        ]);
    }
}
