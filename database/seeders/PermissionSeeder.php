<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Profile
            'dashboard',
            'profile.management',
            'user_profile_show',
            'user_profile_edit',
            'user_profile_update',
            'profile_picture_edit',
            'profile_picture_update',
            'user_password_update',
            'user_password_edit',
            'user_password_reset',

            // Companies routes
            'companies.index',
            'companies.create',
            'companies.store',
            'companies.show',
            'companies.edit',
            'companies.update',
            'companies.destroy',

            // Product routes
            'products.index',
            'products.create',
            'products.store',
            'products.show',
            'products.edit',
            'products.update',
            'products.destroy',

            // Unit routes
            'units.index',
            'units.create',
            'units.store',
            'units.show',
            'units.edit',
            'units.update',
            'units.destroy',

            // Cateogories routes
            'categories.index',
            'categories.create',
            'categories.store',
            'categories.show',
            'categories.edit',
            'categories.update',
            'categories.destroy',

            // Brand routes
            'brands.index',
            'brands.create',
            'brands.store',
            'brands.show',
            'brands.edit',
            'brands.update',
            'brands.destroy',

            // Warranty routes
            'warranties.index',
            'warranties.create',
            'warranties.store',
            'warranties.show',
            'warranties.edit',
            'warranties.update',
            'warranties.destroy',

            // Customer routes
            'customers.index',
            'customers.create',
            'customers.store',
            'customers.show',
            'customers.edit',
            'customers.update',
            'customers.destroy',

            // Branch routes
            'branches.index',
            'branches.create',
            'branches.store',
            'branches.show',
            'branches.edit',
            'branches.update',
            'branches.destroy',

            // Supplier routes
            'suppliers.index',
            'suppliers.create',
            'suppliers.store',
            'suppliers.show',
            'suppliers.edit',
            'suppliers.update',
            'suppliers.destroy',

            // Challan routes
            'challans.index',
            'challans.create',
            'challans.store',
            'challans.show',
            'challans.edit',
            'challans.update',
            'challans.destroy',

            // Invoice routes
            'invoices.index',
            'invoices.create',
            'invoices.store',
            'invoices.show',
            'invoices.edit',
            'invoices.update',
            'invoices.destroy',

            // Permissions & Roles
            'permissions.index',
            'permissions.create',
            'permissions.store',
            'permissions.edit',
            'permissions.update',
            'permissions.destroy',

            'roles.index',
            'roles.create',
            'roles.store',
            'roles.edit',
            'roles.update',
            'roles.destroy',

            // Users & Settings
            'system_users.index',
            'system_users.create',
            'system_users.store',
            'system_users.show',
            'system_users.edit',
            'system_users.update',
            'system_users.destroy',

            'settings.index',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Assign all permissions to 'admin' role
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions(Permission::all());
    }
}
