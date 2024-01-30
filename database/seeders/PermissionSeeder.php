<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $permissions = [
            'create-role',
            'edit-role',
            'delete-role',
            'view-role',
            'create-permission',
            'edit-permission',
            'delete-permission',
            'view-permission',
            'create-dashboard',
            'edit-dashboard',
            'delete-dashboard',
            'view-dashboard',
            'create-member',
            'edit-member',
            'delete-member',
            'view-member',
            'create-household',
            'edit-household',
            'delete-household',
            'view-household',
            'create-area',
            'edit-area',
            'delete-area',
            'view-area',
            'create-activity',
            'edit-activity',
            'delete-activity',
            'view-activity',
            'view-tithes',
            'create-tithes',
        ];

        // Looping and Inserting Array's Permissions into Permission Table
        foreach($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
