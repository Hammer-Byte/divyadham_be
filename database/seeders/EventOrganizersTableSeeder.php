<?php

namespace Database\Seeders;

use App\Models\EventOrganizer;
use App\Models\Events;
use App\Models\Organizer;
use Illuminate\Database\Seeder;

class EventOrganizersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = Events::all();
        $organizers = Organizer::all();
        
        if ($events->isEmpty() || $organizers->isEmpty()) {
            $this->command->warn('Please seed events and organizers first!');
            return;
        }

        foreach ($events as $event) {
            // Assign 2-3 organizers to each event
            $selectedOrganizers = $organizers->random(min(3, $organizers->count()));
            
            foreach ($selectedOrganizers as $organizer) {
                EventOrganizer::create([
                    'event_id' => $event->id,
                    'organizer_id' => $organizer->id,
                    'status' => 1,
                ]);
            }
        }
    }
}

