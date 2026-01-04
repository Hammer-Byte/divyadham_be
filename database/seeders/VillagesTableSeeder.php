<?php

namespace Database\Seeders;

use App\Models\Villages;
use App\Models\State;
use App\Models\District;
use Illuminate\Database\Seeder;

class VillagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first state and district for seeding
        $state = State::first();
        $district = District::where('state_id', $state?->id)->first();

        if (!$state || !$district) {
            $this->command->warn('Please seed states and districts first!');
            return;
        }

        $villages = [
            [
                'name' => 'Divyadham Village',
                'description' => 'A beautiful village with rich cultural heritage and traditions.',
                'state' => $state->id,
                'district' => $district->id,
                'population' => 5000,
                'latitude' => '28.6139',
                'longitude' => '77.2090',
                'status' => 1,
            ],
            [
                'name' => 'Shanti Nagar',
                'description' => 'Peaceful village known for its community harmony and development.',
                'state' => $state->id,
                'district' => $district->id,
                'population' => 3500,
                'latitude' => '28.6140',
                'longitude' => '77.2091',
                'status' => 1,
            ],
            [
                'name' => 'Gram Panchayat Village',
                'description' => 'Well-developed village with modern amenities and infrastructure.',
                'state' => $state->id,
                'district' => $district->id,
                'population' => 7500,
                'latitude' => '28.6141',
                'longitude' => '77.2092',
                'status' => 1,
            ],
            [
                'name' => 'Rural Development Village',
                'description' => 'Village focused on sustainable development and agriculture.',
                'state' => $state->id,
                'district' => $district->id,
                'population' => 4200,
                'latitude' => '28.6142',
                'longitude' => '77.2093',
                'status' => 1,
            ],
            [
                'name' => 'Heritage Village',
                'description' => 'Historical village preserving ancient traditions and culture.',
                'state' => $state->id,
                'district' => $district->id,
                'population' => 2800,
                'latitude' => '28.6143',
                'longitude' => '77.2094',
                'status' => 1,
            ],
        ];

        foreach ($villages as $village) {
            Villages::create($village);
        }
    }
}

