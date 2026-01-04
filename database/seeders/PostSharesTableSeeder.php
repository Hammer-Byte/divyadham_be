<?php

namespace Database\Seeders;

use App\Models\PostShare;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSharesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::all();
        $users = User::limit(10)->get();
        
        if ($posts->isEmpty() || $users->isEmpty()) {
            $this->command->warn('Please seed posts and users first!');
            return;
        }

        foreach ($posts as $post) {
            // Add 2-5 shares per post
            $sharingUsers = $users->random(min(rand(2, 5), $users->count()));
            
            foreach ($sharingUsers as $user) {
                PostShare::create([
                    'post_id' => $post->id,
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}

