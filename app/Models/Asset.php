<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $table = 'ga_assets'; // PENTING karena nama tabel beda

    protected $fillable = [
        'asset_code',
        'name',
        'quantity',
        'category_id',
        'location',
        'condition',
        'purchase_date',
        'price',
        'description',
         'type'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function maintenances()
{
    return $this->hasMany(Maintenance::class);
}
public function category()
{
    return $this->belongsTo(Category::class, 'category_id');
}
public function assets()
{
    return $this->hasMany(Asset::class, 'category_id');
}
}