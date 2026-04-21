<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BpjsRecord extends Model
{
    protected $fillable = [
    'employee_id',
    'bulan',
    'tahun',
    'bpjs_kesehatan',
    'bpjs_ketenagakerjaan',
    'tanggal_bayar_kesehatan',
    'tanggal_bayar_ketenagakerjaan',
    'bukti_bayar',

     // NEW
    'total_iuran',
    'jkk',
    'jht',
    'jkm',
    'jp'
];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    protected $attributes = [
    'bpjs_kesehatan' => 'unpaid',
    'bpjs_ketenagakerjaan' => 'unpaid',
];
}
