<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::with('creator:id,name', 'updater:id,name')
            ->latest()
            ->get();
        
        return response()->json([
            'data' => $pages
        ]);
    }

    public function store(Request $request)
    {
        try {
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
            $validated['updated_by'] = Auth::id(); // Asignar updated_by también

            if ($validated['status'] === 'published') {
                $validated['published_at'] = now();
            }

            $page = Page::create($validated);

            return response()->json([
                'data' => $page->load('creator:id,name', 'updater:id,name'),
                'message' => 'Página creada exitosamente'
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear la página',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $page = Page::with(['creator:id,name', 'updater:id,name'])->find($id);
            
            if (!$page) {
                return response()->json([
                    'message' => 'Página no encontrada'
                ], 404);
            }
            
            return response()->json([
                'data' => $page
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener la página',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function showBySlug($slug)
    {
        $page = Page::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();
        
        return response()->json([
            'data' => $page->load(['creator:id,name', 'updater:id,name'])
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $page = Page::find($id);
            
            if (!$page) {
                return response()->json([
                    'message' => 'Página no encontrada'
                ], 404);
            }
            
            $validated = $request->validate([
                'title' => 'sometimes|string|max:255',
                'slug' => 'sometimes|string|max:255|unique:pages,slug,' . $page->id,
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

            // Manejar published_at según el cambio de status
            if (isset($validated['status'])) {
                if ($validated['status'] === 'published' && $page->status !== 'published') {
                    $validated['published_at'] = now();
                } elseif ($validated['status'] !== 'published' && $page->status === 'published') {
                    $validated['published_at'] = null; // Limpiar published_at si se despublica
                }
            }

            $page->update($validated);

            return response()->json([
                'data' => $page->load('creator:id,name', 'updater:id,name'),
                'message' => 'Página actualizada exitosamente'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar la página',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $page = Page::find($id);
            
            if (!$page) {
                return response()->json([
                    'message' => 'Página no encontrada'
                ], 404);
            }
            
            $page->delete();

            return response()->json([
                'message' => 'Página eliminada exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar la página',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function publish($id)
    {
        try {
            $page = Page::find($id);
            
            if (!$page) {
                return response()->json([
                    'message' => 'Página no encontrada'
                ], 404);
            }
            
            // Solo actualizar si no está ya publicada
            if ($page->status !== 'published') {
                $page->update([
                    'status' => 'published',
                    'published_at' => now(),
                    'updated_by' => Auth::id()
                ]);
            }

            return response()->json([
                'data' => $page->load('creator:id,name', 'updater:id,name'),
                'message' => 'Página publicada exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al publicar la página',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
