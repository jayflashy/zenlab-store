<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('admin_email')->nullable();
            $table->string('email')->nullable();
            $table->string('favicon')->nullable();
            $table->string('logo')->nullable();
            $table->string('primary')->nullable();
            $table->string('currency')->nullable();
            $table->string('currency_code')->nullable();
            $table->string('currency_rate')->nullable();
            $table->string('secondary')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('telegram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('youtube')->nullable();
            $table->text('custom_css')->nullable();
            $table->text('custom_js')->nullable();
            $table->dateTime('last_cron')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
