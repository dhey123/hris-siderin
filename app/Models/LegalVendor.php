<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegalVendor extends Model
{
    protected $fillable = [
    'nama_vendor',
    'jenis_vendor',
    'npwp',
    'alamat',
    'kontak_person',
    'no_telp',
    'email',
    'status',
];

public function documents()
{
    return $this->hasMany(LegalDocument::class, 'vendor_id');
}
public function contracts()
{
    return $this->hasMany(LegalContract::class, 'vendor_id');
}
}
