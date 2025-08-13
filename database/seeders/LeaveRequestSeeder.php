<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeaveRequest;
use App\Models\Employee;
use App\Models\User;
use Carbon\Carbon;

class LeaveRequestSeeder extends Seeder
{
    public function run(): void
    {
        $employees = Employee::all();
        $statuses = ['pending', 'approved', 'rejected'];
        $reasons = [
            'Sick leave',
            'Personal matters',
            'Family emergency',
            'Vacation',
            'Medical appointment'
        ];

        // Ambil user yang punya role HRD atau Admin untuk jadi approver
        $approvers = User::role(['HRD', 'Admin'])->pluck('id')->toArray();

        foreach ($employees as $employee) {
            // Setiap employee dapat 2 request cuti acak
            for ($i = 0; $i < 2; $i++) {
                $startDate = Carbon::now()->subDays(rand(1, 60));
                $endDate = (clone $startDate)->addDays(rand(1, 5));

                $status = $statuses[array_rand($statuses)];

                LeaveRequest::create([
                    'employee_id' => $employee->id,
                    'start_date' => $startDate->toDateString(),
                    'end_date' => $endDate->toDateString(),
                    'reason' => $reasons[array_rand($reasons)],
                    'status' => $status,
                    'approved_by' => $status !== 'pending' && !empty($approvers)
                        ? $approvers[array_rand($approvers)]
                        : null,
                ]);
            }
        }
    }
}
