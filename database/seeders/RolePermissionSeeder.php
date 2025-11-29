<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $defaultPermissions = [
            'dashboard',
        ];

        $userPermissions = [
            'users.index',   // View
            'users.create',  // Create new
            'users.store',   // Store new
            'users.show',    // View individual
            'users.edit',    // Edit
            'users.update',  // Update
            'users.destroy', // Delete
        ];

        $rolePermissions = [
            'roles.index',   // View
            'roles.create',  // Create new
            'roles.store',   // Store new
            'roles.show',    // View individual
            'roles.edit',    // Edit
            'roles.update',  // Update
            'roles.destroy', // Delete
        ];

        $permissionPermissions = [
            'permissions.index',   // View
            'permissions.create',  // Create new
            'permissions.store',   // Store new
            'permissions.show',    // View individual
            'permissions.edit',    // Edit
            'permissions.update',  // Update
            'permissions.destroy', // Delete
            'permissions.deleteSelected', // Delete selected
        ];

        // organization menu
        $organizationPermissions = [
            'organizations.index',   // View
            'organizations.create',  // Create new
            'organizations.store',   // Store new
            'organizations.show',    // View individual
            'organizations.edit',    // Edit
            'organizations.update',  // Update
            'organizations.destroy', // Delete
        ];

        // department menu
        $branchPermissions = [
            'branches.index',   // View
            'branches.create',  // Create new
            'branches.store',   // Store new
            'branches.show',    // View individual
            'branches.edit',    // Edit
            'branches.update',  // Update
            'branches.destroy', // Delete
        ];

        $divisionPermissions = [
            'divisions.index',   // View
            'divisions.create',  // Create new
            'divisions.store',   // Store new
            'divisions.show',    // View individual
            'divisions.edit',    // Edit
            'divisions.update',  // Update
            'divisions.destroy', // Delete
        ];

        $departmentPermissions = [
            'departments.index',   // View
            'departments.create',  // Create new
            'departments.store',   // Store new
            'departments.show',    // View individual
            'departments.edit',    // Edit
            'departments.update',  // Update
            'departments.destroy', // Delete
        ];

        $userCategoriesPermission = [
            'user_categories.index',   // View
            'user_categories.create',  // Create new
            'user_categories.store',   // Store new
            'user_categories.show',    // View individual
            'user_categories.edit',    // Edit
            'user_categories.update',  // Update
            'user_categories.destroy', // Delete
        ];

        $systemUserPermission = [
            'system_users.index',   // View
            'system_users.create',  // Create new
            'system_users.store',   // Store new
            'system_users.show',    // View individual
            'system_users.edit',    // Edit
            'system_users.update',  // Update
            'system_users.destroy', // Delete
        ];

        $systemInformationPermission = [
            'system_informations.index',   // View
            'system_informations.create',  // Create new
            'system_informations.store',   // Store new
            'system_informations.show',    // View individual
            'system_informations.edit',    // Edit
            'system_informations.update',  // Update
            'system_informations.destroy', // Delete
        ];

        $profilePermission = [
            'profile.show',    // View individual
            'profile.edit',    // Edit
            'profile.update',  // Update
        ];

        $settingPermission = [
            'settings.index',    // Index page 
            'settings.password_policy',    // to show password policy page
            'settings.2fa',  // 2fa page
            'settings.toggle2fa',  // 2fa page to turn on/off 
            'settings.2fa.verify',  // 2fa code for verify
            'settings.2fa.resend',  // 2fa code for resend
            'settings.2fa.timeout',  // timeout for the auto logout page
            'settings.2fa.timeout.update',  // timeout for the auto logout update
            'settings.database.backup',  // backup page for database sql
            'settings.database.backup.download',  // backup page for downloading database sql
            'settings.logs',  // to show log page
            'settings.clearLogs',  // to clear log
            'settings.maintenance',  // to show maintenance page
            'settings.maintenance.update',  // to update the maintenance 
        ];

        $ajaxPermission = [
            'ajax.getLocationsByArea',   // Get all locations under a specific Area.
            'ajax.getBuildingsByLocation',  //  Get all building lists under a specific Location.
            'ajax.getHolders',  //  Get all holders by user type
            'ajax.getReporters',  //  Get all holders by user type
            'ajax.getDivisionByBranch',  //  Get all division by branch
            'ajax.getDepartmentByDivision',  //  Get all department by division
        ];

        foreach ($defaultPermissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'module' => 'Default'
            ]);
        }

        foreach ($userPermissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'module' => 'User'
            ]);
        }

        foreach ($rolePermissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'module' => 'Role'
            ]);
        }

        foreach ($permissionPermissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'module' => 'Permission'
            ]);
        }

        foreach ($organizationPermissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'module' => 'Organization'
            ]);
        }

        foreach ($branchPermissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'module' => 'Branch'
            ]);
        }

        foreach ($divisionPermissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'module' => 'Division'
            ]);
        }

        foreach ($departmentPermissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'module' => 'Department'
            ]);
        }

        // setting menu
        foreach ($userCategoriesPermission as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'module' => 'User Categories'
            ]);
        }

        foreach ($systemUserPermission as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'module' => 'System User'
            ]);
        }

        foreach ($systemInformationPermission as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'module' => 'System Information'
            ]);
        }

        foreach ($profilePermission as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'module' => 'Profile'
            ]);
        }

        foreach ($settingPermission as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'module' => 'Setting'
            ]);
        }

        foreach ($ajaxPermission as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'module' => 'Ajax Controller'
            ]);
        }
        // End Permissions

        // Create Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $editorRole = Role::firstOrCreate(['name' => 'editor']);

        // Assign Permissions to Roles
        $adminRole->syncPermissions(Permission::all());
        $editorRole->syncPermissions([
            'users.index',
            'users.create',
            'users.store',
            'users.edit',
            'users.update',
        ]);

        // Assign role to a user (for testing)
        $user = User::find(1);
        if ($user) {
            $user->assignRole('admin');
        }
    }
}
