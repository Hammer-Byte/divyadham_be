<?php

namespace Database\Seeders;

use App\Models\VillageMember;
use App\Models\Villages;
use App\Models\User;
use Illuminate\Database\Seeder;

class VillageMembersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $village = Villages::first();
        $users = User::limit(10)->get();
        
        if (!$village || $users->isEmpty()) {
            $this->command->warn('Please seed villages and users first!');
            return;
        }

        foreach ($users as $user) {
            VillageMember::create([
                'village_id' => $village->id,
                'user_id' => $user->id,
                'status' => 1,
            ]);
        }
    }
}

