<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Office;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $departments = [
            'HRD',
            'Finance',
            'IT',
            'Marketing',
            'Customer Service',
        ];

        foreach ($departments as $deptName) {
            Department::firstOrCreate([
                'name'      => $deptName,
            ]);
        }

    }
}
