<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class News extends Model
{
    use HasSlug;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'embed_url',
        'image',
        'category',
        'published_at',
        'is_published',
        'is_featured',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }
}
