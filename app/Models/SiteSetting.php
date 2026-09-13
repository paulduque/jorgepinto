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
        'agenda_image',
        'agenda_link_visible',
        'agenda_link_public_only',
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
            'agenda_link_visible' => 'boolean',
            'agenda_link_public_only' => 'boolean',
        ];
    }

    public static function current(): ?self
    {
        return static::first();
    }
}
