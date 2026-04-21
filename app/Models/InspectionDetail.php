<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspectionDetail extends Model
{
    protected $fillable = [
        'inspection_id',
        'checklist_id',
        'item',
        'standar',
        'hasil',
        'keterangan',
        'foto'
    ];

    public function inspection()
    {
        return $this->belongsTo(Inspection::class);
    }

    public function checklist()
    {
        return $this->belongsTo(InspectionChecklist::class,'checklist_id');
    }
}
