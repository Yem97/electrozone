<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Initial Super Admin account
    |--------------------------------------------------------------------------
    |
    | Used by Database\Seeders\RolesAndAdminSeeder to provision the first
    | Super Admin user at deploy time. Set these in your environment
    | (.env locally, or the host's environment variables in production).
    | If email or password is empty, no admin user is created.
    |
    */

    'name'     => env('ADMIN_NAME', 'Super Admin'),
    'email'    => env('ADMIN_EMAIL'),
    'password' => env('ADMIN_PASSWORD'),

];
