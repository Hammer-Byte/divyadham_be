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
        Schema::create('notification', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->enum('notificaiton_type', ['info', 'warning', 'error', 'success', 'event', 'system', 'post', 'comment', 'like', 'share']);
            $table->string('entity_type', length: 250);
            $table->unsignedBigInteger('entity_id');
            $table->text('message')->nullable();
            $table->string('title', length: 250);
            $table->boolean('is_read');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification');
    }
};
