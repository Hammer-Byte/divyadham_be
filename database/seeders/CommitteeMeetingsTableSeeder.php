<?php

namespace Database\Seeders;

use App\Models\CommitteeMeeting;
use App\Models\Committee;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CommitteeMeetingsTableSeeder extends Seeder
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
            // Create 2-3 meetings per committee
            for ($i = 0; $i < 3; $i++) {
                CommitteeMeeting::create([
                    'committee_id' => $committee->id,
                    'meeting_date' => Carbon::now()->subMonths(rand(1, 6))->subDays(rand(1, 30)),
                    'agenda' => 'Discussion on ' . $committee->name . ' activities and future plans.',
                    'minutes' => 'Meeting minutes: Discussed various initiatives and approved budget allocations.',
                    'status' => 1,
                ]);
            }
        }
    }
}

