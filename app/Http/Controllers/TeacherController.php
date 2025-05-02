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
        $grades = Grade::with(['student:id,name', 'unit:id,title'])
            ->where('teacher_id', $teacher->id)
            ->latest()
            ->get();
    
        return view('admin.teacher.dashboard', compact('students', 'units', 'grades'));
    }

    public function getStudentDetails(User $student)
    {
        try {
            // Load the student with their course and unit registrations
            $student->load([
                'enrollment.course',
                'enrollment.registeredUnits.grades' => function($query) use ($student) {
                    $query->where('student_id', $student->id)
                          ->where('teacher_id', auth()->id());
                }
            ]);
            
            if (!$student->enrollment) {
                return response()->json([
                    'error' => 'Student is not enrolled in any course',
                    'student_id' => $student->id,
                    'student_name' => $student->name
                ], 404);
            }

            if (!$student->enrollment->course) {
                return response()->json([
                    'error' => 'Student is enrolled but has no course assigned',
                    'student_id' => $student->id,
                    'student_name' => $student->name,
                    'enrollment_id' => $student->enrollment->id
                ], 404);
            }

            $units = $student->enrollment->registeredUnits->map(function($unit) {
                $grade = $unit->grades->first();
                return [
                    'id' => $unit->id,
                    'title' => $unit->title,
                    'cat' => $grade ? $grade->cat_marks : null,
                    'exam' => $grade ? $grade->exam_marks : null
                ];
            });

            return response()->json([
                'student' => [
                    'id' => $student->id,
                    'name' => $student->name,
                    'email' => $student->email,
                    'course' => [
                        'id' => $student->enrollment->course->id,
                        'name' => $student->enrollment->course->title
                    ]
                ],
                'units' => $units,
                'debug' => [
                    'enrollment_id' => $student->enrollment->id,
                    'course_id' => $student->enrollment->course->id,
                    'units_count' => $units->count()
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in getStudentDetails: ' . $e->getMessage(), [
                'student_id' => $student->id,
                'error' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'An error occurred while fetching student details',
                'message' => $e->getMessage()
            ], 500);
        }
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
                    'comments' => $validated['teacher_comment'] ?? null,
                    'file_path' => 'grades/' . $validated['student_id'] . '/' . $unitId . '.pdf',
                    'uploaded_at' => now()
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