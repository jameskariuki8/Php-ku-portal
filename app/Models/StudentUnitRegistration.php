<?php

// app/Models/StudentUnitRegistration.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentUnitRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'enrollment_id',
        'unit_id',
        'registration_date',
        'status'
    ];

    public function enrollment()
    {
        return $this->belongsTo(StudentCourseEnrollment::class, 'enrollment_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}