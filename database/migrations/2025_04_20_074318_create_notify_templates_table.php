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
        Schema::create('notify_templates', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('type', 40)->unique();
            $table->string('name', 100)->nullable();
            $table->string('title', 255)->nullable();
            $table->text('message')->nullable();
            $table->string('subject', 255)->nullable();
            $table->longText('content')->nullable();
            $table->json('shortcodes')->nullable();
            $table->tinyInteger('email_status')->default(1);
            $table->tinyInteger('push_status')->default(1);
            $table->tinyInteger('inapp_status')->default(1);
            $table->json('channels')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notify_templates');
    }
};
