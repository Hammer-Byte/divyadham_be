<?php

namespace Database\Seeders;

use App\Models\Storie;
use App\Models\User;
use Illuminate\Database\Seeder;

class StoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::limit(3)->get();
        
        if ($users->isEmpty()) {
            $this->command->warn('Please seed users first!');
            return;
        }

        $stories = [
            [
                'user_id' => $users[0]->id,
                'media_url' => 'https://via.placeholder.com/400x800',
                'caption' => 'Beautiful morning in the village!',
                'views_count' => 150,
            ],
            [
                'user_id' => $users[0]->id,
                'media_url' => 'https://via.placeholder.com/400x800',
                'caption' => 'Community gathering for festival preparations',
                'views_count' => 200,
            ],
            [
                'user_id' => $users[1]->id ?? $users[0]->id,
                'media_url' => 'https://via.placeholder.com/400x800',
                'caption' => 'New school building construction progress',
                'views_count' => 180,
            ],
        ];

        foreach ($stories as $story) {
            Storie::create($story);
        }
    }
}

