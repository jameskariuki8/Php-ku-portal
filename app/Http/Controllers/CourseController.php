<?php
// app/Http/Controllers/CourseController.php
namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // Show add course form
    public function create()
    {
        return view('admin.courses.add');
    }

    // Store new course
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_code' => 'required|string|max:50|unique:courses,course_code',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'credit_hours' => 'required|integer|min:1',
        ]);

        Course::create($validated);

        return redirect()->route('admin.courses.view')
            ->with('success', 'Course added successfully!');
    }

    // View all courses
    public function index()
    {
        $courses = Course::latest()->get();
        return view('admin.courses.view', compact('courses'));
    }
}