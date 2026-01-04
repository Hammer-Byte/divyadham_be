<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@divyadham.com',
                'password' => Hash::make('admin@123'),
                'phone_number' => '9876543210',
                'admin_type' => 'super_admin',
                'status' => 1,
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin@divyadham.com',
                'password' => Hash::make('admin@123'),
                'phone_number' => '9876543211',
                'admin_type' => 'admin',
                'status' => 1,
            ],
            [
                'name' => 'Sub Admin',
                'email' => 'subadmin@divyadham.com',
                'password' => Hash::make('admin@123'),
                'phone_number' => '9876543212',
                'admin_type' => 'sub_admin',
                'status' => 1,
            ],
            [
                'name' => 'Content Manager',
                'email' => 'content@divyadham.com',
                'password' => Hash::make('admin@123'),
                'phone_number' => '9876543213',
                'admin_type' => 'admin',
                'status' => 1,
            ],
            [
                'name' => 'Event Coordinator',
                'email' => 'events@divyadham.com',
                'password' => Hash::make('admin@123'),
                'phone_number' => '9876543214',
                'admin_type' => 'sub_admin',
                'status' => 1,
            ],
        ];

        foreach ($admins as $admin) {
            Admin::create($admin);
        }
    }
}

