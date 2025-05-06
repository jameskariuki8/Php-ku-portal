<?php

// app/Models/Unit.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'teacher_id',
        'title',
        'description',
        'order'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function registrations()
    {
        return $this->hasMany(StudentUnitRegistration::class, 'unit_id');
    }

    public function enrolledStudents()
    {
        return $this->belongsToMany(StudentCourseEnrollment::class, 'student_unit_registrations', 'unit_id', 'enrollment_id')
            ->using(StudentUnitRegistration::class)
            ->withPivot(['status', 'registration_date']);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    /**
     * Get the students enrolled in this unit.
     */
    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'unit_id', 'student_id')
            ->where('role', 'student');
    }
}