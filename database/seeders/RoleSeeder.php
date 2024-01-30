<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadmin = Role::create(['name' => 'Super Admin']);
        $admin = Role::create(['name' => 'Admin']);
        $areaServant = Role::create(['name' => 'Area Servant']);
        $chapterServant = Role::create(['name' => 'Chapter Servant']);
        $unitServant = Role::create(['name' => 'Unit Servant']);
        $householdServant = Role::create(['name' => 'Household Servant']);
        $member = Role::create(['name' => 'Member']);

        $superadmin->givePermissionTo([
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
            'create-tithes',
            'view-tithes',
        ]);

        $admin->givePermissionTo([
            'view-role',
            'create-dashboard',
            'edit-dashboard',
            'delete-dashboard',
            'view-dashboard',
            'create-member',
            'view-member',
            'edit-member',
            'delete-member',
            'create-household',
            'view-household',
            'edit-household',
            'delete-household',
            'create-area',
            'view-area',
            'edit-area',
            'delete-area',
            'create-activity',
            'view-activity',
            'edit-activity',
            'delete-activity',
            'create-tithes',
            'view-tithes',
        ]);

        $areaServant->givePermissionTo([
            'create-activity',
            'view-activity',
            'edit-activity',
            'delete-activity',
            'create-household',
            'view-household',
            'edit-household',
            'delete-household',
            'create-member',
            'edit-member',
            'delete-member',
            'view-member',
            'create-tithes',
        ]);

        $chapterServant->givePermissionTo([
            'create-activity',
            'view-activity',
            'edit-activity',
            'delete-activity',
            'create-household',
            'view-household',
            'edit-household',
            'delete-household',
            'create-member',
            'edit-member',
            'delete-member',
            'view-member',
            'create-tithes',
        ]);

        $unitServant->givePermissionTo([
            'create-activity',
            'view-activity',
            'edit-activity',
            'delete-activity',
            'create-household',
            'view-household',
            'edit-household',
            'delete-household',
            'create-member',
            'edit-member',
            'delete-member',
            'view-member',
            'create-tithes',
        ]);

        $householdServant->givePermissionTo([
            'view-activity',
            'create-member',
            'edit-member',
            'delete-member',
            'view-member',
            'create-tithes',
        ]);

        $member->givePermissionTo([
            'view-activity',
            'create-tithes',
        ]);
    }
}
