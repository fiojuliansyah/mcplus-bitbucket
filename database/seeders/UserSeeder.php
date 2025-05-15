<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        User::create([
            'name' => 'Student',
            'email' => 'student@gmail.com',
            'password' => bcrypt('password'), 
            'phone' => '081234567890', 
            'status' => 'active',
            'account_type' => 'student', 
        ]);

        User::create([
            'name' => 'Parent',
            'email' => 'parent@gmail.com',
            'password' => bcrypt('password'), 
            'phone' => '08123456789011', 
            'status' => 'active',
            'account_type' => 'parent', 
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'phone' => '0823456789012',
            'status' => 'active',
            'account_type' => 'admin', 
        ]);

        User::create([
            'name' => 'Tutor',
            'email' => 'tutor@gmail.com',
            'password' => bcrypt('password'),
            'phone' => '083456789013',
            'status' => 'active',
            'account_type' => 'tutor', 
        ]);
    }
}
