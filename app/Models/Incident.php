<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    protected $table = 'incidents'; 
    
   protected $fillable = [
    'employee_id',
    'nama_karyawan',
    'department',
    'bagian',
    'incident_date',
    'location',
    'incident_type',
    'severity',
    'description',
    'action_taken',
    'status',
    'status_note', 
    'attachment',
];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    
}
