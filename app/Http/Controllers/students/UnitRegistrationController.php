<?php
// app/Http/Controllers/Student/UnitRegistrationController.php
namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Models\StudentCourseEnrollment;
use App\Models\StudentUnitRegistration;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitRegistrationController extends Controller
{
    public function index()
    {
        $enrollment = Auth::user()->enrolledCourse;
        
        if (!$enrollment) {
            return redirect()->route('student.enroll')
                ->with('error', 'You must enroll in a course first.');
        }
        
        $courseUnits = Unit::where('course_id', $enrollment->course_id)->get();
        $registeredUnits = $enrollment->registeredUnits;
        
        return view('student.units.index', compact('enrollment', 'courseUnits', 'registeredUnits'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $enrollment = $user->enrolledCourse;
        
        if (!$enrollment) {
            return redirect()->route('student.enroll')
                ->with('error', 'You must enroll in a course first.');
        }
        
        $validated = $request->validate([
            'unit_id' => 'required|exists:units,id',
        ]);
        
        // Check if unit belongs to enrolled course
        $unit = Unit::find($validated['unit_id']);
        if ($unit->course_id != $enrollment->course_id) {
            return redirect()->back()
                ->with('error', 'This unit does not belong to your enrolled course.');
        }
        
        // Check if already registered
        if ($enrollment->registeredUnits()->where('unit_id', $validated['unit_id'])->exists()) {
            return redirect()->back()
                ->with('error', 'You are already registered for this unit.');
        }
        
        StudentUnitRegistration::create([
            'enrollment_id' => $enrollment->id,
            'unit_id' => $validated['unit_id'],
            'registration_date' => now(),
            'status' => 'registered'
        ]);
        
        return redirect()->route('student.units')
            ->with('success', 'Successfully registered for unit!');
    }

    public function destroy($id)
    {
        $registration = StudentUnitRegistration::findOrFail($id);
        
        // Verify the registration belongs to the current user
        if ($registration->enrollment->student_id != Auth::id()) {
            abort(403);
        }
        
        $registration->delete();
        
        return redirect()->route('student.units')
            ->with('success', 'Successfully dropped unit.');
    }
}