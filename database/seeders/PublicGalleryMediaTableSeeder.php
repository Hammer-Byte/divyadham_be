<?php

namespace Database\Seeders;

use App\Models\PublicGalleryMedia;
use App\Models\PublicGalleryFolder;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PublicGalleryMediaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $folders = PublicGalleryFolder::all();
        $admin = Admin::first();
        
        if ($folders->isEmpty() || !$admin) {
            $this->command->warn('Please seed gallery folders and admins first!');
            return;
        }

        foreach ($folders as $folder) {
            // Add 3-6 media items per folder
            for ($i = 0; $i < rand(3, 6); $i++) {
                PublicGalleryMedia::create([
                    'folder_id' => $folder->id,
                    'title' => 'Gallery Image ' . ($i + 1),
                    'description' => 'Description for gallery media item ' . ($i + 1),
                    'media_upload_type' => 'url',
                    'media_url' => 'https://via.placeholder.com/800x600',
                    'media_type' => rand(0, 1) ? 'image' : 'video',
                    'position' => $i + 1,
                    'uploaded_by' => $admin->id,
                    'uploaded_date' => Carbon::now()->subDays(rand(1, 30)),
                    'status' => 1,
                ]);
            }
        }
    }
}

