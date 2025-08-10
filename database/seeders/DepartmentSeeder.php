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
        $offices = Office::all();

        $departments = [
            'HRD',
            'Finance',
            'IT',
            'Marketing',
            'Customer Service',
        ];

        foreach ($offices as $office) {
            foreach ($departments as $deptName) {
                Department::firstOrCreate([
                    'office_id' => $office->id,
                    'name'      => $deptName,
                ]);
            }
        }
    }
}
