<?php

namespace Database\Seeders;

use App\Models\CommitteeMember;
use App\Models\Committee;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommitteeMembersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $committees = Committee::all();
        $users = User::limit(20)->get();
        
        if ($committees->isEmpty() || $users->isEmpty()) {
            $this->command->warn('Please seed committees and users first!');
            return;
        }

        $roles = ['president', 'secretary', 'treasurer', 'member'];
        $userIndex = 0;

        foreach ($committees as $committee) {
            // Add president
            if ($userIndex < $users->count()) {
                CommitteeMember::create([
                    'committee_id' => $committee->id,
                    'user_id' => $users[$userIndex]->id,
                    'role' => 'president',
                    'status' => 1,
                ]);
                $userIndex++;
            }

            // Add secretary
            if ($userIndex < $users->count()) {
                CommitteeMember::create([
                    'committee_id' => $committee->id,
                    'user_id' => $users[$userIndex]->id,
                    'role' => 'secretary',
                    'status' => 1,
                ]);
                $userIndex++;
            }

            // Add treasurer
            if ($userIndex < $users->count()) {
                CommitteeMember::create([
                    'committee_id' => $committee->id,
                    'user_id' => $users[$userIndex]->id,
                    'role' => 'treasurer',
                    'status' => 1,
                ]);
                $userIndex++;
            }

            // Add 2-3 members
            for ($i = 0; $i < 3 && $userIndex < $users->count(); $i++) {
                CommitteeMember::create([
                    'committee_id' => $committee->id,
                    'user_id' => $users[$userIndex]->id,
                    'role' => 'member',
                    'status' => 1,
                ]);
                $userIndex++;
            }
        }
    }
}

