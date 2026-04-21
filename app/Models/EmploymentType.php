<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmploymentType extends Model
{
    protected $fillable = [
        'type_name',       // Contoh: Staff, Produksi, Borongan
        'company',         // Opsional, kalau mau pakai company
        'employee_category', // Opsional
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'employment_type_id');
    }
}
