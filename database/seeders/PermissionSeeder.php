<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;



class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $permissions = [
            // Role management
            "role-list",
            "role-create",
            "role-edit",
            "role-delete",
        
            // User management
            "user-list",
            "user-create",
            "user-edit",
            "user-delete",

            // Category management
            "category-list",
            "category-create",
            "category-edit",
            "category-delete",
        
            // Equipment management
            "equipment-list",
            "equipment-create",
            "equipment-edit",
            "equipment-delete",
            
            // Dashboard
            'access-dashboard',

            // Order Management
            'order-list',
            'adminorder-list',
            'update-order-status',

            //checkout managment
            'checkout-list',
            'checkout-create'
        ];

        foreach ($permissions as $permission) {
            // firstOrCreate keeps this seeder idempotent so it can run safely on
            // every deploy without throwing on duplicate permission names.
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'sanctum']);
        }
        
        
    }
}
