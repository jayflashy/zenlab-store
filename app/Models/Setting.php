<?php

namespace App\Models;

use Cache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();
        static::saved(function (): void {
            Cache::forget('Settings');
        });
    }

    protected $casts = [
        'shortcodes' => 'object',
    ];

    protected $fillable = [
        'title',
        'email',
        'admin_email',
        'name',
        'description',
        'address',
        'phone',
        'logo',
        'favicon',
        'loader',
        'primary',
        'secondary',
        'last_cron',
        'custom_js',
        'custom_css',
        'currency',
        'currency_code',
        'currency_rate',
        'rejected_usernames',
        'facebook',
        'twitter',
        'instagram',
        'telegram',
        'linkedin',
        'whatsapp',
        'meta_description',
        'meta_keywords',
        'tiktok',
        'youtube',
    ];
}
