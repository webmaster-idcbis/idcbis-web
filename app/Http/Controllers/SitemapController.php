<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $base = rtrim((string) config('app.url'), '/');
        $urls = [];

        Page::query()
            ->where('status', 'published')
            ->where('no_index', false)
            ->orderBy('slug')
            ->get(['slug', 'canonical_url', 'updated_at'])
            ->each(function (Page $page) use (&$urls, $base) {
                $path = $page->slug === 'inicio' ? '/' : '/'.$page->slug;
                $urls[] = [
                    'loc' => $this->absoluteUrl($page->canonical_url, $path, $base),
                    'lastmod' => $page->updated_at?->toAtomString(),
                ];
            });

        Post::query()
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('slug')
            ->get(['slug', 'updated_at'])
            ->each(function (Post $post) use (&$urls, $base) {
                $urls[] = [
                    'loc' => $base.'/noticias/'.$post->slug,
                    'lastmod' => $post->updated_at?->toAtomString(),
                ];
            });

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach ($urls as $url) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>'.e($url['loc'])."</loc>\n";
            if ($url['lastmod']) {
                $xml .= '    <lastmod>'.e($url['lastmod'])."</lastmod>\n";
            }
            $xml .= "  </url>\n";
        }

        $xml .= "</urlset>\n";

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }

    private function absoluteUrl(?string $canonical, string $path, string $base): string
    {
        if ($canonical && preg_match('#^https?://#i', $canonical)) {
            return $canonical;
        }

        if ($canonical && str_starts_with($canonical, '/')) {
            return $base.$canonical;
        }

        return $path === '/' ? $base.'/' : $base.$path;
    }
}
