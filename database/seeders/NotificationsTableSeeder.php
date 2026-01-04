<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::limit(10)->get();
        
        if ($users->isEmpty()) {
            $this->command->warn('Please seed users first!');
            return;
        }

        $types = ['info', 'warning', 'error', 'success', 'event', 'system', 'post', 'comment', 'like', 'share'];
        $entityTypes = ['post', 'event', 'donation', 'committee', 'village'];

        foreach ($users as $user) {
            // Create 3-5 notifications per user
            for ($i = 0; $i < rand(3, 5); $i++) {
                Notification::create([
                    'user_id' => $user->id,
                    'notificaiton_type' => $types[array_rand($types)],
                    'entity_type' => $entityTypes[array_rand($entityTypes)],
                    'entity_id' => rand(1, 10),
                    'message' => 'This is a sample notification message for testing purposes.',
                    'title' => 'Notification ' . ($i + 1),
                    'is_read' => rand(0, 1),
                ]);
            }
        }
    }
}

