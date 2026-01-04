<?php

namespace Database\Seeders;

use App\Models\EventRegistration;
use App\Models\Events;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventRegistrationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = Events::all();
        $users = User::limit(15)->get();
        
        if ($events->isEmpty() || $users->isEmpty()) {
            $this->command->warn('Please seed events and users first!');
            return;
        }

        foreach ($events as $event) {
            // Register 5-10 users per event
            $registeringUsers = $users->random(min(rand(5, 10), $users->count()));
            
            foreach ($registeringUsers as $user) {
                EventRegistration::create([
                    'event_id' => $event->id,
                    'user_id' => $user->id,
                    'confirmed' => rand(0, 1),
                ]);
            }
        }
    }
}

