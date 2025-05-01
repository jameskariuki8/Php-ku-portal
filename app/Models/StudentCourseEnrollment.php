<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudentCourseEnrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'enrollment_date',
        'status'
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function unitRegistrations(): HasMany
    {
        return $this->hasMany(StudentUnitRegistration::class, 'enrollment_id');
    }

    public function registeredUnits(): BelongsToMany
    {
        return $this->belongsToMany(Unit::class, 'student_unit_registrations', 'enrollment_id', 'unit_id')
            ->withPivot('status', 'registration_date')
            ->using(StudentUnitRegistration::class);
    }

    protected $casts = [
        'enrollment_date' => 'datetime',
    ];

    
}