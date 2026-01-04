<?php

namespace Database\Seeders;

use App\Models\PostLike;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostLikesTableSeeder extends Seeder
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
            // Add 3-8 likes per post
            $likingUsers = $users->random(min(rand(3, 8), $users->count()));
            
            foreach ($likingUsers as $user) {
                PostLike::create([
                    'post_id' => $post->id,
                    'user_id' => $user->id,
                    'type' => 'like',
                ]);
            }
        }
    }
}

