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
                'last_name' => 'System',
                'profile_image' => '',
                'is_verified' => '1',
                'email' => 'divyadham@admin.com',
                'occupation' => 'System Admin',
                'campany_name' => 'Divyadham',
                'address' => 'Village Office',
                'city' => 'Village City',
                'state' => 'State',
                'district' => null,
                'village' => null,
                'country' => 'India',
                'zipcode' => '123456',
                'status' => '1',
                'device_type' => 'web',
                'device_token' => '',
            ],
            [
                'country_code' => '91',
                'phone_number' => '9876543210',
                'first_name' => 'Rajesh',
                'last_name' => 'Kumar',
                'profile_image' => '',
                'is_verified' => '1',
                'email' => 'rajesh@example.com',
                'occupation' => 'Farmer',
                'campany_name' => '',
                'address' => 'House No. 123',
                'city' => 'Village City',
                'state' => 'State',
                'district' => null,
                'village' => null,
                'country' => 'India',
                'zipcode' => '123456',
                'status' => '1',
                'device_type' => 'android',
                'device_token' => '',
            ],
            [
                'country_code' => '91',
                'phone_number' => '9876543211',
                'first_name' => 'Priya',
                'last_name' => 'Sharma',
                'profile_image' => '',
                'is_verified' => '1',
                'email' => 'priya@example.com',
                'occupation' => 'Teacher',
                'campany_name' => 'Village School',
                'address' => 'House No. 456',
                'city' => 'Village City',
                'state' => 'State',
                'district' => null,
                'village' => null,
                'country' => 'India',
                'zipcode' => '123456',
                'status' => '1',
                'device_type' => 'ios',
                'device_token' => '',
            ]
        ];

        DB::table('users')->insert($users);
    }
}
