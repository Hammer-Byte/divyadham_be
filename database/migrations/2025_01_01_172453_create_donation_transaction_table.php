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
        Schema::create('donation_transaction', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('donation_id')->index();
            $table->enum('payment_method', ['credit_card', 'debit_card', 'net_banking', 'upi', 'cash']);
            $table->string('transaction_id', length: 250);
            $table->enum('transaction_status', ['pending', 'completed', 'failed']);
            $table->datetime('donation_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_transaction');
    }
};
