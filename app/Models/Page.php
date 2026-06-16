<?php

namespace App\Models;

use App\Services\PageSearchIndexer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'meta_description',
        'content',
        'sections',
        'status',
        'meta_title',
        'meta_keywords',
        'search_text',
        'og_image',
        'no_index',
        'canonical_url',
        'created_by',
        'updated_by',
        'published_at'
    ];

    protected $casts = [
        'content' => 'array',
        'sections' => 'array',
        'published_at' => 'datetime',
    ];

    protected static function boot(): void
    {
        parent::boot();
        
        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });

        static::saving(function (Page $page) {
            $page->search_text = PageSearchIndexer::buildSearchText($page);
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

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class)->orderBy('order');
    }

    public function isPublished(): bool
    {
        return $this->status === 'published' && $this->published_at <= now();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
