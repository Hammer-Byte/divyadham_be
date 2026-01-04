<?php

namespace Database\Seeders;

use App\Models\DonationCampaign;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DonationCampaignsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $campaigns = [
            [
                'title' => 'School Building Fund',
                'description' => 'Help us build a new school building for better education facilities.',
                'donation_type' => 1,
                'goal_amount' => 500000.00,
                'raise_amount' => 250000.00,
                'start_date' => Carbon::now()->subMonths(2),
                'end_date' => Carbon::now()->addMonths(4),
                'banner_upload_type' => 'url',
                'banner_image_url' => 'https://via.placeholder.com/800x400',
                'organizers' => 'Education Committee',
                'status' => 1,
            ],
            [
                'title' => 'Medical Equipment Fund',
                'description' => 'Raise funds to purchase essential medical equipment for the health center.',
                'donation_type' => 1,
                'goal_amount' => 300000.00,
                'raise_amount' => 150000.00,
                'start_date' => Carbon::now()->subMonths(1),
                'end_date' => Carbon::now()->addMonths(3),
                'banner_upload_type' => 'url',
                'banner_image_url' => 'https://via.placeholder.com/800x400',
                'organizers' => 'Health Committee',
                'status' => 1,
            ],
            [
                'title' => 'Road Development Project',
                'description' => 'Contribute to building better roads for improved connectivity.',
                'donation_type' => 1,
                'goal_amount' => 1000000.00,
                'raise_amount' => 400000.00,
                'start_date' => Carbon::now()->subMonths(3),
                'end_date' => Carbon::now()->addMonths(6),
                'banner_upload_type' => 'url',
                'banner_image_url' => 'https://via.placeholder.com/800x400',
                'organizers' => 'Development Committee',
                'status' => 1,
            ],
            [
                'title' => 'Water Well Installation',
                'description' => 'Help install water wells for clean drinking water access.',
                'donation_type' => 1,
                'goal_amount' => 200000.00,
                'raise_amount' => 80000.00,
                'start_date' => Carbon::now()->subDays(15),
                'end_date' => Carbon::now()->addMonths(2),
                'banner_upload_type' => 'url',
                'banner_image_url' => 'https://via.placeholder.com/800x400',
                'organizers' => 'Village Development Committee',
                'status' => 1,
            ],
            [
                'title' => 'Library Setup Fund',
                'description' => 'Establish a community library with books and reading materials.',
                'donation_type' => 1,
                'goal_amount' => 150000.00,
                'raise_amount' => 60000.00,
                'start_date' => Carbon::now()->subDays(10),
                'end_date' => Carbon::now()->addMonths(3),
                'banner_upload_type' => 'url',
                'banner_image_url' => 'https://via.placeholder.com/800x400',
                'organizers' => 'Education Committee',
                'status' => 1,
            ],
        ];

        foreach ($campaigns as $campaign) {
            DonationCampaign::create($campaign);
        }
    }
}

