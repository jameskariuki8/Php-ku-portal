<?php
namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Models\StudentCourseEnrollment;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitRegistrationController extends Controller
{
    public function index()
    {
        $enrollment = Auth::user()->enrolledCourse()
            ->with(['course', 'registeredUnits'])
            ->first();
        
        if (!$enrollment) {
            return redirect()->route('student.enroll')
                ->with('error', 'You must enroll in a course first.');
        }
        
        // Get available units (not already registered)
        $registeredUnitIds = $enrollment->registeredUnits->pluck('id');
        $courseUnits = Unit::where('course_id', $enrollment->course_id)
            ->whereNotIn('id', $registeredUnitIds)
            ->get();
            
        return view('student.units.index', [
            'enrollment' => $enrollment,
            'courseUnits' => $courseUnits,
            'registeredUnits' => $enrollment->registeredUnits
        ]);
    }

    public function store(Request $request)
    {
        $enrollment = Auth::user()->enrolledCourse;
        
        if (!$enrollment) {
            return redirect()->route('student.enroll')
                ->with('error', 'You must enroll in a course first.');
        }
        
        $validated = $request->validate([
            'unit_id' => 'required|exists:units,id',
        ]);
        
        $unit = Unit::findOrFail($validated['unit_id']);
        
        // Check if unit belongs to enrolled course
        if ($unit->course_id != $enrollment->course_id) {
            return redirect()->back()
                ->with('error', 'This unit does not belong to your enrolled course.');
        }
        
        // Check if already registered
        if ($enrollment->registeredUnits()->where('unit_id', $unit->id)->exists()) {
            return redirect()->back()
                ->with('error', 'You are already registered for this unit.');
        }
        
        // Register the unit
        $enrollment->registeredUnits()->attach($unit->id, [
            'registration_date' => now(),
            'status' => 'registered'
        ]);
        
        return redirect()->route('student.units.index')
            ->with('success', 'Successfully registered for unit!');
    }

    public function destroy($unitId)
{
    $user = Auth::user();
    $enrollment = $user->enrolledCourse;
    
    if (!$enrollment) {
        abort(404, 'No active enrollment found');
    }
    
    // Find the registration
    $registration = $enrollment->unitRegistrations()
        ->where('unit_id', $unitId)
        ->firstOrFail();
    
    // Authorization check
    if ($registration->enrollment->student_id != $user->id) {
        abort(403, 'Unauthorized action');
    }
    
    // Business rule: 7-day drop period
    if ($registration->created_at->diffInDays(now()) > 7) {
        return redirect()->back()
            ->with('error', 'You can only drop units within 7 days of registration');
    }
    
    // Delete the registration
    $registration->delete();
    
    return redirect()->route('student.units.index')
        ->with('success', 'Unit successfully dropped');
}
}