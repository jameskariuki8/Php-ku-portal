<?php

namespace App\Imports;

use App\Models\Grade;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class GradesImport implements ToModel, WithHeadingRow
{
    protected $unitId;

    public function __construct($unitId)
    {
        $this->unitId = $unitId;
    }

    public function model(array $row)
    {
        $validator = Validator::make($row, [
            'student_id' => [
                'required',
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->where('role', 'student');
                })
            ],
            'cat_marks' => 'nullable|numeric|min:0|max:30',
            'exam_marks' => 'nullable|numeric|min:0|max:70',
            'comments' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return null;
        }

        return new Grade([
            'student_id' => $row['student_id'],
            'unit_id' => $this->unitId,
            'teacher_id' => Auth::id(),
            'cat_marks' => $row['cat_marks'] ?? null,
            'exam_marks' => $row['exam_marks'] ?? null,
            'comments' => $row['comments'] ?? null,
            'grade' => $this->calculateGrade(
                $row['cat_marks'] ?? 0,
                $row['exam_marks'] ?? 0
            )
        ]);
    }

    private function calculateGrade($catMarks, $examMarks)
    {
        $total = $catMarks + $examMarks;
        
        if ($total >= 70) return 'A';
        if ($total >= 60) return 'B';
        if ($total >= 50) return 'C';
        if ($total >= 40) return 'D';
        return 'F';
    }
} 