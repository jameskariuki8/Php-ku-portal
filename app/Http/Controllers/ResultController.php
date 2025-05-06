<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Grade;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function downloadAllResults()
    {
        $grades = Grade::with(['student', 'unit.course', 'teacher'])
            ->orderBy('created_at', 'desc')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="all_results.csv"',
        ];

        $callback = function() use ($grades) {
            $file = fopen('php://output', 'w');
            
            // Write CSV headers
            fputcsv($file, [
                'Student Name',
                'Course Code',
                'Course Title',
                'Unit Title',
                'Teacher Name',
                'CAT Marks',
                'Exam Marks',
                'Total Score',
                'Grade',
                'Teacher\'s Comment',
                'Date Uploaded'
            ]);

            // Write data rows
            foreach ($grades as $grade) {
                fputcsv($file, [
                    $grade->student->name,
                    $grade->unit->course->course_code,
                    $grade->unit->course->title,
                    $grade->unit->title,
                    $grade->teacher->name,
                    $grade->cat_marks ?? 'N/A',
                    $grade->exam_marks ?? 'N/A',
                    ($grade->cat_marks ?? 0) + ($grade->exam_marks ?? 0),
                    $grade->grade ?? 'N/A',
                    $grade->comments ?? 'No comment',
                    $grade->uploaded_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
} 