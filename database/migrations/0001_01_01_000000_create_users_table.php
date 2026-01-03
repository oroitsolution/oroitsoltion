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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->text('address')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('code')->nullable();
            $table->string('company_name')->nullable();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('account_type')->nullable();
            $table->string('business_type')->nullable();
            $table->tinyInteger('user_kyc')->default(0)->comment('0 => not verified, 1 => verified, 2 => rejected');
            $table->string('status')->default('active');
            $table->string('payoutmethod')->nullable();
            $table->string('payinmethod')->nullable();
            $table->double('wallet_amount', 15, 2)->default(0);
            $table->boolean('permit')->default(0);
            $table->string('session_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
