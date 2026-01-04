<?php

namespace Database\Seeders;

use App\Models\Donations;
use App\Models\DonationCampaign;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DonationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $campaigns = DonationCampaign::all();
        $users = User::limit(20)->get();
        
        if ($campaigns->isEmpty() || $users->isEmpty()) {
            $this->command->warn('Please seed donation campaigns and users first!');
            return;
        }

        foreach ($campaigns as $campaign) {
            // Add 5-15 donations per campaign
            $donatingUsers = $users->random(min(rand(5, 15), $users->count()));
            
            foreach ($donatingUsers as $user) {
                Donations::create([
                    'dc_id' => $campaign->id,
                    'user_id' => $user->id,
                    'amount' => rand(500, 10000),
                    'currency' => 'INR',
                    'donation_date' => Carbon::now()->subDays(rand(1, 60)),
                    'message' => 'Happy to contribute to this cause!',
                    'receipt_url' => 'https://example.com/receipts/receipt-' . rand(1000, 9999) . '.pdf',
                ]);
            }
        }
    }
}

