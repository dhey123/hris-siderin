<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $table = 'ga_maintenances';

    protected $fillable = [
        'asset_id',
        'title',
        'description',
        'status',
        'report_date',
        'finish_date'
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
