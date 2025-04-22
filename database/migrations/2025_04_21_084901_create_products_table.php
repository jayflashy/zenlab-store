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
        Schema::create('products', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->foreignUlid('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type')->default('script');

            $table->decimal('regular_price', 10, 2)->nullable();
            $table->decimal('extended_price', 10, 2)->nullable();
            $table->integer('discount')->default(2);
            $table->boolean('is_free')->default(false);

            $table->string('image')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('file_path')->nullable();
            $table->string('download_link')->nullable();
            $table->enum('download_type', ['file', 'link'])->default('file');
            $table->json('screenshots')->nullable();
            $table->string('demo_url')->nullable();

            $table->unsignedInteger('downloads_count')->default(0);
            $table->unsignedInteger('sales_count')->default(0);
            $table->unsignedInteger('sales_boost')->default(5);

            $table->boolean('featured')->default(false);
            $table->json('tags')->nullable();
            $table->string('version')->nullable();
            $table->json('attributes')->nullable();
            $table->json('metadata')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');

            $table->dateTime('publish_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['status', 'featured']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
