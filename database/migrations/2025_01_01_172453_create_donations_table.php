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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dc_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->decimal('amount', total: 10, places: 2);
            $table->string('currency', length: 10);
            $table->datetime('donation_date');
            $table->text('message')->nullable();
            $table->string('receipt_url', length: 2048);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
