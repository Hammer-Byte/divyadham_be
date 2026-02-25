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
        Schema::table('family_members', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->string('first_name', 150)->nullable()->after('user_id');
            $table->string('last_name', 150)->nullable()->after('first_name');
            $table->string('phone_number', 50)->nullable()->after('last_name');            
            $table->index('phone_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('family_members', function (Blueprint $table) {
            $table->dropIndex(['phone_number']);
            $table->dropColumn(['first_name', 'last_name', 'phone_number']);            
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
        });
    }
};

