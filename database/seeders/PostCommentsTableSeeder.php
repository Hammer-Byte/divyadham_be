<?php

namespace Database\Seeders;

use App\Models\PostComment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostCommentsTableSeeder extends Seeder
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

        $comments = [
            'Great initiative!',
            'Looking forward to this.',
            'Thank you for organizing this.',
            'This is amazing!',
            'Count me in!',
            'Excellent work!',
            'Very informative.',
            'Keep up the good work!',
        ];

        foreach ($posts as $post) {
            // Add 2-5 comments per post
            for ($i = 0; $i < rand(2, 5); $i++) {
                $user = $users->random();
                PostComment::create([
                    'post_id' => $post->id,
                    'user_id' => $user->id,
                    'content' => $comments[array_rand($comments)],
                ]);
            }
        }
    }
}

