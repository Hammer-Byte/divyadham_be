<?php

namespace Database\Seeders;

use App\Models\Events;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'title' => 'Annual Village Festival',
                'description' => 'Grand celebration of village culture with music, dance, and traditional food.',
                'banner_upload_type' => 'url',
                'banner_image_url' => 'https://via.placeholder.com/800x400',
                'event_image_upload_type' => 'url',
                'event_image_url' => 'https://via.placeholder.com/600x400',
                'start_date' => Carbon::now()->addDays(30),
                'end_date' => Carbon::now()->addDays(32),
                'location' => 'Village Ground',
                'latitude' => 28.6139,
                'longitude' => 77.2090,
                'status' => 1,
            ],
            [
                'title' => 'Health Awareness Camp',
                'description' => 'Free health checkup and awareness program for all villagers.',
                'banner_upload_type' => 'url',
                'banner_image_url' => 'https://via.placeholder.com/800x400',
                'event_image_upload_type' => 'url',
                'event_image_url' => 'https://via.placeholder.com/600x400',
                'start_date' => Carbon::now()->addDays(15),
                'end_date' => Carbon::now()->addDays(15),
                'location' => 'Community Health Center',
                'latitude' => 28.6140,
                'longitude' => 77.2091,
                'status' => 1,
            ],
            [
                'title' => 'Educational Workshop',
                'description' => 'Workshop on digital literacy and skill development for youth.',
                'banner_upload_type' => 'url',
                'banner_image_url' => 'https://via.placeholder.com/800x400',
                'event_image_upload_type' => 'url',
                'event_image_url' => 'https://via.placeholder.com/600x400',
                'start_date' => Carbon::now()->addDays(20),
                'end_date' => Carbon::now()->addDays(22),
                'location' => 'Village School',
                'latitude' => 28.6141,
                'longitude' => 77.2092,
                'status' => 1,
            ],
            [
                'title' => 'Tree Plantation Drive',
                'description' => 'Community initiative to plant trees and promote environmental conservation.',
                'banner_upload_type' => 'url',
                'banner_image_url' => 'https://via.placeholder.com/800x400',
                'event_image_upload_type' => 'url',
                'event_image_url' => 'https://via.placeholder.com/600x400',
                'start_date' => Carbon::now()->addDays(10),
                'end_date' => Carbon::now()->addDays(10),
                'location' => 'Village Park',
                'latitude' => 28.6142,
                'longitude' => 77.2093,
                'status' => 1,
            ],
            [
                'title' => 'Sports Tournament',
                'description' => 'Annual sports competition with various games and prizes.',
                'banner_upload_type' => 'url',
                'banner_image_url' => 'https://via.placeholder.com/800x400',
                'event_image_upload_type' => 'url',
                'event_image_url' => 'https://via.placeholder.com/600x400',
                'start_date' => Carbon::now()->addDays(45),
                'end_date' => Carbon::now()->addDays(47),
                'location' => 'Sports Ground',
                'latitude' => 28.6143,
                'longitude' => 77.2094,
                'status' => 1,
            ],
        ];

        foreach ($events as $event) {
            Events::create($event);
        }
    }
}

