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
}