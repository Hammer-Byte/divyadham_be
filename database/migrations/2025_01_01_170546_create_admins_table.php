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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('email', length: 150);
            $table->string('password', length: 250);
            $table->string('name', length: 250);
            $table->string('phone_number', length: 50)->nullable();
            $table->string('profile_image', length: 250)->nullable();
            $table->enum('admin_type', ['super_admin','admin','sub_admin']);
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
        Schema::dropIfExists('admins');
    }
};
