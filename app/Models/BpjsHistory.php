<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class BpjsHistory extends Model
{
    protected $fillable = [
        'bpjs_record_id',
        'bpjs_kesehatan',
        'bpjs_ketenagakerjaan',
        'tanggal_bayar',
        'updated_by'
    ];

    public function bpjs()
    {
        return $this->belongsTo(BpjsRecord::class, 'bpjs_record_id');
    }
    
}