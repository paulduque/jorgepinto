<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'person_name',
        'site_description',
        'logo',
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

    public static function current(): ?self
    {
        return static::first();
    }
}
