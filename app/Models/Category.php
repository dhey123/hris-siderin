<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'ga_categories'; // 🔥 penting

    protected $fillable = [
        'name',
        'code',
        'color'
    ];

    public function assets()
    {
        return $this->hasMany(Asset::class, 'category_id');
    }
}