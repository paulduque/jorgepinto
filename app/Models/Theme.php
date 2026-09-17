<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Theme extends Model
{
    use HasSlug;

    protected $fillable = [
        'title',
        'description',
        'full_description',
        'image',
        'slug',
        'sort_order',
        'is_active',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();  // No regenerar al editar
    }
}
