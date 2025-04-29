<?php

// app/Models/StudentCourseEnrollment.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCourseEnrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'enrollment_date',
        'status'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function unitRegistrations()
    {
        return $this->hasMany(StudentUnitRegistration::class, 'enrollment_id');
    }

    public function registeredUnits()
    {
        return $this->belongsToMany(Unit::class, 'student_unit_registrations', 'enrollment_id', 'unit_id')
            ->withPivot('status', 'registration_date');
    }
}