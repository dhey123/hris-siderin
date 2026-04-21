<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    use HasFactory;

    protected $table = 'family_members';

    protected $fillable = [
        'employee_id',
        'name',
        'relationship',
        'birth_date',
        'is_dependent',
    ];

    protected $casts = [
        'birth_date' => 'date',      // otomatis jadi Carbon
        'is_dependent' => 'boolean', // otomatis true/false
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }


    
}

