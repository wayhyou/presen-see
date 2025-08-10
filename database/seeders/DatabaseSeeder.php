<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            OfficeSeeder::class,
            DepartmentSeeder::class,
            ShiftSeeder::class,
            AdminSeeder::class,
            EmployeeSeeder::class,
        ]);
    }
}
