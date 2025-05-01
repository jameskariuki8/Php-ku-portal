<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class StudentUnitRegistration extends Pivot
{
    use HasFactory;

    protected $table = 'student_unit_registrations';

    protected $fillable = [
        'enrollment_id',
        'unit_id',
        'registration_date',
        'status'
    ];

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(StudentCourseEnrollment::class, 'enrollment_id');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}