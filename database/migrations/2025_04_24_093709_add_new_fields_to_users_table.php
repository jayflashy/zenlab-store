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
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->after('name');
            $table->string('country_id')->nullable()->after('username');
            $table->string('phone')->nullable()->after('country_id');
            $table->text('address')->nullable()->after('phone');
            $table->string('image')->nullable()->after('address');
            $table->double('balance', 10, 2)->default(0)->after('image');
            $table->enum('status', ['active', 'pending', 'disabled'])->default('pending')->after('balance');
            $table->boolean('email_verify')->default(false)->after('email_verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'country_id',
                'phone',
                'address',
                'image',
                'balance',
                'status',
                'email_verify',
            ]);
        });
    }
};
