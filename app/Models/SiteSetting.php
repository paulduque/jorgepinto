<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'person_name',
        'site_description',
        'registration_enabled',
        'default_role',
        'logo',
        'favicon',
        'phone',
        'email',
        'whatsapp',
        'facebook',
        'instagram',
        'twitter',
        'youtube',
        'tiktok',
        'address',
        'contact_description',
    ];

    protected function casts(): array
    {
        return [
            'registration_enabled' => 'boolean',
        ];
    }

    public static function current(): ?self
    {
        return static::first();
    }
}
