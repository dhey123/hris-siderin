<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeCase extends Model
{
    use HasFactory;

    protected $table = 'employee_cases';

    protected $fillable = [
        'employee_id',
        'jenis_kasus',
        'tanggal',
        'kronologi',
        'status'
    ];
    public function structure()
{
    return $this->belongsTo(IndustrialStructure::class, 'structure_id');
}
public function employee()
{
    return $this->belongsTo(Employee::class);
}
}