<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Job extends Model
{
    protected $fillable = [
        'title',
        'description',
        'department',
        'location',
        'department_id',
        'location_id',
        'status',
    ];

    public function applicants()
    {
        return $this->hasMany(RecruitmentApplicant::class);
    }

    public function departmentRel()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function locationRel()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    // 🧠 fallback pintar (INI KUNCI)
    public function getDepartmentNameAttribute()
    {
        return $this->departmentRel->department_name
            ?? $this->department
            ?? '-';
    }

    public function getLocationNameAttribute()
    {
        return $this->locationRel->location_name
            ?? $this->location
            ?? '-';
    }

}
