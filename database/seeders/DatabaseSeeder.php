<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Safe to run on every deploy — all child seeders are idempotent.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RolesAndAdminSeeder::class,
        ]);
    }
}
