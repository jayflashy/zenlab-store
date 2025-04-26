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
        Schema::create('coupons', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('code')->unique();
            $table->enum('discount_type', ['fixed', 'percent'])->default('percent');
            $table->enum('type', ['general', 'product', 'category'])->default('general');
            $table->decimal('discount', 8, 2);
            $table->foreignUlid('product_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignUlid('category_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('limit')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
