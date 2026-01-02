<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'country_code' => '91',
                'phone_number' => '0000000000',
                'first_name' => 'Divyadham',
                'last_name' => '',
                'profile_image' => '',
                'is_verified' => '0',
                'email' => 'divyadham@admin.com',
                'password' => '$2y$12$Pgv1x51eeIF7FWZgGByMcOe4AR98F3br4eLxZmZE1mSORF2oyPZ6.', //admin@123
                'occupation' => '',
                'campany_name' => '',
                'address' => '',
                'city' => '',
                'state' => '',
                'country' => '',
                'zipcode' => '',
                'status' => '1',
                'device_type' => '',
                'device_token' => '',
            ],
        ];

        DB::table('users')->insert($users);
    }
}
