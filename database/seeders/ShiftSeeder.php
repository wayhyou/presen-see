<?php

namespace Database\Seeders;

use App\Models\Shift;
use App\Models\Office;
use Illuminate\Database\Seeder;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            Shift::insert([
                [
                    'name' => 'Shift Pagi',
                    'start_time' => '08:00',
                    'end_time' => '16:00',
                    'break_minutes' => 60,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Shift Siang',
                    'start_time' => '12:00',
                    'end_time' => '20:00',
                    'break_minutes' => 45,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Shift Malam',
                    'start_time' => '20:00',
                    'end_time' => '04:00',
                    'break_minutes' => 30,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Shift Fleksibel',
                    'start_time' => '09:00',
                    'end_time' => '17:00',
                    'break_minutes' => 60,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
    }
}
