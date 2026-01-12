<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        
        if (!$user) {
            $this->command->warn('Please seed users first!');
            return;
        }

        $posts = [
            [
                'user_id' => $user->id,
                'type' => 'text',
                'content' => 'Excited to announce the upcoming village festival! Join us for a grand celebration of our culture and traditions.',
                'status' => 1,
            ],
            [
                'user_id' => $user->id,
                'type' => 'media',
                'content' => 'Beautiful sunset from our village!',
                'media_upload_type' => 'url',
                'media_url' => ['https://via.placeholder.com/800x600'],
                'media_type' => 'image',
                'status' => 1,
            ],
            [
                'user_id' => $user->id,
                'type' => 'link',
                'content' => 'Check out this interesting article about village development.',
                'link_url' => 'https://example.com/article',
                'link_title' => 'Village Development Guide',
                'link_description' => 'Learn about sustainable village development practices.',
                'link_image_url' => 'https://via.placeholder.com/400x300',
                'status' => 1,
            ],
            [
                'user_id' => $user->id,
                'type' => 'text',
                'content' => 'Thank you to everyone who participated in the health awareness camp. Your health matters!',
                'status' => 1,
            ],
            [
                'user_id' => $user->id,
                'type' => 'media',
                'content' => 'Memories from the educational workshop. Great learning experience!',
                'media_upload_type' => 'url',
                'media_url' => ['https://via.placeholder.com/800x600'],
                'media_type' => 'image',
                'status' => 1,
            ],
            [
                'user_id' => $user->id,
                'type' => 'media',
                'content' => 'Here are some highlights from our cultural festival event!',
                'media_upload_type' => 'url',
                'media_url' => [
                    'https://via.placeholder.com/800x600?text=Event+1',
                    'https://via.placeholder.com/800x600?text=Event+2',
                    'https://via.placeholder.com/800x600?text=Event+3',
                    'https://via.placeholder.com/800x600?text=Video+Thumbnail'
                ],
                'media_type' => 'gallery', 
                'status' => 1,
            ],
        ];

        foreach ($posts as $post) {
            Post::create($post);
        }
    }
}

