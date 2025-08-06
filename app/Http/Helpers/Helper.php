<?php

use App\Models\Coupon;
use App\Models\Page;
use App\Models\Setting;
use App\Models\SystemSetting;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

if (! function_exists('static_asset')) {
    function static_asset(string $path, $secure = null)
    {
        if (PHP_SAPI == 'cli-server') {
            return app('url')->asset('assets/' . $path, $secure);
        }

        return app('url')->asset('public/assets/' . $path, $secure);
    }
}

if (! function_exists('my_asset')) {
    function my_asset(string $path, $secure = null)
    {
        if (PHP_SAPI == 'cli-server') {
            return app('url')->asset('uploads/' . $path, $secure);
        }

        return app('url')->asset('public/uploads/' . $path, $secure);
    }
}

if (! function_exists('get_setting')) {
    function get_setting($key = null, $default = null)
    {
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
        if (! Schema::hasTable('system_settings')) {
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

if (! function_exists('format_price')) {
    function format_price($price): string
    {
        $fomated_price = number_format($price, 2);
        $currency = get_setting('currency');

        return $currency . $fomated_price;
    }
}

if (! function_exists('ngnformat_price')) {
    function ngnformat_price($price): string
    {
        $fomated_price = number_format($price, 2);
        $currency = '₦';

        return $currency . $fomated_price;
    }
}

function sym_price($price): string
{
    $fomated_price = number_format($price, 2);
    $currency = get_setting('currency_code');

    return $currency . ' ' . $fomated_price;
}

function format_number($price, $place = 2): string
{
    return number_format($price, $place);
}

function textTrim($string, $length = null)
{
    if (empty($length)) {
        $length = 100;
    }

    return Str::limit($string, $length, '...');
}

function text_trimer($string, $length = null)
{
    if (empty($length)) {
        $length = 100;
    }

    return Str::limit($string, $length);
}

function slug($string)
{
    return Illuminate\Support\Str::slug($string);
}

function uniqueSlug($name, $model)
{
    $slug = Str::slug($name);

    $allSlugs = checkRelatedSlugs($slug, $model);

    if (! $allSlugs->contains('slug', $slug)) {
        return $slug;
    }

    $i = 1;
    do {
        $newSlug = $slug . '-' . $i;

        if (! $allSlugs->contains('slug', $newSlug)) {
            return $newSlug;
        }

        $i++;
    } while (true);
}

function checkRelatedSlugs(string $slug, $model)
{
    return DB::table($model)->where('slug', 'LIKE', $slug . '%')->get();
}

function getTrx($length = 15): string
{
    $characters = 'ABCDEFGHJKMNOPQRSTUVWXYZ123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ0';
    $charactersLength = strlen($characters);
    $randomString = '';
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

    return $prefix . '_' . $randomString;
}

function getAmount($amount, $length = 2): float
{
    return round($amount, $length);
}

function show_datetime($date, $format = 'Y-m-d h:ia'): string
{
    return Carbon::parse($date)->format($format);
}

function show_date($date, $format = 'Y-m-d'): string
{
    return Carbon::parse($date)->format($format);
}

function trans_date($date, $format = 'M d, Y'): string
{
    return Carbon::parse($date)->format($format);
}

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
            return preg_replace('~(\?|&)' . $key . '[^&]*~', "\?{$key}={$value}", $url);
        }

        $filteredURL = preg_replace('~(\?|&)' . $key . '[^&]*~', '', $url);

        return $filteredURL . $delimeter . "{$key}={$value}";
    }

    return request()->getRequestUri() . $delimeter . "{$key}={$value}";
}

// footer pages
function footerPages($count = 3)
{
    return Cache::remember("footerPages_{$count}", 16000, fn() => Page::where('type', 'custom')->limit($count)->get());
}

// get coupons
function allCoupons()
{
    return Cache::remember('allCoupons', 16000, fn() => Coupon::valid()->get());
}

function getPaymentMethodLabel($method)
{
    $paymentMethods = [
        'paystack_payment' => 'Paystack',
        'flutterwave_payment' => 'Flutterwave',
        'paypal_payment' => 'PayPal',
        'cryptomus_payment' => 'Cryptomus',
        'manual_payment' => 'Bank Transfer',
    ];

    return $paymentMethods[$method] ?? ucfirst(str_replace('_', ' ', $method));
}

function getPaymentStatusClass($status)
{
    return [
        'pending' => 'bg-warning',
        'completed' => 'bg-success',
        'failed' => 'bg-danger',
    ][$status] ?? 'bg-secondary';
}

function getPaymentStatusLabel($status)
{
    return [
        'pending' => 'Pending',
        'completed' => 'Completed',
        'failed' => 'Failed',
    ][$status] ?? 'Pending';
}

function getOrderStatusClass($status)
{
    return [
        'pending' => 'bg-warning',
        'processing' => 'bg-info',
        'completed' => 'bg-success',
        'cancelled' => 'bg-secondary',
        'failed' => 'bg-danger',
    ][$status] ?? 'bg-secondary';
}
function generateUsername(string $name): string
{
    if (empty(trim($name))) {
        return 'user_' . uniqid();
    }

    $name = preg_replace('/[^a-zA-Z0-9\s]/', '', $name);
    $username = strtolower(preg_replace('/\s+/', '_', trim($name)));
    return substr($username, 0, 50);
}



function sendNotification(string $type, $user, array $shortcodes, $custom = [])
{
    try {
        $ns = new NotificationService;
        $ns->send($type, $user, $shortcodes, $custom);
    } catch (\Exception $e) {
        \Log::error($e);
    }
}


function sendAdminNotification(string $type, array $shortcodes, $custom = [])
{
    try {
        $ns = new NotificationService;
        $ns->sendAdmin($type, $shortcodes, $custom);
    } catch (\Exception $e) {
        \Log::error($e);
    }
}
