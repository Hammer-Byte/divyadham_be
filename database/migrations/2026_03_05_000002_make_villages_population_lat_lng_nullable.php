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
        Schema::table('villages', function (Blueprint $table) {
            $table->integer('population')->nullable()->change();
            $table->string('latitude', 20)->nullable()->change();
            $table->string('longitude', 20)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('villages', function (Blueprint $table) {
            $table->integer('population')->nullable(false)->change();
            $table->string('latitude', 20)->nullable(false)->change();
            $table->string('longitude', 20)->nullable(false)->change();
        });
    }
};
