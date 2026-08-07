<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * En Windows/Laragon el cuerpo JSON a veces no llega a $request->all().
 * Usar campo "payload" (FormData) → PHP lo lee desde $_POST sin php://input.
 */
class ParseJsonBody
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('payload')) {
            $payload = $request->input('payload');
            if (is_string($payload) && $payload !== '') {
                $this->mergeDecodedPayload($request, $payload);

                return $next($request);
            }
        }

        if (! array_key_exists('content', $request->all())) {
            $this->mergeDecodedPayload($request, $this->resolveRawJson($request));
        }

        return $next($request);
    }

    private function resolveRawJson(Request $request): ?string
    {
        if (str_contains($request->header('Content-Type', ''), 'application/json')) {
            $stream = @file_get_contents('php://input');
            if (is_string($stream) && $stream !== '') {
                return $stream;
            }
        }

        return null;
    }

    private function mergeDecodedPayload(Request $request, ?string $rawJson): void
    {
        if ($rawJson === null || $rawJson === '') {
            return;
        }

        $decoded = json_decode($rawJson, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            $request->merge($decoded);
        }
    }
}
