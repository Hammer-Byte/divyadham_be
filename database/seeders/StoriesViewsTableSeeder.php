<?php

namespace Database\Seeders;

use App\Models\StoriesViews;
use App\Models\Storie;
use App\Models\User;
use Illuminate\Database\Seeder;

class StoriesViewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stories = Storie::all();
        $users = User::limit(15)->get();
        
        if ($stories->isEmpty() || $users->isEmpty()) {
            $this->command->warn('Please seed stories and users first!');
            return;
        }

        foreach ($stories as $story) {
            // Add 5-15 views per story
            $viewingUsers = $users->random(min(rand(5, 15), $users->count()));
            
            foreach ($viewingUsers as $user) {
                StoriesViews::create([
                    'story_id' => $story->id,
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}

