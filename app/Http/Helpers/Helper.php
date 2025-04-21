<?php

use App\Models\Page;
use App\Models\Setting;
use App\Models\SystemSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

if (! function_exists('static_asset')) {
    function static_asset(string $path, $secure = null)
    {
        if (PHP_SAPI == 'cli-server') {
            return app('url')->asset('assets/'.$path, $secure);
        }

        return app('url')->asset('public/assets/'.$path, $secure);
    }
}

// Return file uploaded via uploader
if (! function_exists('my_asset')) {
    function my_asset(string $path, $secure = null)
    {
        if (PHP_SAPI == 'cli-server') {
            return app('url')->asset('uploads/'.$path, $secure);
        }

        return app('url')->asset('public/uploads/'.$path, $secure);
    }
}

if (! function_exists('get_setting')) {
    function get_setting($key = null, $default = null)
    {
        // Check if the settings table exists
        if (! Schema::hasTable('settings')) {
            return $default;
        }

        $settings = Cache::get('Settings');

        if (! $settings) {
            $settings = Setting::first();
            if ($settings) {
                Cache::put('Settings', $settings, 30000);
            }
        }

        if ($key) {
            return @$settings->$key == null ? $default : @$settings->$key;
        }

        return $settings;
    }
}

if (! function_exists('sys_setting')) {
    function sys_setting($key, $default = null)
    {
        // Check if the system_settings table exists
        if (!Schema::hasTable('system_settings')) {
            return $default;
        }

        $settings = Cache::get('SystemSettings');

        if (! $settings) {
            $settings = SystemSetting::all();
            Cache::put('SystemSettings', $settings, 30000);
        }

        $setting = $settings->where('name', $key)->first();

        return $setting == null ? $default : $setting->value;
    }
}

// formats currency
if (! function_exists('format_price')) {
    function format_price($price): string
    {
        $fomated_price = number_format($price, 2);
        $currency = get_setting('currency');

        return $currency.$fomated_price;
    }
}

// NGN Currency Formats
if (! function_exists('ngnformat_price')) {
    function ngnformat_price($price): string
    {
        $fomated_price = number_format($price, 2);
        $currency = '₦';

        return $currency.$fomated_price;
    }
}

function sym_price($price): string
{
    $fomated_price = number_format($price, 2);
    $currency = get_setting('currency_code');

    return $currency.' '.$fomated_price;
}

function format_number($price, $place = 2): string
{
    return number_format($price, $place);
}

// Trim text and append ellipsis if needed
function textTrim($string, $length = null)
{
    if (empty($length)) {
        $length = 100;
    }

    return Str::limit($string, $length, '...');
}

// Trim text without appending ellipsis
function text_trimer($string, $length = null)
{
    // Set default length to 100 if not provided
    if (empty($length)) {
        $length = 100;
    }

    return Str::limit($string, $length);
}

// Generate a URL-friendly "slug" from a given string
function slug($string)
{
    // Use Str::slug to generate a URL-friendly slug
    return Illuminate\Support\Str::slug($string);
}

// Create a unique slug for a given name and model
function uniqueSlug($name, $model)
{
    // Generate a slug from the provided name
    $slug = Str::slug($name);

    // Check if the generated slug already exists in the model's table
    $allSlugs = checkRelatedSlugs($slug, $model);

    if (! $allSlugs->contains('slug', $slug)) {
        // If the slug is unique, return it
        return $slug;
    }

    // If the slug already exists, append a number to make it unique
    $i = 1;
    do {
        $newSlug = $slug.'-'.$i;

        if (! $allSlugs->contains('slug', $newSlug)) {
            return $newSlug;
        }

        $i++;
    } while (true);
}

// Check for existing slugs related to the provided slug and model
function checkRelatedSlugs(string $slug, $model)
{
    // Use DB::table to query the model's table for slugs starting with the provided slug
    return DB::table($model)->where('slug', 'LIKE', $slug.'%')->get();
}

// Generate a random alphanumeric string of a specified length
function getTrx($length = 15): string
{
    $characters = 'ABCDEFGHJKMNOPQRSTUVWXYZ123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ0';
    $charactersLength = strlen($characters);
    $randomString = '';
    // Generate a random string by selecting characters from the given set
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }

    return $randomString;
}

function getTrans(string $prefix, $len = 15): string
{
    $characters = 'ABCDEFGHJKMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $len; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }

    return $prefix.'_'.$randomString;
}

// Round the given amount to a specified number of decimal places
function getAmount($amount, $length = 2): float
{
    // Ensure the returned amount is treated as a numeric value
    return round($amount, $length);
}

// Format and display a datetime using Carbon library
function show_datetime($date, $format = 'Y-m-d h:ia'): string
{
    return Carbon::parse($date)->format($format);
}

// Format and display a datetime using Carbon library
function show_date($date, $format = 'Y-m-d'): string
{
    return Carbon::parse($date)->format($format);
}

function trans_date($date, $format = 'M d, Y'): string
{
    return Carbon::parse($date)->format($format);
}

// Format and display a time
function show_time($date, $format = 'h:ia'): string
{
    return Carbon::parse($date)->format($format);
}

function campaignDate($date, $format = 'M, d'): string
{
    return Carbon::parse($date)->format($format);
}

function diffForHumans($date): string
{
    $lang = session()->get('lang');
    Carbon::setlocale($lang);

    return Carbon::parse($date)->diffForHumans();
}

function custom_text($string): string
{
    return ucfirst(str_replace('_', ' ', $string));
}

function getNumber($length = 6): string
{
    // if ($length == 6) {
    //     return 123456;
    // }
    $characters = '1234567890';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }

    return $randomString;
}

function getPaginate(): int
{
    return 50;
}

function paginateLinks($data)
{
    return $data->appends(request()->all())->links();
}

function queryBuild(string $key, $value): ?string
{
    $queries = request()->query();

    $delimeter = count($queries) > 0 ? '&' : '?';

    if (request()->has($key)) {
        $url = request()->getRequestUri();
        $pattern = "\?{$key}";
        $match = preg_match("/{$pattern}/", $url);

        if ($match != 0) {
            return preg_replace('~(\?|&)'.$key.'[^&]*~', "\?{$key}={$value}", $url);
        }

        $filteredURL = preg_replace('~(\?|&)'.$key.'[^&]*~', '', $url);

        return $filteredURL.$delimeter."{$key}={$value}";
    }

    return request()->getRequestUri().$delimeter."{$key}={$value}";
}

// footer pages
function footerPages($count = 3)
{
    return Cache::remember("footerPages_{$count}", 16000, fn () => Page::where('type', 'custom')->limit($count)->get());
}
