<?php

namespace App\Models;

use App\Models\StudentUnitRegistration;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', 
        'phone',
        'department',
        'qualifications',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
     /**
     * Check if the user is a student.
     *
     * @return bool
     */
    public function isStudent()
    {
        return $this->role === 'student'; // Return true if role is 'student'
    }

    // app/Models/User.php
    public function enrollment()
    {
        return $this->hasOne(StudentCourseEnrollment::class, 'student_id');
    }

    public function course()
    {
        return $this->hasOneThrough(
            Course::class,
            StudentCourseEnrollment::class,
            'student_id',
            'id',
            'id',
            'course_id'
        );
    }

    public function enrolledCourse()
    {
        return $this->hasOneThrough(
            Course::class,
            StudentCourseEnrollment::class,
            'student_id',
            'id',
            'id',
            'course_id'
        );
    }

    public function unitRegistrations()
    {
        return $this->hasManyThrough(
            StudentUnitRegistration::class,
            StudentCourseEnrollment::class,
            'student_id',
            'enrollment_id',
            'id',
            'id'
        );
    }

    public function units()
    {
        return $this->belongsToMany(Unit::class, 'student_unit_registrations', 'enrollment_id', 'unit_id')
            ->using(StudentUnitRegistration::class)
            ->withPivot(['status', 'registration_date']);
    }

    public function enrolledUnits()
    {
        return $this->belongsToMany(Unit::class, 'student_unit_registrations', 'enrollment_id', 'unit_id')
            ->using(StudentUnitRegistration::class)
            ->withPivot(['status', 'registration_date']);
    }

    public function students()
    {
        return User::where('role', 'student')
            ->whereHas('enrollment.unitRegistrations.unit', function ($query) {
                $query->where('teacher_id', $this->id);
            });
    }

    public function taughtUnits()
    {
        return $this->hasMany(Unit::class, 'teacher_id');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class, 'teacher_id');
    }
    
}
