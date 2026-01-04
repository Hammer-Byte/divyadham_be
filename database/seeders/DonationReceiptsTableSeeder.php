<?php

namespace Database\Seeders;

use App\Models\DonationReceipt;
use App\Models\Donations;
use Illuminate\Database\Seeder;

class DonationReceiptsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $donations = Donations::all();
        
        if ($donations->isEmpty()) {
            $this->command->warn('Please seed donations first!');
            return;
        }

        foreach ($donations as $donation) {
            DonationReceipt::create([
                'donation_id' => $donation->id,
                'receipt_number' => 'RCP-' . str_pad($donation->id, 6, '0', STR_PAD_LEFT),
            ]);
        }
    }
}

