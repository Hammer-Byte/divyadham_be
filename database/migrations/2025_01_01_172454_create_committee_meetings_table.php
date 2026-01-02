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
        Schema::create('committee_meetings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('committee_id')->index();
            $table->datetime('meeting_date');
            $table->text('agenda')->nullable();
            $table->text('minutes')->nullable();
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
        Schema::dropIfExists('committee_meetings');
    }
};
