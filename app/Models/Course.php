<?php
// app/Models/Course.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_code',
        'title',
        'description',
        'credit_hours'
    ];

    // Define relationship: A course has many units
    public function units()
    {
        return $this->hasMany(Unit::class);
    }
}
