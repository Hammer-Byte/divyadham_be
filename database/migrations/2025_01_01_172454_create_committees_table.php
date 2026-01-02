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
        Schema::create('committees', function (Blueprint $table) {
            $table->id();
            $table->string('name', length: 250);
            $table->text('description');
            $table->datetime('formed_date');
            $table->decimal('current_balance', total: 20, places: 2)->default(0);
            $table->decimal('total_income', total: 20, places: 2)->default(0);
            $table->decimal('total_expense', total: 20, places: 2)->default(0);
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('committees');
    }
};
