<?php

namespace Database\Seeders;

use App\Models\PublicGalleryFolder;
use Illuminate\Database\Seeder;

class PublicGalleryFolderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $folders = [
            [
                'folder_name' => 'Festivals & Events',
                'description' => 'Photos and videos from various festivals and community events.',
                'status' => 1,
            ],
            [
                'folder_name' => 'Village Development',
                'description' => 'Documentation of village development projects and infrastructure.',
                'status' => 1,
            ],
            [
                'folder_name' => 'Education',
                'description' => 'School events, educational programs, and student achievements.',
                'status' => 1,
            ],
            [
                'folder_name' => 'Health & Wellness',
                'description' => 'Health camps, awareness programs, and medical facilities.',
                'status' => 1,
            ],
            [
                'folder_name' => 'Cultural Heritage',
                'description' => 'Preservation of traditional arts, crafts, and cultural practices.',
                'status' => 1,
            ],
            [
                'folder_name' => 'Sports & Recreation',
                'description' => 'Sports tournaments, games, and recreational activities.',
                'status' => 1,
            ],
        ];

        foreach ($folders as $folder) {
            PublicGalleryFolder::create($folder);
        }
    }
}

