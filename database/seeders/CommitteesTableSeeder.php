<?php

namespace Database\Seeders;

use App\Models\Committee;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CommitteesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $committees = [
            [
                'name' => 'Village Development Committee',
                'description' => 'Committee responsible for overall village development and infrastructure projects.',
                'formed_date' => Carbon::now()->subMonths(6),
                'current_balance' => 500000.00,
                'total_income' => 750000.00,
                'total_expense' => 250000.00,
                'status' => 1,
            ],
            [
                'name' => 'Education Committee',
                'description' => 'Committee focused on educational initiatives and school development.',
                'formed_date' => Carbon::now()->subMonths(4),
                'current_balance' => 300000.00,
                'total_income' => 400000.00,
                'total_expense' => 100000.00,
                'status' => 1,
            ],
            [
                'name' => 'Health & Wellness Committee',
                'description' => 'Committee managing health programs and medical facilities.',
                'formed_date' => Carbon::now()->subMonths(3),
                'current_balance' => 200000.00,
                'total_income' => 350000.00,
                'total_expense' => 150000.00,
                'status' => 1,
            ],
            [
                'name' => 'Cultural Committee',
                'description' => 'Committee organizing cultural events and preserving traditions.',
                'formed_date' => Carbon::now()->subMonths(8),
                'current_balance' => 150000.00,
                'total_income' => 250000.00,
                'total_expense' => 100000.00,
                'status' => 1,
            ],
            [
                'name' => 'Women Empowerment Committee',
                'description' => 'Committee promoting women\'s rights and empowerment programs.',
                'formed_date' => Carbon::now()->subMonths(5),
                'current_balance' => 180000.00,
                'total_income' => 280000.00,
                'total_expense' => 100000.00,
                'status' => 1,
            ],
        ];

        foreach ($committees as $committee) {
            Committee::create($committee);
        }
    }
}

