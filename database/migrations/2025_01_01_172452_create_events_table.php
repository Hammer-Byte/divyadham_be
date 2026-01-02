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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title', length: 250);
            $table->text('description')->nullable();
            $table->enum('banner_upload_type', ['file_upload', 'url']);
            $table->string('banner_image_url', length: 2048);
            $table->enum('event_image_upload_type', ['file_upload', 'url']);
            $table->string('event_image_url', length: 2048);
            $table->datetime('start_date');
            $table->datetime('end_date')->nullable();
            $table->string('location', length: 250);
            $table->decimal('latitude', total: 10, places: 8);
            $table->decimal('longitude', total: 10, places: 8);
            $table->string('organizers')->nullable();
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
        Schema::dropIfExists('events');
    }
};
