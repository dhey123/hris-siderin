<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mcu extends Model
{
    protected $appends = ['full_name'];

    public function getFullNameAttribute()
    {
        return trim(($this->first_name ?? '') . ' ' . ($this->last_name ?? ''));
    }


    protected $fillable = [
        'employee_id',
        'jenis_mcu',
        'tanggal_mcu',
        'hasil',
        'catatan',
        'file_hasil',
        'klinik'
    ];
    protected $casts = [
    'tanggal_mcu' => 'date',
];


    // Relasi ke Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Accessor: format tanggal MCU otomatis
    public function getTanggalMcuFormattedAttribute()
    {
        return $this->tanggal_mcu ? \Carbon\Carbon::parse($this->tanggal_mcu)->format('d/m/Y') : '-';
    }
}
