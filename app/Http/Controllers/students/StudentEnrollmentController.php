<?php
// app/Http/Controllers/Student/EnrollmentController.php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\StudentCourseEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentEnrollmentController extends Controller
{
    public function index()
    {
        $courses = Course::active()->get();
        $enrollment = Auth::user()->enrolledCourse()->with('course')->first();
        
        return view('student.enroll', compact('courses', 'enrollment'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Check if student already has an active enrollment
        if ($user->enrolledCourse()->exists()) {
            return back()->with('error', 'You are already enrolled in a course.');
        }
        
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);
        
        $enrollment = $user->enrolledCourse()->create([
            'course_id' => $validated['course_id'],
            'enrollment_date' => now(),
            'status' => 'active'
        ]);
        
        return redirect()->route('student.enroll')
            ->with('success', 'Successfully enrolled in course!');
    }

    public function destroy(StudentCourseEnrollment $enrollment)
    {
        // Authorization check - ensure student owns this enrollment
        if ($enrollment->student_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Prevent deleting if there are unit registrations
        if ($enrollment->unitRegistrations()->exists()) {
            return back()->with('error', 'Cannot withdraw from course with registered units.');
        }
        
        $enrollment->delete();
        
        return redirect()->route('student.enroll')
            ->with('success', 'Successfully withdrawn from course.');
    }
}