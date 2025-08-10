<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Office extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'latitude',
        'longitude',
    ];

    // Relasi: Office punya banyak Shift
    public function shifts()
    {
        return $this->hasMany(Shift::class);
    }

    // Relasi: Office punya banyak User/Employee
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Relasi: Office punya banyak Department
    public function departments()
    {
        return $this->hasMany(Department::class);
    }
}
