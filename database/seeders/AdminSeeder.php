<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Office;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $office = Office::first(); // kantor pertama (pusat)

        $admin = User::firstOrCreate(
            ['email' => 'admin@presensee.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'),
                'office_id' => $office->id
            ]
        );

        $admin->assignRole('Admin');
    }
}
