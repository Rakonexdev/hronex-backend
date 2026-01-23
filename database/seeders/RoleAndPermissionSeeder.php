<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create permissions if they don't exist already
        Permission::firstOrCreate(['name' => 'create-employee']);
        Permission::firstOrCreate(['name' => 'edit-employee']);
        Permission::firstOrCreate(['name' => 'delete-employee']);
        Permission::firstOrCreate(['name' => 'master']);
        Permission::firstOrCreate(['name' => 'show-forms']);
        Permission::firstOrCreate(['name' => 'profile-update']);
        Permission::firstOrCreate(['name' => 'approve-leave']);

        $superAdminRole = Role::firstOrCreate(['name' => 'Super-Admin']);
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $hrRole = Role::firstOrCreate(['name' => 'Hr']);
        $employeeRole = Role::firstOrCreate(['name' => 'Employee']);
        $vpRole = Role::firstOrCreate(['name' => 'Vp']);
        $pRole = Role::firstOrCreate(['name' => 'Principal']);
        $acRole = Role::firstOrCreate(['name' => 'Accounts']);

        // Assign permissions to roles
        $superAdminRole->givePermissionTo([
            'create-employee',
            'edit-employee',
            'delete-employee',
            'approve-leave',
            'master',
            'show-forms',
            'profile-update'
        ]);

        $adminRole->givePermissionTo([
            'create-employee',
            'edit-employee',
            'delete-employee',
            'approve-leave',
            'show-forms'
        ]);

        $hrRole->givePermissionTo([
            'approve-leave',
            'show-forms'
        ]);

        $employeeRole->givePermissionTo([
            'show-forms',
            'profile-update'
        ]);

        $vpRole->givePermissionTo([
            'approve-leave',
            'show-forms'
        ]);

        $pRole->givePermissionTo([
            'approve-leave',
            'show-forms'
        ]);

        $acRole->givePermissionTo([
            'show-forms'
        ]);

        // Assign roles to a user
        $user = User::where('email', 'admin@admin.com')->first();
        $user->assignRole('Super-Admin');
    }
}
