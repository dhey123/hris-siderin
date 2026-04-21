<?php

namespace App\Models;
use App\Models\RecruitmentNote;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class RecruitmentApplicant extends Model
{
    use HasFactory;
    protected $fillable = [
    'nik',    
    'name',
    'email',
    'phone',
    'job_id',
    'position',
    'cv',
    'status',
    'stage',
    'application_type',
    'referral_name',
    'referral_relation', 
    'is_blacklisted',
    'blacklist_reason',

];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
    public function notes()
{
    return $this->hasMany(RecruitmentNote::class, 'recruitment_applicant_id');
}

    public function latestNote()
{
    return $this->hasOne(RecruitmentNote::class, 'recruitment_applicant_id')->latestOfMany();
}

public function employee()
{
    return $this->hasOne(Employee::class, 'source_applicant_id');
}


}

   