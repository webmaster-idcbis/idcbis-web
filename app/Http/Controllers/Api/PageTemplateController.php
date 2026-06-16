<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PageTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PageTemplateController extends Controller
{
    public function index()
    {
        $templates = PageTemplate::with('creator:id,name')
            ->orderByDesc('is_system')
            ->orderBy('name')
            ->get();

        return response()->json(['data' => $templates]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:page_templates,slug',
            'description' => 'nullable|string|max:1000',
            'content' => 'required|array',
            'meta_title' => 'nullable|string|max:70',
            'meta_description' => 'nullable|string|max:160',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['created_by'] = Auth::id();
        $validated['is_system'] = false;

        $template = PageTemplate::create($validated);

        return response()->json([
            'data' => $template->load('creator:id,name'),
            'message' => 'Plantilla guardada exitosamente',
        ], 201);
    }

    public function show(PageTemplate $pageTemplate)
    {
        return response()->json([
            'data' => $pageTemplate->load('creator:id,name'),
        ]);
    }

    public function destroy(PageTemplate $pageTemplate)
    {
        if ($pageTemplate->is_system) {
            return response()->json([
                'message' => 'No se pueden eliminar plantillas del sistema',
            ], 403);
        }

        $pageTemplate->delete();

        return response()->json([
            'message' => 'Plantilla eliminada exitosamente',
        ]);
    }
}
