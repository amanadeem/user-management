<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            
            // Users
            ['name' => 'view_users', 'guard_name' => 'web'],
            ['name' => 'create_users', 'guard_name' => 'web'],
            ['name' => 'update_users', 'guard_name' => 'web'],
            ['name' => 'delete_users', 'guard_name' => 'web'],

        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
