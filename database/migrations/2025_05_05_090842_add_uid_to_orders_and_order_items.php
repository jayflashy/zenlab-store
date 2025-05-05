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
        schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('uid')->nullable()->after('id');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->unsignedBigInteger('uid')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('uid');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('uid');
        });
    }
};
