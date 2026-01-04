<?php

namespace Database\Seeders;

use App\Models\EventMedia;
use App\Models\Events;
use Illuminate\Database\Seeder;

class EventMediaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = Events::all();
        
        if ($events->isEmpty()) {
            $this->command->warn('Please seed events first!');
            return;
        }

        foreach ($events as $event) {
            // Add 2-4 media items per event
            for ($i = 0; $i < rand(2, 4); $i++) {
                EventMedia::create([
                    'event_id' => $event->id,
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

