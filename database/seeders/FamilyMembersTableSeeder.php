<?php

namespace Database\Seeders;

use App\Models\FamilyMember;
use App\Models\User;
use Illuminate\Database\Seeder;

class FamilyMembersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::limit(5)->get();
        
        if ($users->isEmpty()) {
            $this->command->warn('Please seed users first!');
            return;
        }

        $relations = ['father', 'mother', 'spouse', 'child', 'sibling', 'uncle', 'aunty', 'other'];
        
        foreach ($users as $user) {
            // Add 2-3 family members for each user
            for ($i = 0; $i < 3; $i++) {
                $otherUser = User::where('id', '!=', $user->id)->inRandomOrder()->first();
                
                if ($otherUser) {
                    FamilyMember::create([
                        'user_id' => $otherUser->id,
                        'relation' => $relations[array_rand($relations)],
                        'added_by' => $user->id,
                        'status' => rand(0, 2), // 0:pending, 1:accepted, 2:rejected
                    ]);
                }
            }
        }
    }
}

