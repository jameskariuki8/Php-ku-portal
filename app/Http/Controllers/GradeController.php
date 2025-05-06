<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\GradesImport;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Gate;

class GradeController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Check if user is authorized as a teacher
     */
    private function checkTeacherRole()
    {
        if (Auth::user()->role !== 'teacher') {
            abort(403, 'Unauthorized action. Only teachers can access this resource.');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->checkTeacherRole();
        
        $units = Unit::with('students')
            ->where('teacher_id', auth()->id())
            ->get();
            
        return view('admin.teacher.grades.index', compact('units'));
    }

    /**
     * Upload grades via file (CSV/Excel)
     */
    public function upload(Request $request)
    {
        $this->checkTeacherRole();
        
        $request->validate([
            'grade_file' => 'required|file|mimes:csv,txt,xlsx|max:2048',
            'unit_id' => 'required|exists:units,id'
        ]);

        try {
            $file = $request->file('grade_file');
            $unit = Unit::findOrFail($request->unit_id);
            
            // Verify the teacher owns this unit
            if ($unit->teacher_id !== auth()->id()) {
                return back()->with('error', 'You are not authorized to upload grades for this unit.');
            }

            // Store the file
            $path = $file->store('grade_uploads');
            
            // Import the grades
            Excel::import(new GradesImport($unit->id), $path);
            
            // Delete the file after import
            Storage::delete($path);
            
            return back()->with('success', 'Grades uploaded successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error uploading grades: ' . $e->getMessage());
        }
    }

    /**
     * Display the grade upload form
     */
    public function showUploadForm()
    {
        $this->checkTeacherRole();
        
        $units = Unit::where('teacher_id', auth()->id())->get();
        return view('admin.teacher.upload-grades', compact('units'));
    }

    /**
     * Display grades for a specific unit
     */
    public function showUnitGrades(Unit $unit)
    {
        $this->checkTeacherRole();
        
        // Verify the teacher owns this unit
        if ($unit->teacher_id !== auth()->id()) {
            abort(403);
        }

        $grades = Grade::with('student')
            ->where('unit_id', $unit->id)
            ->get();

        return view('admin.teacher.unit-grades', compact('unit', 'grades'));
    }

    /**
     * Update individual grade
     */
    public function update(Request $request, Grade $grade)
    {
        $this->checkTeacherRole();
        
        // Verify the teacher owns this grade
        if ($grade->teacher_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'cat_marks' => 'nullable|numeric|min:0|max:30',
            'exam_marks' => 'nullable|numeric|min:0|max:70',
            'comments' => 'nullable|string'
        ]);

        $grade->update($request->only(['cat_marks', 'exam_marks', 'comments']));

        return back()->with('success', 'Grade updated successfully!');
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
}