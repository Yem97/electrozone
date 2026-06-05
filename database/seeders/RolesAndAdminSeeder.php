<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

/**
 * Creates the application roles, syncs their permissions, and provisions the
 * first Super Admin from environment configuration.
 *
 * This logic used to live in AppServiceProvider::boot() and ran on every HTTP
 * request (with hard-coded credentials). It now runs once at deploy time and
 * reads the admin credentials from config/env, never from source code.
 */
class RolesAndAdminSeeder extends Seeder
{
    public function run(): void
    {
        $guard = 'sanctum';

        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => $guard]);
        $adminRole      = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => $guard]);
        $userRole       = Role::firstOrCreate(['name' => 'User', 'guard_name' => $guard]);

        // Super Admin: every permission.
        $superAdminRole->syncPermissions(Permission::all());

        // Admin: everything except role and checkout management.
        $adminRole->syncPermissions(
            Permission::whereNotIn('name', [
                'role-list', 'role-create', 'role-edit', 'role-delete',
                'order-list', 'checkout-list', 'checkout-create',
            ])->get()
        );

        // User (storefront customer): no admin capabilities.
        $userRole->syncPermissions(
            Permission::whereNotIn('name', [
                'role-list', 'role-create', 'role-edit', 'role-delete',
                'user-list', 'user-create', 'user-edit', 'user-delete',
                'adminorder-list', 'update-order-status', 'access-dashboard',
                'category-list', 'category-create', 'category-edit', 'category-delete',
                'equipment-list', 'equipment-create', 'equipment-edit', 'equipment-delete',
            ])->get()
        );

        // Provision the first Super Admin from environment config (never hard-coded).
        // Set ADMIN_EMAIL and ADMIN_PASSWORD in the environment before deploying.
        $email    = config('admin.email');
        $password = config('admin.password');

        if (! empty($email) && ! empty($password)) {
            $admin = User::firstOrCreate(
                ['email' => $email],
                [
                    'name'     => config('admin.name', 'Super Admin'),
                    'password' => Hash::make($password),
                ]
            );

            // Pass the Role instance (not the name) so assignment is guard-safe.
            if (! $admin->hasRole($superAdminRole)) {
                $admin->assignRole($superAdminRole);
            }
        }
    }
}
