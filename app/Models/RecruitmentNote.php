<?php

namespace App\Models;
use App\Models\User;
use App\Models\RecruitmentApplicant;
use Illuminate\Database\Eloquent\Model;

class RecruitmentNote extends Model
{
    protected $fillable = [
        'recruitment_applicant_id',
        'stage',
        'note',
        'user_id',
        
    
    ];
    public const STAGES = [
        'screening',
        'interview',
        'psikotes',
        'test_kerja',
        'mcu',
        'komitmen',
    ];

    public function applicant()
{
    return $this->belongsTo(RecruitmentApplicant::class, 'recruitment_applicant_id');
}

public function user()
{
    return $this->belongsTo(User::class);
}
}
