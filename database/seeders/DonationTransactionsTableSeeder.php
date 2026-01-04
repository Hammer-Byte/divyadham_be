<?php

namespace Database\Seeders;

use App\Models\DonationTransaction;
use App\Models\Donations;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DonationTransactionsTableSeeder extends Seeder
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

        $paymentMethods = ['credit_card', 'debit_card', 'net_banking', 'upi', 'cash'];
        $statuses = ['pending', 'completed', 'failed'];

        /*foreach ($donations as $donation) {
            DonationTransaction::create([
                'donation_id' => $donation->id,
                'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                'transaction_id' => 'TXN' . strtoupper(uniqid()),
                'transaction_status' => $statuses[array_rand($statuses)],
                'donation_date' => $donation->donation_date,
            ]);
        }*/
    }
}

