<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::with('creator:id,name', 'updater:id,name')
            ->latest()
            ->get();

        return response()->json([
            'data' => $pages,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $this->ensureJsonPayloadMerged($request);

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:pages,slug',
                'meta_description' => 'nullable|string|max:160',
                'meta_title' => 'nullable|string|max:70',
                'meta_keywords' => 'nullable|string|max:255',
                'og_image' => 'nullable|url|max:500',
                'no_index' => 'boolean',
                'canonical_url' => 'nullable|string|max:500',
                'content' => 'nullable|array',
                'sections' => 'nullable|array',
                'status' => 'in:draft,published,archived',
            ]);

            if (empty($validated['slug'])) {
                $validated['slug'] = Str::slug($validated['title']);
            }

            $validated['created_by'] = Auth::id();
            $validated['updated_by'] = Auth::id();

            if (($validated['status'] ?? 'draft') === 'published') {
                $validated['published_at'] = now();
            }

            $page = new Page(collect($validated)->except(['content', 'sections'])->all());
            $this->assignPageContentFromRequest($page, $request);
            $page->save();
            $page->refresh();

            return response()->json($this->buildSaveResponse(
                $page->load('creator:id,name', 'updater:id,name'),
                'Página creada exitosamente',
                $request,
            ), 201)->header('Cache-Control', 'no-store, no-cache, must-revalidate');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear la página',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $page = Page::with(['creator:id,name', 'updater:id,name'])->find($id);

            if (! $page) {
                return response()->json([
                    'message' => 'Página no encontrada',
                ], 404);
            }

            return response()->json([
                'data' => $page,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener la página',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function showBySlug($slug)
    {
        $page = Page::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return response()->json([
            'data' => $page->load(['creator:id,name', 'updater:id,name']),
        ])->header('Cache-Control', 'no-store, no-cache, must-revalidate');
    }

    public function update(Request $request, $id)
    {
        try {
            $this->ensureJsonPayloadMerged($request);

            $page = Page::find($id);

            if (! $page) {
                return response()->json([
                    'message' => 'Página no encontrada',
                ], 404);
            }

            $validated = $request->validate([
                'title' => 'sometimes|string|max:255',
                'slug' => 'sometimes|string|max:255|unique:pages,slug,'.$page->id,
                'meta_description' => 'nullable|string|max:160',
                'meta_title' => 'nullable|string|max:70',
                'meta_keywords' => 'nullable|string|max:255',
                'og_image' => 'nullable|url|max:500',
                'no_index' => 'boolean',
                'canonical_url' => 'nullable|string|max:500',
                'content' => 'nullable|array',
                'sections' => 'nullable|array',
                'status' => 'in:draft,published,archived',
            ]);

            $validated['updated_by'] = Auth::id();

            if (isset($validated['status'])) {
                if ($validated['status'] === 'published' && $page->status !== 'published') {
                    $validated['published_at'] = now();
                } elseif ($validated['status'] !== 'published' && $page->status === 'published') {
                    $validated['published_at'] = null;
                }
            }

            $page->fill(collect($validated)->except(['content', 'sections'])->all());
            $this->assignPageContentFromRequest($page, $request);
            $page->save();
            $this->forcePersistContent($page, $request);
            $page->refresh();

            return response()->json($this->buildSaveResponse(
                $page->load('creator:id,name', 'updater:id,name'),
                'Página actualizada exitosamente',
                $request,
            ))->header('Cache-Control', 'no-store, no-cache, must-revalidate');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar la página',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    private function ensureJsonPayloadMerged(Request $request): void
    {
        if (array_key_exists('content', $request->all())) {
            return;
        }

        $candidates = [];

        if ($request->has('payload')) {
            $candidates[] = $request->input('payload');
        }

        $raw = $GLOBALS['laravel_raw_input'] ?? '';
        if ($raw !== '') {
            $candidates[] = $raw;
        }

        foreach ($candidates as $rawJson) {
            if (! is_string($rawJson) || $rawJson === '') {
                continue;
            }

            $decoded = json_decode($rawJson, true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $request->merge($decoded);
                return;
            }
        }
    }

    private function contentWasReceived(Request $request): bool
    {
        return array_key_exists('content', $request->all());
    }

    private function buildSaveResponse(Page $page, string $message, Request $request): array
    {
        $contentSaved = $this->contentWasReceived($request);

        $response = [
            'data' => $page,
            'message' => $message,
            'content_saved' => $contentSaved,
        ];

        if (config('app.debug') && ! $contentSaved) {
            $response['debug'] = [
                'content_type' => $request->header('Content-Type'),
                'input_keys' => array_keys($request->all()),
                'raw_len' => strlen($GLOBALS['laravel_raw_input'] ?? ''),
                'has_payload' => $request->has('payload'),
                'payload_len' => $request->has('payload')
                    ? strlen((string) $request->input('payload'))
                    : 0,
            ];
        }

        return $response;
    }

    private function assignPageContentFromRequest(Page $page, Request $request): void
    {
        if (array_key_exists('content', $request->all())) {
            $page->content = $request->input('content');
        }

        if (array_key_exists('sections', $request->all())) {
            $page->setAttribute('sections', $request->input('sections'));
        }
    }

    private function forcePersistContent(Page $page, Request $request): void
    {
        if (! $page->id) {
            return;
        }

        $updates = [];

        if (array_key_exists('content', $request->all())) {
            $updates['content'] = json_encode(
                $request->input('content'),
                JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR
            );
        }

        if (array_key_exists('sections', $request->all())) {
            $updates['sections'] = json_encode(
                $request->input('sections'),
                JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR
            );
        }

        if ($updates !== []) {
            $updates['updated_at'] = now();
            DB::table('pages')->where('id', $page->id)->update($updates);
        }
    }

    public function destroy($id)
    {
        try {
            $page = Page::find($id);

            if (! $page) {
                return response()->json([
                    'message' => 'Página no encontrada',
                ], 404);
            }

            $page->delete();

            return response()->json([
                'message' => 'Página eliminada exitosamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar la página',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function publish($id)
    {
        try {
            $page = Page::find($id);

            if (! $page) {
                return response()->json([
                    'message' => 'Página no encontrada',
                ], 404);
            }

            if ($page->status !== 'published') {
                $page->update([
                    'status' => 'published',
                    'published_at' => now(),
                    'updated_by' => Auth::id(),
                ]);
            }

            return response()->json([
                'data' => $page->load('creator:id,name', 'updater:id,name'),
                'message' => 'Página publicada exitosamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al publicar la página',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
