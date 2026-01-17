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
        Schema::table('posts', function (Blueprint $table) {
            $table->text('reported_comment')->nullable();
            $table->unsignedBigInteger('reportedBy')->nullable();
            $table->boolean('isPostReported')->default(false);

            $table->foreign('reportedBy')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['reportedBy']);
            $table->dropColumn(['reported_comment', 'reportedBy', 'isPostReported']);
        });
    }
};
