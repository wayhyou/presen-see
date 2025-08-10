<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = [
        'office_id',
        'name',
        'start_time',
        'end_time',
        'break_minutes',
    ];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
