<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
    class InspectionChecklist extends Model
    {
        protected $fillable = [
            'kategori',  
             'kode',
            'area',
            'item',
            'standar',
            'aktif'
        ];
    }

