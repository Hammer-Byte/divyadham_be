<?php

namespace Database\Seeders;

use App\Models\CommitteeFinance;
use App\Models\Committee;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CommitteeFinanceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $committees = Committee::all();
        
        if ($committees->isEmpty()) {
            $this->command->warn('Please seed committees first!');
            return;
        }

        foreach ($committees as $committee) {
            // Add income transactions
            for ($i = 0; $i < 5; $i++) {
                CommitteeFinance::create([
                    'committee_id' => $committee->id,
                    'transaction_date' => Carbon::now()->subMonths(rand(1, 6))->subDays(rand(1, 30)),
                    'amount' => rand(10000, 100000),
                    'transaction_type' => 'income',
                    'description' => 'Donation received from community member',
                    'remark' => 'Monthly contribution',
                ]);
            }

            // Add expense transactions
            for ($i = 0; $i < 3; $i++) {
                CommitteeFinance::create([
                    'committee_id' => $committee->id,
                    'transaction_date' => Carbon::now()->subMonths(rand(1, 6))->subDays(rand(1, 30)),
                    'amount' => rand(5000, 50000),
                    'transaction_type' => 'expense',
                    'description' => 'Expense for committee activities',
                    'remark' => 'Operational cost',
                ]);
            }
        }
    }
}

