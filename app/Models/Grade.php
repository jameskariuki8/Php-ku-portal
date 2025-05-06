<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'unit_id',
        'teacher_id',
        'cat_marks',      
        'exam_marks',     
        'comments', 
        'grade',
        'remarks',
        'file_path',
        'uploaded_at'
    ];
    protected $casts = [
        'uploaded_at' => 'datetime',
        'cat_marks' => 'float',
        'exam_marks' => 'float'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
