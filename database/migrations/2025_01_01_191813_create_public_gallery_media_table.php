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
        Schema::create('public_gallery_media', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('folder_id')->index();
            $table->string('title', length: 250);
            $table->text('description')->nullable();
            $table->enum('media_upload_type', ['file_upload', 'url']);
            $table->string('media_url', length: 2048);
            $table->enum('media_type', ['image', 'video']);
            $table->integer('position');
            $table->unsignedBigInteger('uploaded_by');
            $table->datetime('uploaded_date');
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
        Schema::dropIfExists('public_gallery_media');
    }
};
