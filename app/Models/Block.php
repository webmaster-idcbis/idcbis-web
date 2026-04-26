<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Block extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'type',
        'name',
        'order',
        'content',
        'settings',
        'styles'
    ];

    protected $casts = [
        'content' => 'array',
        'settings' => 'array',
        'styles' => 'array',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function render(): string
    {
        return view("components.blocks.{$this->type}", ['block' => $this])->render();
    }
}
