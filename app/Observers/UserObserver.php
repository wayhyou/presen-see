<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Employee;
use Carbon\Carbon;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // Jika user adalah Admin, jangan buat record Employee
        if ($user->hasRole('Admin')) {
            return;
        }

        // Buat record karyawan untuk user baru
        Employee::create([
            'user_id' => $user->id,
            'office_id' => $user->office_id,
            'employee_code' => 'EMP-' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
            'join_date' => Carbon::now()->toDateString(),
        ]);
    }
}
