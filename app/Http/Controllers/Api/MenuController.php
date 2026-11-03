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
        $this->prepareMenuItems($request);

        $validated = $request->validate($this->menuRules());

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
        $this->prepareMenuItems($request);

        $validated = $request->validate($this->menuRules());

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

        $items = $this->resolveMenuItems($menu->items ?? []);

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

    private function menuRules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'location' => 'required|in:header,footer',
            'items' => 'required|array',
            'items.*.title' => 'required|string',
            'items.*.type' => 'required|in:page,url',
            'items.*.url' => 'required|string',
            'items.*.target' => 'nullable|in:_self,_blank',
            'items.*.order' => 'nullable|integer',
            'items.*.page_id' => 'nullable|integer',
            'items.*.children' => 'nullable|array',
            'items.*.children.*.title' => 'required|string',
            'items.*.children.*.type' => 'required|in:page,url',
            'items.*.children.*.url' => 'nullable|string',
            'items.*.children.*.target' => 'nullable|in:_self,_blank',
            'items.*.children.*.order' => 'nullable|integer',
            'items.*.children.*.page_id' => 'nullable|integer',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ];
    }

    private function prepareMenuItems(Request $request): void
    {
        $items = $request->input('items');

        if (! is_array($items)) {
            return;
        }

        $request->merge([
            'items' => $this->normalizeMenuItems($items),
        ]);
    }

    private function normalizeMenuItems(array $items): array
    {
        return array_values(array_map(function ($item) {
            if (! is_array($item)) {
                return $item;
            }

            if (array_key_exists('page_id', $item) && $item['page_id'] === '') {
                $item['page_id'] = null;
            }

            if (isset($item['children']) && is_array($item['children'])) {
                $item['children'] = $this->normalizeMenuItems($item['children']);
            }

            return $item;
        }, $items));
    }

    private function resolveMenuItems(array $items): array
    {
        return collect($items)->map(function ($item) {
            if (! is_array($item)) {
                return null;
            }

            if (($item['type'] ?? null) === 'page') {
                $page = Page::find($item['page_id'] ?? null);
                $item['url'] = $page ? '/'.$page->slug : '#';
                $item['is_active'] = $page && $page->status === 'published';
            }

            if (! empty($item['children']) && is_array($item['children'])) {
                $item['children'] = $this->resolveMenuItems($item['children']);
            }

            return $item;
        })->filter(function ($item) {
            return is_array($item) && (! isset($item['is_active']) || $item['is_active']);
        })->sortBy('order')->values()->all();
    }
}
