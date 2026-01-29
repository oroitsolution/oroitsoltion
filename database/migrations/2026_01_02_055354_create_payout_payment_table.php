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
        Schema::create('payout_payment', function (Blueprint $table) {
            $table->id();
            $table->string('payout_id')->nullable();
            $table->string('systemid')->nullable();
            $table->string('trx_id')->nullable();
            $table->string('cus_trx_id')->nullable();
            $table->text('utr')->nullable();
            $table->string('txnRcvdTimeStamp')->nullable();
            $table->string('txnUpdTimeStamp')->nullable();
            $table->string('txn_type')->default('PAY');
            $table->string('pymt_type')->default('IMPS');
            $table->string('status')->nullable();
            $table->string('name')->nullable();
            $table->string('ifsc')->nullable();
            $table->string('account_number')->nullable();
            $table->string('amount')->nullable();
            $table->string('charges')->nullable();
            $table->string('usercharges')->nullable();
            $table->string('refund_amount')->nullable();
            $table->string('lastwallet_balance')->nullable();
            $table->string('payment_source')->nullable();
            $table->string('merchant_id')->nullable();
            $table->string('payouttype')->nullable();
            $table->text('response_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payout_payment');
    }
};
