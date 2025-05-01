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
        'student_id', // Foreign key on enrollments table
        'id', // Foreign key on courses table
        'id', // Local key on users table
        'course_id' // Local key on enrollments table
    );
}
// In User.php
public function enrolledCourse()
{
    return $this->enrollment();
}


public function unitRegistrations()
{
    return $this->hasMany(StudentUnitRegistration::class, 'enrollment_id', 'id');
}

// In User.php
public function units()
{
    return $this->hasManyThrough(
        Unit::class,
        StudentUnitRegistration::class,
        'enrollment_id',
        'id',
        'id',
        'unit_id'
    );
}


}
