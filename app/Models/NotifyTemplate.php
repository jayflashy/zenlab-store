<?php

namespace App\Models;

use Cache;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotifyTemplate extends Model
{
    use HasUlids;
    use SoftDeletes;

    protected $casts = [
        'shortcodes' => 'object',
        'channels' => 'array',
    ];

    protected $fillable = [
        'name',
        'channels',
        'title',
        'subject',
        'message',
        'content',
        'type',
        'email_status',
        'shortcodes',
    ];

    protected static function boot()
    {
        parent::boot();
        static::saved(function (): void {
            Cache::forget('NotifyTemplates');
        });
    }
}
