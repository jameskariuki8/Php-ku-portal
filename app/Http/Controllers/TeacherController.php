<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Unit;
use App\Models\Grade;
use App\Models\student\StudentCourseEnrollment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function create()
    {
        return view('admin.teacher.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'required|string|max:20',
            'department' => 'required|string|max:255',
            'qualifications' => 'nullable|string',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'department' => $validated['department'],
            'qualifications' => $validated['qualifications'],
            'role' => 'teacher',
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.teacher.view')
            ->with('success', 'Teacher added successfully!');
    }

    public function index()
    {
        $teachers = User::where('role', 'teacher')->latest()->get();
        return view('admin.teacher.view', compact('teachers'));
    }

    public function enrollments()
    {
        $enrollments = StudentCourseEnrollment::with(['student', 'course'])
            ->latest()
            ->take(10)
            ->get();
        
        return view('teacher.enrollments', compact('enrollments'));
    }

    public function dashboard()
    {
        $teacher = auth()->user();
    
        // Get only students enrolled in units taught by this teacher
        $students = User::where('role', 'student')
            ->whereHas('enrollment.unitRegistrations.unit', function ($query) use ($teacher) {
                $query->where('teacher_id', $teacher->id);
            })
            ->orderBy('name')
            ->get(['id', 'name', 'email']);
    
        // Get units this teacher teaches
        $units = Unit::where('teacher_id', $teacher->id)->get();
    
        // Get grades
        $grades = Grade::with(['student:id,name', 'unit:id,name'])
            ->where('teacher_id', $teacher->id)
            ->latest()
            ->get();
    
        return view('admin.teacher.dashboard', compact('students', 'units', 'grades'));
    }
// In TeacherController
public function getStudentDetails(User $student)
{
    // Verify the student is enrolled in this teacher's units
    if (!$student->units()->whereHas('teacher', function ($query) {
        $query->where('id', auth()->id());
    })->exists()) {
        return response()->json([
            'error' => 'Unauthorized access to student data'
        ], 403);
    }
    

    return response()->json([
        'student' => [
            'id' => $student->id,
            'name' => $student->name,
            'email' => $student->email,
            'course' => $student->course ? [
                'id' => $student->course->id,
                'name' => $student->course->name
            ] : null
        ],
        'units' => $student->units->map(function($unit) {
            return [
                'id' => $unit->id,
                'name' => $unit->title,
                'code' => $unit->code,
                'cat' => optional($unit->grades->first())->cat_marks,
                'exam' => optional($unit->grades->first())->exam_marks
            ];
        })
    ]);
}
public function submitGrades(Request $request)
{
    $validated = $request->validate([
        'student_id' => 'required|exists:users,id',
        'units' => 'required|array',
        'units.*.cat' => 'nullable|numeric|min:0|max:30',
        'units.*.exam' => 'nullable|numeric|min:0|max:70',
        'teacher_comment' => 'nullable|string'
    ]);

    foreach ($validated['units'] as $unitId => $marks) {
        Grade::updateOrCreate(
            [
                'student_id' => $validated['student_id'],
                'unit_id' => $unitId,
                'teacher_id' => auth()->id()
            ],
            [
                'cat_marks' => $marks['cat'] ?? null,
                'exam_marks' => $marks['exam'] ?? null,
                'comments' => $validated['teacher_comment'] ?? null
            ]
        );
    }

    return redirect()->back()->with('success', 'Grades submitted successfully');
}

public function getStudentUnits(Student $student)
{
    $units = $student->units()
        ->where('teacher_id', auth()->id())
        ->get();

    return view('admin.teacher.student-units', compact('student', 'units'));
}

private function isStudentInTeacherUnits(Student $student)
{
    return $student->units()->where('teacher_id', auth()->id())->exists();
}

    
}  