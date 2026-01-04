<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed in order - dependencies first
        $this->call([
            // Basic data
            StateSeeder::class,
            DistrictSeeder::class,
            
            // Users and Admins
            UsersTableSeeder::class,
            AdminsTableSeeder::class,
            
            // Villages and related
            VillagesTableSeeder::class,
            VillageMembersTableSeeder::class,
            VillageMediaTableSeeder::class,
            
            // Committees and related
            CommitteesTableSeeder::class,
            CommitteeMembersTableSeeder::class,
            CommitteeMeetingsTableSeeder::class,
            CommitteeFinanceTableSeeder::class,
            
            // Events and related
            EventsTableSeeder::class,
            EventMediaTableSeeder::class,
            OrganizersTableSeeder::class,
            EventOrganizersTableSeeder::class,
            EventRegistrationsTableSeeder::class,
            EventSharesTableSeeder::class,
            
            // Posts and related
            PostsTableSeeder::class,
            PostLikesTableSeeder::class,
            PostCommentsTableSeeder::class,
            PostSharesTableSeeder::class,
            
            // Donations and related
            DonationCampaignsTableSeeder::class,
            DonationMediaTableSeeder::class,
            DonationUpdatesTableSeeder::class,
            DonationsTableSeeder::class,
            DonationTransactionsTableSeeder::class,
            DonationReceiptsTableSeeder::class,
            
            // Other content
            PagesTableSeeder::class,
            StoriesTableSeeder::class,
            StoriesViewsTableSeeder::class,
            PublicGalleryFolderTableSeeder::class,
            PublicGalleryMediaTableSeeder::class,
            PublicDocumentsTableSeeder::class,
            FamilyMembersTableSeeder::class,
            NotificationsTableSeeder::class,
        ]);
    }
}
