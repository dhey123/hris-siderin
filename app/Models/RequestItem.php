<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestItem extends Model
{
    protected $table = 'ga_requests';

    protected $fillable = [
        'request_code',
        'item_name',
        'qty',
        'description',
        'status',
        'request_date',
    ];
}