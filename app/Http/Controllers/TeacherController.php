<?php

namespace App\Http\Controllers;
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

    public function indx()
{
    $enrollments = StudentCourseEnrollment::with(['student', 'course'])
        ->latest()
        ->take(10)
        ->get();
    
    return view('your.view', compact('enrollments'));
}
}
