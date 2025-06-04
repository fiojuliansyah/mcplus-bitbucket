<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile; 
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $student = User::create([
            'name' => 'Student',
            'email' => 'student@gmail.com',
            'password' => bcrypt('password'), 
            'phone' => '081234567890', 
            'status' => 'active',
            'account_type' => 'student', 
        ]);

        
        $studentProfile = Profile::create([
            'user_id' => $student->id,
            'name' => 'Student Profile',  
            'avatar' => 'default-avatar.png',  
        ]);

        
        $student->profile_id = $studentProfile->id;
        $student->save();

        
        $parent = User::create([
            'name' => 'Parent',
            'email' => 'parent@gmail.com',
            'password' => bcrypt('password'), 
            'phone' => '08123456789011', 
            'status' => 'active',
            'account_type' => 'parent', 
        ]);

        
        $parentProfile = Profile::create([
            'user_id' => $parent->id,
            'name' => 'Parent Profile',  
            'avatar' => 'default-avatar.png',  
        ]);

        
        $parent->profile_id = $parentProfile->id;
        $parent->save();

        
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'phone' => '0823456789012',
            'status' => 'active',
            'account_type' => 'admin', 
        ]);

        
        $adminProfile = Profile::create([
            'user_id' => $admin->id,
            'name' => 'Admin Profile',  
            'avatar' => 'default-avatar.png',  
        ]);

        
        $admin->profile_id = $adminProfile->id;
        $admin->save();

        
        $tutor = User::create([
            'name' => 'Tutor',
            'email' => 'tutor@gmail.com',
            'password' => bcrypt('password'),
            'phone' => '083456789013',
            'status' => 'active',
            'account_type' => 'tutor', 
        ]);

        
        $tutorProfile = Profile::create([
            'user_id' => $tutor->id,
            'name' => 'Tutor Profile',  
            'avatar' => 'default-avatar.png',  
        ]);

        
        $tutor->profile_id = $tutorProfile->id;
        $tutor->save();
    }
}
