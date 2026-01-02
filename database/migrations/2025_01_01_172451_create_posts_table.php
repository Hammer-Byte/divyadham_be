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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->enum('type', ['text', 'media', 'link', 'donation']);
            $table->text('content')->nullable();
            $table->enum('media_upload_type', ['file_upload', 'url'])->nullable();
            $table->text('media_url')->nullable();
            $table->enum('media_type', ['image', 'video'])->nullable();
            $table->string('link_url', length: 2048)->nullable();
            $table->string('link_title', length: 250)->nullable();
            $table->text('link_description')->nullable();
            $table->string('link_image_url', length: 2048)->nullable();
            $table->unsignedBigInteger('donation_id')->index()->default(0);
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
        Schema::dropIfExists('posts');
    }
};
