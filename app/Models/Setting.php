<?php

namespace App\Models;

use Cache;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected static function boot()
    {
        parent::boot();
        static::saved(function () {
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
        'support_email',
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
    ];
}
