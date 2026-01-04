<?php

namespace Database\Seeders;

use App\Models\EventShare;
use App\Models\Events;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventSharesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = Events::all();
        $users = User::limit(10)->get();
        
        if ($events->isEmpty() || $users->isEmpty()) {
            $this->command->warn('Please seed events and users first!');
            return;
        }

        foreach ($events as $event) {
            // Add 3-8 shares per event
            $sharingUsers = $users->random(min(rand(3, 8), $users->count()));
            
            foreach ($sharingUsers as $user) {
                EventShare::create([
                    'event_id' => $event->id,
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}

