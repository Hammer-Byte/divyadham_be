<?php

namespace Database\Seeders;

use App\Models\DonationMedia;
use App\Models\DonationCampaign;
use Illuminate\Database\Seeder;

class DonationMediaTableSeeder extends Seeder
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
            // Add 2-4 media items per campaign
            for ($i = 0; $i < rand(2, 4); $i++) {
                DonationMedia::create([
                    'donation_id' => $campaign->id,
                    'media_upload_type' => 'url',
                    'media_url' => 'https://via.placeholder.com/800x600',
                    'media_type' => rand(0, 1) ? 'image' : 'video',
                    'position' => $i + 1,
                    'status' => 1,
                ]);
            }
        }
    }
}

