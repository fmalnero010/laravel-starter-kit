<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // UserSeeder must be run apart as it is only for local development

        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            PermissionsByRoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}
