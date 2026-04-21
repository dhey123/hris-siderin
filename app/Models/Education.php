<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $table = 'educations'; // tabel yang benar

    protected $fillable = [
        'education_level',
        'order_level'
    ];
}
