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
        // Schema::table('post_links', function (Blueprint $table) {
        //     $table->text('image_url')->change();
        // });
        // Schema::table('post_media', function (Blueprint $table) {
        //     $table->text('media_url')->change();
        // });
        Schema::table('stories', function (Blueprint $table) {
            $table->text('media_url')->change();
        });
        Schema::table('event_media', function (Blueprint $table) {
            $table->text('media_url')->change();
        });
        Schema::table('events', function (Blueprint $table) {
            $table->text('banner_image_url')->change();
            $table->text('event_image_url')->change();
        });

        Schema::table('donation_campaigns', function (Blueprint $table) {
            $table->text('banner_image_url')->nullable()->change();
        });

        DB::table('donation_campaigns')->whereNull('banner_image_url')->update(['banner_image_url' => '']);

        Schema::table('donation_campaigns', function (Blueprint $table) {
            $table->text('banner_image_url')->nullable(false)->change();
        });

        Schema::table('donations', function (Blueprint $table) {
            $table->text('receipt_url')->change();
        });
        Schema::table('village_media', function (Blueprint $table) {
            $table->text('media_url')->change();
        });
        Schema::table('public_documents', function (Blueprint $table) {
            $table->text('document_url')->change();
        });
        Schema::table('public_gallery_media', function (Blueprint $table) {
            $table->text('media_url')->change();
        });
        Schema::table('donation_media', function (Blueprint $table) {
            $table->text('media_url')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
