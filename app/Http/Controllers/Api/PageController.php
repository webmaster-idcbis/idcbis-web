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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug',
            'meta_description' => 'nullable|string|max:500',
            'content' => 'nullable|array',
            'sections' => 'nullable|array',
            'status' => 'in:draft,published,archived',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['created_by'] = Auth::id();

        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        $page = Page::create($validated);

        return response()->json([
            'data' => $page->load('creator:id,name'),
            'message' => 'Página creada exitosamente'
        ], 201);
    }

    public function show(Page $page)
    {
        return response()->json([
            'data' => $page->load(['creator:id,name', 'updater:id,name'])
        ]);
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

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'slug' => 'sometimes|string|max:255|unique:pages,slug,' . $page->id,
            'meta_description' => 'nullable|string|max:500',
            'content' => 'nullable|array',
            'sections' => 'nullable|array',
            'status' => 'in:draft,published,archived',
        ]);

        $validated['updated_by'] = Auth::id();

        if ($validated['status'] === 'published' && $page->status !== 'published') {
            $validated['published_at'] = now();
        }

        $page->update($validated);

        return response()->json([
            'data' => $page->load('creator:id,name', 'updater:id,name'),
            'message' => 'Página actualizada exitosamente'
        ]);
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return response()->json([
            'message' => 'Página eliminada exitosamente'
        ]);
    }

    public function publish(Page $page)
    {
        $page->update([
            'status' => 'published',
            'published_at' => now(),
            'updated_by' => Auth::id()
        ]);

        return response()->json([
            'data' => $page->load('creator:id,name', 'updater:id,name'),
            'message' => 'Página publicada exitosamente'
        ]);
    }
}
