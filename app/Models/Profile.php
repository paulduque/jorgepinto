<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'name',
        'position',
        'intro',
        'biography',
        'photo',
        'secondary_photo',
        'quote',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
