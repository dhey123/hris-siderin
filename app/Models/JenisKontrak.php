<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisKontrak extends Model
{
    use HasFactory;

    protected $table = 'jenis_kontrak';

    protected $fillable = ['nama_jenis'];

    public function contracts()
    {
        return $this->hasMany(LegalContract::class, 'jenis_kontrak_id');
    }
}