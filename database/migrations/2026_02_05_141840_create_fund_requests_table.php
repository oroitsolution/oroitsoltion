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
        Schema::create('fund_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('deposit_amount')->nullable();
            $table->string('payment_method');
            $table->string('paymentdate');
            $table->string('bank_name');
            $table->string('account_detail');
            $table->string('ifsc');
            $table->string('utr');
            $table->string('remark');
            $table->string('oldamount');
            $table->string('status')->default('PENDING');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fund_requests');
    }
};
