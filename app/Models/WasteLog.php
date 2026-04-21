<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WasteLog extends Model
{
     
    protected $fillable = [
        'waste_id',
        'tipe_log',
        'jumlah',
        'user_id',
        'keterangan',
        'foto'
    ];
  


     public function waste()
    {
        return $this->belongsTo(Waste::class,'waste_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
