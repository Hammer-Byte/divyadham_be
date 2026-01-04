<?php

namespace Database\Seeders;

use App\Models\DonationUpdate;
use App\Models\DonationCampaign;
use Illuminate\Database\Seeder;

class DonationUpdatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $campaigns = DonationCampaign::all();
        
        if ($campaigns->isEmpty()) {
            $this->command->warn('Please seed donation campaigns first!');
            return;
        }

        foreach ($campaigns as $campaign) {
            // Add 2-4 updates per campaign
            for ($i = 0; $i < rand(2, 4); $i++) {
                DonationUpdate::create([
                    'donation_id' => $campaign->id,
                    'title' => 'Update ' . ($i + 1) . ' - Progress Report',
                    'description' => 'We are making great progress! ' . ($i + 1) * 20 . '% of the goal has been achieved. Thank you for your continued support.',
                    'status' => 1,
                ]);
            }
        }
    }
}

