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
        Schema::create('payins', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->text('systemgenerateid')->nullable();
            $table->string('order_id')->nullable();
            $table->text('utr')->nullable();
            $table->text('url')->nullable();
            $table->string('amount')->nullable();
            $table->string('status')->nullable();
            $table->text('data_request')->nullable();
            $table->text('data_request_response')->nullable();
            $table->text('status_response')->nullable();
            $table->text('qr_response')->nullable();
            $table->text('payment_response')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payins');
    }
};
