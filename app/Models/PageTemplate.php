<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class PageTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'content',
        'meta_title',
        'meta_description',
        'is_system',
        'created_by',
    ];

    protected $casts = [
        'content' => 'array',
        'is_system' => 'boolean',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (PageTemplate $template) {
            if (empty($template->slug)) {
                $template->slug = Str::slug($template->name);
            }
        });
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
