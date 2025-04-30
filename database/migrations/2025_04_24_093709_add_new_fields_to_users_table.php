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
            $table->string('username')->unique()->nullable()->after('name');
            $table->string('country')->nullable()->after('username');
            $table->string('phone')->nullable()->after('country');
            $table->text('address')->nullable()->after('phone');
            $table->string('image')->nullable()->after('address');
            $table->double('balance', 10, 2)->default(0)->after('image');
            $table->enum('status', ['active', 'pending', 'disabled'])->default('pending')->after('balance');
            $table->boolean('email_verify')->default(false)->after('email_verified_at');
            $table->boolean('update_notify')->default(false)->after('email_verify');
            $table->boolean('trx_notify')->default(false)->after('update_notify');
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
                'country',
                'phone',
                'address',
                'image',
                'balance',
                'status',
                'email_verify',
                'update_notify',
                'trx_notify',
            ]);
        });
    }
};
