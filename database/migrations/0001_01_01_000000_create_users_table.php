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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('country_code', length: 20);
            $table->string('phone_number', length: 50);
            $table->string('first_name', length: 150);
            $table->string('last_name', length: 150)->nullable();
            $table->string('profile_image', length: 250)->nullable();
            $table->string('email', length: 150);
            $table->string('password', length: 250);
            $table->string('occupation', length: 150)->nullable();
            $table->string('campany_name', length: 250)->nullable();
            $table->string('address', length: 250)->nullable();
            $table->string('city', length: 50)->nullable();
            $table->string('state', length: 50)->nullable();
            $table->string('country', length: 50)->nullable();
            $table->string('zipcode', length: 50)->nullable();
            $table->tinyInteger('status')->default(0);
            $table->string('device_type')->nullable();
            $table->string('device_token')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

// php artisan make:model User
// php artisan make:model EventMedia


// php artisan make:model Admin
// php artisan make:model AdminForgot
// php artisan make:model PostComment
// php artisan make:model PostDonation
// php artisan make:model PostLike
// php artisan make:model PostLink
// php artisan make:model PostMedia
// php artisan make:model PostShare
// php artisan make:model Post
// php artisan make:model Storie
// php artisan make:model AuditTrail
// php artisan make:model AdminForgot
// php artisan make:model EventOrganizer
// php artisan make:model EventRegistration
// php artisan make:model EventShare
// php artisan make:model Events
// php artisan make:model Notification
// php artisan make:model StoriesViews
// php artisan make:model DonationCampaign
// php artisan make:model DonationReceipt
// php artisan make:model DonationTransaction
// php artisan make:model DonationUpdate
// php artisan make:model Donations
// php artisan make:model VillageMedia
// php artisan make:model VillageMember
// php artisan make:model Villages
// php artisan make:model CommitteeFinance
// php artisan make:model CommitteeMeeting
// php artisan make:model CommitteeMember
// php artisan make:model Committee
// php artisan make:model FamilyMember
// php artisan make:model PublicDocument
// php artisan make:model PublicGalleryFolder
// php artisan make:model PublicGalleryMedia
