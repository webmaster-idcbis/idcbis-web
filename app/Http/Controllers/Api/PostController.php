<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Support\PostCategories;
use App\Support\PostMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    public function index(Request $request)
    {
        return $this->listPosts($request, publicOnly: true);
    }

    public function adminIndex(Request $request)
    {
        return $this->listPosts($request, publicOnly: false);
    }

    private function listPosts(Request $request, bool $publicOnly): \Illuminate\Http\JsonResponse
    {
        $query = Post::query()
            ->with('creator:id,name', 'updater:id,name')
            ->latest($publicOnly ? 'published_at' : 'updated_at');

        if ($publicOnly) {
            $query->where('status', 'published')
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now());
        }

        if ($category = $request->string('category')->toString()) {
            if ($category !== 'all' && PostCategories::isValid($category)) {
                $query->where('category', $category);
            }
        }

        if ($search = trim($request->string('q')->toString())) {
            $query->where(function ($builder) use ($search) {
                $builder->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($request->boolean('paginate')) {
            $perPage = min(max((int) $request->input('per_page', 9), 1), 50);
            $paginator = $query->paginate($perPage);
            $mapFn = $publicOnly ? 'toListArray' : 'toAdminListArray';

            return response()->json([
                'data' => collect($paginator->items())->map->$mapFn()->values(),
                'meta' => [
                    'current_page' => $paginator->currentPage(),
                    'last_page' => $paginator->lastPage(),
                    'per_page' => $paginator->perPage(),
                    'total' => $paginator->total(),
                ],
            ])->header('Cache-Control', 'no-store, no-cache, must-revalidate');
        }

        $posts = $query->get();

        $mapFn = $publicOnly ? 'toListArray' : 'toAdminListArray';

        return response()->json([
            'data' => $posts->map->$mapFn()->values(),
        ]);
    }

    public function store(Request $request)
    {
        $this->ensureJsonPayloadMerged($request);

        if (! $this->payloadWasReceived($request)) {
            return response()->json([
                'message' => 'No se recibieron los datos del formulario. Vuelve a intentar guardar.',
            ], 422);
        }

        $this->persistIncomingMedia($request);
        $validated = $this->validatePost($request);

        if (empty($validated['slug'])) {
            $validated['slug'] = $this->uniqueSlug($validated['title']);
        }

        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();
        $validated = $this->applyPublishDates($validated);

        $post = new Post;
        $post->fill(collect($validated)->except(['content', 'featured_image'])->all());
        $this->assignPostBodyFromRequest($post, $request);
        $post->save();

        return response()->json($this->buildSaveResponse(
            $post->load('creator:id,name', 'updater:id,name'),
            'Noticia creada exitosamente',
            $request,
        ), 201);
    }

    public function show($id)
    {
        $post = Post::with('creator:id,name', 'updater:id,name')->findOrFail($id);
        $data = $post->toArray();
        $data['featured_image'] = PostMedia::normalizeUrl($post->getRawOriginal('featured_image'));
        $data['content'] = PostMedia::normalizeContent($post->getRawOriginal('content'));

        return response()->json([
            'data' => $data,
        ]);
    }

    public function showBySlug(string $slug)
    {
        $post = Post::query()
            ->with('creator:id,name')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->firstOrFail();

        $related = Post::query()
            ->where('status', 'published')
            ->where('id', '!=', $post->id)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderByRaw('CASE WHEN category = ? THEN 0 ELSE 1 END', [$post->category])
            ->latest('published_at')
            ->limit(8)
            ->get()
            ->map->toListArray()
            ->values();

        return response()->json([
            'data' => $post->toDetailArray(),
            'related' => $related,
        ])->header('Cache-Control', 'no-store, no-cache, must-revalidate');
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $this->ensureJsonPayloadMerged($request);

        if (! $this->payloadWasReceived($request)) {
            return response()->json([
                'message' => 'No se recibieron los datos del formulario. Vuelve a intentar guardar.',
            ], 422);
        }

        $this->persistIncomingMedia($request);
        $validated = $this->validatePost($request, $post);

        if (isset($validated['title']) && empty($validated['slug'] ?? null) && ! $request->has('slug')) {
            unset($validated['slug']);
        }

        $validated['updated_by'] = Auth::id();
        $validated = $this->applyPublishDates($validated, $post);

        $post->fill(collect($validated)->except(['content', 'featured_image'])->all());
        $this->assignPostBodyFromRequest($post, $request);
        $post->save();

        return response()->json($this->buildSaveResponse(
            $post->fresh()->load('creator:id,name', 'updater:id,name'),
            'Noticia actualizada exitosamente',
            $request,
        ));
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json([
            'message' => 'Noticia eliminada exitosamente',
        ]);
    }

    public function publish($id)
    {
        $post = Post::findOrFail($id);

        if ($post->status !== 'published') {
            $post->update([
                'status' => 'published',
                'published_at' => $post->published_at ?? now(),
                'updated_by' => Auth::id(),
            ]);
        }

        return response()->json([
            'data' => $post->fresh()->load('creator:id,name', 'updater:id,name'),
            'message' => 'Noticia publicada exitosamente',
        ]);
    }

    public function categories()
    {
        return response()->json([
            'data' => collect(PostCategories::LABELS)->map(function ($label, $id) {
                return ['id' => $id, 'label' => $label];
            })->values(),
        ]);
    }

    private function ensureJsonPayloadMerged(Request $request): void
    {
        if (! $request->has('payload')) {
            return;
        }

        $raw = $request->input('payload');

        if (! is_string($raw) || $raw === '') {
            return;
        }

        $decoded = json_decode($raw, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            $request->merge($decoded);
        }
    }

    private function payloadWasReceived(Request $request): bool
    {
        return $request->has('title')
            || array_key_exists('content', $request->all())
            || array_key_exists('featured_image', $request->all());
    }

    private function persistIncomingMedia(Request $request): void
    {
        if (array_key_exists('featured_image', $request->all())) {
            $request->merge([
                'featured_image' => PostMedia::persistIfDataUrl($request->input('featured_image')),
            ]);
        }

        if (array_key_exists('content', $request->all())) {
            $request->merge([
                'content' => PostMedia::persistContentDataUrls($request->input('content')),
            ]);
        }
    }

    private function assignPostBodyFromRequest(Post $post, Request $request): void
    {
        if (array_key_exists('content', $request->all())) {
            $post->content = $request->input('content');
        }

        if (array_key_exists('featured_image', $request->all())) {
            $post->featured_image = $request->input('featured_image');
        }
    }

    /** @return array<string, mixed> */
    private function buildSaveResponse(Post $post, string $message, Request $request): array
    {
        $contentSaved = array_key_exists('content', $request->all());
        $featuredImageSaved = array_key_exists('featured_image', $request->all());

        $response = [
            'data' => $post,
            'message' => $message,
            'content_saved' => $contentSaved,
            'featured_image_saved' => $featuredImageSaved,
        ];

        if (config('app.debug') && (! $contentSaved || ! $featuredImageSaved)) {
            $response['debug'] = [
                'input_keys' => array_keys($request->all()),
                'has_payload' => $request->has('payload'),
                'payload_len' => $request->has('payload')
                    ? strlen((string) $request->input('payload'))
                    : 0,
            ];
        }

        return $response;
    }

    private function validatePost(Request $request, ?Post $post = null): array
    {
        $slugRule = Rule::unique('posts', 'slug');
        if ($post) {
            $slugRule = $slugRule->ignore($post->id);
        }

        return $request->validate([
            'title' => ($post ? 'sometimes' : 'required').'|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', $slugRule],
            'excerpt' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'category' => ['nullable', 'string', Rule::in(PostCategories::ids())],
            'featured_image' => 'nullable|string|max:500',
            'status' => 'in:draft,published,archived',
            'meta_title' => 'nullable|string|max:70',
            'meta_description' => 'nullable|string|max:500',
            'published_at' => 'nullable|date',
        ]);
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'noticia';
        $slug = $base;
        $counter = 1;

        while (
            Post::withTrashed()
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    /** @param  array<string, mixed>  $validated */
    private function applyPublishDates(array $validated, ?Post $post = null): array
    {
        $status = $validated['status'] ?? $post?->status ?? 'draft';

        if ($status === 'published') {
            $hasExplicitDate = array_key_exists('published_at', $validated) && ! empty($validated['published_at']);
            if (! $hasExplicitDate && ! $post?->published_at) {
                $validated['published_at'] = now();
            }
        }

        return $validated;
    }
}
