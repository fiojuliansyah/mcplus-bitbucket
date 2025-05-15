<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample data untuk tabel permissions
        $permissions = [
            [
                'name' => 'view-users',
                'mock' => 'View Users',
                'guard_name' => 'web',
                'grup' => 'User Management'
            ],
            [
                'name' => 'create-users',
                'mock' => 'Create Users',
                'guard_name' => 'web',
                'grup' => 'User Management'
            ],
            [
                'name' => 'edit-users',
                'mock' => 'Edit Users',
                'guard_name' => 'web',
                'grup' => 'User Management'
            ],
            [
                'name' => 'delete-users',
                'mock' => 'Delete Users',
                'guard_name' => 'web',
                'grup' => 'User Management'
            ],
            [
                'name' => 'manage-roles',
                'mock' => 'Manage Roles and Permissions',
                'guard_name' => 'web',
                'grup' => 'Role Management'
            ]
        ];

        // Menyisipkan data ke dalam tabel permissions
        DB::table('permissions')->insert($permissions);
    }
}
