<?php

namespace App\Models;

use Cache;
use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected static function boot()
    {
        parent::boot();
        static::saved(function () {
            Cache::forget('SystemSettings');
        });
    }
}
