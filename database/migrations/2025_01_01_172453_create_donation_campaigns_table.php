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
        Schema::create('donation_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('title', length: 250);
            $table->text('description')->nullable();
            $table->decimal('goal_amount', total: 10, places: 2)->default(0);
            $table->decimal('raise_amount', total: 10, places: 2)->default(0);
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->enum('banner_upload_type', ['file_upload', 'url'])->nullable();
            $table->string('banner_image_url', length: 2048)->nullable();
            $table->string('organizers', length: 250);
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
        Schema::dropIfExists('donation_campaigns');
    }
};
