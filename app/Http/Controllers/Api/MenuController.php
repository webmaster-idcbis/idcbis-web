<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $query = Menu::query();
        
        if ($request->has('location')) {
            $query->byLocation($request->location);
        }
        
        $menus = $query->ordered()->get();
        
        return response()->json([
            'data' => $menus
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|in:header,footer',
            'items' => 'required|array',
            'items.*.title' => 'required|string',
            'items.*.type' => 'required|in:page,url',
            'items.*.url' => 'required|string',
            'items.*.target' => 'nullable|in:_self,_blank',
            'items.*.order' => 'nullable|integer',
            'is_active' => 'boolean',
            'order' => 'nullable|integer'
        ]);

        $menu = Menu::create($validated);

        return response()->json([
            'data' => $menu,
            'message' => 'Menú creado exitosamente'
        ], 201);
    }

    public function show(Menu $menu)
    {
        return response()->json([
            'data' => $menu
        ]);
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|in:header,footer',
            'items' => 'required|array',
            'items.*.title' => 'required|string',
            'items.*.type' => 'required|in:page,url',
            'items.*.url' => 'required|string',
            'items.*.target' => 'nullable|in:_self,_blank',
            'items.*.order' => 'nullable|integer',
            'is_active' => 'boolean',
            'order' => 'nullable|integer'
        ]);

        $menu->update($validated);

        return response()->json([
            'data' => $menu,
            'message' => 'Menú actualizado exitosamente'
        ]);
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        return response()->json([
            'message' => 'Menú eliminado exitosamente'
        ]);
    }

    public function getPublicMenus(Request $request)
    {
        $location = $request->get('location', 'header');
        
        $menu = Menu::active()
            ->byLocation($location)
            ->ordered()
            ->first();

        if (!$menu) {
            return response()->json([
                'data' => null
            ]);
        }

        // Resolver URLs de páginas
        $items = collect($menu->items)->map(function ($item) {
            if ($item['type'] === 'page') {
                $page = Page::find($item['page_id'] ?? null);
                $item['url'] = $page ? '/' . $page->slug : '#';
                $item['is_active'] = $page && $page->status === 'published';
            }
            return $item;
        })->filter(function ($item) {
            // Solo mostrar items activos (páginas publicadas o URLs externas)
            return !isset($item['is_active']) || $item['is_active'];
        })->sortBy('order')->values()->all();

        return response()->json([
            'data' => [
                'id' => $menu->id,
                'name' => $menu->name,
                'location' => $menu->location,
                'items' => $items
            ]
        ]);
    }

    public function getAvailablePages()
    {
        $pages = Page::select('id', 'title', 'slug')
            ->where('status', 'published')
            ->orderBy('title')
            ->get();

        return response()->json([
            'data' => $pages
        ]);
    }
}
