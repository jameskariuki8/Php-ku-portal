<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class GradeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:teacher');
    }

    /**
     * Upload grades via file (CSV/Excel)
     */
    public function upload(Request $request)
    {
        $request->validate([
            'grade_file' => 'required|file|mimes:csv,txt,xlsx|max:2048',
            'unit_id' => 'required|exists:units,id,teacher_id,'.Auth::id()
        ]);

        try {
            $unit = Unit::findOrFail($request->unit_id);
            $file = $request->file('grade_file');
            
            // Process the file (example for CSV)
            $path = $file->getRealPath();
            $data = array_map('str_getcsv', file($path));
            
            $header = array_shift($data);
            $grades = [];
            
            foreach ($data as $row) {
                $grades[] = array_combine($header, $row);
            }
            
            // Validate and store grades
            $processed = 0;
            foreach ($grades as $gradeData) {
                $validator = Validator::make($gradeData, [
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
                
                if ($validator->fails()) continue;
                
                Grade::updateOrCreate(
                    [
                        'student_id' => $gradeData['student_id'],
                        'unit_id' => $unit->id,
                        'teacher_id' => Auth::id()
                    ],
                    [
                        'cat_marks' => $gradeData['cat_marks'] ?? null,
                        'exam_marks' => $gradeData['exam_marks'] ?? null,
                        'comments' => $gradeData['comments'] ?? null,
                        'grade' => $this->calculateGrade(
                            $gradeData['cat_marks'] ?? 0,
                            $gradeData['exam_marks'] ?? 0
                        )
                    ]
                );
                
                $processed++;
            }
            
            return back()->with('success', "Successfully processed $processed grades");
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error processing file: '.$e->getMessage());
        }
    }

    /**
     * Send grades to students (email notification)
     */
    public function send(Request $request)
    {
        $request->validate([
            'unit_id' => 'required|exists:units,id,teacher_id,'.Auth::id(),
            'message' => 'nullable|string|max:500'
        ]);
        
        $unit = Unit::with(['grades.student'])->find($request->unit_id);
        
        try {
            $sentCount = 0;
            
            foreach ($unit->grades as $grade) {
                if ($grade->student && $grade->student->email) {
                    // Send email notification
                    \Mail::to($grade->student->email)->send(
                        new \App\Mail\GradeNotification($grade, $request->message)
                    );
                    $sentCount++;
                }
            }
            
            return back()->with('success', "Grades sent to $sentCount students");
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error sending grades: '.$e->getMessage());
        }
    }

    /**
     * Calculate final grade based on CAT and exam marks
     */
    private function calculateGrade($catMarks, $examMarks)
    {
        $total = ($catMarks ?? 0) + ($examMarks ?? 0);
        
        if ($total >= 70) return 'A';
        if ($total >= 60) return 'B';
        if ($total >= 50) return 'C';
        if ($total >= 40) return 'D';
        return 'F';
    }

    /**
     * Get grades for a specific unit
     */
    public function unitGrades(Unit $unit)
    {
        $this->authorize('view', $unit);
        
        $grades = Grade::with('student')
            ->where('unit_id', $unit->id)
            ->where('teacher_id', Auth::id())
            ->get();
            
        return view('admin.teacher.grades.unit', compact('unit', 'grades'));
    }

    /**
     * Update individual grade
     */
    public function update(Request $request, Grade $grade)
    {
        $this->authorize('update', $grade);
        
        $validated = $request->validate([
            'cat_marks' => 'nullable|numeric|min:0|max:30',
            'exam_marks' => 'nullable|numeric|min:0|max:70',
            'comments' => 'nullable|string|max:255'
        ]);
        
        $grade->update([
            'cat_marks' => $validated['cat_marks'],
            'exam_marks' => $validated['exam_marks'],
            'comments' => $validated['comments'],
            'grade' => $this->calculateGrade(
                $validated['cat_marks'] ?? 0,
                $validated['exam_marks'] ?? 0
            )
        ]);
        
        return back()->with('success', 'Grade updated successfully');
    }
}