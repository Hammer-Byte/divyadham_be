<?php

namespace Database\Seeders;

use App\Models\VillageMedia;
use App\Models\Villages;
use Illuminate\Database\Seeder;

class VillageMediaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $villages = Villages::all();
        
        if ($villages->isEmpty()) {
            $this->command->warn('Please seed villages first!');
            return;
        }

        foreach ($villages as $village) {
            // Add 3-5 media items per village
            for ($i = 0; $i < rand(3, 5); $i++) {
                VillageMedia::create([
                    'village_id' => $village->id,
                    'media_upload_type' => 'url',
                    'media_url' => 'https://via.placeholder.com/800x600',
                    'media_type' => rand(0, 1) ? 'image' : 'video',
                    'position' => $i + 1,
                    'status' => 1,
                ]);
            }
        }
    }
}

