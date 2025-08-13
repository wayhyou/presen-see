<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $employees = Employee::with('shift')->get();

        foreach ($employees as $employee) {
            if (!$employee->shift) {
                continue; // lewati kalau tidak punya shift
            }

            $shiftStart = Carbon::parse($employee->shift->start_time);
            $shiftEnd   = Carbon::parse($employee->shift->end_time);

            // Buat data untuk 30 hari terakhir
            for ($i = 0; $i < 30; $i++) {
                $date = Carbon::now()->subDays($i)->toDateString();

                // Tentukan jam check-in
                $checkIn = $shiftStart->copy()->addMinutes(rand(-10, 40));
                $checkOut = $shiftEnd->copy()->addMinutes(rand(-40, 20));

                // Tentukan status
                $status = 'present';
                if ($checkIn->gt($shiftStart) && $checkOut->lt($shiftEnd)) {
                    // Kalau datang terlambat dan pulang cepat → pilih salah satu
                    $status = rand(0, 1) ? 'late' : 'early_leave';
                } elseif ($checkIn->gt($shiftStart)) {
                    $status = 'late';
                } elseif ($checkOut->lt($shiftEnd)) {
                    $status = 'early_leave';
                }

                // Simpan ke DB
                Attendance::create([
                    'employee_id' => $employee->id,
                    'date' => $date,
                    'check_in' => $status !== 'absent' ? $checkIn->format('H:i:s') : null,
                    'check_out' => $status !== 'absent' ? $checkOut->format('H:i:s') : null,
                    'status' => $status,
                    'check_in_latitude' => $status !== 'absent' ? fake()->latitude() : null,
                    'check_in_longitude' => $status !== 'absent' ? fake()->longitude() : null,
                    'check_out_latitude' => $status !== 'absent' ? fake()->latitude() : null,
                    'check_out_longitude' => $status !== 'absent' ? fake()->longitude() : null,
                ]);
            }
        }
    }
}
