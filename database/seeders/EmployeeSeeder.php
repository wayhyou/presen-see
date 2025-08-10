<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Office;
use App\Models\Department;
use App\Models\Shift;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $offices = Office::all();
        $departments = Department::all();
        $shifts = Shift::all();

        $positions = ['Staff', 'Supervisor', 'Manager', 'HRD', 'Operator'];

        for ($i = 1; $i <= 20; $i++) {
            $office = $offices->random();
            $department = $departments->random();
            $shift = $shifts->random();

            $position = $positions[array_rand($positions)];

            $user = User::create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('password123'),
                'office_id' => $office->id,
            ]);

            // Mapping posisi ke role
            $roleName = match ($position) {
                'HRD' => 'HRD',
                'Manager', 'Supervisor' => 'Atasan',
                default => 'Karyawan',
            };

            $user->assignRole($roleName);

            Employee::create([
                'user_id' => $user->id,
                'office_id' => $office->id,
                'department_id' => $department->id,
                'shift_id' => $shift->id,
                'employee_code' => 'EMP' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'position' => $position,
                'join_date' => Carbon::now()->subDays(rand(30, 1000))->format('Y-m-d'),
            ]);
        }
    }
}
