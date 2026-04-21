<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelatihanEvaluasi extends Model
{
    protected $fillable = [
    'pelatihan_id',
    'nilai',
    'catatan',
];

}
