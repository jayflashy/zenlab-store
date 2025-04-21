<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'title' => 'ZenLab',
            'name' => 'ZenLab',
            'description' => 'Welcome to ZenLab - Your Digital Innovation Hub',
            'phone' => '+1234567890',
            'address' => '123 Innovation Street, Tech City',
            'admin_email' => 'admin@zenlab.com',
            'email' => 'info@zenlab.com',
            'favicon' => 'favicon.ico',
            'logo' => 'logo.png',
            'primary' => '#4F46E5',
            'currency' => 'USD',
            'currency_code' => '$',
            'currency_rate' => '1',
            'secondary' => '#10B981',
            'facebook' => 'https://facebook.com/zenlab',
            'twitter' => 'https://twitter.com/zenlab',
            'instagram' => 'https://instagram.com/zenlab',
            'telegram' => 'https://t.me/zenlab',
            'linkedin' => 'https://linkedin.com/company/zenlab',
            'whatsapp' => 'https://wa.me/1234567890',
            'tiktok' => 'https://tiktok.com/@zenlab',
            'youtube' => 'https://youtube.com/zenlab',
            'custom_css' => null,
            'custom_js' => null,
            'last_cron' => now(),
        ]);
    }
}
