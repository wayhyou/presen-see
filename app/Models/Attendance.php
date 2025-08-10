<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'date',
        'check_in',
        'check_out',
        'status',
        'notes',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', now()->toDateString());
    }
}
