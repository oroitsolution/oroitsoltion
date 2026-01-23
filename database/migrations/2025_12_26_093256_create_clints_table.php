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
        Schema::create('clints', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('client_id')->nullable();
            $table->string('secret_id')->unique()->nullable();
            $table->text('payout_url')->nullable();
            $table->text('payin_url')->nullable();
            $table->string('ipaddress')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clints');
    }
};
