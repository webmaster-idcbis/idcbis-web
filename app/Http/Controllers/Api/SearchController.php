<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Services\PageSearchIndexer;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim((string) $request->get('q', ''));
        $limit = min(max((int) $request->get('limit', 20), 1), 50);

        if (mb_strlen($query) < 2) {
            return response()->json([
                'data' => [],
                'meta' => [
                    'query' => $query,
                    'total' => 0,
                ],
            ]);
        }

        $terms = array_values(array_filter(
            preg_split('/\s+/u', $query) ?: [],
            fn ($term) => mb_strlen($term) >= 2
        ));

        if ($terms === []) {
            return response()->json([
                'data' => [],
                'meta' => [
                    'query' => $query,
                    'total' => 0,
                ],
            ]);
        }

        $pagesQuery = Page::query()
            ->where('status', 'published')
            ->where(function ($builder) {
                $builder->where('no_index', false)->orWhereNull('no_index');
            })
            ->whereNotNull('search_text')
            ->where('search_text', '!=', '');

        foreach ($terms as $term) {
            $like = '%' . addcslashes($term, '%_\\') . '%';
            $pagesQuery->where(function ($builder) use ($like) {
                $builder->where('title', 'like', $like)
                    ->orWhere('meta_description', 'like', $like)
                    ->orWhere('meta_keywords', 'like', $like)
                    ->orWhere('search_text', 'like', $like);
            });
        }

        $pages = $pagesQuery->get();

        $results = $pages
            ->map(function (Page $page) use ($query, $terms) {
                return [
                    'id' => $page->id,
                    'title' => $page->title,
                    'slug' => $page->slug,
                    'url' => $page->slug === 'inicio' ? '/' : '/' . ltrim($page->slug, '/'),
                    'excerpt' => PageSearchIndexer::excerpt($page->search_text ?? '', $query),
                    'score' => PageSearchIndexer::relevanceScore($page, $query, $terms),
                ];
            })
            ->sortByDesc('score')
            ->values()
            ->take($limit)
            ->map(fn (array $item) => collect($item)->except('score')->all())
            ->values()
            ->all();

        return response()->json([
            'data' => $results,
            'meta' => [
                'query' => $query,
                'total' => count($results),
            ],
        ]);
    }
}
