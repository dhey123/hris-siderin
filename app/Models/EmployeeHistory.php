<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeHistory extends Model
{
    protected $fillable = [
        'employee_id',
        'type',
        'status',
        'employment_type',
        'start_date',
        'end_date',
        'notes',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    //
}
