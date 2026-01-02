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
        Schema::create('audit_trail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id')->index();
            $table->enum('action_type', ['create', 'update', 'delete', 'view', 'login', 'logout', 'assign_permission', 'revoke_permission']);
            $table->string('entity_type', length: 250);
            $table->unsignedBigInteger('entity_id');
            $table->text('description')->nullable();
            $table->ipAddress('ip_address');
            $table->datetime('performed_at');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_trail');
    }
};
