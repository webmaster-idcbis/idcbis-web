<?php

namespace App\Models;

use App\Support\PostCategories;
use App\Support\PostMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'category',
        'featured_image',
        'status',
        'meta_title',
        'meta_description',
        'created_by',
        'updated_by',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Post $post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function isPublished(): bool
    {
        return $this->status === 'published'
            && $this->published_at
            && $this->published_at <= now();
    }

    public function categoryLabel(): string
    {
        return PostCategories::label($this->category);
    }

    public function formattedPublishedAt(): ?string
    {
        if (! $this->published_at) {
            return null;
        }

        return Carbon::parse($this->published_at)
            ->locale('es')
            ->translatedFormat('j \d\e F \d\e Y');
    }

    public function publicUrl(): string
    {
        return '/noticias/'.$this->slug;
    }

    public function toListArray(): array
    {
        return [
            'id' => (string) $this->id,
            'title' => $this->title,
            'excerpt' => $this->excerpt ?? '',
            'category' => $this->category,
            'categoryLabel' => $this->categoryLabel(),
            'publishedAt' => $this->formattedPublishedAt() ?? '',
            'publishedAtIso' => $this->published_at?->toIso8601String(),
            'image' => PostMedia::normalizeUrl($this->featured_image),
            'slug' => $this->slug,
            'url' => $this->publicUrl(),
        ];
    }

    public function toAdminListArray(): array
    {
        return array_merge($this->toListArray(), [
            'status' => $this->status,
            'published_at' => $this->published_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ]);
    }

    public function toDetailArray(): array
    {
        return array_merge($this->toListArray(), [
            'content' => PostMedia::normalizeContent($this->content ?? ''),
            'metaTitle' => $this->meta_title ?: $this->title,
            'metaDescription' => $this->meta_description ?: ($this->excerpt ?? ''),
        ]);
    }
}
