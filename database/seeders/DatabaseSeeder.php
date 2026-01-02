<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Admin::create([
            'name' => 'Super Admin',
            'email' => 'admin@admin.com',
            'admin_type' => 'super_admin',
            'password' => Hash::make('admin@123'),
            'status' => 1,
        ]);

        // Seed states and districts
        $this->call([
            StateSeeder::class,
            DistrictSeeder::class,
        ]);
    }
}
