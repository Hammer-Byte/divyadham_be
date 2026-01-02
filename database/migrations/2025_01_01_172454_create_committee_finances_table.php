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
        Schema::create('committee_finances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('committee_id')->index();
            $table->datetime('transaction_date');
            $table->decimal('amount', total: 10, places: 2)->default(0);
            $table->enum('transaction_type', ['income', 'expense']);
            $table->text('description')->nullable();
            $table->text('remark')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('committee_finances');
    }
};
