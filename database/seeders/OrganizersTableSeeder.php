<?php

namespace Database\Seeders;

use App\Models\Organizer;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrganizersTableSeeder extends Seeder
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

        foreach ($users as $user) {
            Organizer::create([
                'user_id' => $user->id,
                'status' => 1,
            ]);
        }
    }
}

